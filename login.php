<?php
include 'header.php';
include 'data_koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = $conn->prepare("SELECT * FROM users WHERE username=?");
    if (!$sql) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit;
    }
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            echo "Login berhasil!  Anda akan diarahkan ke halaman utama...";
            header("Location: index.php");
            exit;
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
    }
    
    $sql->close();
    $conn->close();
}
?>

<h2>Login</h2>
<form method="post" action="">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>

<?php include 'footer.php'; ?>
