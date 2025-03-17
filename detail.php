<?php
require 'config.php';

// Lấy MaSV từ query string
$MaSV = $_GET['MaSV'] ?? '';

// Lấy thông tin sinh viên
$sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
$result = $conn->query($sql);
$sinhVien = $result->fetch_assoc();
?>

<?php include 'header.php'; ?>
<h1 class="mb-4">Chi tiết Sinh viên</h1>

<?php if (!$sinhVien): ?>
  <div class="alert alert-danger">
    Không tìm thấy sinh viên!
  </div>
<?php else: ?>
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
<?php endif; ?>

<br>
<a href="index.php" class="btn btn-secondary">Về trang danh sách</a>

<?php include 'footer.php'; ?>
