<?php
include 'config.php';
include 'header.php';

// Lấy danh sách đăng ký từ database
$result = $conn->query("SELECT DangKy.MaDK, SinhVien.HoTen, HocPhan.TenHP, DangKy.NgayDK 
                        FROM DangKy
                        JOIN SinhVien ON DangKy.MaSV = SinhVien.MaSV
                        JOIN ChiTietDangKy ON DangKy.MaDK = ChiTietDangKy.MaDK
                        JOIN HocPhan ON ChiTietDangKy.MaHP = HocPhan.MaHP");
?>

<div class="container mt-5">
    <h2 class="text-center mb-3">Danh Sách Đăng Ký Học Phần</h2>

    <div class="text-end mb-3">
        <a href="create_dangky.php" class="btn btn-success btn-lg">
            <i class="bi bi-plus-circle"></i> Thêm Đăng Ký
        </a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Mã Đăng Ký</th>
                <th>Sinh Viên</th>
                <th>Học Phần</th>
                <th>Ngày Đăng Ký</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['MaDK']; ?></td>
                <td><?php echo $row['HoTen']; ?></td>
                <td><?php echo $row['TenHP']; ?></td>
                <td><?php echo $row['NgayDK']; ?></td>
                <td>
                    <a href="delete_dangky.php?MaDK=<?php echo $row['MaDK']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                        <i class="bi bi-trash"></i> Xóa
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
