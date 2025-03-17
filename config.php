<?php
$servername = "localhost";
$username = "root"; // XAMPP mặc định là root
$password = ""; // Mặc định là rỗng
$dbname = "Test1";

// Kết nối CSDL
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
