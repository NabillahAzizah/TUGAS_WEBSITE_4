<?php
include 'header.php';
include 'data_koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);    

    $sql = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $sql->bind_param("ss", $username, $password);

    if ($sql->execute()) {
        echo "Pendaftaran berhasil!";
    } else {
        echo "Error: " . $sql->error;
    }
    
    $sql->close();
    $conn->close();
}
?>

<h2>Register</h2>
<form method="post" action="">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Register">
</form>

<?php include 'footer.php'; ?>
