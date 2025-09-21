<?php
// Koneksi database dengan MySQLi
$kon = mysqli_connect('localhost', 'root', '', 'myblog');

// Cek koneksi
if (!$kon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Mendapatkan data dari request POST
$id_post = $_POST['id_post'];
$user_id = $_POST['user_id'];
$interaction_type = $_POST['interaction_type']; // 'like', 'dislike', atau 'save'

// Fungsi untuk menghapus interaksi sebelumnya dari user (like atau dislike)
function removePreviousInteraction($kon, $id_post, $user_id)
{
    $query = "DELETE FROM interactions WHERE post_id = ? AND user_id = ? AND interaction_type IN ('like', 'dislike')";
    $stmt = mysqli_prepare($kon, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $id_post, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Cek apakah interaksi sebelumnya sudah ada
$query_check = "SELECT interaction_type FROM interactions WHERE post_id = ? AND user_id = ?";
$stmt_check = mysqli_prepare($kon, $query_check);
mysqli_stmt_bind_param($stmt_check, "ii", $id_post, $user_id);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_bind_result($stmt_check, $existing_interaction);
mysqli_stmt_fetch($stmt_check);
mysqli_stmt_close($stmt_check);

// Jika interaksi yang dikirim adalah 'like'
if ($interaction_type === 'like') {
    // Jika sebelumnya user memberikan dislike, hapus dislike terlebih dahulu
    if ($existing_interaction === 'dislike') {
        removePreviousInteraction($kon, $id_post, $user_id);
    }

    // Tambahkan atau perbarui like
    $query_like = "REPLACE INTO interactions (post_id, user_id, interaction_type) VALUES (?, ?, 'like')";
    $stmt_like = mysqli_prepare($kon, $query_like);
    mysqli_stmt_bind_param($stmt_like, 'ii', $id_post, $user_id);
    mysqli_stmt_execute($stmt_like);
    mysqli_stmt_close($stmt_like);
}

// Jika interaksi yang dikirim adalah 'dislike'
if ($interaction_type === 'dislike') {
    // Jika sebelumnya user memberikan like, hapus like terlebih dahulu
    if ($existing_interaction === 'like') {
        removePreviousInteraction($kon, $id_post, $user_id);
    }

    // Tambahkan atau perbarui dislike
    $query_dislike = "REPLACE INTO interactions (post_id, user_id, interaction_type) VALUES (?, ?, 'dislike')";
    $stmt_dislike = mysqli_prepare($kon, $query_dislike);
    mysqli_stmt_bind_param($stmt_dislike, 'ii', $id_post, $user_id);
    mysqli_stmt_execute($stmt_dislike);
    mysqli_stmt_close($stmt_dislike);
}

// Jika interaksi yang dikirim adalah 'save'
if ($interaction_type === 'save') {
    // Tambahkan atau perbarui save
    $query_save = "REPLACE INTO interactions (post_id, user_id, interaction_type) VALUES (?, ?, 'save')";
    $stmt_save = mysqli_prepare($kon, $query_save);
    mysqli_stmt_bind_param($stmt_save, 'ii', $id_post, $user_id);
    mysqli_stmt_execute($stmt_save);
    mysqli_stmt_close($stmt_save);
}

// Tutup koneksi
mysqli_close($kon);

// Output sukses atau redirect ke halaman sebelumnya
header('Location: ?p=readpage&id=' . $id_post);
exit();
