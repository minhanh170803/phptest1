<?php
require 'config.php';

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $MaSV    = $_POST['MaSV'];
    $HoTen   = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $Hinh    = $_POST['Hinh'];
    $MaNganh = $_POST['MaNganh'];

    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh)
            VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$Hinh', '$MaNganh')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi thêm mới: " . $conn->error;
    }
}
?>

<?php include 'header.php'; ?>
<h1 class="mb-4">Thêm mới Sinh viên</h1>

<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Mã SV:</label>
        <input type="text" name="MaSV" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Họ tên:</label>
        <input type="text" name="HoTen" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Giới tính:</label>
        <input type="text" name="GioiTinh" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Ngày sinh (yyyy-mm-dd):</label>
        <input type="date" name="NgaySinh" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Hình (URL ảnh):</label>
        <input type="text" name="Hinh" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Mã ngành:</label>
        <input type="text" name="MaNganh" class="form-control" required>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="index.php" class="btn btn-secondary">Về trang danh sách</a>
    </div>
</form>

<?php include 'footer.php'; ?>