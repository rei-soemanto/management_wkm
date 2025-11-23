
@extends('layout.mainlayout')

@section('name', 'Manage Users')
@section('content')
<main class="min-h-[597px] bg-cover bg-center relative" style="background-image: url('{{ asset('img/aboutpagebg.jpg') }}')">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow-sm">User Interests</h1>
        </div>

        @if (session('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">User Name</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Interested Products</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Interested Services</th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($user->interested_products->count() > 0)
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($user->interested_products as $product)
                                                <li class="text-gray-700">{{ $product->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-400 italic">None</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($user->interested_services->count() > 0)
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($user->interested_services as $service)
                                                <li class="text-gray-700">{{ $service->name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-gray-400 italic">None</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="mailto:{{ $user->email }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded font-bold shadow-sm transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Contact
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection