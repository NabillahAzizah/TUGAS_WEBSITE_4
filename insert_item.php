<?php
include 'header.php';
include 'data_koneksi.php';

$kategori_sql = "SELECT * FROM kategori";
$kategori_result = $conn->query($kategori_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_menu = $_POST['nama_menu'];
    $bahan = $_POST['bahan'];
    $resep = $_POST['resep'];
    $id_kategori = $_POST['id_kategori'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if($check === false) {
        echo "File bukan gambar.";
        exit();
    }

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $sql = $conn->prepare("INSERT INTO menu (nama_menu, bahan, resep, gambar, id_kategori) VALUES (?, ?, ?, ?, ?)");

        if ($sql === false) {
            die("Error: " . $conn->error);
        }

        $sql->bind_param("ssssi", $nama_menu, $bahan, $resep, $target_file, $id_kategori);

        if ($sql->execute()) {
            echo "Item berhasil ditambahkan!";
        } else {
            echo "Error: " . $sql->error;
        }

        $sql->close();
    } else {
        echo "Terjadi kesalahan saat mengupload gambar.";
    }
}

$conn->close();
?>
<div class='container'>

<h2>Tambah Item</h2>
<form method="post" enctype="multipart/form-data">
    Nama Menu: <input type="text" name="nama_menu" required><br>
    Bahan: <textarea name="bahan" required></textarea><br>
    Resep: <textarea name="resep" required></textarea><br>
    Gambar: <input type="file" name="gambar" required><br>
    Kategori: 
    <select name="id_kategori" required>
        <?php
        while ($row = $kategori_result->fetch_assoc()) {
            echo "<option value='" . $row['id_kategori'] . "'>" . $row['nama_kategori'] . "</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Tambah Item">
</form>
</div>
<?php include 'footer.php'; ?>