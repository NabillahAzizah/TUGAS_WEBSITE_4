<?php

include 'header.php';
include 'data_koneksi.php';

if (isset($_SESSION['username'])) {
    echo "<h2>Selamat datang, " . $_SESSION['username'] . "!</h2>";
    echo  "<p>Silahkan pilih menu di bawah ini:.</p>";
    echo  "<ul>";
    echo   "<li><a href='list_menu.php ?id_kategori=1'>Menu Lauk Pauk</a></li>";
    echo   "<li><a href='list_menu.php ?id_kategori=2'>Menu Sayur</a></li>";
    echo   "</ul>";
} else {
    header("Location: login.php");
    exit;
}
?>

<?php include 'footer.php'; ?>
