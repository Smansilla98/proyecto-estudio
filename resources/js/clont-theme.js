// Clont Theme JavaScript Functions

// Sidebar Toggle for Mobile
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const mobileToggle = document.getElementById('mobileSidebarToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            if (sidebar) {
                sidebar.classList.add('active');
            }
        });
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            if (sidebar) {
                sidebar.classList.remove('active');
            }
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (sidebar && sidebar.classList.contains('active')) {
                if (!sidebar.contains(e.target) && !mobileToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        }
    });

    // Profile dropdown
    const profileDropdown = document.getElementById('profileDropdown');
    const profileMenu = document.getElementById('profileMenu');

    if (profileDropdown && profileMenu) {
        profileDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            const isVisible = profileMenu.style.display === 'block';
            profileMenu.style.display = isVisible ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileDropdown.contains(e.target)) {
                profileMenu.style.display = 'none';
            }
        });
    }

    // Dropdown item hover effects
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.background = '#f8fafc';
        });
        item.addEventListener('mouseleave', function() {
            this.style.background = 'transparent';
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
});

// Theme Toggle (Dark/Light Mode) - Future implementation
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
}

// Load saved theme
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
});

