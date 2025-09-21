<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
            /* Ensures the body takes full height of the viewport */
            padding: 20px;
            /* Add space between the card and the top/bottom of the screen */
        }

        .custom-btn {
            background-color: #111;
            /* Matching gray color */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s;
            font-weight: 500;
        }

        .custom-btn:hover {
            background-color: #1119;
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

        <h2 class="text-2xl font-semibold text-center mb-4">Welcome Back!</h2>

        <form id="loginForm" class="space-y-4" method="post" action="loginaction.php">
            <!-- Email input -->
            <div id="emailInput">
                <input type="email" name="email" placeholder="Enter your email*" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
            </div>

            <!-- Password input -->
            <div id="passwordInput">
                <input type="password" id="passwordField" name="password" placeholder="Enter your password*" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-500">
            </div>

            <!-- Display error messages if any -->
            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <?php
                    if ($_GET['error'] == 'invalid_credentials') {
                        echo "Incorrect email or password. Please try again.";
                    } elseif ($_GET['error'] == 'empty_fields') {
                        echo "Both email and password are required.";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <!-- Show/Hide Password Checkbox -->
            <div class="flex items-center">
                <input type="checkbox" id="showPasswordToggle" class="mr-2">
                <label for="showPasswordToggle" class="text-sm text-gray-600">Show Password</label>
            </div>

            <!-- Sign in button -->
            <button type="submit" id="continueButton" class="custom-btn w-full text-center">Sign In</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">New here?
                <a href="signup.php" class="text-blue-500">Create an account</a>
            </p>
        </div>
    </div>


    <script>
        // JavaScript to toggle password visibility
        document.getElementById('showPasswordToggle').addEventListener('change', function() {
            var passwordField = document.getElementById('passwordField');
            if (this.checked) {
                passwordField.type = 'text'; // Show password
            } else {
                passwordField.type = 'password'; // Hide password
            }
        });
    </script>

</body>

</html>