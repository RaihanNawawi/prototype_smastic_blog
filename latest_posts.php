<?php
// Koneksi ke database
include 'include/koneksi.php'; // Sesuaikan dengan konfigurasi koneksi Anda

// Number of posts per page
$limit = 6;
$offset = isset($_GET['page']) ? ($_GET['page'] - 1) * $limit : 0; // Calculate offset based on page number

// Query to fetch latest posts ordered by created_at
$query = $kon->prepare("
    SELECT posts.*, categories.name AS category_name, users.username AS author_name
    FROM posts
    INNER JOIN categories ON posts.category_id = categories.id
    INNER JOIN users ON posts.author_id = users.id_user
    ORDER BY posts.created_at DESC
    LIMIT ?, ?
");
$query->bind_param("ii", $offset, $limit);
$query->execute();
$result = $query->get_result();

?>

<!-- HTML Section -->
<section class="bg-white py-20 px-6">
    <div class="container mx-auto max-w-6xl">
        <div class="text-center mb-10">
            <h1 class="text-5xl md:text-6xl font-extrabold text-black">Latest Articles</h1>
            <p class="text-lg text-gray-600 mt-4">Stay updated with the most recent news and articles.</p>
        </div>
    </div>
</section>

<!-- Main Content Area -->
<main class="container mx-auto px-4 py-12">
    <!-- Blog Post Grid -->
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3" id="post-container">
        <?php
        if ($result->num_rows > 0) {
            // Loop through posts
            while ($post = $result->fetch_assoc()) {
        ?>
                <article class="bg-white rounded-lg overflow-hidden shadow-md transition-shadow hover:shadow-lg">
                    <a href="?p=readpage&id=<?= htmlspecialchars($post['id_post']) ?>">
                        <div class="relative h-48">
                            <img src="assets/img/uploads/<?= htmlspecialchars($post['images']) ?>" alt="Blog post" class="object-cover w-full h-full" />
                        </div>
                    </a>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-gray-500"><?= date('F d, Y', strtotime($post['created_at'])) ?></span>
                            <a href="?p=categorypage&id=<?= htmlspecialchars($post['category_id']) ?>" class="px-2 py-1 bg-black text-white text-xs font-medium rounded-full"><?= htmlspecialchars($post['category_name']) ?></a>
                        </div>
                        <a href="?p=readpage&id=<?= htmlspecialchars($post['id_post']) ?>" class="text-xl font-semibold mb-2 line-clamp-2"><?= htmlspecialchars($post['tittle']) ?></a>
                        <a href="?p=readpage&id=<?= htmlspecialchars($post['id_post']) ?>" class="text-gray-600 text-sm mb-4 line-clamp-3"><?= substr($post['content'], 0, 120) ?>...</a>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <img src="img/ic1.png" loading="lazy" alt="Author Image" class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-medium"><?= htmlspecialchars($post['author_name']) ?></span>
                            </div>
                            <span class="text-sm text-gray-500">5 min read</span>
                        </div>
                    </div>
                </article>
        <?php
            }
        } else {
            echo "<p class='text-lg font-semibold text-red-500 mb-8 text-center'>No posts found.</p>";
        }
        ?>
    </div>

    <!-- (Pagination) -->
    <div class="mt-16 flex justify-center">
        <?php
        // Fetch total post count for pagination
        $count_query = $kon->query("SELECT COUNT(*) AS total FROM posts");
        $total_posts = $count_query->fetch_assoc()['total'];
        $total_pages = ceil($total_posts / $limit);

        // Check if the 'page' parameter exists in the URL and if it's a valid number
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($total_pages > 1) {
            // Start pagination navigation
            echo '<nav class="inline-flex items-center space-x-2 rounded-md shadow">';

            // Previous Button
            if ($page > 1) {
                echo '<a href="main.php?p=latest_posts&page=' . ($page - 1) . '" class="pagination-link bg-white text-gray-700 px-4 py-2 border border-gray-300 rounded-l-md hover:bg-gray-100">Previous</a>';
            }

            // Page number links
            for ($i = 1; $i <= $total_pages; $i++) {
                $active_class = ($i == $page) ? 'bg-black text-white' : 'bg-white text-gray-700 hover:bg-gray-100';
                echo '<a href="main.php?p=latest_posts&page=' . $i . '" class="pagination-link ' . $active_class . ' px-4 py-2 border border-gray-300">' . $i . '</a>';
            }

            // Next Button
            if ($page < $total_pages) {
                echo '<a href="main.php?p=latest_posts&page=' . ($page + 1) . '" class="pagination-link bg-white text-gray-700 px-4 py-2 border border-gray-300 rounded-r-md hover:bg-gray-100">Next</a>';
            }

            // End pagination navigation
            echo '</nav>';
        }
        ?>
    </div>



    <style>
        /* Add some custom pagination styles */
        .pagination-link {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination-link:hover {
            background-color: #f0f0f0;
        }
    </style>

    <style>
        /* Images hover effect */
        img {
            transition: transform 0.5s ease;
        }

        img:hover {
            transform: scale(1.05);
        }

        /* Pagination */
        #load-more {
            background-color: #000;
            color: white;
        }

        #load-more:hover {
            background-color: #444;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        /* Overall layout */

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