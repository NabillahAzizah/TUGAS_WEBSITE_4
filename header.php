<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Website</title>
    <style>
        .nav {
            background-color: #f2f2f2;
            padding: 15px;
        }
        .nav a {
            margin: 0 15px;
            text-decoration: none;
            position: relative;
            padding: 10px 15px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .nav ul{
            display: none;
            position: absolute;
            list-style-type: none;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2; 
            border: 1px solid #ccc;
            z-index: 1; 
            width: 200px;
        }

        .dropdown:hover ul {
            display: block;
        }

        .nav ul li {
            padding: 10px 15px;
        }
        .nav ul li:hover {
            background-color: #e2e2e2;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="nav">
        <a href="index.php">Home</a>

        <div class="dropdown">
            <a href="#">List Menu</a>
            <ul>
                <li>
                    <a href="list_menu.php ?id_kategori=1">Lauk Pauk</a>
                </li>
                <li>
                    <a href="list_menu.php ?id_kategori=2">Sayur</a>
                </li>
            </ul>
        </div>
        <?php
        if (isset($_SESSION['username'])) {
            echo '<a href="logout.php">Logout</a>';
        } else {
            echo '<a href="login.php">Login</a>';
            echo '<a href="register.php">Register</a>';
        }
        ?>
    </div>
