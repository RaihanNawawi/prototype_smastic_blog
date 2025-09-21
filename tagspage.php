<?php
// Koneksi ke database
include 'include/koneksi.php'; // Sesuaikan dengan konfigurasi koneksi Anda

// Ambil tag dari URL
if (isset($_GET['tag'])) {
    $tag = $_GET['tag'];

    // Query untuk mendapatkan post yang terkait dengan tag yang diklik
    $query = $kon->prepare("
        SELECT posts.*, categories.name AS category_name, users.username AS author_name
        FROM posts
        INNER JOIN post_tags ON posts.id_post = post_tags.id_posts
        INNER JOIN tags ON post_tags.id_tag = tags.id
        INNER JOIN categories ON posts.category_id = categories.id
        INNER JOIN users ON posts.author_id = users.id_user
        WHERE tags.name = ?
    ");
    $query->bind_param("s", $tag);
    $query->execute();
    $result = $query->get_result();

// Cek apakah ada hasil
if ($result->num_rows > 0) {
    echo "<section class='bg-gray-100 p-8 rounded-lg shadow-md'>";
    echo "<h3 class='text-2xl font-bold mb-6 text-gray-800 text-center faded'>Posts tagged with #" . htmlspecialchars($tag) . "</h3>";
    echo "<div class='container mx-auto'>";
    echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8'>";

    while ($post = $result->fetch_assoc()) {
        // Tampilkan post
        echo "
            <div class='bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 overflow-hidden'>
                <div class='relative'>
                    <img src='assets/img/uploads/" . htmlspecialchars($post['images']) . "' alt='Blog Post Image' class='w-full h-56 object-cover rounded-t-lg' />
                    <div class='absolute top-2 left-2 bg-gray-800 text-white text-xs font-semibold px-2 py-1 rounded fade '>#" . htmlspecialchars($tag) . "</div>
                </div>
                <div class='p-5'>
                <!-- Display Category Name -->
                    <a href='?p=categorypage&id=" . htmlspecialchars($post['category_id']) . "' class='text-muted-foreground text-indigo-500 font-semibold mb-2'>
                        " . htmlspecialchars($post['category_name']) . "
                    </a>
                    <h3 class='text-lg font-semibold text-gray-800 hover:text-primary transition-colors'>
                        <a href='?p=readpage&id=" . htmlspecialchars($post['id_post']) . "'>" . htmlspecialchars($post['tittle']) . "</a>
                    </h3>
                    <p class='mt-2 text-sm text-gray-600 line-clamp-3'>
                        " . substr($post['content'], 0, 100) . "...
                    </p>
                    <a href='?p=readpage&id=" . htmlspecialchars($post['id_post']) . "' class='mt-4 inline-block text-sm text-primary hover:underline'>
                        Read More
                    </a>
                </div>
            </div>
        ";
    }

    echo "</div>";  // Close grid div
    echo "</div>";  // Close container div
    echo "</section>";  // Close section
} else {
    // Pesan jika tidak ada post terkait tag tersebut
    echo "<p class='text-lg font-semibold text-red-500 mb-4 text-center'>No posts found for tag #" . htmlspecialchars($tag) . ".</p>";
}
}

