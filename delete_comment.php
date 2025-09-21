<?php
session_start();
include "include/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment_id = $_POST['comment_id'];
    $user_id = $_SESSION['id_user'];

    // Periksa apakah komentar milik pengguna yang sedang login
    $check_query = $kon->query("SELECT user_id FROM comments WHERE id = '$comment_id'");
    if ($check_query->num_rows > 0) {
        $row = $check_query->fetch_assoc();
        if ($row['user_id'] == $user_id) {
            $stmt = $kon->prepare("DELETE FROM comments WHERE id = ?");
            $stmt->bind_param("i", $comment_id);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Comment not found']);
    }
}
