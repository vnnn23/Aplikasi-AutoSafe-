// Navigation functionality
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav-item');
    const orderButton = document.querySelector('.order-button');
    const serviceItems = document.querySelectorAll('.service-item');

    // Handle navigation clicks
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active class from all items
            navItems.forEach(nav => nav.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');
            
            // Simple navigation simulation
            const navText = this.querySelector('span').textContent;
            console.log(`Navigating to: ${navText}`);
        });
    });

    // Handle order button click
    orderButton.addEventListener('click', function() {
        // Add click animation
        this.style.transform = 'scale(0.98)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);
        
        // Simulate order process
        alert('Redirecting to order form...');
        console.log('Order button clicked');
    });

    // Handle service item clicks
    serviceItems.forEach(item => {
        item.addEventListener('click', function() {
            // Add click animation
            this.style.transform = 'translateY(-2px)';
            setTimeout(() => {
                this.style.transform = 'translateY(0)';
            }, 200);
            
            const serviceName = this.querySelector('h4').textContent;
            console.log(`Service selected: ${serviceName}`);
            alert(`Opening details for: ${serviceName}`);
        });
    });

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading states for interactive elements
    function addLoadingState(element, duration = 1000) {
        element.style.opacity = '0.7';
        element.style.pointerEvents = 'none';
        
        setTimeout(() => {
            element.style.opacity = '1';
            element.style.pointerEvents = 'auto';
        }, duration);
    }

    // Simulate API calls with loading states
    const interactiveElements = [orderButton, ...serviceItems];
    interactiveElements.forEach(element => {
        element.addEventListener('click', function() {
            addLoadingState(this, 500);
        });
    });

    // Tombol Pesan Jemput Kendaraan Sekarang
    const orderBtn = document.getElementById('orderBtn');
    if (orderBtn) {
        orderBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/layanan';
        });
    }

    // Link Lainnya >
    const serviceLink = document.querySelector('.service-link');
    if (serviceLink) {
        serviceLink.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/layanan';
        });
    }
});

// Add some dynamic behavior for better UX
window.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    const scrolled = window.pageYOffset;
    
    if (scrolled > 50) {
        header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
    } else {
        header.style.boxShadow = 'none';
    }
});

// Simple animation on page load
window.addEventListener('load', function() {
    const elements = document.querySelectorAll('.service-item, .step, .stat-item');
    elements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            element.style.transition = 'all 0.5s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

