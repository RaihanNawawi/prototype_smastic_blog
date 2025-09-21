<?php
// Include koneksi database
include "include/koneksi.php";

function registerUser($username, $email, $password)
{
    global $kon;  // Menggunakan koneksi database global

    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        return "Semua kolom harus diisi.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Format email tidak valid.";
    }

    // Cek apakah email sudah terdaftar
    $query = $kon->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        return "Email sudah terdaftar.";
    }

    // Hash password sebelum menyimpan ke database
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Simpan user baru ke database
    $createdAt = date('Y-m-d H:i:s');
    $stmt = $kon->prepare("INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $createdAt);

    // Cek apakah eksekusi query berhasil
    if ($stmt->execute()) {
        return "<META HTTP-EQUIV='Refresh' Content='0; URL=login.php'>";
    } else {
        return "Terjadi kesalahan: " . $stmt->error;
    }
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Panggil fungsi untuk mendaftarkan user
    $message = registerUser($username, $email, $password);
    echo $message;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="icon" href="img/ic3.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f9f9f9;
            /* Flexbox centering */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .custom-btn {
            background-color: #111;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
            font-weight: 500;
        }

        .custom-btn:hover {
            background-color: #1119;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.75rem;
            width: 100%;
            background-color: white;
            transition: background-color 0.2s;
        }

        .social-btn img {
            margin-right: 0.5rem;
        }

        .social-btn:hover {
            background-color: #f3f4f6;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #6b7280;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex-grow: 1;
            background: #d1d5db;
            height: 1px;
            margin: 0 1rem;
        }
    </style>
</head>

<body>

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center">
            <img src="img/ic1.png" class="h-45" alt="Logo">
        </div>

        <h2 class="text-2xl font-semibold text-center mb-4">Create a New Account</h2>

        <form id="signupForm" class="space-y-4" method="post">
            <!-- Full Name Input -->
            <div id="nameInput">
                <input name="username" type="text" id="name" placeholder="Full Name*" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
            </div>

            <!-- Email Input -->
            <div id="emailInput">
                <input type="email" name="email" id="email" placeholder="Email Address*" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
            </div>

            <!-- Password Input -->
            <div id="passwordInput">
                <input type="password" name="password" id="password" placeholder="Password*" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
            </div>

            <!-- Sign Up Button -->
            <button type="submit" id="signupButton" class="custom-btn w-full text-center">Sign Up</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">Already have an account?
                <a href="login.php" class="text-blue-500">Sign In</a>
            </p>
        </div>

        <!-- Uncomment if you want to add social sign-up options -->
        <!-- 
    <div class="divider my-4">OR</div>

    <div class="space-y-2">
        <button class="social-btn">
            <img src="https://img.icons8.com/color/24/000000/google-logo.png"> Continue with Google
        </button>
        <button class="social-btn">
            <img src="https://img.icons8.com/color/24/000000/microsoft.png"> Continue with Microsoft
        </button>
        <button class="social-btn">
            <img src="https://img.icons8.com/ios-filled/24/000000/mac-os.png"> Continue with Apple
        </button>
    </div> 
    -->
    </div>


</body>

</html>