@extends('layout.mainlayout')

@section('name', 'My Profile')

@section('content')
<div class="bg-black mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if ($action === 'edit')
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('users.index') }}" class="text-sm text-white hover:text-gray-300 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Profile
                </a>
                <h1 class="text-3xl font-bold text-[#e0bb35] mt-2">Edit Profile</h1>
            </div>

            <div class="bg-[#0f0f0f] shadow-lg rounded-xl overflow-hidden border border-[#0f0f0f]">
                <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            @if($user->profile_picture)
                                <img class="h-16 w-16 object-cover rounded-full border-2 border-[#0f0f0f]" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current profile photo" />
                            @else
                                <div class="h-16 w-16 rounded-full bg-[#e0bb35] flex items-center justify-center text-[#0f0f0f] text-2xl font-bold border-2 border-[#0f0f0f]">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" name="profile_picture" class="block w-full text-sm text-gray-300
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-[#e0bb35] file:text-[#0f0f0f]
                                hover:file:bg-[#e3cf85]
                            "/>
                        </label>
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-300 mb-1">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required 
                            class="block w-full rounded-md border-[#e0bb35] shadow-sm text-[#e0bb35] focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-300 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required 
                            class="block w-full rounded-md border-[#e0bb35] shadow-sm text-[#e0bb35] focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2">
                    </div>

                    <hr class="border-[#e0bb35] my-4">
                    <h3 class="text-lg font-medium text-[#e0bb35]">Change Password <span class="text-sm text-gray-300 font-normal">(Leave blank to keep current)</span></h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-300 mb-1">New Password</label>
                            <input type="password" name="password" id="password" placeholder="New Password" class="block w-full rounded-md border-[#e0bb35] shadow-sm text-[#e0bb35] focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-300 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="block w-full rounded-md border-[#e0bb35] shadow-sm text-[#e0bb35] focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-[#e0bb35] flex justify-end gap-3">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#e0bb35] border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-[#e3cf85]">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @else
        <div class="max-w-3xl mx-auto">
            
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#0f0f0f] shadow-xl rounded-2xl overflow-hidden">
                
                <div class="h-32 bg-gradient-to-r from-[#e0bb35] to-[#e3cf85]"></div>
                
                <div class="px-8 pb-8">
                    <div class="relative flex justify-between items-end -mt-12 mb-6">
                        <div class="relative">
                            @if($user->profile_picture)
                                <img class="h-32 w-32 rounded-full border-4 border-[#0f0f0f] object-cover shadow-md" src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}">
                            @else
                                <div class="h-32 w-32 rounded-full border-4 border-[#0f0f0f] bg-[#e0bb35] flex items-center justify-center text-[#0f0f0f] text-4xl font-bold shadow-md">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('users.edit') }}" class="mb-2 inline-flex items-center px-4 py-2 bg-[#e0bb35] border border-[#e0bb35] rounded-md font-semibold text-xs text-black uppercase tracking-widest shadow-sm hover:bg-[#e3cf85] transition">
                            <svg class="w-4 h-4 mr-2 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Profile
                        </a>
                    </div>

                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-[#e0bb35]">{{ $user->name }}</h1>
                        <p class="text-sm font-medium text-gray-300">{{ $user->userRole->name ?? 'User' }}</p>
                        <p class="text-gray-200 mt-1">{{ $user->email }}</p>
                    </div>

                    <hr class="border-[#e0bb35] my-6">

                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-300">Assigned Projects</dt>
                            <dd class="mt-1 text-sm text-[#e0bb35]">{{ $user->projectRoleAssignments->count() }} Active</dd>
                        </div>
                    </dl>

                    <div class="mt-6 pt-6 border-t border-[#e0bb35]">
                        <h3 class="text-lg font-medium text-red-600">Delete Account</h3>
                        <p class="text-sm text-gray-300 mb-4">Permanently delete your account and all associated data.</p>
                        
                        <form method="POST" action="{{ route('users.destroy') }}" class="inline-block" onsubmit="return confirm('Are you absolutely sure? This action cannot be undone.');">
                            @csrf
                            @method('delete')
                            
                            <div class="flex gap-2 items-center">
                                <input type="password" name="password" placeholder="Confirm Password" required class="text-sm text-gray-300 border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 px-3 py-2">
                                <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Delete Account
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </form>
                    </div>

                </div>
            </div>
        </div>

    @endif
</div>
@endsection