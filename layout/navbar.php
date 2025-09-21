<!-- Navbar -->
<header id="navbar" class="navbar-white navbar-dark">
    <nav class="mx-auto px-2 py-4 flex justify-between items-center">
        <!-- Brand on the left -->
        <div class="flex items-center space-x-2">
            <img src="img/ic1.png" alt="Agriswara Logo" class="h-12 nav-logo">
            <a href="index.php" class="font-semibold text-lg">SMASTIC</a>
        </div>

        <!-- Centered Navigation Items (hidden on mobile) -->
        <ul id="desktop-menu" class="hidden md:flex space-x-8 justify-center flex-grow">
            <li><a href="index.php" class="text-black hover:text-gray-300">Home</a></li>
            <li><a href="main.php?p=home" class="text-black hover:text-gray-300">Article</a></li>
        </ul>

        <!-- Right-aligned User Content -->
        <div class="flex items-center space-x-4">
            <!-- Search icon -->
            <a href="main.php?p=searchpage" class="text-dark hover:text-gray-700 px-2">
                <i class="fa fa-magnifying-glass text-2xl"></i>
            </a>
            <?php if (isset($_SESSION['id_user'])) : ?>
                <!-- If user is logged in, display avatar (desktop and mobile) -->
                <div class="flex items-center space-x-2">
                    <a href="main.php?p=profile" class="text-dark hover:text-gray-300">
                        <i class="fas fa-user-circle text-3xl md:text-4xl"></i>
                    </a>
                </div>
            <?php else : ?>
                <!-- If user is not logged in, hide the avatar and show Sign In / Sign Up -->
                <a href="login.php" class="font-semibold py-2 px-4 rounded-full hover:text-gray-300 hidden md:block">Sign In</a>
                <a href="signup.php" class="signup-button bg-black text-white font-semibold py-2 px-4 rounded-full hover:bg-gray-400 hidden md:block">Sign Up</a>
            <?php endif; ?>
            <!-- Hamburger menu (only visible on mobile) -->
            <button id="hamburger" class="block md:hidden text-2xl focus:outline-none">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- Minimalistic Dropdown Menu (hidden by default) -->
    <div id="mobile-menu" class="hidden absolute right-4 top-16 w-48 bg-white rounded-lg shadow-lg z-10">
        <ul class="py-2">
            <li><a href="index.php" class="block px-4 py-2 text-black hover:bg-gray-200">Home</a></li>
            <li><a href="main.php?p=home" class="block px-4 py-2 text-black hover:bg-gray-200">Article</a></li>
            <?php if (isset($_SESSION['id_user'])) : ?>
                <!-- If user is logged in, show profile in mobile menu -->
                <li><a href="main.php?p=profile" class="block px-4 py-2 text-black hover:bg-gray-200">Profile</a></li>
            <?php else : ?>
                <!-- If user is not logged in, show Sign In / Sign Up in mobile menu -->
                <li><a href="login.php" class="block px-4 py-2 text-black hover:bg-gray-200">Sign In</a></li>
                <li><a href="signup.php" class="block px-4 py-2 text-black hover:bg-gray-200">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>

<!-- CSS -->
<style>
    /* Hamburger menu toggle */
    #hamburger:focus {
        outline: none;
    }

    /* Dropdown menu styles */
    #mobile-menu {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    #mobile-menu.show {
        display: block;
        opacity: 1;
    }

    /* Responsive styling */
    @media (max-width: 768px) {
        #desktop-menu {
            display: none;
        }

        #hamburger {
            display: block;
        }
    }

    @media (min-width: 769px) {
        #hamburger {
            display: none;
        }
    }
</style>


<!-- JavaScript -->
<script>
    document.getElementById('hamburger').addEventListener('click', function() {
        var menu = document.getElementById('mobile-menu');
        menu.classList.toggle('show');
    });
</script>