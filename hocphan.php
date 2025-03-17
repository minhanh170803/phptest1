<?php
session_start();
include 'config.php';

// Kiểm tra nếu sinh viên chưa đăng nhập, chuyển hướng về trang đăng nhập
if (!isset($_SESSION['maSV'])) {
    header("Location: login.php");
    exit();
}

$maSV = $_SESSION['maSV'];

// Xử lý khi sinh viên nhấn "Đăng ký"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['maHP'])) {
    $maHP = $_POST['maHP'];

    // Kiểm tra xem sinh viên đã đăng ký học phần này chưa
    $checkQuery = "SELECT * FROM ChiTietDangKy WHERE MaSV='$maSV' AND MaHP='$maHP'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows == 0) {
        // Thêm đăng ký mới vào bảng ChiTietDangKy
        $insertQuery = "INSERT INTO ChiTietDangKy (MaSV, MaHP) VALUES ('$maSV', '$maHP')";
        $conn->query($insertQuery);

        // Chuyển hướng đến trang học phần đã đăng ký
        header("Location: hocphan_dadangky.php");
        exit();
    } else {
        $message = "Bạn đã đăng ký học phần này rồi!";
    }
}

// Lấy danh sách học phần
$hocPhanQuery = "SELECT * FROM HocPhan";
$hocPhanResult = $conn->query($hocPhanQuery);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Học Phần</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'header.php'; ?> <!-- Gọi header -->

    <div class="container mt-5">
        <h2 class="text-center">Danh Sách Học Phần</h2>

        <?php if (isset($message)) { ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php } ?>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $hocPhanResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['MaHP']; ?></td>
                        <td><?php echo $row['TenHP']; ?></td>
                        <td><?php echo $row['SoTinChi']; ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="maHP" value="<?php echo $row['MaHP']; ?>">
                                <button type="submit" class="btn btn-success">Đăng Ký</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?> <!-- Gọi footer -->
</body>

</html>