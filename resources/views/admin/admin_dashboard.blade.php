@extends('layout.mainlayout')

@section('name', 'Admin Dashboard')
@section('content')

<main class="min-h-[597px] bg-cover bg-center relative" 
    style="background-image: url('{{ asset('img/aboutpagebg.jpg') }}')">

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-md">
                Admin Dashboard
            </h1>
            <p class="text-lg text-gray-200 font-medium">
                Welcome, {{ Auth::user()->name }}!
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

            @php
                $cards = [
                    [
                        'title' => 'Total User Interest',
                        'value' => $user_count,
                        'route' => 'admin.users.list',
                        'btn_color' => 'bg-[#e0bb35] hover:bg-[#e3cf85] text-[#0f0f0f]',
                    ],
                    [
                        'title' => 'Total Products',
                        'value' => $product_count,
                        'route' => 'admin.products.list',
                        'btn_color' => 'bg-[#e0bb35] hover:bg-[#e3cf85] text-[#0f0f0f]',
                    ],
                    [
                        'title' => 'Total Services',
                        'value' => $service_count,
                        'route' => 'admin.services.list',
                        'btn_color' => 'bg-[#e0bb35] hover:bg-[#e3cf85] text-[#0f0f0f]',
                    ],
                    [
                        'title' => 'Total Projects',
                        'value' => $project_count,
                        'route' => 'admin.projects.list',
                        'btn_color' => 'bg-[#e0bb35] hover:bg-[#e3cf85] text-[#0f0f0f]',
                    ],
                ];
            @endphp

            @foreach($cards as $card)
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden flex flex-col h-full transition-transform hover:-translate-y-1 duration-300">
                <div class="p-6 flex flex-col h-full justify-between">
                    <h5 class="text-lg font-bold text-gray-800 mb-2">{{ $card['title'] }}</h5>
                    
                    <div class="flex justify-between items-end mt-4">
                        <span class="text-3xl font-extrabold text-gray-900">
                            {{ $card['value'] }}
                        </span>
                        <a href="{{ route($card['route']) }}" 
                            class="px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors {{ $card['btn_color'] }}">
                            Manage
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-xl overflow-hidden h-full">
                <div class="p-6">
                    <h5 class="text-lg font-bold text-gray-800 mb-6">Quick Actions</h5>
                    
                    <div class="flex flex-col space-y-3">
                        <a href="{{ route('admin.products.create') }}" class="w-full py-2 px-4 bg-blue-700 hover:bg-blue-800 text-white font-bold rounded-lg text-center shadow-sm transition-colors">
                            Add Product
                        </a>
                        <a href="{{ route('admin.services.create') }}" class="w-full py-2 px-4 bg-green-700 hover:bg-green-800 text-white font-bold rounded-lg text-center shadow-sm transition-colors">
                            Add Service
                        </a>
                        <a href="{{ route('admin.projects.create') }}" class="w-full py-2 px-4 bg-purple-700 hover:bg-purple-800 text-white font-bold rounded-lg text-center shadow-sm transition-colors">
                            Add Project
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection