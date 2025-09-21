<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
    $target_dir = "../assets/img/uploads/";
    $file_name = basename($_FILES["upload"]["name"]);
    $target_file = $target_dir . $file_name;

    // Cek tipe file (hanya menerima gambar)
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_type, $allowed_types)) {
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            // URL gambar yang di-upload
            $response = [
                "uploaded" => true,
                "url" => $target_file
            ];
        } else {
            $response = [
                "uploaded" => false,
                "error" => ["message" => "Gagal mengunggah file."]
            ];
        }
    } else {
        $response = [
            "uploaded" => false,
            "error" => ["message" => "Format file tidak didukung."]
        ];
    }

    echo json_encode($response);
}
