@extends('layout.mainlayout')

@section('name', 'Page Not Found')
@section('content')

<main class="relative bg-gray-900 bg-no-repeat bg-center" 
    style="background-image: url('{{ asset('img/logoWKM.jpg') }}'); background-size: 70%;">

    <div class="min-h-[60vh] md:min-h-[70vh] w-full flex flex-col items-center justify-center bg-black/80 py-20 px-4">
        <div class="text-center max-w-2xl">
            
            <h1 class="text-8xl md:text-9xl font-black text-[#e0bb35] tracking-tight drop-shadow-xl">
                404
            </h1>
            <p class="text-3xl md:text-4xl font-bold text-white mt-4">
                Page Not Found
            </p>
            <p class="text-gray-400 mt-6 text-lg">
                Sorry, the page you are looking for does not exist or has been moved.
            </p>
            <div class="mt-10">
                <a href="{{ url('/') }}" 
                    class="inline-block bg-[#e0bb35] hover:bg-[#e3cf7c] text-white hover:text-white font-bold text-lg py-3 px-8 rounded shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    Go Back Home
                </a>
            </div>

        </div>
    </div>
</main>
@endsection