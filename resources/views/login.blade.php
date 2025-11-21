@extends('layout.mainlayout')

@section('name', 'Login')

@section('content')
<main class="min-h-screen bg-cover bg-center relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-image: url('{{ asset('img/logoWKM.jpg') }}');">
    
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="relative z-10 w-full max-w-md bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden border border-white/20">
        
        <div class="p-8">
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-block">
                    <img src="{{ asset('img/logoWKM.png') }}" alt="WKM Logo" class="h-20 w-auto mx-auto drop-shadow-md transition-transform hover:scale-105">
                </a>
            </div>

            <div class="flex border-b border-white/20 mb-6">
                <button id="tab-login" onclick="switchTab('login')" 
                    class="w-1/2 py-3 text-center text-sm font-bold uppercase tracking-wider border-b-2 border-[#e0bb35] text-[#e0bb35] transition-colors duration-300 focus:outline-none">
                    Login
                </button>
                <button id="tab-register" onclick="switchTab('register')" 
                    class="w-1/2 py-3 text-center text-sm font-bold uppercase tracking-wider border-b-2 border-transparent text-gray-300 hover:text-white transition-colors duration-300 focus:outline-none">
                    Register
                </button>
            </div>

            <div id="auth-content">
                
                <div id="pane-login" class="animate-fade-in">
                    <h2 class="text-2xl font-bold text-white text-center mb-6">Welcome Back</h2>
                    
                    <form action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-200 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" required
                                class="block w-full rounded-lg border-transparent bg-white/20 text-white placeholder-gray-300 focus:border-[#e0bb35] focus:bg-white/30 focus:ring-0 transition-all py-2.5 px-4 sm:text-sm">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-200 mb-1">Password</label>
                            <input type="password" id="password" name="password" required
                                class="block w-full rounded-lg border-transparent bg-white/20 text-white placeholder-gray-300 focus:border-[#e0bb35] focus:bg-white/30 focus:ring-0 transition-all py-2.5 px-4 sm:text-sm">
                        </div>

                        <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-black bg-[#e0bb35] hover:bg-[#e3cf85] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e0bb35] transition-transform transform hover:-translate-y-0.5">
                            Login
                        </button>
                    </form>
                </div>

                <div id="pane-register" class="hidden animate-fade-in">
                    <h2 class="text-2xl font-bold text-white text-center mb-6">Create Account</h2>
                    
                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-200 mb-1">Full Name</label>
                            <input type="text" id="name" name="name" required
                                class="block w-full rounded-lg border-transparent bg-white/20 text-white placeholder-gray-300 focus:border-[#e0bb35] focus:bg-white/30 focus:ring-0 transition-all py-2.5 px-4 sm:text-sm">
                        </div>

                        <div>
                            <label for="reg_email" class="block text-sm font-bold text-gray-200 mb-1">Email Address</label>
                            <input type="email" id="reg_email" name="email" required
                                class="block w-full rounded-lg border-transparent bg-white/20 text-white placeholder-gray-300 focus:border-[#e0bb35] focus:bg-white/30 focus:ring-0 transition-all py-2.5 px-4 sm:text-sm">
                        </div>

                        <div>
                            <label for="reg_password" class="block text-sm font-bold text-gray-200 mb-1">Password</label>
                            <input type="password" id="reg_password" name="password" required
                                class="block w-full rounded-lg border-transparent bg-white/20 text-white placeholder-gray-300 focus:border-[#e0bb35] focus:bg-white/30 focus:ring-0 transition-all py-2.5 px-4 sm:text-sm">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-200 mb-1">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="block w-full rounded-lg border-transparent bg-white/20 text-white placeholder-gray-300 focus:border-[#e0bb35] focus:bg-white/30 focus:ring-0 transition-all py-2.5 px-4 sm:text-sm">
                        </div>

                        <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-black bg-[#e0bb35] hover:bg-[#e3cf85] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e0bb35] transition-transform transform hover:-translate-y-0.5">
                            Register
                        </button>
                    </form>
                </div>

                @if ($errors->any())
                    <div class="mt-6 bg-red-500/20 border border-red-500 rounded-lg p-4">
                        <ul class="list-disc list-inside text-sm text-red-100">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
</main>

<script>
    function switchTab(tab) {
        const loginPane = document.getElementById('pane-login');
        const registerPane = document.getElementById('pane-register');
        const loginTabBtn = document.getElementById('tab-login');
        const registerTabBtn = document.getElementById('tab-register');

        const activeClasses = ['border-[#e0bb35]', 'text-[#e0bb35]'];
        const inactiveClasses = ['border-transparent', 'text-gray-300', 'hover:text-white'];

        if (tab === 'login') {
            loginPane.classList.remove('hidden');
            registerPane.classList.add('hidden');

            loginTabBtn.classList.add(...activeClasses);
            loginTabBtn.classList.remove(...inactiveClasses);
            
            registerTabBtn.classList.remove(...activeClasses);
            registerTabBtn.classList.add(...inactiveClasses);
        } else {
            registerPane.classList.remove('hidden');
            loginPane.classList.add('hidden');

            registerTabBtn.classList.add(...activeClasses);
            registerTabBtn.classList.remove(...inactiveClasses);
            
            loginTabBtn.classList.remove(...activeClasses);
            loginTabBtn.classList.add(...inactiveClasses);
        }
    }
</script>
@endsection