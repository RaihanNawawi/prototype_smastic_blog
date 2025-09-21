<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
include "include/koneksi.php";

// Assuming you have a database connection $kon
// Query to fetch popular articles (you can define the criteria for 'popular', like number of views or likes)
$popular_articles_query = $kon->query("SELECT posts.*, categories.name AS category_name FROM posts 
                                       INNER JOIN categories ON posts.category_id = categories.id 
                                       ORDER BY id_post DESC LIMIT 4");

// Query to fetch the latest articles
$latest_articles_query = $kon->query("SELECT posts.*, categories.name AS category_name FROM posts 
                                      INNER JOIN categories ON posts.category_id = categories.id 
                                      ORDER BY id_post DESC LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMASTIC Blog - Prototype</title>
    <link rel="icon" href="img/ic3.png" type="image/x-icon">
    <link rel="stylesheet" href="style2.css">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- JavaScript for AOS animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include_once "layout/navbar.php"; ?>

    <!-- Hero Section -->
    <?php
    // Fetch all text content from the database
    $sql = "SELECT text_content FROM text_snippets"; // Replace 'your_table_name' with your actual table name
    $result = $kon->query($sql);

    $text_snippets = [];

    if ($result->num_rows > 0) {
        // Fetch each row and add the text content to the array
        while ($row = $result->fetch_assoc()) {
            $text_snippets[] = $row['text_content'];
        }
    } else {
        echo "No records found.";
    }
    ?>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-screen flex items-center" style="background-image: url('img/ic-2.jpg');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative container mx-auto px-6 text-gray-800 content-wrapper">
            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Kiri: Intro & Explore -->
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4 text-white drop-shadow-lg">
                        Welcome to SMASTIC Blog!
                    </h1>
                    <p class="text-lg text-gray-300 max-w-lg mb-6 drop-shadow-md">
                        <span id="typingText" class="typing-text"></span>
                    </p>

                    <!-- Explore Articles Button -->
                    <div class="flex justify-start">
                        <a href="main.php?p=home"
                            class="group relative inline-flex items-center px-6 py-3 text-lg font-semibold text-black bg-white rounded-xl opacity-90 shadow-md transition-all duration-300 ease-in-out hover:bg-gray-200 hover:shadow-lg">
                            <span class="mr-2">Explore Articles</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Kanan: Artikel Terbaru & Kategori -->
                <div>
                    <!-- Latest Articles -->
                    <h2 class="text-lg font-semibold mb-3 text-white drop-shadow-md flex items-center gap-2">
                        <i class="fas fa-newspaper text-xl"></i> Latest News
                    </h2>
                    <ul class="space-y-2 md:space-y-4">
                        <?php
                        // Fetch latest articles with the author's username
                        $query1 = "SELECT posts.id_post, posts.tittle AS tittle
          FROM posts
          ORDER BY posts.id_post DESC LIMIT 3";
                        $result = mysqli_query($kon, $query1);
                        if (mysqli_num_rows($result) > 0) {
                        ?>
                            <?php while ($article1 = mysqli_fetch_assoc($result)) { ?>
                                <li>
                                    <a href="main.php?p=readpage&id=<?= $article1['id_post'] ?>"
                                        class="block bg-white/20 backdrop-blur-lg border border-white/30
                                    p-3 md:p-4 rounded-md text-sm md:text-base text-white shadow-md
                                    hover:shadow-xl hover:scale-105 transition-transform duration-300
                                    w-full max-w-xs md:max-w-full mx-auto">
                                        <i class="fas fa-thumbtack text-red-500"></i> <span class="text-white"><?= $article1['tittle'] ?></span>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php
                        } else {
                            echo "<p>No articles found.</p>";
                        }
                        ?>
                    </ul>

                    <!-- Popular Categories (Hanya Tampil di desktop) -->
                    <h2 class="hidden md:flex text-lg font-semibold mt-6 mb-3 text-white drop-shadow-md items-center gap-2">
                        <i class="fas fa-folder-open text-xl"></i> Popular Categories
                    </h2>
                    <div class="hidden md:grid grid-cols-2 md:grid-cols-4 gap-2">
                        <?php
                        $query = $kon->query("SELECT * FROM categories ORDER BY id DESC LIMIT 4");
                        foreach ($query as $key) { ?>
                            <a href="main.php?p=categorypage&id=<?= $key['id'] ?>"
                                class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white 
            bg-white/10 backdrop-blur-lg border border-white/20 rounded-lg shadow-md 
            transition-all duration-300 hover:bg-white/20 hover:scale-105">
                                <?= $key['name'] ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Popular Articles Section -->
    <section class="container max-w-7xl mx-auto p-6 py-12">
        <h2 class="text-3xl font-bold mb-8">Popular Articles</h2>

        <!-- Versi Desktop -->
        <div class="hidden md:grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8" data-aos="fade-up" data-aos-delay="200">
            <?php
            $main_article_query = $kon->query("
            SELECT posts.id_post, posts.tittle, posts.content, posts.images, posts.created_at,
            categories.id AS category_id, categories.name AS category_name, users.username AS author_name
            FROM posts
            JOIN users ON posts.author_id = users.id_user
            JOIN categories ON posts.category_id = categories.id
            ORDER BY posts.id_post DESC
            LIMIT 1
        ");
            $main_article = $main_article_query->fetch_assoc();

            $small_articles_query = $kon->query("
            SELECT posts.id_post, posts.tittle, posts.content, posts.images, posts.created_at, categories.id AS category_id, categories.name AS category_name
            FROM posts
            JOIN categories ON posts.category_id = categories.id
            ORDER BY posts.id_post DESC
            LIMIT 1, 3
        ");
            ?>
            <!-- Main Article -->
            <div class="lg:col-span-2" data-aos="fade-up" data-aos-duration="1000">
                <div class="bg-white p-6">
                    <div class="flex items-center mb-4">
                        <img src="img/ic1.png" alt="Main Article Image" loading="lazy" class="w-15 h-10 rounded-full mr-4">
                        <div>
                            <p class="text-sm text-gray-500"><?= $main_article['author_name'] ?></p>
                            <p class="text-xs text-gray-400 mt-1">Author</p>
                        </div>
                    </div>
                    <a href="main.php?p=readpage&id=<?= $main_article['id_post'] ?>" class="text-2xl font-bold mb-4"><?= $main_article['tittle'] ?></a>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <a href="main.php?p=categorypage&id=<?= $main_article['category_id'] ?>" class="mr-4"><?= $main_article['category_name'] ?></a>
                        <p class="text-gray-500 text-sm"><?= date('F d, Y', strtotime($main_article['created_at'])) ?></p>
                    </div>
                    <img src="assets/img/uploads/<?= $main_article['images'] ?>" alt="Main Article Image" loading="lazy" class="w-full h-64 object-cover rounded-lg mb-4">
                </div>
            </div>
            <!-- Small Articles -->
            <div class="grid grid-cols-1 gap-4" data-aos="fade-up" data-aos-duration="1000">
                <?php while ($small_article = $small_articles_query->fetch_assoc()) { ?>
                    <div class="flex bg-white p-4">
                        <div class="flex-grow pr-4">
                            <a href="main.php?p=readpage&id=<?= $small_article['id_post'] ?>" class="text-lg font-semibold mb-2"><?= $small_article['tittle'] ?></a>
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <a href="main.php?p=categorypage&id=<?= $small_article['category_id'] ?>" class="mr-4"><?= $small_article['category_name'] ?></a>
                                <p class="text-gray-500 text-sm"><?= date('F d, Y', strtotime($small_article['created_at'])) ?></p>
                            </div>
                        </div>
                        <img src="assets/img/uploads/<?= $small_article['images'] ?>" loading="lazy" alt="Small Article Image" class="w-32 h-20 object-cover rounded-lg">
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Versi Mobile (Menggunakan Tampilan Latest Articles) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:hidden" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
            <?php
            $mobile_articles_query = $kon->query("
            SELECT posts.id_post, posts.tittle, posts.content, posts.images, posts.created_at, categories.id AS category_id, categories.name AS category_name, users.username AS author_name
            FROM posts
            JOIN users ON posts.author_id = users.id_user
            JOIN categories ON posts.category_id = categories.id
            ORDER BY posts.id_post DESC
            LIMIT 4
        ");
            ?>
            <?php while ($article = mysqli_fetch_assoc($mobile_articles_query)) { ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden transition-transform transform hover:scale-105">
                    <img src="assets/img/uploads/<?= $article['images'] ?>" loading="lazy" class="w-full h-40 object-cover" alt="Article Image">
                    <div class="p-4">
                        <div class="flex items-center space-x-2 text-sm mb-2">
                            <img src="img/ic1.png" loading="lazy" alt="Author Image" class="w-6 h-6 rounded-full object-cover">
                            <span><?= $article['author_name'] ?></span>
                            <span>|</span>
                            <span><?= date('F d, Y', strtotime($article['created_at'])) ?></span>
                        </div>
                        <a href="main.php?p=readpage&id=<?= $article['id_post'] ?>" class="text-lg font-semibold text-gray-900 mb-2"><?= $article['tittle'] ?></a>
                        <a href="main.php?p=readpage&id=<?= $article['id_post'] ?>" class="text-gray-600 text-sm"><?= substr($article['content'], 0, 100) ?>...</a>
                        <div class="flex items-center space-x-1 justify-start mt-2 text-sm text-muted-foreground">
                            <a href="main.php?p=categorypage&id=<?= $article['category_id'] ?>" class="text-black-500 font-semibold"><?= $article['category_name'] ?></a>
                            <span>|</span>
                            <span>8 min read</span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <span id="latest-articles"></span>

    <!-- Latest Post -->
    <?php
    // Fetch latest articles with the author's username
    $query = "SELECT posts.id_post, posts.tittle AS tittle, posts.content, posts.images, posts.created_at,
            categories.id AS category_id, categories.name AS category_name, users.username AS author_name
          FROM posts
          JOIN categories ON posts.category_id = categories.id
          JOIN users ON posts.author_id = users.id_user
          ORDER BY posts.id_post DESC LIMIT 4";

    $result = mysqli_query($kon, $query);

    if (mysqli_num_rows($result) > 0) {
    ?>
        <section class="bg-gray-50 py-12 mt-5">
            <div class="container mx-auto px-6">
                <!-- Section Title -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Latest Articles</h2>
                    <a href="main.php?p=latest_posts" class="text-black-600 hover:text-gray-800 text-sm font-bold">See all →</a>
                </div>

                <!-- Articles Grid -->
                <div id="latest-articles-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up"
                    data-aos-anchor-placement="top-bottom">
                    <?php while ($article = mysqli_fetch_assoc($result)) { ?>
                        <div class="bg-white shadow-md rounded-lg overflow-hidden transition-transform transform hover:scale-105">
                            <img src="assets/img/uploads/<?= $article['images'] ?>" loading="lazy" class="w-full h-40 object-cover" alt="Article Image">
                            <div class="p-4">
                                <div class="flex items-center space-x-2 text-sm mb-2">
                                    <!-- Author Image -->
                                    <img src="img/ic1.png" loading="lazy" alt="Author Image" class="w-6 h-6 rounded-full object-cover">
                                    <!-- Author Name -->
                                    <span><?= $article['author_name'] ?></span>
                                    <span>|</span>
                                    <!-- Formatted Date -->
                                    <span><?= date('F d, Y', strtotime($article['created_at'])) ?></span>
                                </div>
                                <a href="main.php?p=readpage&id=<?= $article['id_post'] ?>" class="text-lg font-semibold text-gray-900 mb-2"><?= $article['tittle'] ?></a> <!-- Article title -->
                                <a href="main.php?p=readpage&id=<?= $article['id_post'] ?>" class="text-gray-600 text-sm"><?= substr($article['content'], 0, 100) ?>...</a> <!-- Short description -->
                                <div class="flex items-center space-x-1 justify-start mt-2 text-sm text-muted-foreground">
                                    <a href="main.php?p=categorypage&id=<?= $article['category_id'] ?>" class="text-black-500 font-semibold"><?= $article['category_name'] ?></a> <!-- Display article category -->
                                    <span>|</span>
                                    <span>8 min read</span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php
    } else {
        echo "<p>No articles found.</p>";
    }
    ?>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="bg-black text-white py-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- School Information Section with Logo -->
                <div class="text-center md:text-left">
                    <img src="img/ic1.png" alt="SMA Sains Tahfizh Logo" class="mx-auto md:mx-0 mb-4" style="max-width: 150px;">
                    <h4 class="font-bold text-xl text-green-400">SMA Sains Tahfizh</h4>
                    <p class="text-green-200">Islamic Center Siak</p>
                    <p class="mt-4 text-gray-300 leading-relaxed">
                        School Address:<br>
                        Komplek Islamic Center Kampung Rempak<br>
                        Provinsi Kec. Siak, Kab. Siak - Riau, Indonesia
                    </p>
                </div>
                <!-- Contact Details -->
                <div class="text-center md:text-left">
                    <h4 class="font-bold text-lg mb-5">Contact Us</h4>
                    <ul class="text-gray-300 space-y-4">
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-phone-alt mr-2 text-green-400"></i>
                            <span>Phone: (0764) 3249465</span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-envelope mr-2 text-green-400"></i>
                            <span>Email: <a href="mailto:smastics@gmail.com" class="hover:text-white">smastics@gmail.com</a></span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-globe mr-2 text-green-400"></i>
                            <span>Website: <a href="http://www.smastic.sch.id" class="hover:text-white">www.smastic.sch.id</a></span>
                        </li>
                    </ul>
                    <h4 class="font-bold text-lg mt-8 mb-4">Stay Connected</h4>
                    <div class="flex flex-col md:flex-row items-center justify-center md:justify-start space-y-4 md:space-y-0 md:space-x-4 mb-2">
                        <a href="https://www.facebook.com/share/g4kocCusPFdRtJ8U/" target='_blank' class="flex items-center gap-2 text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f text-lg"></i>
                            <span class="text-sm md:text-base">Facebook</span>
                        </a>
                        <a href="https://youtube.com/@smasticofficial?si=GoqizrA1K9zlRhvP" target='_blank' class="flex items-center gap-2 text-gray-400 hover:text-white">
                            <i class="fab fa-youtube text-lg"></i>
                            <span class="text-sm md:text-base">YouTube</span>
                        </a>
                        <a href="https://www.instagram.com/smasticsofficial?igsh=MWJ1bnlodzNtdWZ6cQ==" target='_blank' class="flex items-center gap-2 text-gray-400 hover:text-white">
                            <i class="fab fa-instagram text-lg"></i>
                            <span class="text-sm md:text-base">Instagram</span>
                        </a>
                    </div>
                </div>
                <!-- Blog and Social Media Section -->
                <div class="text-center md:text-left">
                    <h4 class="font-bold text-lg mb-4">Explore Our Blog</h4>
                    <ul class="text-gray-300 space-y-4">
                        <?php
                        $query = $kon->query("SELECT * FROM categories ORDER BY id DESC");
                        foreach ($query as $key) { ?>
                            <li><a href="main.php?p=categorypage&id=<?= $key['id'] ?>" class="hover:text-white"><?= $key['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- Map Section  -->
            <div class="mt-8">
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <iframe class="w-full h-64"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.4134134496894!2d102.02761527407107!3d0.816285963060398!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d420d42727d795%3A0x643a20ddb060fc0b!2sSMA%20SAINS%20TAHFIZH%20ISLAMIC%20CENTER%20SIAK!5e0!3m2!1sms!2sid!4v1740654725694!5m2!1sms!2sid"
                        allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
            <!-- Footer Bottom Text -->
            <div class="mt-10 text-center text-sm text-gray-500">
                <p>&copy;
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    SMA Sains Tahfizh. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
    <script>
        // JavaScript for the typing effect
        // PHP array is passed to JavaScript
        const textSnippets = <?php echo json_encode($text_snippets); ?>;

        const typingTextElement = document.getElementById("typingText");
        let snippetIndex = 0;
        let charIndex = 0;
        let typingSpeed = 100; // Typing speed in milliseconds
        let deletingSpeed = 50; // Deleting speed in milliseconds
        let pauseBetween = 1500; // Pause between typing and deleting

        function typeText() {
            if (charIndex < textSnippets[snippetIndex].length) {
                typingTextElement.textContent += textSnippets[snippetIndex].charAt(charIndex);
                charIndex++;
                setTimeout(typeText, typingSpeed);
            } else {
                setTimeout(deleteText, pauseBetween);
            }
        }

        function deleteText() {
            if (charIndex > 0) {
                typingTextElement.textContent = textSnippets[snippetIndex].substring(0, charIndex - 1);
                charIndex--;
                setTimeout(deleteText, deletingSpeed);
            } else {
                snippetIndex = (snippetIndex + 1) % textSnippets.length; // Cycle through text snippets
                setTimeout(typeText, typingSpeed);
            }
        }

        // Start the typing effect on page load
        window.onload = typeText;
        // JavaScript for the typing effect END

        // JavaScript for dynamic navbar style
        document.addEventListener("scroll", function() {
            const navbar = document.getElementById('navbar');
            const hamburger = document.getElementById('hamburger');

            if (window.scrollY > 50) {
                // When scrolled down, apply glassmorphism and adjust text color
                navbar.classList.remove('navbar-transparent', 'navbar-dark');
                navbar.classList.add('navbar-glassmorphism', 'navbar-light');

                // Set hamburger icon to black when scrolled
                hamburger.style.color = "black";
            } else {
                // When at the top, revert back to transparent
                navbar.classList.remove('navbar-glassmorphism', 'navbar-light');
                navbar.classList.add('navbar-transparent', 'navbar-dark');

                // Set hamburger icon to white when at the top of the page
                hamburger.style.color = "white";
            }
        });

        // Ensure dropdown menu text is always black
        var menuItems = document.querySelectorAll('#mobile-menu a');
        menuItems.forEach(function(item) {
            item.style.color = 'black'; // Force text color to black
        });
    </script>

    <script>
        AOS.init();
    </script>
</body>

</html>