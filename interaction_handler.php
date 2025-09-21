<?php
session_start();
include "include/koneksi.php";

// Memeriksa apakah session ID benar-benar ada
if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Check the action type (like, dislike, save)
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $query = "SELECT posts.tittle, posts.content, posts.created_at
              FROM posts
              JOIN interactions ON interactions.post_id = posts.id_post
              WHERE interactions.user_id = ? AND interactions.interaction_type = ?";

    $stmt = $kon->prepare($query);
    $stmt->bind_param("is", $user_id, $action); // Use 'is' for integer and string binding
    $stmt->execute();
    $result = $stmt->get_result();

    $blogs = [];
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }

    echo json_encode(['status' => 'success', 'blogs' => $blogs]);
    exit;
}

// Check if post_id and interaction_type are set
if (isset($_POST['post_id']) && isset($_POST['interaction_type'])) {
    $user_id = $_SESSION['id_user'];
    $post_id = intval($_POST['post_id']);
    $action_type = $_POST['interaction_type'];

    // Validate interaction type
    if (!in_array($action_type, ['like', 'dislike', 'save', 'check'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        exit;
    }

    if ($action_type === 'check') {
        // Fetch current user's interactions for this post
        $userInteractions = $kon->prepare("SELECT interaction_type FROM interactions WHERE user_id = ? AND post_id = ?");
        $userInteractions->bind_param("ii", $user_id, $post_id);
        $userInteractions->execute();
        $result = $userInteractions->get_result();

        $userActions = [];
        while ($row = $result->fetch_assoc()) {
            $userActions[] = $row['interaction_type'];
        }

        echo json_encode(['status' => 'success', 'userActions' => $userActions]);
        exit;
    }

    // Handle Save logic (toggle)
    if ($action_type === 'save') {
        $checkSave = $kon->prepare("SELECT * FROM interactions WHERE user_id = ? AND post_id = ? AND interaction_type = 'save'");
        $checkSave->bind_param("ii", $user_id, $post_id);
        $checkSave->execute();
        $checkSave->store_result();

        if ($checkSave->num_rows > 0) {
            $stmt = $kon->prepare("DELETE FROM interactions WHERE user_id = ? AND post_id = ? AND interaction_type = 'save'");
            $stmt->bind_param("ii", $user_id, $post_id);
            $stmt->execute();
        } else {
            $stmt = $kon->prepare("INSERT INTO interactions (user_id, post_id, interaction_type) VALUES (?, ?, 'save')");
            $stmt->bind_param("ii", $user_id, $post_id);
            $stmt->execute();
        }
    } else {
        $kon->query("DELETE FROM interactions WHERE post_id = $post_id AND user_id = $user_id AND interaction_type IN ('like', 'dislike')");
        $stmt = $kon->prepare("REPLACE INTO interactions (user_id, post_id, interaction_type) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $post_id, $action_type);
        $stmt->execute();
    }

    $result = $kon->query("
        SELECT 
            COUNT(CASE WHEN interaction_type = 'like' THEN 1 END) AS likes,
            COUNT(CASE WHEN interaction_type = 'dislike' THEN 1 END) AS dislikes,
            COUNT(CASE WHEN interaction_type = 'save' THEN 1 END) AS saves
        FROM interactions
        WHERE post_id = $post_id
    ");

    $data = $result->fetch_assoc();

    echo json_encode([
        'status' => 'success',
        'message' => ucfirst($action_type) . ' action processed.',
        'likes' => $data['likes'],
        'dislikes' => $data['dislikes'],
        'saves' => $data['saves']
    ]);

    $kon->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
