<!-- Main Content -->
<main class="container mx-auto px-4 py-12">

    <!-- Slider -->
    <?php
    include_once "slider.php";
    ?>

    <!-- Popular Articles Section -->
    <section class="mb-16 relative">
        <h2 class="text-3xl font-bold mb-6">Popular Articles</h2>
        <?php
        include_once "popular_posts.php";
        ?>
    </section>

    <!-- Latest Articles Section -->
    <section class="mb-16 relative">
        <h2 class="text-3xl font-bold mb-6">Latest Articles</h2>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <!-- Article Card Loop -->
            <?php
            $a = "INNER JOIN categories ON posts.category_id = categories.id INNER JOIN users ON posts.author_id = users.id_user";
            $query = $kon->query("SELECT posts.*, categories.name AS category_name, users.username AS author_id FROM posts $a ORDER BY id_post DESC LIMIT 6");
            foreach ($query as $key) {
            ?>
                <article class="bg-white rounded-lg overflow-hidden shadow-md transition-shadow hover:shadow-lg">
                    <a href="?p=readpage&id=<?= $key['id_post'] ?>">
                        <div class="relative h-48">
                            <img src="assets/img/uploads/<?= $key['images'] ?>" alt="Article Image" class="object-cover w-full h-full" />
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-gray-500"><?= date('F d, Y', strtotime($key['created_at'])) ?></span>
                                <a href="main.php?p=categorypage&id=<?= $key['category_id'] ?>" class="px-2 py-1 bg-black text-white text-xs font-medium rounded-full">
                                    <?= $key['category_name'] ?>
                                </a>
                            </div>
                            <a href="main.php?p=readpage&id=<?= $key['id_post'] ?>" class="text-xl font-semibold mb-2 line-clamp-2">
                                <?= $key['tittle'] ?>
                            </a>
                            <a href="main.php?p=readpage&id=<?= $key['id_post'] ?>" class="text-gray-600 text-sm mb-4 line-clamp-3">
                                <?= substr(strip_tags($key['content']), 0, 100) ?>...
                            </a>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="img/ic1.png" loading="lazy" alt="Author Image" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm font-medium"><?= $key['author_id'] ?></span>
                                </div>
                                <span class="text-sm text-gray-500">5 min read</span>
                            </div>
                        </div>
                    </a>
                </article>
            <?php } ?>
        </div>
    </section>


    <!-- Explore by Category Section -->
    <?php
    // Koneksi ke database
    include 'include/koneksi.php'; // Sesuaikan dengan konfigurasi koneksi Anda

    // Fetch categories
    $category_query = $kon->prepare("SELECT * FROM categories");
    $category_query->execute();
    $categories_result = $category_query->get_result();

    // Check if a category is selected, default to "all"
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

    // Fetch posts based on the selected category
    if ($category_id > 0) {
        // If category selected, fetch posts by category ID
        $post_query = $kon->prepare("
        SELECT posts.*, categories.name AS category_name, users.username AS author_name
        FROM posts
        INNER JOIN categories ON posts.category_id = categories.id
        INNER JOIN users ON posts.author_id = users.id_user
        WHERE categories.id = ?
        ORDER BY posts.created_at DESC
    ");
        $post_query->bind_param("i", $category_id);
    } else {
        // If no category is selected, fetch all posts
        $post_query = $kon->prepare("
        SELECT posts.*, categories.name AS category_name, users.username AS author_name
        FROM posts
        INNER JOIN categories ON posts.category_id = categories.id
        INNER JOIN users ON posts.author_id = users.id_user
        ORDER BY posts.created_at DESC
    ");
    }
    $post_query->execute();
    $posts_result = $post_query->get_result();

    ?>

    <!-- Explore by Category Section -->
    <section class="mb-16" id="explore-category">
        <h2 class="text-3xl font-bold mb-6 text-center">Explore by Category</h2>

        <!-- Category Tabs -->
        <div class="category-tabs flex overflow-x-auto scrollbar-hide mb-8 space-x-4 px-4">
            <!-- Make sure the very first item is fully visible and scrollable -->
            <a href="#" class="category-tab active bg-black text-white px-4 py-2 rounded-full whitespace-nowrap flex-shrink-0" data-category="0">All</a>
            <?php
            while ($category = $categories_result->fetch_assoc()) {
                echo '<a href="#" class="category-tab bg-gray-200 text-gray-700 px-4 py-2 rounded-full whitespace-nowrap flex-shrink-0" data-category="' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</a>';
            }
            ?>
        </div>

        <!-- Filtered Posts by Category (Dynamic Content) From load_posts.php -->
        <div id="category-content" class="category-content grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <!-- Posts will be dynamically loaded here -->
        </div>

        <!-- Pagination -->
        <div id="pagination" class="flex justify-center mt-8">
            <!-- Pagination links will be dynamically loaded here -->
        </div>
    </section>


    <style>
        /* Hide the scrollbar but still allow scrolling */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
            scrollbar-width: none;
            /* Firefox */
        }

        /* Ensure the category tabs are scrollable and never cut off */
        .category-tabs {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            padding-left: 16px;
            /* Ensure some space on the left */
            padding-right: 16px;
            /* Ensure some space on the right */
        }

        /* Flex-shrink ensures that each category is its own scrollable unit */
        .category-tabs a {
            flex-shrink: 0;
            /* Prevent items from shrinking to fit */
            padding: 8px 16px;
            /* Proper padding for touch devices */
            border-radius: 9999px;
            /* Fully rounded buttons */
            white-space: nowrap;
            /* Ensure text stays in one line */
        }

        .category-tab.active {
            background-color: #000;
            color: #fff;
        }

        .category-tab:hover {
            background-color: #000;
        }

        /* Global Styling */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Articles Layout */
        .article-card {
            position: relative;
            background-color: #f5f5f5;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .article-card img {
            object-fit: cover;
            width: 100%;
            height: 200px;
        }

        .article-card:hover {
            transform: scale(1.03);
        }

        .article-card .content {
            padding: 1rem;
        }

        .article-card .category-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background-color: black;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
        }

        /* "View More" and "See More" Button */
        .view-more-btn,
        .see-more-btn {
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: bold;
            color: black;
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: color 0.3s ease;
            position: absolute;
            right: 0;
            bottom: 0;
            padding: 0.75rem 1rem;
        }

        .view-more-btn:hover,
        .see-more-btn:hover {
            color: #555;
        }

        .view-more-btn svg,
        .see-more-btn svg {
            margin-left: 0.5rem;
            transition: transform 0.3s ease;
        }

        .view-more-btn:hover svg,
        .see-more-btn:hover svg {
            transform: translateX(5px);
        }

        /* Category Tab Styling */
        .category-tab {
            transition: background-color 0.3s, color 0.3s;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
        }

        .category-tab:hover,
        .category-tab.active {
            background-color: black;
            color: white;
        }



        /* Smooth transitions */
        .post {
            transition: all 0.3s ease;
        }

        .post:hover {
            transform: scale(1.03);
        }

        /* Typography */
        h1,
        h2,
        h3 {
            color: #000;
            font-weight: 700;
            line-height: 1.2;
        }

        p,
        span,
        button {
            font-size: 16px;
        }
    </style>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to load posts via AJAX based on category and page
        function loadPosts(categoryId, page = 1, scroll = true) {
            $.ajax({
                url: 'load_posts.php', // PHP file to load posts dynamically
                type: 'GET',
                data: {
                    category_id: categoryId,
                    page: page
                },
                success: function(response) {
                    // Update the category content with the new posts
                    $('#category-content').html(response.posts);
                    $('#category-pagination').html(response.pagination); // Update Explore by Category pagination

                    // Remove 'active' class from all tabs and apply it to the selected one
                    $('.category-tab').removeClass('active');
                    $('.category-tab[data-category="' + categoryId + '"]').addClass('active');

                    // Only scroll if the scroll argument is true (prevent scrolling on page reload)
                    if (scroll) {
                        $('html, body').animate({
                            scrollTop: $('#explore-category').offset().top
                        }, 500); // Scroll to "Explore by Category" section
                    }
                }
            });
        }

        // Event listener for category tabs
        $(document).on('click', '.category-tab', function(e) {
            e.preventDefault();
            const categoryId = $(this).data('category'); // Get the category ID
            loadPosts(categoryId); // Load posts for the selected category
            localStorage.setItem('lastCategory', categoryId); // Save the selected category to localStorage
        });

        // Event listener for pagination links in Explore by Category ONLY
        $(document).on('click', '#category-pagination .pagination-link', function(e) {
            e.preventDefault();
            const page = $(this).data('page'); // Get the page number
            const categoryId = $('.category-tab.active').data('category'); // Get the current category ID
            loadPosts(categoryId, page); // Load posts for the selected page and category
            localStorage.setItem('lastPage', page); // Save the current page to localStorage
        });

        // On page load, check if we have last category and page stored in localStorage
        const lastCategory = localStorage.getItem('lastCategory') || 0; // Default to 'All' (category 0)
        const lastPage = localStorage.getItem('lastPage') || 1; // Default to page 1
        loadPosts(lastCategory, lastPage, false); // Load posts without scrolling

        // Optionally, clear localStorage on page reload if not needed for future visits
        // localStorage.clear(); 
    });
</script>