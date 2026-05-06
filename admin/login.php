<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'yaraahmed' && $password === 'yara2008') {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Luxurious+Script&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../assets/image9.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
        }
        .login-box {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        h1 {
            font-family: 'Luxurious Script', cursive;
            font-size: 3rem;
            color: white;
            text-align: center;
        }
        label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.5);
            display: block;
            margin-bottom: 0.4rem;
        }
        input {
            width: 100%;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 0.7rem 1rem;
            color: white;
            font-size: 0.85rem;
            outline: none;
            font-family: inherit;
        }
        input:focus {
            border-color: rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.11);
        }
        button {
            background: #6b705c;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.8rem;
            font-family: 'Playfair Display', serif;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover { background: #a5a58d; }
        .error {
            color: rgba(255,100,100,0.9);
            font-size: 0.82rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Admin</h1>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST">
            <div style="margin-bottom: 1rem;">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
