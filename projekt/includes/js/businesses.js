// Business data
const businesses = [
    {
        id: 1,
        name: "Luxe Hair Studio",
        serviceType: "Hair Salon",
        imageUrl: "https://images.unsplash.com/photo-1600948836101-f9ffda59d250?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxoYWlyJTIwc2Fsb24lMjBpbnRlcmlvcnxlbnwxfHx8fDE3NjgxODQxNTZ8MA&ixlib=rb-4.1.0&q=80&w=1080"
    },
    {
        id: 2,
        name: "Polish & Shine",
        serviceType: "Nail Studio",
        imageUrl: "https://images.unsplash.com/photo-1619607146034-5a05296c8f9a?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYWlsJTIwc2Fsb24lMjBpbnRlcmlvcnxlbnwxfHx8fDE3NjgyNDQ3NDB8MA&ixlib=rb-4.1.0&q=80&w=1080"
    },
    {
        id: 3,
        name: "Radiance Beauty Clinic",
        serviceType: "Beauty Clinic",
        imageUrl: "https://images.unsplash.com/photo-1700142360825-d21edc53c8db?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiZWF1dHklMjBjbGluaWMlMjBzcGF8ZW58MXx8fHwxNzY4MTk5MzU5fDA&ixlib=rb-4.1.0&q=80&w=1080"
    },
    {
        id: 4,
        name: "Serenity Spa & Wellness",
        serviceType: "Spa & Massage",
        imageUrl: "https://images.unsplash.com/photo-1757689314932-bec6e9c39e51?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtYXNzYWdlJTIwc3BhJTIwd2VsbG5lc3N8ZW58MXx8fHwxNzY4MjQ0MTczfDA&ixlib=rb-4.1.0&q=80&w=1080"
    },
    {
        id: 5,
        name: "Glam Studio",
        serviceType: "Makeup Studio",
        imageUrl: "https://images.unsplash.com/photo-1653641621097-d25366c2c6a4?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtYWtldXAlMjBzdHVkaW8lMjBjb3NtZXRpY3N8ZW58MXx8fHwxNzY4MjQ0MTczfDA&ixlib=rb-4.1.0&q=80&w=1080"
    },
    {
        id: 6,
        name: "The Modern HairStyle",
        serviceType: "Hair Salon",
        imageUrl: "https://images.unsplash.com/photo-1759134198561-e2041049419c?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiYXJiZXJzaG9wJTIwbW9kZXJufGVufDF8fHx8MTc2ODI0Mzk2OXww&ixlib=rb-4.1.0&q=80&w=1080"
    }
];

let filteredBusinesses = [...businesses];

// Render business cards
function renderBusinessCards() {
    const grid = document.getElementById('businessGrid');
    const emptyState = document.getElementById('emptyState');
    const businessCount = document.getElementById('businessCount');

    grid.innerHTML = '';

    if (filteredBusinesses.length === 0) {
        grid.style.display = 'none';
        emptyState.style.display = 'block';
        businessCount.textContent = '0 businesses available';
    } else {
        grid.style.display = 'grid';
        emptyState.style.display = 'none';
        businessCount.textContent = filteredBusinesses.length + ' ' + (filteredBusinesses.length === 1 ? 'business' : 'businesses') + ' available';

        filteredBusinesses.forEach(function(business) {
            const card = document.createElement('div');
            card.className = 'business-card';
            card.onclick = function() {
                openBookingPage(business);
            };

            card.innerHTML =
                '<div class="card-image-container">' +
                '<img src="' + business.imageUrl + '" alt="' + business.name + '" class="card-image">' +
                '<div class="card-overlay"></div>' +
                '<div class="card-book-now">Book Now</div>' +
                '</div>' +
                '<div class="card-content">' +
                '<h3 class="card-title">' + business.name + '</h3>' +
                '<p class="card-service-type">' +
                '<span class="service-dot"></span>' +
                business.serviceType +
                '</p>' +
                '</div>' +
                '<div class="card-accent"></div>';

            grid.appendChild(card);
        });
    }
}

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();

        filteredBusinesses = businesses.filter(function(business) {
            return business.name.toLowerCase().includes(query) ||
                business.serviceType.toLowerCase().includes(query);
        });

        renderBusinessCards();
    });

    // Initial render
    renderBusinessCards();
});

// Open booking page (you can customize this function later)
function openBookingPage(business) {
    if (business.id === 1) {

        const bookingUrl = "/Projekt-Programim-Web/projekt/includes/book-service.php?businessId=" + business.id;
        window.location.href = bookingUrl;
    } else {

        alert(
            `Booking for "${business.name}" is not available yet.\n` +
            `We are working on adding this service soon!`
        );
        console.warn(`Booking not implemented for business id: ${business.id}`);
    }
}
