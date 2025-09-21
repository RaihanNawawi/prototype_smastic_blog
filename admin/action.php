<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start(); // Mulai sesi
require "../include/koneksi.php";
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
    echo "<META HTTP-EQUIV='Refresh' Content='0; URL=index.php'>";
}
// Category Form
if ($_GET['category'] == "add") {
    $name = $_POST['name'];
    $query = mysqli_query($kon, "INSERT INTO categories (name) VALUES ('$name')");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=main.php?p=category'>";
    }
} elseif ($_GET['category'] == "edit") {
    $id = $_POST['id'];
    $name = $_POST['name'];

    $query = $kon->query("UPDATE categories SET name ='$name' WHERE id='$id'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=main.php?p=category'>";
    }
} elseif ($_GET["category"] == "delete") {
    $id = $_GET['id'];
    $query = $kon->query("DELETE FROM categories WHERE id='$id'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh'Content='0; URL=main.php?p=category'>";
    }
}

// Tag form
if ($_GET['tag'] == "add") {
    $name = $_POST['name'];
    $query = mysqli_query($kon, "INSERT INTO tags (name) VALUES ('$name')");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=main.php?p=tags'>";
    }
} elseif ($_GET['tag'] == "edit") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $query = $kon->query("UPDATE tags SET name ='$name' WHERE id='$id'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=main.php?p=tags'>";
    }
} elseif ($_GET["tag"] == "delete") {
    $id = $_GET['id'];
    $query = $kon->query("DELETE FROM tags WHERE id='$id'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh'Content='0; URL=main.php?p=tags'>";
    }
}


// Blog Form
if ($_GET['blog'] == "add") {
    // Tangkap data dari form
    $tittle = mysqli_real_escape_string($kon, $_POST['tittle']);
    $content = mysqli_real_escape_string($kon, $_POST['content']);

    // Clean content and replace relative image paths
    $content = stripslashes($content);
    $content = str_replace('../assets/img/uploads/', 'http://localhost/myblog/assets/img/uploads/', $content);

    $category_id = $_POST['category_id'];
    $slug = createSlug($tittle);
    $author_id = $_SESSION['id_user']; // ID penulis dari sesi

    // Proses upload gambar
    $file_name = handleImageUpload($slug);

    // Simpan post baru ke database
    $query = $kon->prepare("INSERT INTO posts (tittle, content, slug, category_id, author_id, images, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $query->bind_param('sssiss', $tittle, $content, $slug, $category_id, $author_id, $file_name);

    if ($query->execute()) {
        $postId = $query->insert_id;

        // Menangani tag yang dipilih
        handleTags($kon, $postId, $_POST['selected_tags']);

        // Redirect setelah berhasil
        redirectToBlog();
    } else {
        echo "Terjadi kesalahan saat menyimpan data: " . $query->error;
    }
} elseif ($_GET['blog'] == "edit") {
    $id_post = $_POST['id_post'];
    $tittle = mysqli_real_escape_string($kon, $_POST['tittle']);
    $content = $_POST['content'];
    // Hapus karakter backslash sebelum menyimpan konten
    $content = stripslashes($content);
    // Ganti path relatif menjadi URL absolut sebelum disimpan
    $content = str_replace('../assets/img/uploads/', 'http://localhost/myblog/assets/img/uploads/', $content);

    $category_id = mysqli_real_escape_string($kon, $_POST['category_id']);
    $slug = createSlug($tittle);
    $author_id = 1;

    // Dapatkan gambar lama
    $current_image = getCurrentImage($kon, $id_post);

    // Proses upload gambar baru jika ada
    $file_name = handleImageUpload($slug, $current_image);

    // Update post di database
    $query = $kon->prepare("UPDATE posts SET tittle=?, content=?, slug=?, category_id=?, author_id=?, images=?, updated_at=NOW() WHERE id_post=?");
    $query->bind_param('sssissi', $tittle, $content, $slug, $category_id, $author_id, $file_name, $id_post);

    if ($query->execute()) {
        // Hanya hapus dan tambah tags sesuai perubahan user
        if (!empty($_POST['selected_tags'])) {
            handleTags($kon, $id_post, $_POST['selected_tags']);
        }

        // Redirect setelah berhasil
        redirectToBlog();
    } else {
        echo "Terjadi kesalahan saat mengupdate data: " . $query->error;
    }
} elseif ($_GET["blog"] == "delete") {
    $id = $_GET['id'];
    $query = $kon->query("DELETE FROM posts WHERE id_post='$id'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh'Content='0; URL=main.php?p=blog'>";
    }
}




// Fungsi untuk membuat slug dari judul
function createSlug($tittle)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $tittle)));
}

