@extends('layout.mainlayout')

@section('name', 'Unauthorized')
@section('content')
<main class="product-main-background" style="background-image: url('{{ asset('img/logoWKM.jpg') }}'); background-size: 70%;">
    <div class="hero-container d-flex flex-column">
        <div class="bg-overlay min-vh-60 py-5 flex-grow-1 d-flex align-items-center justify-content-center text-center">
            
            <div>
                <h1 class="display-huge fw-bolder text-gold">401</h1>
                <p class="h2 fw-bold text-white mt-4">Unauthorized</p>
                
                <p class="text-white-50 mt-4">Sorry, you are not authorized to access this page.</p>
                
                <div class="mt-5">
                    <a href="{{ url('/') }}" class="btn btn-gold btn-lg fw-bold">
                        Go Back Home
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection