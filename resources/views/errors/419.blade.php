@extends('layout.mainlayout')

@section('name', 'Page Expired')

@section('content')
<main class="relative min-h-[597px] bg-gray-900 bg-no-repeat bg-center" style="background-image: url('{{ asset('img/logoWKM.jpg') }}'); background-size: 70%;">
    
    <div class="absolute inset-0 bg-black/70"></div>

    <div class="relative flex flex-col min-h-screen">
        <div class="flex-grow flex items-center justify-center py-12 text-center px-4">
            
            <div>
                <h1 class="text-8xl md:text-9xl font-extrabold text-[#e0bb35]">
                    419
                </h1>

                <p class="text-3xl md:text-4xl font-bold text-white mt-4">
                    Page Expired
                </p>
                
                <p class="text-white/50 mt-4 text-lg">
                    Sorry, the page you are looking for has expired.
                </p>
                
                <div class="mt-12">
                    <a href="{{ url('/') }}" class="inline-block px-8 py-3 text-lg font-bold text-black bg-[#e0bb35] rounded hover:bg-[#e3cf85] transition duration-300 ease-in-out shadow-lg">
                        Go Back Home
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection