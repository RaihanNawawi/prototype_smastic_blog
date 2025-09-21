<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <!-- Filter Section -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <?php
        // Mendapatkan parameter 'id' dari URL
        if (isset($_GET['id'])) {
            $id_post = $_GET['id'];

            // Menggunakan INNER JOIN untuk mengambil kategori berdasarkan category_id
            // Menambahkan JOIN untuk tabel users
            $a = "INNER JOIN categories ON posts.category_id = categories.id INNER JOIN users ON posts.author_id = users.id_user";

            // Query dengan users.name untuk mendapatkan nama penulis
            $query = $kon->query("SELECT posts.*, categories.name AS category_id, users.username AS author_id FROM posts $a WHERE posts.id_post = '$id_post'");  // Filter berdasarkan id_post");

            // Cek apakah post ditemukan
            if ($query->num_rows > 0) {
                $key = $query->fetch_assoc();
                // Query untuk mengambil semua tags yang terkait dengan post ini
                $tagQuery = $kon->query("SELECT tags.name AS tag_name
                                         FROM post_tags
                                         INNER JOIN tags ON post_tags.id_tag = tags.id
                                         WHERE post_tags.id_posts = '$id_post'");

                // Inisialisasi array untuk menyimpan tag yang ditemukan
                $tags = [];
                if ($tagQuery->num_rows > 0) {
                    while ($tag = $tagQuery->fetch_assoc()) {
                        $tags[] = $tag['tag_name'];
                    }
                }
        ?>
                <div class="card mb-4">
                    <!-- Blog Image -->
                    <img class="card-img-top" src="../assets/img/uploads/<?= $key['images'] ?>" alt="Blog Image" style="max-height: 400px; object-fit: cover; width: 100%;" />

                    <!-- Blog Content -->
                    <div class="card-body">
                        <h2 class="card-title"><?= $key['tittle'] ?></h2>
                        <p class="card-text">
                            <span class="badge bg-label-primary me-1"><?= $key['category_id'] ?></span>
                            <!-- Tags -->
                        </p>

                        <!-- Author and Date -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-muted">
                                <i class="bx bx-user"></i> <span><?= $key['author_id'] ?></span>
                            </div>
                            <div class="text-muted">
                                <i class="bx bx-calendar"></i> <span><?= $key['created_at'] ?></span>
                            </div>
                        </div>

                        <!-- Blog Content -->
                        <p class="card-text">
                            <?= htmlspecialchars_decode($key['content']) ?>
                        </p>
                        <!-- Edit and Delete Buttons -->
                        <div class="d-flex justify-content-end mt-4">
                            <a href="?p=blog_form&blog=edit&id=<?= $key['id_post'] ?>" class="btn btn-outline-warning btn-sm me-2">
                                <i class="bx bx-edit-alt"></i> Edit
                            </a>
                            <button data-bs-target="#deleteBlogModal<?= $key['id_post'] ?>" data-bs-toggle="modal" class="btn btn-danger btn-sm">
                                <i class="bx bx-trash-alt"></i> Delete
                            </button>
                        </div>

                        <!-- Back Button -->
                        <?php
                        // Tampilkan tags sebagai badge
                        if (!empty($tags)) {
                            foreach ($tags as $tag) {
                                echo "<span class='badge bg-label-info me-1 mt-4'>#$tag</span>";
                            }
                        } else {
                            echo "<span class='badge bg-label-secondary me-1'>No Tags</span>";
                        }
                        ?>
                        <div class="text-end mt-4">
                            <a href="?p=blog" class="btn btn-primary">Back to Blog List</a>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteBlogModal<?= $key['id_post'] ?>" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteBlogModalLabel<?= $key['id_post'] ?>">Delete Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are You Sure Delete "<strong><?= $key['tittle'] ?></strong>" Blog?</p>
                                <p class="text-muted">This Action Cannot be Canceled.</p>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <a href="action.php?blog=delete&id=<?= $key['id_post'] ?>" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            } else {
                echo "<p>Can't Find Blog.</p>";
            }
        }
        ?>
    </div>
    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->