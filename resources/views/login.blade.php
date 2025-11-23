@extends('layout.mainlayout')

@section('name', 'Login')

@section('content')
<main class="min-h-[550px] bg-cover bg-center relative flex items-center justify-center py-10 px-4 sm:px-6 lg:px-8" style="background-image: url('{{ asset('img/logoWKM.jpg') }}');">
    
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
                    class="w-full py-3 text-center text-sm font-bold uppercase tracking-wider border-b-2 border-[#e0bb35] text-[#e0bb35] transition-colors duration-300 focus:outline-none">
                    Login
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
@endsection