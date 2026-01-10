<?php
require_once __DIR__ . "/guard.php";
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
        <button class="cta-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <span>Book Now</span>
        </button>
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
            <button class="cta-button-white">Get Started Free</button>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand -->
            <div class="footer-column">
                <h3 class="footer-brand">Glam<span class="pink-text">Book</span></h3>
                <p class="footer-text">Your trusted platform for beauty and wellness appointments.</p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-column">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-list">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">How It Works</a></li>
                    <li><a href="#">For Businesses</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="footer-column">
                <h4 class="footer-heading">Services</h4>
                <ul class="footer-list">
                    <li><a href="#">Hair Salons</a></li>
                    <li><a href="#">Nail Studios</a></li>
                    <li><a href="#">Spa & Massage</a></li>
                    <li><a href="#">Makeup Artists</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-column">
                <h4 class="footer-heading">Contact Us</h4>
                <ul class="footer-contact">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>123 Beauty Street, Glamour City, GL 12345</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>+1 (555) 123-4567</span>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>hello@glambook.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <p>© 2026 GlamBook. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

<script src="/Projekt-Programim-Web/projekt/includes/js/script.js"></script>
</body>
</html>
