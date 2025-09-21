<?php
include 'include/koneksi.php';

// Ambil category_id dan page dari permintaan AJAX
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$posts_per_page = 9;
$offset = ($page - 1) * $posts_per_page;

// Query berdasarkan kategori dan pagination
if ($category_id > 0) {
    $post_query = $kon->prepare("
        SELECT posts.*, categories.name AS category_name, users.username AS author_name
        FROM posts
        INNER JOIN categories ON posts.category_id = categories.id
        INNER JOIN users ON posts.author_id = users.id_user
        WHERE categories.id = ?
        ORDER BY posts.created_at DESC
        LIMIT ?, ?
    ");
    $post_query->bind_param("iii", $category_id, $offset, $posts_per_page);
    $count_query = $kon->prepare("SELECT COUNT(*) AS total FROM posts WHERE category_id = ?");
    $count_query->bind_param("i", $category_id);
} else {
    $post_query = $kon->prepare("
        SELECT posts.*, categories.name AS category_name, users.username AS author_name
        FROM posts
        INNER JOIN categories ON posts.category_id = categories.id
        INNER JOIN users ON posts.author_id = users.id_user
        ORDER BY posts.created_at DESC
        LIMIT ?, ?
    ");
    $post_query->bind_param("ii", $offset, $posts_per_page);
    $count_query = $kon->prepare("SELECT COUNT(*) AS total FROM posts");
}

$post_query->execute();
$posts_result = $post_query->get_result();
$count_query->execute();
$total_posts_result = $count_query->get_result();
$total_posts = $total_posts_result->fetch_assoc()['total'];
$total_pages = ceil($total_posts / $posts_per_page);

// Check if posts were retrieved
$posts_html = '';
if ($posts_result->num_rows > 0) {
    while ($post = $posts_result->fetch_assoc()) {
        $posts_html .= '
        <div class="bg-gray-100 rounded-lg shadow-lg trending-post post" data-category="' . htmlspecialchars($post['category_name']) . '">
            <img src="assets/img/uploads/' . htmlspecialchars($post['images']) . '" alt="Post Image" class="w-full h-48 object-cover rounded-t-lg">
            <div class="p-4">
                <span class="bg-black text-white text-sm font-semibold py-1 px-3 rounded-full mb-2 inline-block">' . htmlspecialchars($post['category_name']) . '</span>
                <h3 class="text-xl font-bold mb-2">' . htmlspecialchars($post['tittle']) . '</h3>
                                                <div class="flex items-center space-x-2 mt-2">
                                                <img src="img/ic1.png" loading="lazy" alt="Author Image" class="w-8 h-8 rounded-full object-cover">
                                                <p class="text-gray-600 text-sm">' . htmlspecialchars($post['author_name']) . ' • ' . date('F d, Y', strtotime($post['created_at'])) . '</p>
                                                </div>
            </div>
            <div class="p-4">
                <a href="?p=readpage&id=' . htmlspecialchars($post['id_post']) . '" class="w-full text-center border border-gray-400 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 block">Read More</a>
            </div>
        </div>';
    }
} else {
    $posts_html = '<p class="text-center text-gray-500">No posts available for this category.</p>';
}

// Generate pagination HTML
$pagination_html = '';
if ($total_pages > 1) {
    $pagination_html .= '<nav class="inline-flex items-center space-x-2 rounded-md shadow">';

    // Tombol Previous
    if ($page > 1) {
        $pagination_html .= '<a href="#" class="pagination-link bg-white text-gray-700 px-4 py-2 border border-gray-300 rounded-l-md hover:bg-gray-100" data-page="' . ($page - 1) . '">Previous</a>';
    }

    // Nomor halaman
    for ($i = 1; $i <= $total_pages; $i++) {
        $active_class = ($i == $page) ? 'bg-black text-white' : 'bg-white text-gray-700 hover:bg-gray-100';
        $pagination_html .= '<a href="#" class="pagination-link ' . $active_class . ' px-4 py-2 border border-gray-300" data-page="' . $i . '">' . $i . '</a>';
    }

    // Tombol Next
    if ($page < $total_pages) {
        $pagination_html .= '<a href="#" class="pagination-link bg-white text-gray-700 px-4 py-2 border border-gray-300 rounded-r-md hover:bg-gray-100" data-page="' . ($page + 1) . '">Next</a>';
    }

    $pagination_html .= '</nav>';
}

// Return posts and pagination HTML as JSON
header('Content-Type: application/json');
echo json_encode([
    'posts' => $posts_html,
    'pagination' => $pagination_html
]);
