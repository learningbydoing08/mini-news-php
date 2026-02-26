<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM news WHERE id=?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $imageName = $news['image'];

    if (!empty($_FILES["image"]["name"])) {
        $imageName = time() . "_" . $_FILES["image"]["name"];
        move_uploaded_file(
            $_FILES["image"]["tmp_name"],
            "../uploads/" . $imageName
        );
    }

    $stmt = $pdo->prepare("UPDATE news SET title=?, content=?, image=? WHERE id=?");
    $stmt->execute([$title, $content, $imageName, $id]);

    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Berita</title>
</head>
<body class="bg-gray-100 p-10">

<h1 class="text-2xl font-bold mb-6">Edit Berita</h1>

<form method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-xl">

    <input type="text"
           name="title"
           value="<?= htmlspecialchars($news['title']) ?>"
           class="w-full border p-2 mb-3 rounded">

    <textarea name="content"
              rows="6"
              class="w-full border p-2 mb-3 rounded"><?= htmlspecialchars($news['content']) ?></textarea>

    <input type="file"
           name="image"
           class="w-full border p-2 mb-3 rounded">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Update
    </button>
</form>

</body>
</html>