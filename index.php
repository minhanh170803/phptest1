<?php
require 'config.php';

// Truy vấn lấy danh sách sinh viên
$sql = "SELECT * FROM SinhVien";
$result = $conn->query($sql);
?>

<?php include 'header.php'; ?>
<h1 class="mb-4">Danh sách Sinh viên</h1>

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
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['MaSV'] ?></td>
        <td><?= $row['HoTen'] ?></td>
        <td><?= $row['GioiTinh'] ?></td>
        <td><?= $row['NgaySinh'] ?></td>
        <td><?= $row['MaNganh'] ?></td>
        <td>
          <a href="detail.php?MaSV=<?= $row['MaSV'] ?>" class="btn btn-sm btn-info">Chi tiết</a>
          <a href="edit.php?MaSV=<?= $row['MaSV'] ?>" class="btn btn-sm btn-warning">Sửa</a>
          <a href="delete.php?MaSV=<?= $row['MaSV'] ?>"
             onclick="return confirm('Bạn có chắc muốn xóa sinh viên này?');"
             class="btn btn-sm btn-danger">
             Xóa
          </a>
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
