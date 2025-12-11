<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Managements\ManagementProjectRoleAssignment;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->userRole && $user->userRole->name === 'Admin' || $user->userRole && $user->userRole->name === 'Manager') {
            return $next($request);
        }

        $projectParam = $request->route('project');

        $projectId = is_object($projectParam) ? $projectParam->id : $projectParam;

        if (!$projectId) {
            return $next($request);
        }

        $isAssigned = ManagementProjectRoleAssignment::where('management_project_id', $projectId)->where('user_id', $user->id)->exists();

        if ($isAssigned) {
            return $next($request);
        }

        abort(401, 'You are not assigned to this project.');
    }
}