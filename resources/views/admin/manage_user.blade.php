@extends('layout.mainlayout')

@section('name', 'Manage Users')
@section('content')
<main class="min-h-[597px] bg-cover bg-center relative" style="background-image: url('{{ asset('img/aboutpagebg.jpg') }}')">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- HEADER SECTION --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow-sm">User Interests</h1>

            <form action="{{ route('admin.user_manage.list') }}" method="GET" class="flex-1 w-full md:max-w-md mx-4">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search users by name or email..." 
                        class="w-full bg-white/90 text-gray-800 border-none rounded-lg py-2 px-4 pl-10 focus:ring-2 focus:ring-blue-500 shadow-lg"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.user_manage.list') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-red-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if (session('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif

        {{-- TABLE SECTION --}}
        <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider hidden lg:table-cell">Email</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider hidden sm:table-cell">Interested Products</th>
                            <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider hidden md:table-cell">Interested Services</th>
                            <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500 lg:hidden">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 hidden lg:table-cell">
                                    {{ $user->email }}
                                </td>
                                
                                {{-- Products List --}}
                                <td class="px-6 py-4 text-sm hidden sm:table-cell">
                                    @if ($user->interested_products->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($user->interested_products as $product)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $product->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-xs">No products</span>
                                    @endif
                                </td>

                                {{-- Services List --}}
                                <td class="px-6 py-4 text-sm hidden md:table-cell">
                                    @if ($user->interested_services->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($user->interested_services as $service)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $service->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-xs">No services</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex flex-col gap-2">
                                        <a href="mailto:{{ trim($user->email) }}" target="_blank" rel="noopener noreferrer"
                                            class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold py-1.5 px-3 rounded shadow-sm transition-colors uppercase flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Contact
                                        </a>
                                        
                                        {{-- Details Toggle (for mobile viewing of lists) --}}
                                        <button type="button" 
                                            class="view-details-btn cursor-pointer bg-gray-500 hover:bg-gray-600 text-white text-[10px] font-bold py-1.5 px-3 rounded shadow-sm transition-colors uppercase"
                                            data-sidebar-title="User Interest Details"
                                            data-sidebar-schema="{{ json_encode([
                                                ['type' => 'header', 'label' => 'User', 'value' => $user->name],
                                                ['type' => 'normal-text', 'label' => 'Email', 'value' => $user->email],
                                                ['type' => 'badge-list', 'label' => 'Interested Products', 'value' => $user->interested_products->pluck('name')->implode(', ') ?: 'None'],
                                                ['type' => 'badge-list', 'label' => 'Interested Services', 'value' => $user->interested_services->pluck('name')->implode(', ') ?: 'None'],
                                            ]) }}">
                                            View All
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No user interests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</main>
@endsection