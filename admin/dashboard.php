<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$host = 'localhost';
$db   = 'portfolio';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $stmt = $pdo->prepare("INSERT INTO projects (title, tag, description, github_url, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['title'], $_POST['tag'], $_POST['description'], $_POST['github_url'], $_POST['image']]);
    header('Location: dashboard.php');
    exit;
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$_POST['id']]);
    header('Location: dashboard.php');
    exit;
}

$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Luxurious+Script&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('../assets/image9.jpg');
            background-size: cover;
            background-position: center;
            font-family: 'Playfair Display', serif;
            color: white;
            padding: 2rem;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        h1 {
            font-family: 'Luxurious Script', cursive;
            font-size: 3rem;
        }
        a.logout {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            transition: background 0.2s;
        }
        a.logout:hover { background: rgba(255,255,255,0.1); }
        .card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        h2 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            color: rgba(255,255,255,0.8);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.85rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-grid .full { grid-column: 1 / -1; }
        label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.5);
            display: block;
            margin-bottom: 0.3rem;
        }
        input, textarea, select {
            width: 100%;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 0.7rem 1rem;
            color: white;
            font-size: 0.85rem;
            outline: none;
            font-family: inherit;
            resize: none;
        }
        input:focus, textarea:focus { border-color: rgba(255,255,255,0.5); }
        button {
            margin-top: 1rem;
            background: #6b705c;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.7rem 2rem;
            font-family: 'Playfair Display', serif;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover { background: #a5a58d; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }
        th {
            text-align: left;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255,255,255,0.5);
            padding-bottom: 0.8rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        td {
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.85);
        }
        .delete-btn {
            background: rgba(255,100,100,0.15);
            border: 1px solid rgba(255,100,100,0.3);
            color: rgba(255,100,100,0.9);
            border-radius: 20px;
            padding: 0.3rem 0.9rem;
            font-size: 0.75rem;
            cursor: pointer;
            margin-top: 0;
            letter-spacing: 1px;
        }
        .delete-btn:hover { background: rgba(255,100,100,0.3); }
    </style>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <a href="logout.php" class="logout">Logout</a>
    </header>

    <div class="card">
        <h2>Add New Project</h2>
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="form-grid">
                <div>
                    <label>Title</label>
                    <input type="text" name="title" required>
                </div>
                <div>
                    <label>Tag</label>
                    <input type="text" name="tag" placeholder="e.g. Backend, IoT" required>
                </div>
                <div class="full">
                    <label>Description</label>
                    <textarea name="description" rows="3" required></textarea>
                </div>
                <div>
                    <label>GitHub URL</label>
                    <input type="text" name="github_url" required>
                </div>
                <div>
                    <label>Image path</label>
                    <input type="text" name="image" placeholder="assets/image.jpg" required>
                </div>
            </div>
            <button type="submit">Add Project</button>
        </form>
    </div>

    <div class="card">
        <h2>Existing Projects</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Tag</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['title']) ?></td>
                    <td><?= htmlspecialchars($p['tag']) ?></td>
                    <td><?= htmlspecialchars($p['description']) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
