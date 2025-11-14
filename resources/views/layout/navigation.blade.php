<nav class="bg-gray-900 text-white shadow-md relative z-50">
    <div class="w-full px-4 py-3 flex items-center justify-between">

        {{-- 
        * ====================
        * Logo
        * ====================
        --}}
        <a class="flex-shrink-0 mr-4" href="{{ url('/') }}">
            <img src="{{ asset('img/logoWKM.png') }}" alt="WKM Logo" class="h-10 w-auto object-contain">
        </a>

        {{-- 
        * ====================
        * Nav links (Desktop MD–XL)
        * ====================
        --}}
        <ul class="hidden lg:flex flex-row flex-grow justify-center space-x-8 font-bold text-center mx-auto">
            <li>
                <a class="hover:text-gray-300 transition duration-150 ease-in-out" href="{{ url('/') }}">About</a>
            </li>
            <li>
                <a class="hover:text-gray-300 transition duration-150 ease-in-out" href="{{ url('/project') }}">Portfolio</a>
            </li>
            <li>
                <a class="hover:text-gray-300 transition duration-150 ease-in-out" href="{{ url('/product') }}">Products</a>
            </li>
            <li>
                <a class="hover:text-gray-300 transition duration-150 ease-in-out" href="{{ url('/service') }}">Services</a>
            </li>
        </ul>

        {{-- 
        * ====================
        * Auth / Guest
        * ====================
        --}}
        <div class="flex-shrink-0">
            @guest
                <div class="ml-2 lg:ml-5">
                    <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap transition duration-150">
                        Login
                    </a>
                </div>
            @endguest

            @auth
                <div class="relative ml-2 lg:ml-5">
                    <button id="user-menu-button" class="flex items-center font-bold focus:outline-none hover:text-gray-300">
                        <span class="mr-2">Hello, {{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </button>

                    <div id="user-menu-content" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 text-gray-800 z-50 ring-1 ring-black ring-opacity-5">
                        @if(Auth::user()->role == 'admin')
                            <a class="block px-4 py-2 text-sm hover:bg-gray-100" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                        @else
                            <a class="block px-4 py-2 text-sm hover:bg-gray-100" href="{{ route('user.interests') }}">My Interest List</a>
                        @endif
                        
                        <div class="border-t border-gray-100"></div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="block px-4 py-2 text-sm hover:bg-gray-100 cursor-pointer" 
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    {{-- 
    * ====================
    * Nav for below LG (Mobile)
    * ====================
    --}}
    <div class="lg:hidden w-full">
        <hr class="border-gray-700">

        <div class="text-center py-2">
            <button id="mobile-menu-toggle" type="button" class="text-white focus:outline-none hover:text-gray-300 transition-colors">
                <svg class="w-6 h-6 mx-auto animate-bounce-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <div id="mobile-menu-links" class="hidden w-full pb-4">
            <ul class="flex flex-col items-center justify-center space-y-2 font-medium">
                <li><a class="block py-2 px-4 hover:text-blue-400" href="{{ url('/') }}">About</a></li>
                <li><a class="block py-2 px-4 hover:text-blue-400" href="{{ url('/project') }}">Portfolio</a></li>
                <li><a class="block py-2 px-4 hover:text-blue-400" href="{{ url('/product') }}">Products</a></li>
                <li><a class="block py-2 px-4 hover:text-blue-400" href="{{ url('/service') }}">Services</a></li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu-links');

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });
        }

        const userBtn = document.getElementById('user-menu-button');
        const userContent = document.getElementById('user-menu-content');

        if (userBtn && userContent) {
            userBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                userContent.classList.toggle('hidden');
            });

            window.addEventListener('click', function (e) {
                if (!userBtn.contains(e.target) && !userContent.contains(e.target)) {
                    userContent.classList.add('hidden');
                }
            });
        }
    });
</script>