document.addEventListener('click', function(e) {
    // Look for any element with the schema attribute
    const btn = e.target.closest('[data-sidebar-schema]');
    
    if (btn) {
        try {
            const title = btn.getAttribute('data-sidebar-title') || 'Details';
            const schema = JSON.parse(btn.getAttribute('data-sidebar-schema'));

            window.renderSidebar(title, schema);
        } catch (error) {
            console.error("Error parsing sidebar schema:", error);
        }
    }
});

window.renderSidebar = function (title, schema) {
    const sidebar = document.getElementById('detailSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const titleEl = document.getElementById('sidebarTitle');
    const content = document.getElementById('sidebarContent');

    // Set Title in Gold
    titleEl.innerText = title.toUpperCase();
    titleEl.style.color = '#e0bb35';
    content.innerHTML = ''; 

    const container = document.createElement('div');
    container.className = 'p-6 space-y-8';

    schema.forEach(item => {
        let section = document.createElement('div');
        
        switch(item.type) {
            case 'image':
                section.innerHTML = `<img src="${item.value}" class="w-full h-64 object-cover rounded-xl border border-white/10 shadow-2xl">`;
                break;
            
            case 'header':
                section.innerHTML = `
                    <label class="block text-[#e0bb35] text-[10px] font-bold uppercase tracking-[0.2em] mb-1">${item.label}</label>
                    <h3 class="text-white text-2xl font-bold tracking-tight">${item.value}</h3>`;
                break;

            case 'lead':
                section.innerHTML = `
                    <p class="text-gray-300 text-sm leading-relaxed bg-white/5 p-4 rounded-lg border-l-2 border-[#e0bb35] wrap-break-word whitespace-normal overflow-wrap-anywhere">
                        ${item.value}
                    </p>`;
                break;

            case 'normal-text':
                section.innerHTML = `
                    <p class="text-gray-300 text-sm leading-relaxed wrap-break-word whitespace-normal overflow-wrap-anywhere">
                        ${item.value}
                    </p>`;
                break;

            case 'grid':
                let gridHtml = `<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">`;
                item.items.forEach(gridItem => {
                    gridHtml += `
                        <div class="bg-white/5 p-3 rounded-lg border border-white/5 flex flex-col gap-1">
                            <label class="text-gray-500 text-[9px] uppercase font-bold tracking-wider">${gridItem.label}</label>
                            <p class="text-gray-200 text-sm font-medium">${gridItem.value}</p>
                        </div>`;
                });
                gridHtml += `</div>`;
                section.innerHTML = gridHtml;
                break;

            case 'badge-list':
                const badgeValues = (item.value && typeof item.value === 'string') ? item.value : '';
                let badgeHtml = `<label class="text-gray-500 text-[10px] uppercase font-bold block mb-2">${item.label}</label><div class="flex flex-wrap gap-2">`;
                
                if (badgeValues.trim().length > 0) {
                    badgeValues.split(',').forEach(val => {
                        badgeHtml += `<span class="px-2 py-1 bg-[#e0bb35]/10 text-[#e0bb35] text-[10px] font-bold rounded border border-[#e0bb35]/20 uppercase">${val.trim()}</span>`;
                    });
                } else {
                    badgeHtml += `<span class="text-gray-500 text-xs italic">None</span>`;
                }
                badgeHtml += `</div>`;
                section.innerHTML = badgeHtml;
                break;
        }
        container.appendChild(section);
    });

    content.appendChild(container);

    // Show Sidebar
    sidebar.classList.remove('translate-x-full');
    overlay.classList.remove('hidden', 'pointer-events-none');
    setTimeout(() => overlay.classList.add('opacity-100'), 10);
};

window.hideSidebar = function () {
    const sidebar = document.getElementById('detailSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    sidebar.classList.add('translate-x-full');
    overlay.classList.remove('opacity-100');
    setTimeout(() => {
        overlay.classList.add('hidden', 'pointer-events-none');
    }, 300);
};

document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('sidebarOverlay');
    if(overlay) {
        overlay.addEventListener('click', hideSidebar);
    }
});