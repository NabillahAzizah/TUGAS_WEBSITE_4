<?php
include 'header.php';
include 'data_koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = $conn->prepare("SELECT * FROM menu WHERE id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "Menu tidak ditemukan.";
        exit();
    }
} else {
    echo "ID menu tidak diberikan.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_menu = $_POST['nama_menu'];
    $bahan = $_POST['bahan'];
    $resep = $_POST['resep'];
    $id_kategori = $_POST['id_kategori'];
    
    if ($_FILES["gambar"]["error"] == UPLOAD_ERR_OK) {

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

        $sql = $conn->prepare("UPDATE menu SET nama_menu = ?, bahan = ?, resep = ?, gambar = ?, id_kategori = ? WHERE id = ?");
        $sql->bind_param("ssssii", $nama_menu, $bahan, $resep, $target_file, $id_kategori, $id);
    } else {

        $sql = $conn->prepare("UPDATE menu SET nama_menu = ?, bahan = ?, resep = ?, id_kategori = ? WHERE id = ?");
        $sql->bind_param("sssii", $nama_menu, $bahan, $resep, $id_kategori, $id);
    }

    if ($sql->execute()) {
        echo "Item berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql->error;
    }

    $sql->close();
    $conn->close();
}
?>
<div class='container'>
<h2>Update Item</h2>
<form method="post" enctype="multipart/form-data">

    Nama Menu: <input type="text" name="nama_menu" value="<?php echo $row['nama_menu']; ?>" required><br>
    Bahan: <textarea name="bahan" required><?php echo $row['bahan']; ?></textarea><br>
    Resep: <textarea name="resep" required><?php echo $row['resep']; ?></textarea><br>
    Gambar: <input type="file" name="gambar"><br>
    <img src="<?php echo $row['gambar']; ?>" alt="Gambar Menu" width="100"><br>
    Kategori: 
    <select name="id_kategori" required>
        <?php
        $kategori_sql = "SELECT * FROM kategori";
        $kategori_result = $conn->query($kategori_sql);
        while ($kategori_row = $kategori_result->fetch_assoc()) {
            $selected = $kategori_row['id_kategori'] == $row['id_kategori'] ? 'selected' : '';
            echo "<option value='" . $kategori_row['id_kategori'] . "' $selected>" . $kategori_row['nama_kategori'] . "</option>";
        }
        ?>
    </select><br>

    <input type="submit" value="Update Item">
</form>
</div>

<?php include 'footer.php'; ?>
