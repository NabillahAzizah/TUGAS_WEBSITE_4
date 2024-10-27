<?php
include 'header.php';
include 'data_koneksi.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);    

    $cek_user = $conn->prepare("SELECT * FROM users WHERE username=?");
    $cek_user->bind_param("s", $username);
    $cek_user->execute();
    $cek_result = $cek_user->get_result();

    if($cek_result->num_rows>0){
        $error_message = "<div class='error-message'>Username sudah ada. Silakan gunakan username lain.</div>";
    } else {
        $sql = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $sql->bind_param("ss", $username, $password);
    
        if ($sql->execute()) {
                header("Location: login.php");
                exit();
            } else {
            echo "Error: " . $sql->error;
        }

        $sql->close();
    }

    $cek_user->close();
    $conn->close();
}
?>
<div class='container'>

<h2>Register</h2>
<form method="post" action="">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <?php if (!empty($error_message)) { ?>
        <div style="color: red; margin-top: 10px">
            <?php echo  $error_message; ?>
        </div>
    <?php }  ?>

    <input type="submit" value="Register">
</form>
</div>
<?php include 'footer.php'; ?>