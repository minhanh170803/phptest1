<?php
session_start();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Sinh viên</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Thanh điều hướng (Navbar) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">QL Sinh viên</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="hocphan.php">Quản lý Học Phần</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dangky.php">Đăng Ký Học Phần</a>
                    </li>
                </ul>

                <!-- Nút Đăng nhập/Đăng xuất bên phải -->
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['maSV'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-danger text-white ms-2" href="logout.php">Đăng Xuất</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white ms-2" href="login.php">Đăng Nhập</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
