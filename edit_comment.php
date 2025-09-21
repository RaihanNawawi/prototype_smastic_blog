<?php
session_start();
include "include/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment_id = $_POST['comment_id'];
    $comment_text = $kon->real_escape_string($_POST['comment_text']);
    $user_id = $_SESSION['id_user'];

    // Periksa apakah komentar milik pengguna yang sedang login
    $check_query = $kon->query("SELECT user_id FROM comments WHERE id = '$comment_id'");
    if ($check_query->num_rows > 0) {
        $row = $check_query->fetch_assoc();
        if ($row['user_id'] == $user_id) {
            $stmt = $kon->prepare("UPDATE comments SET comment = ? WHERE id = ?");
            $stmt->bind_param("si", $comment_text, $comment_id);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'comment' => nl2br(htmlspecialchars($comment_text))]);
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
