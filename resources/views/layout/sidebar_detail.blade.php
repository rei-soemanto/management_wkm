<div id="sidebarOverlay"
    onclick="hideSidebar()"
    class="fixed inset-0 bg-black/50 opacity-0 transition-opacity duration-300 z-40 hidden">
</div>


<div id="detailSidebar"
    class="fixed top-0 right-0 w-72 h-full bg-[#0f0f0f]
            border-l border-gray-800 shadow-xl
            transform translate-x-full transition-transform duration-300 z-50">

    <button onclick="hideSidebar()"
            class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl">
        &times;
    </button>

    <div class="p-6 pt-14 overflow-y-auto h-full" id="sidebarContent"></div>
</div>
