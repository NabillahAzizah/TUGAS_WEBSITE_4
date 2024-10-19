<?php
include 'header.php';
include 'data_koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $conn->prepare("DELETE FROM menu WHERE id = ?");
    $sql->bind_param("i", $id);

    if ($sql->execute()) {
        echo "Item berhasil dihapus!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql->error;
    }
} else {
    echo "ID item tidak diberikan.";
}

$conn->close();
?>