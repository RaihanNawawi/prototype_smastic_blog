<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo ($_GET['blog'] == "edit") ? "Blog Edit" : "New Blog"; ?></h5>
                    <small class="text-muted float-end"><?php echo ($_GET['blog'] == "edit") ? "Edit existing blog post" : "Create a new blog post"; ?></small>
                </div>
                <div class="card-body">
                    <?php
                    if ($_GET['blog'] == "add") {
                        // Form untuk menambahkan blog baru
                    ?>
                        <form action="?p=action&blog=add" method="post" enctype="multipart/form-data">
                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-title">Title</label>
                                <input type="text" class="form-control" id="blog-title" name="tittle" placeholder="Judul Blog" />
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-content">Content</label>
                                <textarea name="content" id="editor" rows="10" cols="80" class="form-control"></textarea>
                            </div>

                            <!-- Kategori -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-category">Category</label>
                                <div id="blog-category">
                                    <?php
                                    $query = $kon->query("SELECT * FROM categories");
                                    foreach ($query as $key) {
                                    ?>
                                        <button type="button" class="btn btn-outline-primary category-btn" data-category-id="<?= $key['id']; ?>"><?= $key['name']; ?></button>
                                    <?php } ?>
                                </div>
                                <input type="hidden" id="selected-category" name="category_id" value="">
                            </div>

                            <!-- Tags (Two Options: Select or Add New) -->
                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>

                                <!-- Selected Tags -->
                                <div id="selected-tags" class="mt-3">
                                    <!-- Button Tags will be inserted here dynamically -->
                                </div>

                                <!-- Available Tags -->
                                <div id="available-tags" class="mt-3">
                                    <?php
                                    $query = $kon->query("SELECT * FROM tags");
                                    foreach ($query as $key) {
                                    ?>
                                        <button type="button" class="btn btn-outline-secondary available-tag-btn" data-tag-id="<?= $key['id']; ?>"><?= $key['name']; ?></button>
                                    <?php } ?>
                                    <!-- <button type="button" class="btn btn-outline-secondary available-tag-btn" data-tag-id="1">#Technology</button>
                    <button type="button" class="btn btn-outline-secondary available-tag-btn" data-tag-id="2">#Lifestyle</button>
                    <button type="button" class="btn btn-outline-secondary available-tag-btn" data-tag-id="3">#Education</button> -->
                                </div>

                                <!-- Add new tag -->
                                <div class="mt-3">
                                    <input type="text" class="form-control" id="new-tag" placeholder="Add a new tag (optional)">
                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add-new-tag">Add New Tag</button>
                                </div>

                                <!-- Hidden input to store selected tag IDs -->
                                <input type="hidden" name="selected_tags" id="selected-tags-input" value="">
                            </div>


                            <!-- Images -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-images">Cover Image</label>
                                <input type="file" class="form-control" id="blog-images" name="images" />
                            </div>

                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    <?php
                    } elseif ($_GET['blog'] == "edit") {
                        // Ambil data blog yang akan di-edit berdasarkan ID
                        $blog = $kon->query("SELECT * FROM posts WHERE id_post ='$_GET[id]' ");
                        $key = mysqli_fetch_array($blog);
                    ?>
                        <form action="?p=action&blog=edit" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_post" value="<?= $key['id_post'] ?>" />
                            <!-- Title -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-title">Title</label>
                                <input type="text" class="form-control" id="blog-title" name="tittle" placeholder="Judul Blog" value="<?= $key['tittle'] ?>" />
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-content">Content</label>
                                <textarea name="content" id="editor" rows="10" cols="80" class="form-control"><?= isset($key['content']) ? $key['content'] : '' ?></textarea>
                            </div>

                            <!-- Kategori -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-category">Category</label>
                                <div id="blog-category">
                                    <?php
                                    $query = $kon->query("SELECT * FROM categories");
                                    foreach ($query as $category) {
                                        $isActive = ($category['id'] == $key['category_id']) ? "active" : "";
                                    ?>
                                        <button type="button" class="btn btn-outline-primary category-btn <?= $isActive ?>" data-category-id="<?= $category['id']; ?>"><?= $category['name']; ?></button>
                                    <?php } ?>
                                </div>
                                <input type="hidden" id="selected-category" name="category_id" value="<?= $key['category_id'] ?>">
                            </div>

                            <!-- Tags (Edit Mode) -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-tags">Tags</label>

                                <!-- Selected Tags (Buttons) -->
                                <div id="selected-tags" class="mt-3">
                                    <!-- Button Tags will be inserted here dynamically -->
                                    <?php
                                    $postTags = getPostTags($key['id_post']);

                                    // Array untuk menyimpan ID tag yang sudah dicetak
                                    $printedTagIds = [];

                                    foreach ($postTags as $tag) {
                                        // Cek apakah tag sudah dicetak berdasarkan ID-nya
                                        if (!in_array($tag['id'], $printedTagIds)) {
                                            echo "<button type='button' class='btn btn-info me-1 mt-2 selected-tag-btn' data-tag-id='{$tag['id']}'>#{$tag['name']} <i class='remove-tag'>&times;</i></button>";

                                            // Tambahkan ID tag ke array printedTagIds
                                            $printedTagIds[] = $tag['id'];
                                        }
                                    }
                                    ?>
                                </div>

                                <!-- Available Tags (Rendered as Button Options) -->
                                <div id="available-tags" class="mt-3">
                                    <?php
                                    $tagQuery = $kon->query("SELECT * FROM tags");
                                    while ($tag = $tagQuery->fetch_assoc()) {
                                        echo "<button type='button' class='btn btn-outline-secondary me-1 mt-2 available-tag-btn' data-tag-id='{$tag['id']}'>#{$tag['name']}</button>";
                                    }
                                    ?>
                                </div>

                                <!-- Add new tag -->
                                <div class="mt-3">
                                    <input type="text" class="form-control" id="new-tag" name="selected_tags" placeholder="Add a new tag (optional)" />
                                    <button type="button" class="btn btn-sm btn-primary mt-2" id="add-new-tag">Add New Tag</button>
                                </div>

                                <!-- Hidden input to store selected tag IDs -->
                                <input type="hidden" name="selected_tags" id="selected-tags-input" value="<?php echo implode(',', array_column($postTags, 'id')); ?>">
                            </div>


                            <!-- Images -->
                            <div class="mb-3">
                                <label class="form-label" for="blog-images">Cover Image</label>
                                <input type="file" class="form-control" id="blog-images" name="images" />
                                <img src="../assets/img/uploads/<?= $key['images'] ?>" alt="Current Image" class="img-fluid mt-2" />
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    // Untuk Kategori (hanya satu yang bisa dipilih)
    document.querySelectorAll(".category-btn").forEach(function(button) {
        button.addEventListener("click", function() {
            // Hapus active dari semua tombol
            document.querySelectorAll(".category-btn").forEach(function(btn) {
                btn.classList.remove("active");
            });
            // Tambahkan active ke tombol yang dipilih
            this.classList.add("active");
            // Simpan ID kategori yang dipilih ke input tersembunyi
            document.getElementById("selected-category").value =
                this.getAttribute("data-category-id");
        });
    });

    const selectedTags = new Set(
        document.getElementById('selected-tags-input').value.split(',').filter(tagId => tagId)
    );



    // Tampilkan tags yang sudah ada saat form dimuat
    document.querySelectorAll('.available-tag-btn').forEach(btn => {
        const tagId = btn.getAttribute('data-tag-id');
        if (selectedTags.has(tagId) && !document.querySelector(`#selected-tags button[data-tag-id="${tagId}"]`)) {
            // Tag sudah ada dalam set, tambahkan ke bagian selected tags jika belum ada di HTML
            document.getElementById('selected-tags').innerHTML += `<button type="button" class="btn btn-info me-1 mt-2 selected-tag-btn" data-tag-id="${tagId}">${btn.innerText} <i class="remove-tag">&times;</i></button>`;
        }
    });

    // Event untuk memilih tag dari daftar yang tersedia
    document.querySelectorAll('.available-tag-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tagId = this.getAttribute('data-tag-id');
            if (!selectedTags.has(tagId)) {
                selectedTags.add(tagId);
                document.getElementById('selected-tags').innerHTML += `<button type="button" class="btn btn-info me-1 mt-2 selected-tag-btn" data-tag-id="${tagId}">${this.innerText} <i class="remove-tag">&times;</i></button>`;
            }
            updateHiddenTagsInput();
            addRemoveTagEvent();
        });
    });

    // Event untuk menambahkan tag baru
    document.getElementById('add-new-tag').addEventListener('click', function() {
        const newTag = document.getElementById('new-tag').value.trim();
        if (newTag) {
            // Kirim tag baru ke server dan tambahkan ke set tags terpilih
            addNewTagToDatabase(newTag, function(tagId) {
                selectedTags.add(tagId.toString());
                document.getElementById('selected-tags').innerHTML += `<button type="button" class="btn btn-info me-1 mt-2 selected-tag-btn" data-tag-id="${tagId}">#${newTag} <i class="remove-tag">&times;</i></button>`;
                document.getElementById('new-tag').value = ''; // Bersihkan input
                updateHiddenTagsInput();
                addRemoveTagEvent();
            });
        }
    });

    // Fungsi untuk memperbarui input hidden dengan tag yang dipilih
    function updateHiddenTagsInput() {
        document.getElementById('selected-tags-input').value = Array.from(selectedTags).join(',');
    }

    // Event untuk menghapus tag yang dipilih
    function addRemoveTagEvent() {
        document.querySelectorAll('.selected-tag-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tagId = this.getAttribute('data-tag-id');
                selectedTags.delete(tagId); // Hapus tag dari Set
                this.remove(); // Hapus tag dari tampilan
                updateHiddenTagsInput();
            });
        });
    }

    // Fungsi AJAX untuk menambah tag baru ke database
    function addNewTagToDatabase(newTag, callback) {
        const formData = new FormData();
        formData.append('tag_name', newTag);

        fetch('add_tag.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    callback(data.tag_id); // Kembalikan ID tag baru
                } else {
                    console.error('Failed to add tag:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Inisialisasi event hapus tag
    addRemoveTagEvent();
</script>

<style>
    /* Gaya untuk tombol yang aktif */
    .btn.active {
        background-color: #007bff;
        color: white;
    }
</style>