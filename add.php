<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, MaNganh) 
            VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$MaNganh')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm sinh viên thành công!";
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Sinh Viên</title>
</head>

<body>
    <h2>Thêm Sinh Viên</h2>
    <form method="POST">
        Mã SV: <input type="text" name="MaSV" required><br>
        Họ Tên: <input type="text" name="HoTen" required><br>
        Giới Tính: <select name="GioiTinh">
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select><br>
        Ngày Sinh: <input type="date" na