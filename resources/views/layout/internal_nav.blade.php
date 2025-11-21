<nav class="bg-[#0f0f0f] text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- LEFT: Logo & Desktop Links --}}
            <div class="flex items-center">
                {{-- Logo --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img class="h-8 w-auto" src="{{ asset('img/logoWKM.png') }}" alt="WKM Logo">
                    </a>
                    <span class="ml-3 font-bold text-xl tracking-wider text-gray-100 hidden md:block">
                        WKM<span class="text-[#e0bb35]">INTERNAL</span>
                    </span>
                </div>

                {{-- Desktop Menu Links --}}
                <div class="hidden md:ml-10 md:flex md:space-x-4">
                    
                    {{-- === ADMIN LINKS === --}}
                    @if(Auth::user() && Auth::user()->userRole && Auth::user()->userRole->name === 'Admin')
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition">
                            Dashboard
                        </a>
                        
                        <a href="{{ route('admin.users.list') }}" class="{{ request()->routeIs('admin.users.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition">
                            Users
                        </a>

                        <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition">
                            Clients
                        </a>

                        <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fa-solid fa-boxes-stacked mr-1"></i> Inventory
                        </a>

                        {{-- Dropdown for Master Data --}}
                        <div class="relative group">
                            <button class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium inline-flex items-center transition">
                                <span>Master Data</span>
                                <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left">
                                <div class="py-1">
                                    <a href="{{ route('admin.projects.list') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Public Portfolio</a>
                                    <a href="{{ route('admin.products.list') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Products</a>
                                    <a href="{{ route('admin.services.list') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Services</a>
                                </div>
                            </div>
                        </div>

                        {{-- Access to Internal Ops as well --}}
                        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'bg-blue-900 text-white' : 'text-blue-200 hover:bg-blue-800 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition border border-blue-800">
                            Internal Ops
                        </a>
                    @endif

                    {{-- === EMPLOYEE LINKS === --}}
                    @if(Auth::user() && Auth::user()->userRole && Auth::user()->userRole->name === 'Employee')
                        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fa-solid fa-briefcase mr-1"></i> My Projects
                        </a>

                        <a href="{{ route('inventory.index') }}" class="{{ request()->routeIs('inventory.*') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fa-solid fa-boxes-stacked mr-1"></i> Inventory
                        </a>
                    @endif

                </div>
            </div>

            {{-- RIGHT: User Dropdown (ONLY SHOW IF LOGGED IN) --}}
            @auth
                <div class="hidden md:flex items-center">
                    <div class="ml-3 relative group">
                        <div class="flex items-center cursor-pointer text-gray-300 hover:text-white transition">
                            <div class="text-right mr-3">
                                <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-400">{{ Auth::user()->userRole->name ?? 'User' }}</div>
                            </div>
                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold border-2 border-gray-700">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        
                        {{-- Dropdown Content --}}
                        <div class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                    Log Out
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            {{-- MOBILE: Hamburger Button --}}
            <div class="-mr-2 flex md:hidden">
                <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div class="hidden md:hidden bg-gray-800" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-gray-700">
            
            @if(Auth::user() && Auth::user()->userRole && Auth::user()->userRole->name === 'Admin')
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900">Dashboard</a>
                <a href="{{ route('admin.users.list') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Users</a>
                <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-300 hover:text-white hover:bg-blue-800">Internal Ops</a>
            @endif

            @if(Auth::user() && Auth::user()->userRole && Auth::user()->userRole->name === 'Employee')
                <a href="{{ route('projects.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900">My Projects</a>
                <a href="{{ route('inventory.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700">Inventory</a>
            @endif

            @auth
            <div class="border-t border-gray-700 mt-4 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-400 hover:text-white hover:bg-gray-700">
                        Log Out
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>