<nav class="bg-gray-900 text-white shadow-md relative z-50">
    <div class="w-full px-4 py-3 flex items-center justify-between relative">

        {{-- 
        * ====================
        * Logo (Left)
        * ====================
        --}}
        <div class="flex-shrink-0 z-20">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/logoWKM.png') }}" alt="WKM Logo" class="h-10 w-auto object-contain">
            </a>
        </div>

        {{-- 
        * ====================
        * Links (Desktop MD–XL) - Absolutely Centered
        * ====================
        --}}
        <div class="hidden lg:flex absolute inset-x-0 justify-center z-10 pointer-events-none">
            <ul class="flex flex-row space-x-8 font-bold text-center pointer-events-auto">
                <li>
                    <a class="hover:text-blue-400 transition duration-150" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li>
                    <a class="hover:text-blue-400 transition duration-150" href="{{ route('admin.users.list') }}">User</a>
                </li>
                <li>
                    <a class="hover:text-blue-400 transition duration-150" href="{{ route('admin.projects.list') }}">Portfolio</a>
                </li>
                <li>
                    <a class="hover:text-blue-400 transition duration-150" href="{{ route('admin.products.list') }}">Products</a>
                </li>
                <li>
                    <a class="hover:text-blue-400 transition duration-150" href="{{ route('admin.services.list') }}">Services</a>
                </li>
            </ul>
        </div>

        {{-- 
        * ====================
        * Admin Profile Dropdown (Right)
        * ====================
        --}}
        @auth
            <div class="relative flex-shrink-0 z-20">
                <button id="admin-menu-button" class="flex items-center font-bold focus:outline-none hover:text-gray-300 transition">
                    <span class="mr-2">Admin, {{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </button>

                <div id="admin-menu-content" class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 origin-top-right">
                    <a class="block px-4 py-2 text-sm hover:bg-gray-100" href="{{ url('/') }}">
                        User View
                    </a>
                    
                    <div class="border-t border-gray-100 my-1"></div>
                    
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


    {{-- 
    * ====================
    * Nav for below LG (Mobile)
    * ====================
    --}}
    <div class="lg:hidden w-full">
        <hr class="border-gray-700">

        <div class="text-center py-2">
            <button id="admin-mobile-toggle" type="button" class="text-white focus:outline-none hover:text-blue-400 transition-colors">
                <svg class="w-6 h-6 mx-auto" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
            </button>
        </div>

        <div id="admin-mobile-links" class="hidden w-full pb-4">
            <ul class="flex flex-col items-center justify-center space-y-3 font-medium">
                <li><a class="block px-4 py-2 hover:text-blue-400" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a class="block px-4 py-2 hover:text-blue-400" href="{{ route('admin.users.list') }}">User</a></li>
                <li><a class="block px-4 py-2 hover:text-blue-400" href="{{ route('admin.projects.list') }}">Portfolio</a></li>
                <li><a class="block px-4 py-2 hover:text-blue-400" href="{{ route('admin.products.list') }}">Products</a></li>
                <li><a class="block px-4 py-2 hover:text-blue-400" href="{{ route('admin.services.list') }}">Services</a></li>
            </ul>
        </div>
    </div>
</nav>

{{-- 
* ====================
* Interactive Scripts
* ====================
--}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const adminBtn = document.getElementById('admin-menu-button');
        const adminContent = document.getElementById('admin-menu-content');

        if (adminBtn && adminContent) {
            adminBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                adminContent.classList.toggle('hidden');
            });

            window.addEventListener('click', function (e) {
                if (!adminBtn.contains(e.target) && !adminContent.contains(e.target)) {
                    adminContent.classList.add('hidden');
                }
            });
        }

        const mobileToggle = document.getElementById('admin-mobile-toggle');
        const mobileLinks = document.getElementById('admin-mobile-links');

        if (mobileToggle && mobileLinks) {
            mobileToggle.addEventListener('click', function () {
                mobileLinks.classList.toggle('hidden');

                const icon = mobileToggle.querySelector('svg');
                if(mobileLinks.classList.contains('hidden')){
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                }
                icon.style.transition = 'transform 0.3s';
            });
        }
    });
</script>