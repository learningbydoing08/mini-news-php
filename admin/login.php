<?php
session_start();
require '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->execute([$username, $password]);

    if ($stmt->rowCount() > 0) {
        $_SESSION["user"] = $username;
        header("Location: dashboard.php");
        exit;
    }

    $error = "Login gagal!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<form method="POST" class="bg-white p-8 rounded shadow w-96">
    <h2 class="text-2xl font-bold mb-4">Login Admin</h2>

    <?php if(isset($error)): ?>
        <p class="text-red-500"><?= $error ?></p>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Username"
        class="w-full border p-2 mb-3 rounded">

    <input type="password" name="password" placeholder="Password"
        class="w-full border p-2 mb-3 rounded">

    <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
        Login
    </button>
</form>

</body>
</html>