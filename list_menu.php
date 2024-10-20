<?php
include 'header.php';
include 'data_koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET["id_kategori"])) {
    $id_kategori = $_GET["id_kategori"];
    
    $sql = "SELECT * FROM menu WHERE id_kategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $kategori_nama = $id_kategori == 1 ? "Lauk Pauk" : "Sayur";
} else {
    echo "ID kategori tidak diberikan.";
    exit();
}
?>

<div class='container'>

<h2>Daftar Menu <?php echo $kategori_nama; ?></h2>
<ul>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='container'>";
            echo "<li>";
            echo "<img src='" . $row["gambar"] . "' alt='" . $row["nama_menu"] . "' width='150'>";
            echo "<br><a href='detail_menu.php?id_menu=" . $row["id"] . "'>" . $row["nama_menu"] . "</a>";
            echo "</li>";   
            echo "</div>";     
        }
    } else {
        echo "<li>Menu belum tersedia.</li>";
    }
    ?>
</ul>
</div>
<?php
$stmt->close();
$conn->close();
include 'footer.php';
?>