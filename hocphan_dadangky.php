<?php
session_start();
include 'config.php';

// Kiểm tra nếu sinh viên chưa đăng nhập, chuyển hướng về trang đăng nhập
if (!isset($_SESSION['maSV'])) {
    header("Location: login.php");
    exit();
}

$maSV = $_SESSION['maSV'];

// Xử lý khi sinh viên nhấn "Hủy đăng ký"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['maHP'])) {
    $maHP = $_POST['maHP'];
    $deleteQuery = "DELETE FROM ChiTietDangKy WHERE MaSV='$maSV' AND MaHP='$maHP'";
    $conn->query($deleteQuery);
    $message = "Hủy đăng ký học phần thành công!";
}

// Lấy danh sách học phần mà sinh viên đã đăng ký
$registeredQuery = "SELECT HocPhan.MaHP, HocPhan.TenHP, HocPhan.SoTinChi 
                    FROM ChiTietDangKy 
                    JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP 
                    WHERE ChiTietDangKy.MaSV='$maSV'";
$registeredResult = $conn->query($registeredQuery);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Học Phần Đã Đăng Ký</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'header.php'; ?> <!-- Gọi header -->

    <div class="container mt-5">
        <h2 class="text-center">Học Phần Đã Đăng Ký</h2>

        <?php if (isset($message)) { ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php } ?>

        <?php if ($registeredResult->num_rows > 0) { ?>
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
                    <?php while ($row = $registeredResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['MaHP']; ?></td>
                            <td><?php echo $row['TenHP']; ?></td>
                            <td><?php echo $row['SoTinChi']; ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="maHP" value="<?php echo $row['MaHP']; ?>">
                                    <button type="submit" class="btn btn-danger">Hủy Đăng Ký</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-warning text-center">Bạn chưa đăng ký học phần nào.</div>
        <?php } ?>
    </div>

    <?php include 'footer.php'; ?> <!-- Gọi footer -->
</body>

</html>