// Fungsi untuk menangani upload gambar
function handleImageUpload($slug, $current_image = "")
{
    if (!empty($_FILES["images"]["name"])) {
        $file_name = $slug . "-" . basename($_FILES["images"]["name"]);
        $upload_path = "../assets/img/uploads/" . $file_name;

        if (move_uploaded_file($_FILES["images"]["tmp_name"], $upload_path)) {
            if (!empty($current_image)) {
                // Uncomment baris di bawah jika ingin menghapus gambar lama
                // unlink("../assets/img/uploads/" . $current_image);
            }
            return $file_name;
        } else {
            echo "Gagal meng-upload file gambar.";
            exit;
        }
    }
    return $current_image;
}

// Fungsi untuk menangani tags
function handleTags($kon, $postId, $selectedTags)
{
    $existingTags = getPostTags($postId);
    $existingTagIds = array_column($existingTags, 'id');

    $newTagIds = explode(',', $selectedTags);

    // Hanya hapus tags jika ada perbedaan antara tags lama dan baru
    $tagsToRemove = array_diff($existingTagIds, $newTagIds);
    if (!empty($tagsToRemove)) {
        $tagsToRemoveStr = implode(',', $tagsToRemove);
        $kon->query("DELETE FROM post_tags WHERE id_posts = $postId AND id_tag IN ($tagsToRemoveStr)");
    }

    // Tambahkan tags baru ke post jika ada
    $tagsToAdd = array_diff($newTagIds, $existingTagIds);
    foreach ($tagsToAdd as $tagId) {
        $tagId = intval($tagId);
        $kon->query("INSERT INTO post_tags (id_posts, id_tag) VALUES ($postId, $tagId)");
    }
}







// Cek apakah tag ada di database
function tagExists($kon, $tagId)
{
    $query = $kon->prepare("SELECT id FROM tags WHERE id=?");
    $query->bind_param('i', $tagId);
    $query->execute();
    $query->store_result();
    return $query->num_rows > 0;
}

// Menambahkan tag ke post
function addTagToPost($kon, $postId, $tagId)
{
    $query = $kon->prepare("INSERT INTO post_tags (id_posts, id_tag) VALUES (?, ?)");
    $query->bind_param('ii', $postId, $tagId);
    $query->execute();
}

// Menghapus tag lama dari post
function clearOldTags($kon, $postId)
{
    $query = $kon->prepare("DELETE FROM post_tags WHERE id_posts=?");
    $query->bind_param('i', $postId);
    $query->execute();
}

// Mendapatkan gambar saat ini
function getCurrentImage($kon, $id_post)
{
    $query = $kon->prepare("SELECT images FROM posts WHERE id_post=?");
    $query->bind_param('i', $id_post);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc()['images'];
}

// Fungsi untuk redirect ke halaman blog
function redirectToBlog()
{
    echo "<META HTTP-EQUIV='Refresh' Content='0; URL=main.php?p=blog'>";
}

// Category Form
if ($_GET['info'] == "add") {
    $text_content = $_POST['text_content'];
    $query = mysqli_query($kon, "INSERT INTO text_snippets (text_content) VALUES ('$text_content')");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=main.php?p=info'>";
    }
} elseif ($_GET['info'] == "edit") {
    $id = $_POST['id'];
    $text_content = $_POST['text_content'];

    $query = $kon->query("UPDATE text_snippets SET text_content ='$text_content' WHERE id='$id'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh' Content='0; URL=main.php?p=info'>";
    }
} elseif ($_GET["info"] == "delete") {
    $id = $_GET['id'];
    $query = $kon->query("DELETE FROM text_snippets WHERE id='$id'");
    if ($query) {
        echo "<META HTTP-EQUIV='Refresh'Content='0; URL=main.php?p=info'>";
    }
}

