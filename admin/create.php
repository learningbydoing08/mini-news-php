<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = $_POST["title"] ?? '';
    $content = $_POST["content"] ?? '';

    $imageName = null;

    // PROSES UPLOAD GAMBAR
    if (!empty($_FILES["image"]["name"])) {

        $uploadDir = __DIR__ . "/../uploads/";

        // Kalau folder belum ada, buat otomatis
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Bikin nama unik
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $uploadPath = $uploadDir . $imageName;

        // Pindahkan file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath)) {
            die("Upload gagal! Cek permission folder uploads.");
        }
    }

    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO news (title, content, image) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $imageName]);

    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Buat Berita</title>
</head>
<body class="bg-gray-100 p-10">

<h1 class="text-2xl font-bold mb-6">Buat Berita</h1>

<form method="POST"
      enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-xl">

    <input type="text"
           name="title"
           placeholder="Judul"
           required
           class="w-full border p-2 mb-3 rounded">

    <textarea name="content"
              rows="6"
              placeholder="Isi berita"
              required
              class="w-full border p-2 mb-3 rounded"></textarea>

    <input type="file"
           name="image"
           accept="image/*"
           class="w-full border p-2 mb-3 rounded">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Publish
    </button>

</form>

</body>
</html>