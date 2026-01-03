@extends('layout.mainlayout')

@section('name', 'My Profile')

@section('content')
<div class="bg-black min-h-screen mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if ($action === 'edit')
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('users.index') }}" class="text-sm text-gray-400 hover:text-[#e0bb35] flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Profile
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-[#e0bb35] mt-2">Edit Profile</h1>
            </div>

            <div class="bg-[#0f0f0f] shadow-lg rounded-xl overflow-hidden border border-gray-800">
                <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data" class="p-5 sm:p-8 space-y-6">
                    @csrf
                    @method('PATCH')

                    {{-- Profile Picture Upload --}}
                    <div class="flex flex-col sm:flex-row items-center gap-4 pb-4">
                        <div class="h-20 w-20 rounded-full bg-[#e0bb35] flex items-center justify-center text-black font-bold text-2xl overflow-hidden">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" class="h-full w-full object-cover">
                            @else
                                {{ substr($user->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="flex-1 w-full">
                            <label class="block text-sm font-medium text-[#e0bb35] mb-1">Profile Picture</label>
                            <input type="file" name="profile_picture" class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#e0bb35] file:text-black hover:file:bg-[#e3cf85]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-[#e0bb35] mb-1">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                                class="block w-full rounded-md border-gray-700 bg-[#1a1a1a] text-gray-300 focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-[#e0bb35] mb-1">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                                class="block w-full rounded-md border-gray-700 bg-[#1a1a1a] text-gray-300 focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <hr class="border-gray-800 my-4">
                    <h3 class="text-lg font-medium text-[#e0bb35]">Change Password <span class="text-xs text-gray-400 font-normal block sm:inline">(Leave blank to keep current)</span></h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-[#e0bb35] mb-1">New Password</label>
                            <input type="password" name="password" id="password" class="block w-full rounded-md border-gray-700 bg-[#1a1a1a] text-gray-300 focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-[#e0bb35] mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full rounded-md border-gray-700 bg-[#1a1a1a] text-gray-300 focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-800 flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <a href="{{ route('users.index') }}" class="w-full sm:w-auto text-center px-4 py-2 bg-gray-800 border border-gray-700 rounded-md font-semibold text-xs text-gray-300 uppercase tracking-widest hover:bg-gray-700 transition">
                            Cancel
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-[#e0bb35] border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-[#e3cf85] transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @else
        <div class="max-w-3xl mx-auto">
            
            @if (session('success'))
                <div class="bg-green-900/20 border-l-4 border-green-500 text-green-400 p-4 mb-6 rounded shadow-md text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#0f0f0f] shadow-xl rounded-2xl overflow-hidden border border-gray-800">
                
                {{-- Cover Header --}}
                <div class="h-24 sm:h-32 bg-linear-to-r from-[#e0bb35] to-[#e3cf85]"></div>
                
                <div class="px-5 sm:px-8 pb-8">
                    {{-- Profile Image & Edit Button --}}
                    <div class="relative flex flex-col sm:flex-row justify-between items-center sm:items-end -mt-12 sm:-mt-16 mb-6 gap-4">
                        <div class="relative">
                            @if($user->profile_picture)
                                <img class="h-24 w-24 sm:h-32 sm:w-32 rounded-full border-4 border-[#0f0f0f] object-cover shadow-md" src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                            @else
                                <div class="h-24 w-24 sm:h-32 sm:w-32 rounded-full border-4 border-[#0f0f0f] bg-[#e0bb35] flex items-center justify-center text-[#0f0f0f] text-3xl sm:text-4xl font-bold shadow-md">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('users.edit') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-[#e0bb35] border border-[#e0bb35] rounded-md font-semibold text-xs text-black uppercase tracking-widest shadow-sm hover:bg-[#e3cf85] transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Profile
                        </a>
                    </div>

                    {{-- User Info --}}
                    <div class="text-center sm:text-left mb-6">
                        <h1 class="text-2xl sm:text-3xl font-bold text-[#e0bb35]">{{ $user->name }}</h1>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 mt-1">
                            <p class="text-sm font-medium text-gray-400">{{ $user->userRole->name ?? 'User' }}</p>
                            <span class="hidden sm:inline text-gray-700">•</span>
                            <p class="text-sm text-gray-300">{{ $user->email }}</p>
                        </div>
                    </div>

                    <hr class="border-gray-800 my-6">

                    {{-- Stats --}}
                    <dl class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="p-4 bg-[#1a1a1a] rounded-lg border border-gray-800 text-center sm:text-left">
                            <dt class="text-xs font-medium text-[#e0bb35] uppercase tracking-wider">Assigned Projects</dt>
                            <dd class="mt-1 text-xl font-semibold text-white">{{ $user->projectRoleAssignments->count() }} <span class="text-sm font-normal text-gray-400">Active</span></dd>
                        </div>
                    </dl>

                    {{-- Danger Zone --}}
                    <div class="mt-8 pt-6 border-t border-gray-800">
                        <h3 class="text-lg font-medium text-red-500">Delete Account</h3>
                        <p class="text-sm text-gray-400 mb-4">Once you delete your account, you can't restore it.</p>
                        
                        <form method="POST" action="{{ route('users.destroy') }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.');">
                            @csrf
                            @method('delete')
                            
                            <input type="password" name="password" placeholder="Confirm Password to Delete" required 
                                class="grow text-sm bg-[#1a1a1a] text-gray-300 border-gray-700 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 px-3 py-2">
                            
                            <button type="submit" class="whitespace-nowrap px-4 py-2 bg-red-600/10 border border-red-600/50 rounded-md font-semibold text-xs text-red-500 uppercase tracking-widest hover:bg-red-600 hover:text-white transition">
                                Delete Account
                            </button>
                        </form>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

    @endif
</div>
@endsection