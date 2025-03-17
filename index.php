<?php
session_start();
require 'config.php';

// Truy vấn lấy danh sách sinh viên từ bảng SinhVien
$sql = "SELECT * FROM SinhVien";
$result = $conn->query($sql);
?>

<?php include 'header.php'; ?>

<h1 class="mb-4">Danh sách Sinh viên</h1>

<?php
// Hiển thị thông báo thành công nếu có, ví dụ từ thao tác thêm, sửa, xóa
if (isset($_GET['success'])) {
  echo '<div class="alert alert-success">Thao tác thành công!</div>';
}
?>

<div class="mb-3">
  <a href="create.php" class="btn btn-primary">Thêm mới sinh viên</a>
</div>

<table class="table table-bordered table-hover">
  <thead class="table-dark">
    <tr>
      <th>Mã SV</th>
      <th>Họ tên</th>
      <th>Giới tính</th>
      <th>Ngày sinh</th>
      <th>Mã ngành</th>
      <th>Hành động</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['MaSV']) ?></td>
          <td><?= htmlspecialchars($row['HoTen']) ?></td>
          <td><?= htmlspecialchars($row['GioiTinh']) ?></td>
          <td><?= htmlspecialchars($row['NgaySinh']) ?></td>
          <td><?= htmlspecialchars($row['MaNganh']) ?></td>
          <td>
            <a href="detail.php?MaSV=<?= urlencode($row['MaSV']) ?>" class="btn btn-sm btn-info">Chi tiết</a>
            <a href="edit.php?MaSV=<?= urlencode($row['MaSV']) ?>" class="btn btn-sm btn-warning">Sửa</a>
            <a href="delete.php?MaSV=<?= urlencode($row['MaSV']) ?>"
              onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?');"
              class="btn btn-sm btn-danger">Xóa</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="6" class="text-center">Không có sinh viên nào.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?php include 'footer.php'; ?>