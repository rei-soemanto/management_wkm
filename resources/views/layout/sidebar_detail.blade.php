<div id="sidebarOverlay" class="fixed inset-0 bg-black/40 opacity-0 transition-opacity duration-300 z-40 hidden"></div>

<div id="detailSidebar" class="fixed top-0 right-0 w-full sm:w-[450px] h-full bg-[#0f0f0f] border-l border-white/10 shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
    <div class="p-6 border-b border-white/5 flex justify-between items-center">
        <h2 id="sidebarTitle" class="text-xl font-bold text-white tracking-tight"></h2>
        <button onclick="hideSidebar()" class="text-gray-400 hover:text-white transition-colors p-2 bg-white/5 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="h-[calc(100%-80px)] overflow-y-auto sidebar-scrollbar" id="sidebarContent"></div>
</div>