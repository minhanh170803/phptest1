<?php
require 'config.php';

// Lấy MaSV từ URL (GET)
$MaSV = $_GET['MaSV'] ?? '';

// Nếu người dùng đã xác nhận xóa (gửi form POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy lại MaSV từ form (ẩn trong input hidden)
    $MaSV = $_POST['MaSV'] ?? '';

    // Thực hiện xóa
    $sql = "DELETE FROM SinhVien WHERE MaSV='$MaSV'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi khi xóa: " . $conn->error;
    }
} else {
    // Nếu chưa POST, tức là lần đầu vào trang => Lấy thông tin sinh viên để hiển thị
    $sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
    $result = $conn->query($sql);
    $sinhVien = $result->fetch_assoc();
}
?>

<?php include 'header.php'; ?>
<h1 class="mb-4">Xóa Sinh viên</h1>

<?php if (!$sinhVien): ?>
    <div class="alert alert-danger">
        Không tìm thấy sinh viên với mã <?= htmlspecialchars($MaSV) ?>!
    </div>
    <a href="index.php" class="btn btn-secondary">Về trang danh sách</a>
<?php else: ?>
    <!-- Hiển thị thông tin sinh viên dạng Card (như trang detail) -->
    <div class="card" style="max-width: 500px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= $sinhVien['Hinh'] ?>" class="img-fluid rounded-start"
                    alt="Hình sinh viên" onerror="this.onerror=null;this.src='https://via.placeholder.com/150';">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $sinhVien['HoTen'] ?></h5>
                    <p class="card-text"><strong>Mã SV:</strong> <?= $sinhVien['MaSV'] ?></p>
                    <p class="card-text"><strong>Giới tính:</strong> <?= $sinhVien['GioiTinh'] ?></p>
                    <p class="card-text"><strong>Ngày sinh:</strong> <?= $sinhVien['NgaySinh'] ?></p>
                    <p class="card-text"><strong>Mã ngành:</strong> <?= $sinhVien['MaNganh'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Phần xác nhận xóa, đặt bên dưới Card -->
    <div class="alert alert-warning mt-4" role="alert">
        Bạn có chắc muốn xóa sinh viên <strong><?= htmlspecialchars($sinhVien['HoTen']) ?></strong> (Mã SV: <?= htmlspecialchars($sinhVien['MaSV']) ?>)?
    </div>
    <form method="POST">
        <input type="hidden" name="MaSV" value="<?= htmlspecialchars($sinhVien['MaSV']) ?>">
        <button type="submit" class="btn btn-danger">Xóa</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </form>
<?php endif; ?>

<?php include 'footer.php'; ?>