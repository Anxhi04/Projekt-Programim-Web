<?php
require_once __DIR__ . "/guard.php";
require_once __DIR__ . "/partials/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="css/nav.css">
    <link rel="stylesheet" href="/Projekt-Programim-Web/projekt/includes/css/businesses.css">
</head>
<body class="businesses">
<!-- Header -->
<header>
    <div class="container">
        <div class="header-title">
            <svg class="sparkle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
            <h1>GlamBook</h1>
            <svg class="sparkle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
        </div>
        <p class="header-subtitle">Discover and book appointments with premium beauty service providers</p>
    </div>
</header>

<!-- Search Bar -->
<div class="search-container">
    <div class="container">
        <div class="search-wrapper">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="searchInput" class="search-input" placeholder="Search by business name or service type...">
        </div>
    </div>
</div>

<!-- Main Content -->
<main>
    <div class="container">
        <!-- Stats Banner -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">6+</div>
                <div class="stat-label">Registered Businesses</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12+</div>
                <div class="stat-label">Service Categories</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Online Booking</div>
            </div>
        </div>

        <!-- Section Title -->
        <div class="section-title">
            <h2>Featured Beauty Businesses</h2>
            <p class="section-subtitle" id="businessCount">6 businesses available</p>
        </div>

        <!-- Business Cards Grid -->
        <div id="businessGrid" class="cards-grid"></div>

        <!-- Empty State -->
        <div id="emptyState" class="empty-state">
            <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <h3 class="empty-title">No businesses found</h3>
            <p class="empty-text">Try adjusting your search criteria</p>
        </div>
    </div>
</main>

<script src="/Projekt-Programim-Web/projekt/includes/js/businesses.js"></script>
<?php require_once __DIR__ . "/partials/footer.php";?>
</body>
</html>
