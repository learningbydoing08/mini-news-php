<?php
session_start();
require '../config/database.php';

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM news WHERE id=?");
$stmt->execute([$id]);

header("Location: ../index.php");
exit;