<?php
session_start();
require_once __DIR__ . '/app/Db.php';

// Logout
if (isset($_GET['logout'])) {
    session_start();
    session_destroy();

    // Redirect to the main screen (root of localhost)
    header("Location: /temp/");
    exit;
}

// Already logged in → redirect agad sa admin
if (!empty($_SESSION['user_id'])) {
    header('Location: admin/index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username !== '' && $password !== '') {
        try {
            $pdo = Db::getConnection();
            $stmt = $pdo->prepare('SELECT user_id, username, password, is_admin FROM users WHERE username = :u LIMIT 1');
            $stmt->execute([':u' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $user['password'] === $password) {
                // plaintext match
                $_SESSION['user_id'] = (int) $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = (int) $user['is_admin'] === 1;

                // Redirect lahat ng successful login sa admin
                header('Location: admin/index.php');
                exit();
            }

            $error = 'Invalid username or password';
        } catch (Exception $e) {
            $error = 'Login failed. Please try again.';
        }
    } else {
        $error = 'Please enter username and password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #DADADA;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 0 15px;
        }

        .login-card {
            background: #FFFFFF;
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        .login-header {
            background: #121212;
            color: #FFFFFF;
            padding: 2rem;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }

        .login-body {
            padding: 2rem;
        }

        .form-label {
            color: #121212;
            font-weight: 500;
        }

        .form-control {
            border: 2px solid #DADADA;
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #121212;
            box-shadow: 0 0 0 0.2rem rgba(18, 18, 18, 0.1);
        }

        .btn-login {
            background: #121212;
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #2a2a2a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card login-card">
            <div class="login-header">
                <h3 class="m-0">Welcome Back</h3>
                <p class="mb-0 mt-2">Please login to continue</p>
            </div>
            <div class="login-body">
                <?php if ($error): ?>
                <div class="alert alert-danger mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-4">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary btn-login w-100" type="submit">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
