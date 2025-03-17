<?php
include 'config.php';

if (isset($_GET['MaDK'])) {
    $MaDK = $_GET['MaDK'];

    // Xóa chi tiết đăng ký trước
    $conn->query("DELETE FROM ChiTietDangKy WHERE MaDK='$MaDK'");

    // Xóa đăng ký
    $conn->query("DELETE FROM DangKy WHERE MaDK='$MaDK'");

    header("Location: dangky.php");
}
?>
