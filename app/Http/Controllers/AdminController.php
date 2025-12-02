<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Products\Product;
use App\Models\Products\ProductBrand;
use App\Models\Products\ProductCategory;
use App\Models\Projects\Project;
use App\Models\Projects\ProjectCategory;
use App\Models\Projects\ProjectImage;
use App\Models\Services\Service;
use App\Models\Services\ServiceCategory;
use App\Models\Users\User;

class AdminController extends Controller
{
    // Display admin dashboard with stats.
    public function dashboard(): View
    {
        $userInterestCount = User::whereHas('userRole', function ($q) {
            $q->where('name', '==', 'User');
        })->where(function ($query) {
            $query->has('interested_products')->orHas('interested_services');
        })->count();

        return view('admin.admin_dashboard', [
            'admin_username' => Auth::user()->name,
            'user_count'     => $userInterestCount,
            'product_count'  => Product::count(),
            'service_count'  => Service::count(),
            'project_count'  => Project::count(),
        ]);
    }

    // PRODUCT MANAGEMENT
    public function listProducts(): View
    {
        return view('admin.manage_product', [
            'action'   => 'list',
            'products' => Product::with(['brand', 'category', 'lastUpdatedBy'])->orderBy('id', 'asc')->get(),
        ]);
    }

    public function createProduct(): View
    {
        return view('admin.manage_product', [
            'action'     => 'add',
            'brands'     => ProductBrand::orderBy('name', 'asc')->get(),
            'categories' => ProductCategory::orderBy('name', 'asc')->get()
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'brand_id'    => 'required|integer|exists:product_brands,id',
            'category_id' => 'required|integer|exists:product_categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf_path'    => 'nullable|file|mimes:pdf|max:10240',
            'is_hidden'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/image/products', 'public');
        }
        
        if ($request->hasFile('pdf_path')) {
            $data['pdf_path'] = $request->file('pdf_path')->store('uploads/pdf', 'public');
        }

        $data['last_update_by'] = Auth::id();
        
        $data['is_hidden'] = $request->has('is_hidden') ? true : false;

        Product::create($data);

        return redirect()->route('admin.products.list')->with('message', 'Product created successfully.');
    }

    public function editProduct(string $id): View
    {
        return view('admin.manage_product', [
            'action'          => 'edit',
            'product_to_edit' => Product::findOrFail($id),
            'brands'          => ProductBrand::orderBy('name', 'asc')->get(),
            'categories'      => ProductCategory::orderBy('name', 'asc')->get()
        ]);
    }

    public function updateProduct(Request $request, string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'brand_id'    => 'required|integer|exists:product_brands,id',
            'category_id' => 'required|integer|exists:product_categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'pdf_path'    => 'nullable|file|mimes:pdf|max:5120',
            'is_hidden'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('uploads/image/products', 'public');
        }

        if ($request->hasFile('pdf_path')) {
            if ($product->pdf_path) {
                Storage::disk('public')->delete($product->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf_path')->store('uploads/pdf', 'public');
        }

        $data['last_update_by'] = Auth::id();

        $data['is_hidden'] = $request->has('is_hidden') ? true : false;
        
        $product->update($data);

        return redirect()->route('admin.products.list')->with('message', 'Product updated successfully.');
    }

    public function destroyProduct(string $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        if ($product->image) Storage::disk('public')->delete($product->image);
        if ($product->pdf_path) Storage::disk('public')->delete($product->pdf_path);

        $product->delete();

        return redirect()->route('admin.products.list')->with('message', 'Product deleted successfully.');
    }

    // SERVICE MANAGEMENT
    public function listServices(): View
    {
        return view('admin.manage_service', [
            'action'   => 'list',
            'services' => Service::with(['category', 'lastUpdatedBy'])->orderBy('id', 'asc')->get(),
        ]);
    }

    public function createService(): View
    {
        return view('admin.manage_service', [
            'action'     => 'add',
            'categories' => ServiceCategory::orderBy('name', 'asc')->get(),
        ]);
    }

    public function storeService(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|integer|exists:service_categories,id',
            'description' => 'nullable|string',
        ]);
        
        $data['last_update_by'] = Auth::id();
        Service::create($data);

        return redirect()->route('admin.services.list')->with('message', 'Service created successfully.');
    }

