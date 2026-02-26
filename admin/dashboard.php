<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

<h1 class="text-2xl font-bold mb-4">Dashboard</h1>

<a href="create.php"
   class="bg-green-600 text-white px-4 py-2 rounded">
   + Buat Berita
</a>

<a href="logout.php"
   class="ml-4 text-red-500 underline">
   Logout
</a>

</body>
</html>