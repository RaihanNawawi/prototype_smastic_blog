<?php
require "../include/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['tag_name'])) {
    $tagName = $kon->real_escape_string(trim($_POST['tag_name']));

    // Cek apakah tag sudah ada di database
    $query = $kon->query("SELECT id FROM tags WHERE name = '$tagName'");
    if ($query->num_rows > 0) {
        $tag = $query->fetch_assoc();
        echo json_encode(['success' => true, 'tag_id' => $tag['id']]);
    } else {
        // Tambah tag baru ke database
        $insert = $kon->query("INSERT INTO tags (name) VALUES ('$tagName')");
        if ($insert) {
            $tagId = $kon->insert_id;
            echo json_encode(['success' => true, 'tag_id' => $tagId]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to insert tag']);
        }
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}