    public function editService(string $id): View
    {
        return view('admin.manage_service', [
            'action'          => 'edit',
            'service_to_edit' => Service::findOrFail($id),
            'categories'      => ServiceCategory::orderBy('name', 'asc')->get(),
        ]);
    }

    public function updateService(Request $request, string $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|integer|exists:service_categories,id',
            'description' => 'nullable|string',
        ]);

        $data['last_update_by'] = Auth::id();
        $service->update($data);

        return redirect()->route('admin.services.list')->with('message', 'Service updated successfully.');
    }

    public function destroyService(string $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.list')->with('message', 'Service deleted successfully.');
    }

    // PUBLIC PROJECT MANAGEMENT
    public function listProjects(): View
    {
        $projects = Project::with(['categories', 'images', 'lastUpdatedBy'])
            ->orderBy('id', 'asc')
            ->get()
            ->map(function($project) {
                $project->category_names = $project->categories->pluck('name')->join(', ');
                $project->thumbnail = $project->images->sortBy('upload_order')->first()->image_path ?? null;
                return $project;
            });

        return view('admin.manage_project', [
            'action'   => 'list',
            'projects' => $projects,
        ]);
    }

    public function createProject(): View
    {
        return view('admin.manage_project', [
            'action'     => 'add',
            'categories' => ProjectCategory::orderBy('name', 'asc')->get(),
        ]);
    }

    public function storeProject(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_ids'   => 'required|array|max:4',
            'category_ids.*' => 'integer|exists:project_categories,id',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data['last_update_by'] = Auth::id();
        
        $project = Project::create($data);
        $project->categories()->attach($data['category_ids']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('uploads/image/projects', 'public');
                ProjectImage::create([
                    'project_id'   => $project->id,
                    'image_path'   => $path,
                    'upload_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.projects.list')->with('message', 'Project created successfully.');
    }

    public function editProject(string $id): View
    {
        $project = Project::with('images', 'categories')->findOrFail($id);

        return view('admin.manage_project', [
            'action'                      => 'edit',
            'project_to_edit'             => $project,
            'project_images'              => $project->images->sortBy('upload_order'),
            'project_categories_assigned' => $project->categories->pluck('id')->toArray(),
            'categories'                  => ProjectCategory::orderBy('name', 'asc')->get(),
        ]);
    }

    public function updateProject(Request $request, string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category_ids'   => 'required|array|max:4',
            'category_ids.*' => 'integer|exists:project_categories,id',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_images'  => 'nullable|array',
            'delete_images.*'=> 'integer|exists:project_images,id',
        ]);
        
        $data['last_update_by'] = Auth::id();
        $project->update($data);
        
        $project->categories()->sync($data['category_ids']);

        if ($request->has('delete_images')) {
            $images_to_delete = ProjectImage::whereIn('id', $request->delete_images)->where('project_id', $project->id)->get();
            foreach ($images_to_delete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        if ($request->hasFile('images')) {
            $currentMaxOrder = $project->images()->max('upload_order') ?? 0;
            
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('uploads/image/projects', 'public');
                ProjectImage::create([
                    'project_id'   => $project->id,
                    'image_path'   => $path,
                    'upload_order' => $currentMaxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.projects.list')->with('message', 'Project updated successfully.');
    }

    public function destroyProject(string $id): RedirectResponse
    {
        $project = Project::with('images')->findOrFail($id);

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $project->categories()->detach();

        $project->delete();

        return redirect()->route('admin.projects.list')->with('message', 'Project deleted successfully.');
    }

    // USER INTERESTS
    public function listUsers(): View
    {
        $users = User::whereHas('userRole', function ($q) {
            $q->where('name', '=', 'User');
        })
        ->where(function ($query) {
            $query->has('interested_products')->orHas('interested_services');
        })
        ->with(['interested_products', 'interested_services'])->latest()->get();

        return view('admin.manage_user', ['users' => $users]);
    }
}