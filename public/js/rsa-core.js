/**
 * RSA International Premium - Core JS
 * Handles Theme Toggle, Search Overlay, Cart Drawer, and UI Interactions.
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // --- Theme Engine ---
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    const themeIcon = themeToggle?.querySelector('i');

    function setTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem('rsa_theme', theme);
        if(themeIcon) {
            themeIcon.className = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
        }
    }

    // Init Theme
    const savedTheme = localStorage.getItem('rsa_theme') || 'dark';
    setTheme(savedTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const target = current === 'dark' ? 'light' : 'dark';
            setTheme(target);
        });
    }

    // --- Search Overlay ---
    const searchTrigger = document.getElementById('searchTrigger');
    const closeSearch = document.getElementById('closeSearch');
    const searchOverlay = document.getElementById('searchOverlay');
    const searchInput = searchOverlay?.querySelector('input');

    if (searchTrigger && searchOverlay) {
        searchTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            searchOverlay.classList.add('active');
            setTimeout(() => searchInput?.focus(), 100);
        });
    }

    if (closeSearch && searchOverlay) {
        closeSearch.addEventListener('click', () => {
            searchOverlay.classList.remove('active');
        });
    }

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            searchOverlay?.classList.remove('active');
            document.getElementById('cartDrawer')?.classList.remove('active');
            document.getElementById('cartOverlay')?.classList.remove('active');
        }
    });

    // --- Cart Drawer ---
    const cartTrigger = document.getElementById('cartTrigger');
    const closeCart = document.getElementById('closeCart');
    const cartDrawer = document.getElementById('cartDrawer');
    const cartOverlay = document.getElementById('cartOverlay');

    function toggleCart(show) {
        if (show) {
            cartDrawer?.classList.add('active');
            cartOverlay.style.visibility = 'visible';
            cartOverlay.style.opacity = '1';
        } else {
            cartDrawer?.classList.remove('active');
            cartOverlay.style.opacity = '0';
            setTimeout(() => cartOverlay.style.visibility = 'hidden', 400);
        }
    }

    if (cartTrigger) {
        cartTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            toggleCart(true);
        });
    }

    if (closeCart) {
        closeCart.addEventListener('click', () => toggleCart(false));
    }
    
    if (cartOverlay) {
        cartOverlay.addEventListener('click', () => toggleCart(false));
    }
    
    // --- Mobile Menu Toggle ---
    const mobileToggle = document.getElementById('mobileMenuToggle');
    // Implement mobile menu logic here if needed, or if utilizing bootstrap collapse
});
