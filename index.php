<?php
require 'config/database.php';
session_start();

$stmt = $pdo->query("SELECT * FROM news ORDER BY created_at DESC");
$news = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mini News</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Berita Terbaru</h1>

    <?php foreach ($news as $item): ?>
        <div class="bg-white p-6 rounded-lg shadow mb-6">

            <?php
                $imagePath = "uploads/" . $item['image'];
                if (!empty($item['image']) && file_exists($imagePath)):
            ?>
                <img src="<?= htmlspecialchars($imagePath) ?>"
                     class="w-full h-60 object-cover rounded mb-4">
            <?php endif; ?>

            <h2 class="text-xl font-semibold">
                <?= htmlspecialchars($item['title']) ?>
            </h2>

            <p class="text-gray-600 mt-2">
                <?= nl2br(htmlspecialchars($item['content'])) ?>
            </p>

            <span class="text-sm text-gray-400 block mt-2">
                <?= $item['created_at'] ?>
            </span>

            <?php if(isset($_SESSION["user"])): ?>
                <div class="mt-4">
                    <a href="admin/edit.php?id=<?= $item['id'] ?>"
                       class="text-blue-500 mr-3">Edit</a>

                    <a href="admin/delete.php?id=<?= $item['id'] ?>"
                       class="text-red-500"
                       onclick="return confirm('Yakin hapus?')">
                       Delete
                    </a>
                </div>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>

    <a href="admin/login.php" class="text-blue-600 underline">Login Admin</a>
</div>

</body>
</html>