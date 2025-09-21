<?php
session_start();
include "include/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $id_user = $_SESSION['id_user'];
    $comment_text = $kon->real_escape_string($_POST['comment_text']);

    if (!empty($comment_text)) {
        $stmt = $kon->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $post_id, $id_user, $comment_text);
        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'username' => $_SESSION['username'], // Assuming you store the username in session
                'created_at' => date("F j, Y"),
                'comment' => nl2br(htmlspecialchars($comment_text))
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['status' => 'error', 'message' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Comment text is empty']);
    }
}
