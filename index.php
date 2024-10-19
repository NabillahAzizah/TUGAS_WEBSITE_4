<?php

include 'header.php';
include 'data_koneksi.php';

if (isset($_SESSION['username'])) {
    echo "<div class='container'>";
        echo "<h2>Selamat datang, " . $_SESSION['username'] . "!</h2>";
        echo  "<i>Remaja kos hari ini, mau masak apa?</i>";
        echo  "<p>Silakan pilih menu di bawah:</p>";
        echo  "<ul>";
        echo   "<li><a href='list_menu.php?id_kategori=1'>Menu Lauk Pauk</a></li>";
        echo   "<li><a href='list_menu.php?id_kategori=2'>Menu Sayur</a></li>";
        echo  "</ul>";
        echo "</div>";

    echo "<div class='container'>";
        echo "<h2>Daftar Menu</h2>";
        echo  "<i>Berikut semua daftar menu yang ada:</i><br>";

    $sql = "SELECT * FROM menu";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<ul class='menu-list'>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo $row["nama_menu"];
            echo " --> <a href='update_item.php?id=" . $row['id'] . "'>Update</a>";
            echo " \ \ <a href='delete_item.php?id=" . $row['id'] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus item ini?');\">Delete</a>";
            echo " \ \  <a href='detail_menu.php?id_menu=" . $row['id'] . "'>Detail</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Belum ada menu.</p>";
    } 

    echo  "<br><i>Jika menu belum lengkap, catat di sini:</i><br></br>";
    echo "<a href='insert_item.php'>Tambah Item Baru</a>";
    echo "</div>";

} else {
    header("Location: login.php");
    exit;
}

$conn->close();
?>

<?php include 'footer.php'; 
?>