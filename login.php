<?php
session_start();
include 'config.php'; // Kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST["maSV"]; // Chỉ lấy mã sinh viên

    // Kiểm tra xem mã sinh viên có tồn tại không
    $sql = "SELECT * FROM SinhVien WHERE MaSV = '$maSV'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['maSV'] = $maSV; // Lưu mã sinh viên vào session
        header("Location: hocphan.php"); // Chuyển hướng về trang chủ
        exit();
    } else {
        $error = "Mã sinh viên không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Đăng nhập</h2>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label for="maSV" class="form-label">Mã Sinh Viên</label>
                <input type="text" class="form-control" id="maSV" name="maSV" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng Nhập</button>
        </form>
    </div>
</body>
</html>
