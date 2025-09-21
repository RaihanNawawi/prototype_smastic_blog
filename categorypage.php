<?php
// Koneksi ke database
include 'include/koneksi.php'; // Sesuaikan dengan konfigurasi koneksi Anda

// Initial load (fetch the first set of posts)
$limit = 6;  // Number of posts per page
$offset = 0;  // Offset to start fetching

// Ambil kategori dari URL jika ada
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Query to fetch posts and category name
    $query = $kon->prepare("
        SELECT posts.*, categories.name AS category_name, users.username AS author_name
        FROM posts
        INNER JOIN categories ON posts.category_id = categories.id
        INNER JOIN users ON posts.author_id = users.id_user
        WHERE categories.id = ?
        ORDER BY posts.created_at DESC
        LIMIT ?, ?
    ");
    $query->bind_param("iii", $category_id, $offset, $limit);
    $query->execute();
    $result = $query->get_result();

    // Fetch the category name from the first result
    if ($result->num_rows > 0) {
        $first_post = $result->fetch_assoc(); // Fetch the first post to get the category name
        $category_name = htmlspecialchars($first_post['category_name']);
    } else {
        $category_name = "Unknown"; // Default if no posts are found
    }
?>

    <!-- HTML Section -->
    <section class="bg-white py-20 px-6">
        <div class="container mx-auto max-w-6xl">
            <div class="text-center mb-10">
                <h1 class="text-5xl md:text-6xl font-extrabold text-black"><?= $category_name ?></h1>
                <p class="text-lg text-gray-600 mt-4">Discover articles and posts in the <?= $category_name ?> category.</p>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <main class="container mx-auto px-4 py-12">
        <!-- Blog Post Grid -->
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3" id="post-container">
            <?php
            // Rewind result set pointer to fetch posts again for the loop
            $result->data_seek(0);

            // Loop through posts
            while ($post = $result->fetch_assoc()) {
            ?>
                <article class="bg-white rounded-lg overflow-hidden shadow-md transition-shadow hover:shadow-lg">
                    <a href="?p=readpage&id=<?= htmlspecialchars($post['id_post']) ?>">
                        <div class="relative h-48">
                            <img src="assets/img/uploads/<?= htmlspecialchars($post['images']) ?>" alt="Blog post" class="object-cover w-full h-full" />
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-gray-500"><?= date('F d, Y', strtotime($post['created_at'])) ?></span>
                                <span class="px-2 py-1 bg-black text-white text-xs font-medium rounded-full"><?= htmlspecialchars($post['category_name']) ?></span>
                            </div>
                            <h2 class="text-xl font-semibold mb-2 line-clamp-2"><?= htmlspecialchars($post['tittle']) ?></h2>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?= substr($post['content'], 0, 120) ?>...</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2 mt-2">
                                    <img src="img/ic1.png" loading="lazy" alt="Author Image" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm font-medium"><?= htmlspecialchars($post['author_name']) ?></span>
                                </div>
                                <span class="text-sm text-gray-500">5 min read</span>
                            </div>
                        </div>
                    </a>
                </article>
            <?php
            }
            ?>
        </div>

        <!-- Load More Button -->
        <!-- <div class="mt-16 flex justify-center">
            <button id="load-more" class="bg-black text-white px-6 py-3 rounded-full transition-transform transform hover:scale-105 hover:bg-gray-800">
                Load More
            </button>
        </div> -->

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

<?php
} else {
    echo "<p class='text-lg font-semibold text-red-500 mb-8 text-center'>Category not found.</p>";
}
?>