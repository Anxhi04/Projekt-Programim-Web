<!-- SIDEBAR -->
<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="adminPage.php">
                        <img src="/Projekt-Programim-Web/projekt/public/assets/logo/GlamBookLogo.png"
                             alt="Logo" class="logo-img">
                    </a>
                </div>

                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block">
                        <i class="bi bi-x bi-middle"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">ADMIN PANEL</li>

                <!-- DASHBOARD -->
                <li class="sidebar-item <?= ($currentPage === 'dashboard') ? 'active' : '' ?>">
                    <a href="adminPage.php" class="sidebar-link">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- USERS -->
                <li class="sidebar-item <?= ($currentPage === 'users') ? 'active' : '' ?>">
                    <a href="usersAdm.php" class="sidebar-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Users</span>
                    </a>
                </li>

                <!-- BUSINESSES -->
                <li class="sidebar-item <?= ($currentPage === 'businesses') ? 'active' : '' ?>">
                    <a href="businessesAdm.php" class="sidebar-link">
                        <i class="bi bi-building"></i>
                        <span>Businesses</span>
                    </a>
                </li>

                <!-- SERVICE CATEGORIES -->
                <li class="sidebar-item <?= ($currentPage === 'categories') ? 'active' : '' ?>">
                    <a href="service-categories.php" class="sidebar-link">
                        <i class="bi bi-tags-fill"></i>
                        <span>Service Categories</span>
                    </a>
                </li>

                <!-- BOOKINGS -->
<!--                <li class="sidebar-item --><?php //= ($currentPage === 'bookings') ? 'active' : '' ?><!--">-->
<!--                    <a href="bookingsAdm.php" class="sidebar-link">-->
<!--                        <i class="bi bi-calendar-check-fill"></i>-->
<!--                        <span>Bookings</span>-->
<!--                    </a>-->
<!--                </li>-->

                <!-- PAYMENTS -->
                <li class="sidebar-item <?= ($currentPage === 'payments') ? 'active' : '' ?>">
                    <a href="paymentsAdm.php" class="sidebar-link">
                        <i class="bi bi-credit-card-fill"></i>
                        <span>Payments</span>
                    </a>
                </li>

                <!-- REVIEWS -->
<!--                <li class="sidebar-item --><?php //= ($currentPage === 'reviews') ? 'active' : '' ?><!--">-->
<!--                    <a href="reviews.php" class="sidebar-link">-->
<!--                        <i class="bi bi-star-fill"></i>-->
<!--                        <span>Reviews</span>-->
<!--                    </a>-->
<!--                </li>-->

                <li class="sidebar-title">SYSTEM</li>

                <li class="sidebar-item">
                    <a href="/Projekt-Programim-Web/projekt/public/login.php" class="sidebar-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>


