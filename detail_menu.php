<?php
include 'header.php';
include 'data_koneksi.php';

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

<div class='container'>
    <h2>Detail Menu</h2>
    <h3>Nama Menu: <?php echo $row["nama_menu"]; ?></h3>
    
    <h4>Bahan:</h4>
    <ul>
        <?php
        $bahan = explode('-', $row["bahan"]);
        foreach ($bahan as $item) {
            $trimmed_item = trim($item); 
            if (!empty($trimmed_item)) { 
                echo "<li> " . htmlspecialchars($trimmed_item) . "</li>";
            }
        }
        ?>
    </ul>
    
    <h4>Resep:</h4>
    <ol> 
        <?php
        $resep = $row["resep"];
        $resep_array = preg_split('/\d+\.\s/', $resep, -1, PREG_SPLIT_NO_EMPTY);
        
        foreach ($resep_array as $step) {
            echo "<li>" . trim($step) . "</li>"; 
        } ?>
    </ol>

    <h4>Gambar:</h4>
    <img src="<?php echo $row["gambar"]; ?>" alt="<?php echo $row["nama_menu"]; ?>" style="max-width: 100%; height: auto;">
    
    <a href="list_menu.php?id_kategori=<?php echo $row['id_kategori']; ?>"><br><br>Kembali ke List Menu</a>
</div>
<?php
$sql->close();
$conn->close();
include 'footer.php';
?>
