<?php
require_once __DIR__ . "/partials/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlamBook - Beauty Reservations Made Easy</title>
    <link rel="stylesheet" href="/Projekt-Programim-Web/projekt/includes/css/styles.css">
</head>
<body class="homepage">
<!-- Hero Carousel Section -->
<div class="hero-carousel">
    <div class="carousel-container">
        <div class="carousel-slide active">
            <img src="https://images.unsplash.com/photo-1626383137804-ff908d2753a2?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxiZWF1dHklMjBzYWxvbiUyMGludGVyaW9yfGVufDF8fHx8MTc2NzkxNDAxNnww&ixlib=rb-4.1.0&q=80&w=1080" alt="Beauty Salon Interior">
            <div class="overlay"></div>
        </div>
        <div class="carousel-slide">
            <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxoYWlyJTIwc2Fsb24lMjBzdHlsaW5nfGVufDF8fHx8MTc2Nzg5ODA3MHww&ixlib=rb-4.1.0&q=80&w=1080" alt="Hair Salon Styling">
            <div class="overlay"></div>
        </div>
        <div class="carousel-slide">
            <img src="https://images.unsplash.com/photo-1630595633877-9918ee257288?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxzcGElMjB0cmVhdG1lbnQlMjB3ZWxsbmVzc3xlbnwxfHx8fDE3Njc5OTUxMDF8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Spa Treatment Wellness">
            <div class="overlay"></div>
        </div>
        <div class="carousel-slide">
            <img src="https://images.unsplash.com/photo-1613457492120-4fcfbb7c3a5b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxuYWlsJTIwc2Fsb24lMjBtYW5pY3VyZXxlbnwxfHx8fDE3Njc5Mzc1MDl8MA&ixlib=rb-4.1.0&q=80&w=1080" alt="Nail Salon Manicure">
            <div class="overlay"></div>
        </div>
        <div class="carousel-slide">
            <img src="https://images.unsplash.com/photo-1698181842513-2179d5f8bc65?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtYWtldXAlMjBhcnRpc3QlMjBiZWF1dHl8ZW58MXx8fHwxNzY3OTI5Nzg4fDA&ixlib=rb-4.1.0&q=80&w=1080" alt="Makeup Artist Beauty">
            <div class="overlay"></div>
        </div>

    </div>

    <!-- Content Overlay -->
    <div class="hero-content">
        <h1 class="hero-title">Glam<span class="pink-text">Book</span></h1>
        <p class="hero-subtitle">Your beauty appointments, simplified. Book your next salon, spa, or wellness session in seconds.</p>
        <a href="/Projekt-Programim-Web/projekt/public/login.php" class="cta-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span>Book Now</span>
        </a>

    </div>

    <!-- Carousel Indicators -->
    <div class="carousel-indicators">
        <button class="indicator active" data-slide="0"></button>
        <button class="indicator" data-slide="1"></button>
        <button class="indicator" data-slide="2"></button>
        <button class="indicator" data-slide="3"></button>
        <button class="indicator" data-slide="4"></button>
    </div>
</div>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What We <span class="pink-text">Offer</span></h2>
            <p class="section-subtitle">GlamBook connects you with the best beauty professionals and makes booking effortless.</p>
        </div>

        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Find Your Perfect Match</h3>
                <p class="feature-description">Browse through hundreds of beauty professionals and services in your area.</p>
            </div>

            <!-- Feature 2 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <h3 class="feature-title">Easy Booking</h3>
                <p class="feature-description">Book appointments 24/7 with real-time availability and instant confirmation.</p>
            </div>

            <!-- Feature 3 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <h3 class="feature-title">Time Management</h3>
                <p class="feature-description">Manage all your appointments in one place. Never miss a booking again.</p>
            </div>

            <!-- Feature 4 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                    </svg>
                </div>
                <h3 class="feature-title">Verified Reviews</h3>
                <p class="feature-description">Read authentic reviews from real clients to make informed decisions.</p>
            </div>

            <!-- Feature 5 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Smart Reminders</h3>
                <p class="feature-description">Get timely notifications and reminders for your upcoming appointments.</p>
            </div>

            <!-- Feature 6 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                </div>
                <h3 class="feature-title">Secure Payments</h3>
                <p class="feature-description">Pay safely online or in-person with our flexible payment options.</p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="cta-section">
            <h3 class="cta-title">Ready to Transform Your Beauty Routine?</h3>
            <p class="cta-text">Join thousands of satisfied clients who have discovered the easiest way to book beauty services.</p>
            <a href="/Projekt-Programim-Web/projekt/public/login.php" >
                <button class="cta-button-white">Get Started Free</button>
            </a>
        </div>
    </div>
</section>


<script src="/Projekt-Programim-Web/projekt/includes/js/script.js"></script>

<?php require_once __DIR__ . "/partials/footer.php";?>
</body>
</html>
