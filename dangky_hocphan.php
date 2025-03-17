<?php
session_start();
require 'config.php';

// Lấy mã sinh viên từ session
$MaSV = $_SESSION['MaSV'] ?? '';
if (!$MaSV) {
    die("Chưa có thông tin sinh viên. Vui lòng đăng nhập.");
}

// Truy vấn danh sách học phần
$sqlHocPhan = "SELECT * FROM HocPhan";
$resultHocPhan = $conn->query($sqlHocPhan);
$courses = [];
if ($resultHocPhan && $resultHocPhan->num_rows > 0) {
    while ($row = $resultHocPhan->fetch_assoc()) {
        $courses[] = $row;
    }
}

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy danh sách học phần được chọn (mảng MaHP)
    $selectedCourses = $_POST['MaHP'] ?? [];
    if (empty($selectedCourses)) {
        $error = "Bạn phải chọn ít nhất 1 học phần.";
    } else {
        // Tạo phiếu đăng ký: insert vào bảng DangKy
        $ngayDK = date('Y-m-d');
        $sqlInsertDK = "INSERT INTO DangKy (NgayDK, MaSV) VALUES ('$ngayDK', '$MaSV')";
        if ($conn->query($sqlInsertDK) === TRUE) {
            $MaDK = $conn->insert_id;
            $success = true;
            // Lưu từng học phần vào bảng ChiTietDangKy
            foreach ($selectedCourses as $MaHP) {
                $sqlInsertCT = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')";
                if (!$conn->query($sqlInsertCT)) {
                    $success = false;
                    $error = "Lỗi khi đăng ký học phần: " . $conn->error;
                    break;
                }
            }
            if ($success) {
                // Đăng ký thành công, chuyển hướng về index với thông báo
                header("Location: index.php?success=1");
                exit;
            }
        } else {
            $error = "Lỗi khi tạo phiếu đăng ký: " . $conn->error;
        }
    }
}
?>

<?php include 'header.php'; ?>

<h1 class="mb-4">Đăng ký Học phần</h1>

<!-- Hiển thị thông báo lỗi (nếu có) -->
<?php if (isset($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST">
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Mã HP</th>
        <th>Tên học phần</th>
        <th>Số tín chỉ</th>
        <th>Chọn</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($courses)): ?>
        <?php $i = 1; ?>
        <?php foreach ($courses as $course): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($course['MaHP']) ?></td>
            <td><?= htmlspecialchars($course['TenHP']) ?></td>
            <td><?= htmlspecialchars($course['SoTinChi']) ?></td>
            <td>
              <input type="checkbox" name="MaHP[]" value="<?= htmlspecialchars($course['MaHP']) ?>">
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center text-muted">Chưa có học phần nào.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <button type="submit" class="btn btn-primary">Đăng ký</button>
  <a href="index.php" class="btn btn-secondary">Quay lại</a>
</form>

<?php include 'footer.php'; ?>