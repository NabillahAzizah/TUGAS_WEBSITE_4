<?php
include 'header.php';
include 'data_koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];

    $sql = $conn->prepare("SELECT * FROM menu WHERE id = ?");
    $sql->bind_param("i", $id_menu);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Menu tidak ditemukan.";
        exit();
    }
} else {
    echo "ID menu tidak diberikan.";
    exit();
}
?>

<h2>Detail Menu</h2>
<pre>Nama Menu: <?php echo $row["nama_menu"]; ?></pre>
<pre>Bahan: <?php echo $row["bahan"]; ?></pre>
<pre>Resep: <?php echo $row["resep"]; ?></pre>
<a href="list_menu.php ?id_kategori= <?php echo $row['id_kategori']; ?>">
    Kembali ke List Menu</a>

<?php
$sql->close();
$conn->close();
include 'footer.php';
?>
