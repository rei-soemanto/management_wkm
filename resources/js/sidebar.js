window.showSidebar = function (html) {
    const sidebar = document.getElementById('detailSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const content = document.getElementById('sidebarContent');

    content.innerHTML = html;

    sidebar.classList.remove('translate-x-full');
    overlay.classList.remove('hidden');
    overlay.classList.add('opacity-100');
    console.log("Opening sidebar")
};

window.hideSidebar = function () {
    const sidebar = document.getElementById('detailSidebar');
    const overlay = document.getElementById('sidebarOverlay');

    sidebar.classList.add('translate-x-full');
    overlay.classList.add('hidden');
    overlay.classList.remove('opacity-100');
    console.log("Closing sidebar")
};

document.getElementById('sidebarOverlay').addEventListener('click', hideSidebar);

document.addEventListener('DOMContentLoaded', () => {
    const detailButtons = document.querySelectorAll('.sidebar-details-trigger');

    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const content = this.getAttribute('data-sidebar-content');
            
            showSidebar(content); 
        });
    });
});