<nav class="bg-[#0f0f0f] text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <div class="flex items-center">
                @auth
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                            <img class="h-10 w-auto" src="{{ asset('img/logoWKM.png') }}" alt="WKM Logo">
                            <span class="ml-3 font-bold text-lg tracking-wider text-gray-100 hidden sm:block">
                                WKM <span class="text-[#e0bb35]">MANAGEMENT</span>
                            </span>
                        </a>
                    </div>
                @endauth

                {{-- Desktop Menu --}}
                <div class="hidden lg:ml-8 lg:flex lg:space-x-2">
                    @if(Auth::user()?->userRole?->name === 'Admin')
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f]' }} px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                            <i class="fa-solid fa-chart-line mr-2 !hidden xl:!inline-block"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.users.list') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f]' }} px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                            <i class="fa-solid fa-heart mr-2 !hidden xl:!inline-block"></i> Interest
                        </a>
                        <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f]' }} px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                            <i class="fa-solid fa-boxes-stacked mr-2 !hidden xl:!inline-block"></i> Inventory
                        </a>
                        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f]' }} px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                            <i class="fa-solid fa-server mr-2 !hidden xl:!inline-block"></i> Internal Ops
                        </a>

                        <div class="relative group">
                            <button class="text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f] px-3 py-2 rounded-md text-sm font-medium inline-flex items-center transition">
                                <i class="fa-solid fa-database mr-2 !hidden xl:!inline-block"></i>
                                <span>Master Data</span>
                                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-52 rounded-md shadow-lg bg-[#0f0f0f] border border-gray-800 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50">
                                <div class="py-1">
                                    <a href="{{ route('admin.projects.list') }}" class="px-4 py-2 text-sm text-white hover:bg-[#e0bb35] hover:text-[#0f0f0f] flex items-center">
                                        <i class="fa-solid fa-briefcase mr-2 w-5 text-center !hidden xl:!inline-block"></i> <span>Public Portfolio</span>
                                    </a>
                                    <a href="{{ route('admin.products.list') }}" class="px-4 py-2 text-sm text-white hover:bg-[#e0bb35] hover:text-[#0f0f0f] flex items-center">
                                        <i class="fa-solid fa-tag mr-2 w-5 text-center !hidden xl:!inline-block"></i> <span>Products</span>
                                    </a>
                                    <a href="{{ route('admin.services.list') }}" class="px-4 py-2 text-sm text-white hover:bg-[#e0bb35] hover:text-[#0f0f0f] flex items-center">
                                        <i class="fa-solid fa-gears mr-2 w-5 text-center !hidden xl:!inline-block"></i> <span>Services</span>
                                    </a>
                                    <a href="{{ route('admin.user_manage.list') }}" class="px-4 py-2 text-sm text-white hover:bg-[#e0bb35] hover:text-[#0f0f0f] flex items-center">
                                        <i class="fa-solid fa-users-gear mr-2 w-5 text-center !hidden xl:!inline-block"></i> <span>Users</span>
                                    </a>
                                    <a href="{{ route('clients.index') }}" class="px-4 py-2 text-sm text-white hover:bg-[#e0bb35] hover:text-[#0f0f0f] flex items-center">
                                        <i class="fa-solid fa-handshake mr-2 w-5 text-center !hidden xl:!inline-block"></i> <span>Clients</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()?->userRole?->name === 'Manager')
                        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f]' }} px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                            <i class="fa-solid fa-briefcase mr-2 !hidden xl:!inline-block"></i> My Projects
                        </a>
                        <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f]' }} px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                            <i class="fa-solid fa-boxes-stacked mr-2 !hidden xl:!inline-block"></i> Inventory
                        </a>
                        <a href="{{ route('admin.users.list') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f]' }} px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                            <i class="fa-solid fa-heart mr-2 !hidden xl:!inline-block"></i> Interest
                        </a>
                    @endif

                    @if(Auth::user()?->userRole?->name === 'Employee')
                        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300 hover:bg-[#e3cf85] hover:text-[#0f0f0f]' }} px-3 py-2 rounded-md text-sm font-medium transition flex items-center">
                            <i class="fa-solid fa-briefcase mr-2 !hidden xl:!inline-block"></i> My Projects
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex items-center">
                @auth
                    <div class="hidden lg:flex items-center">
                        <div class="ml-3 relative group">
                            <div class="flex items-center cursor-pointer">
                                <div class="text-right mr-3">
                                    <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-400">{{ Auth::user()->userRole->name ?? 'User' }}</div>
                                </div>
                                <div class="h-10 w-10 rounded-full bg-[#e0bb35] flex items-center justify-center text-black font-semibold overflow-hidden">
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Avatar" class="h-full w-full object-cover">
                                    @else
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-[#0f0f0f] border border-gray-800 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50">
                                <div class="py-1">
                                    <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-white hover:bg-[#e0bb35] hover:text-[#0f0f0f]">Account Management</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-500 hover:bg-red-400 hover:text-white">Log Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth

                {{-- Hamburger Button (Far Right) --}}
                <div class="flex lg:hidden ml-4">
                    <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div class="hidden lg:hidden bg-[#0f0f0f] border-t border-gray-800" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            @if(Auth::user()?->userRole?->name === 'Admin')
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('admin.dashboard') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Dashboard</a>
                <a href="{{ route('admin.users.list') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('admin.users.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Interest</a>
                <a href="{{ route('inventory.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('inventory.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Inventory</a>
                <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('projects.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Internal Ops</a>
                <a href="{{ route('admin.projects.list') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('admin.projects.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Public Portfolio</a>
                <a href="{{ route('admin.products.list') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('admin.products.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Products</a>
                <a href="{{ route('admin.services.list') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('admin.services.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Services</a>
                <a href="{{ route('admin.user_manage.list') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('admin.user_manage.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Users</a>
                <a href="{{ route('clients.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('clients.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Clients</a>
            @endif

            @if(Auth::user()?->userRole?->name === 'Manager')
                <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('projects.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">My Projects</a>
                <a href="{{ route('inventory.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('inventory.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Inventory</a>
                <a href="{{ route('admin.users.list') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.users.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Interest</a>
            @endif

            @auth
            <div class="border-t border-gray-800 mt-4 pt-4 pb-2">
                <div class="flex items-center px-3 mb-3">
                    <div class="shrink-0 h-10 w-10 rounded-full bg-[#e0bb35] flex items-center justify-center text-black font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-[#e0bb35]">{{ Auth::user()->userRole->name }}</div>
                    </div>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-[#e3cf85] hover:text-[#0f0f0f] {{ request()->routeIs('users.*') ? 'bg-[#e0bb35] text-[#0f0f0f]' : 'text-gray-300' }}">Account Management</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-500 hover:bg-red-400 hover:text-white">Log Out</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
</nav>