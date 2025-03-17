<?php
require 'config.php';

// Lấy MaSV từ query string
$MaSV = $_GET['MaSV'] ?? '';

// Lấy thông tin sinh viên hiện tại
$sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
$result = $conn->query($sql);
$sinhVien = $result->fetch_assoc();

if (!$sinhVien) {
    die("Không tìm thấy sinh viên với mã: " . htmlspecialchars($MaSV));
}

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $HoTen    = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh  = $_POST['MaNganh'];
    
    // Kiểm tra file upload hình ảnh
    if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['Hinh']['tmp_name'];
        $fileName      = $_FILES['Hinh']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts   = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExts)) {
            $uploadFolder = 'uploads/';
            if (!is_dir($uploadFolder)) {
                mkdir($uploadFolder, 0755, true);
            }
            // Tạo tên file duy nhất để tránh trùng lặp
            $newFileName = uniqid('img_', true) . '.' . $fileExtension;
            $destPath = $uploadFolder . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                echo "Lỗi khi di chuyển file upload.";
                exit;
            }
            $Hinh = $destPath;
        } else {
            echo "Định dạng file không hợp lệ. Chỉ hỗ trợ jpg, jpeg, png, gif.";
            exit;
        }
    } else {
        // Nếu không chọn file mới, giữ lại ảnh hiện tại (được gửi qua input hidden)
        $Hinh = $_POST['currentHinh'] ?? $sinhVien['Hinh'];
    }

    // Cập nhật thông tin sinh viên vào CSDL
    $sql = "UPDATE SinhVien 
            SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', Hinh='$Hinh', MaNganh='$MaNganh'
            WHERE MaSV='$MaSV'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi khi sửa: " . $conn->error;
    }
}
?>

<?php include 'header.php'; ?>
<h1 class="mb-4">Sửa Sinh viên</h1>

<?php if (!$sinhVien): ?>
  <div class="alert alert-danger">
    Không tìm thấy sinh viên với mã <?= htmlspecialchars($MaSV) ?>!
  </div>
  <a href="index.php" class="btn btn-secondary">Về trang danh sách</a>
<?php else: ?>
  <!-- Hiển thị thông tin hiện tại của sinh viên trong Card -->
  <div class="card mb-4" style="max-width: 600px;">
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

  <!-- Form chỉnh sửa thông tin sinh viên -->
  <!-- Lưu ý: thêm enctype để hỗ trợ upload file -->
  <form method="POST" class="row g-3" style="max-width: 600px;" enctype="multipart/form-data">
    <div class="col-md-6">
      <label class="form-label">Mã SV (không sửa được):</label>
      <input type="text" class="form-control" value="<?= $sinhVien['MaSV'] ?>" disabled>
    </div>
    <div class="col-md-6">
      <label class="form-label">Họ tên:</label>
      <input type="text" name="HoTen" class="form-control" value="<?= $sinhVien['HoTen'] ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Giới tính:</label>
      <input type="text" name="GioiTinh" class="form-control" value="<?= $sinhVien['GioiTinh'] ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Ngày sinh (yyyy-mm-dd):</label>
      <input type="date" name="NgaySinh" class="form-control" value="<?= $sinhVien['NgaySinh'] ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Hình (URL ảnh hoặc chọn file):</label>
      <!-- Hiển thị đường dẫn file cũ (nếu muốn) và cho phép chọn file mới -->
      <input type="file" name="Hinh" class="form-control">
      <small class="form-text text-muted">
        Nếu không chọn file mới, ảnh hiện tại sẽ được giữ lại.
      </small>
      <!-- Input hidden chứa ảnh hiện tại -->
      <input type="hidden" name="currentHinh" value="<?= $sinhVien['Hinh'] ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Mã ngành:</label>
      <input type="text" name="MaNganh" class="form-control" value="<?= $sinhVien['MaNganh'] ?>" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-warning">Cập nhật</button>
      <a href="index.php" class="btn btn-secondary">Về trang danh sách</a>
    </div>
  </form>
<?php endif; ?>

<?php include 'footer.php'; ?>
