<?php
session_start();
include "../include/koneksi.php";

// Fungsi untuk mengambil data blog berdasarkan jenis interaksi
$user_id = $_SESSION['id_user']; // Sesuaikan ID user, misalkan 1 sebagai contoh

function get_blogs_by_interaction($kon, $user_id, $interaction_type)
{
    $a = "INNER JOIN users ON posts.author_id = users.id_user";
    $query = "SELECT posts.id_post, posts.tittle, posts.author_id , posts.content, posts.created_at, users.username AS author_name
              FROM posts $a
              JOIN interactions ON interactions.post_id = posts.id_post
              WHERE interactions.user_id = ? AND interactions.interaction_type = ?";
    $stmt = $kon->prepare($query);
    $stmt->bind_param("is", $user_id, $interaction_type);
    $stmt->execute();
    return $stmt->get_result();
}

// Ambil blog yang di-like, dislike, dan di-save oleh user
$liked_blogs = get_blogs_by_interaction($kon, $user_id, 'like');
$disliked_blogs = get_blogs_by_interaction($kon, $user_id, 'dislike');
$saved_blogs = get_blogs_by_interaction($kon, $user_id, 'save');
?>
<div class="container mx-auto p-4 w-full profile-container grid grid-cols-1 lg:grid-cols-3 gap-6 mt-5 mb-5">
    <!-- Left Column: Profile Information -->
    <div class="container flex flex-col items-center p-6 bg-gray-100 rounded-lg">
        <img src="img/user-1.jpg" alt="User Avatar" class="profile-avatar w-32 h-32 rounded-full">
        <h1 class="text-xl font-bold text-gray-800 mb-1"><?= $_SESSION['username'] ?></h1>
        <p class="text-gray-500"><?= $_SESSION['email'] ?></p>

        <!-- Button Manage My Blog -->
        <a href="../myblog/admin/main.php?p=dashboard" class="mt-4 px-6 py-2 bg-black text-white font-semibold rounded-lg hover:bg-gray-800 transition-all flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square"></i> Manage Blog
        </a>
    </div>

    <!-- Right Column: Tabs and Content -->
    <div class="col-span-2">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-black">User Profile</h2>
            <a href="logout.php" class="logout-btn text-black font-semibold rounded-full hover:bg-black hover:text-white px-4 py-2 flex items-center gap-2">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
            </a>
        </div>

        <div class="flex border-b-2 mb-4">
            <button class="tab-button text-black py-2 px-6 font-semibold border-r-2" data-tab="liked-blogs">Liked Blogs</button>
            <button class="tab-button text-black py-2 px-6 font-semibold border-r-2" data-tab="disliked-blogs">Disliked Blogs</button>
            <button class="tab-button text-black py-2 px-6 font-semibold" data-tab="saved-blogs">Saved Blogs</button>
        </div>

        <!-- Blog Sections (Liked, Disliked, Saved) -->
        <div class="liked-blogs tab-content hidden">
            <h3 class="text-xl font-bold mb-4">Blogs You Liked</h3>
            <ul class="space-y-4">
                <?php while ($blog = $liked_blogs->fetch_assoc()): ?>
                    <li class="bg-gray-100 p-4 rounded-md shadow-sm flex justify-between items-center">
                        <div>
                            <a href="main.php?p=readpage&id=<?= $blog['id_post'] ?>" class="font-semibold text-lg mb-2"><?= htmlspecialchars($blog['tittle']); ?></a>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($blog['author_name']); ?></p>
                            <small class="text-gray-500 text-xs"><?= htmlspecialchars($blog['created_at']); ?></small>
                        </div>
                        <button class="icon-btn like-btn text-red-500 active" data-action="like" data-blog-id="<?= $blog['id'] ?>">
                            <i class="fa fa-heart text-2xl"></i>
                        </button>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="disliked-blogs tab-content hidden">
            <h3 class="text-xl font-bold mb-4">Blogs You Disliked</h3>
            <ul class="space-y-4">
                <?php while ($blog = $disliked_blogs->fetch_assoc()): ?>
                    <li class="bg-gray-100 p-4 rounded-md shadow-sm flex justify-between items-center">
                        <div>
                            <a href="main.php?p=readpage&id=<?= $blog['id_post'] ?>" class="font-semibold text-lg mb-2"><?= htmlspecialchars($blog['tittle']); ?></a>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($blog['author_name']); ?></p>
                            <small class="text-gray-500 text-xs"><?= htmlspecialchars($blog['created_at']); ?></small>
                        </div>
                        <button class="icon-btn dislike-btn text-blue-500 active" data-action="dislike" data-blog-id="<?= $blog['id'] ?>">
                            <i class="fa fa-thumbs-down text-2xl"></i>
                        </button>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="saved-blogs tab-content hidden">
            <h3 class="text-xl font-bold mb-4">Blogs You Saved</h3>
            <ul class="space-y-4">
                <?php while ($blog = $saved_blogs->fetch_assoc()): ?>
                    <li class="bg-gray-100 p-4 rounded-md shadow-sm flex justify-between items-center">
                        <div>
                            <a href="main.php?p=readpage&id=<?= $blog['id_post'] ?>" class="font-semibold text-lg mb-2"><?= htmlspecialchars($blog['tittle']); ?></a>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($blog['author_name']); ?></p>
                            <small class="text-gray-500 text-xs"><?= htmlspecialchars($blog['created_at']); ?></small>
                        </div>
                        <button class="icon-btn save-btn text-black active" data-action="save" data-blog-id="<?= $blog['id'] ?>">
                            <i class="fa fa-bookmark text-2xl"></i>
                        </button>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</div>


<!-- Script untuk penggantian tab -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove 'active' class from all buttons
                tabButtons.forEach(btn => btn.classList.remove('active'));
                // Add 'active' class to clicked button
                button.classList.add('active');

                // Hide all tab contents
                tabContents.forEach(content => content.classList.add('hidden'));
                // Show the selected tab
                const target = button.getAttribute('data-tab');
                document.querySelector(`.${target}`).classList.remove('hidden');
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event handler for icon buttons
        const iconButtons = document.querySelectorAll('.icon-btn');

        iconButtons.forEach(button => {
            button.addEventListener('click', function() {
                const blogId = this.getAttribute('data-blog-id');
                const action = this.getAttribute('data-action');

                // Toggle the active/inactive state visually
                if (this.classList.contains('active')) {
                    this.classList.remove('active');
                    this.classList.add('inactive');
                } else {
                    this.classList.remove('inactive');
                    this.classList.add('active');
                }
            });
        });
    });
</script>

<style>
    /* Native CSS for custom styles */
    body {
        font-family: 'Raleway', sans-serif;
        background-color: #f7f7f7;
    }

    .profile-container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }

    .tab-button.active {
        background-color: #e5e7eb;
        /* Light grey background for active tab */
    }

    .logout-btn {
        border: 2px solid #000;
        padding: 0.5rem 1.5rem;
        transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
        background-color: #333333;
        color: #ffffff;
    }

    .profile-avatar {
        border: 4px solid #dddddd;
        margin-bottom: 1.5rem;
    }

    .profile-actions button:hover {
        background-color: #f3f4f6;
    }

    .tab-content.active {
        display: block;
    }

    .icon-btn {
        background: none;
        border: none;
        cursor: pointer;
        outline: none;
    }

    .icon-btn i {
        transition: color 0.3s ease;
    }

    .icon-btn.active i {
        color: inherit;
        /* Warna aktif sesuai kelas bawaan, misalnya merah untuk like */
    }

    .icon-btn.inactive i {
        color: white;
        /* Ikon non-aktif berwarna putih */
    }
</style>