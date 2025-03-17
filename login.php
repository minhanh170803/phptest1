<?php
session_start();
require 'config.php';

$error = '';

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy MSSV từ form, loại bỏ khoảng trắng dư
    $MaSV = trim($_POST['MaSV'] ?? '');

    if (empty($MaSV)) {
        $error = "Vui lòng nhập MSSV.";
    } else {
        // Kiểm tra MSSV trong bảng SinhVien
        $sql = "SELECT * FROM SinhVien WHERE MaSV = '$MaSV'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            // Nếu tìm thấy, lưu thông tin đăng nhập vào session
            $_SESSION['MaSV'] = $MaSV;
            header("Location: index.php");
            exit();
        } else {
            $error = "MSSV không tồn tại!";
        }
    }
}
?>

<?php include 'header.php'; ?>
<h1 class="mb-4">Đăng nhập</h1>

<?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="row g-3" style="max-width: 400px;">
    <div class="col-12">
        <label class="form-label">MSSV:</label>
        <input type="text" name="MaSV" class="form-control" required>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
    </div>
</form>

<?php include 'footer.php'; ?>