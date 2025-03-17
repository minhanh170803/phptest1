<?php
session_start();
require 'config.php';

// Kiểm tra sinh viên đã đăng nhập chưa
$MaSV = $_SESSION['MaSV'] ?? '';
if (!$MaSV) {
    die("Chưa có thông tin sinh viên. Vui lòng đăng nhập.");
}

// Xử lý xóa học phần đã đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MaHP'])) {
    $MaHP = $_POST['MaHP'];
    $deleteQuery = "DELETE FROM ChiTietDangKy WHERE MaSV='$MaSV' AND MaHP='$MaHP'";
    if ($conn->query($deleteQuery)) {
        $message = "Hủy đăng ký học phần thành công!";
    } else {
        $message = "Lỗi khi hủy học phần: " . $conn->error;
    }
}

// Lấy danh sách học phần đã đăng ký
$sql = "
SELECT 
    sv.MaSV,
    sv.HoTen,
    sv.NgaySinh,
    sv.MaNganh,
    dk.MaDK,
    dk.NgayDK,
    hp.MaHP,
    hp.TenHP,
    hp.SoTinChi
FROM SinhVien sv
JOIN DangKy dk ON sv.MaSV = dk.MaSV
JOIN ChiTietDangKy ct ON dk.MaDK = ct.MaDK
JOIN HocPhan hp ON ct.MaHP = hp.MaHP
WHERE sv.MaSV = '$MaSV'
ORDER BY dk.MaDK
";

$result = $conn->query($sql);
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}

// Nếu không có kết quả, kiểm tra sinh viên có tồn tại không
if ($result->num_rows === 0) {
    $sqlCheckSV = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
    $rCheck = $conn->query($sqlCheckSV);
    if ($rCheck && $rCheck->num_rows > 0) {
        $svInfo = $rCheck->fetch_assoc();
        $student = [
            'MaSV'     => $svInfo['MaSV'],
            'HoTen'    => $svInfo['HoTen'],
            'NgaySinh' => $svInfo['NgaySinh'],
            'MaNganh'  => $svInfo['MaNganh']
        ];
        $courses = [];
    } else {
        die("Không tìm thấy thông tin sinh viên với MaSV = " . htmlspecialchars($MaSV));
    }
} else {
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $first = $rows[0];
    $student = [
        'MaSV'     => $first['MaSV'],
        'HoTen'    => $first['HoTen'],
        'NgaySinh' => $first['NgaySinh'],
        'MaNganh'  => $first['MaNganh']
    ];
    $courses = [];
    foreach ($rows as $r) {
        $courses[] = [
            'MaDK'      => $r['MaDK'],
            'NgayDK'    => $r['NgayDK'],
            'MaHP'      => $r['MaHP'],
            'TenHP'     => $r['TenHP'],
            'SoTinChi'  => $r['SoTinChi']
        ];
    }
}
?>

<?php include 'header.php'; ?>
<div class="container">
    <h2 class="mb-4">Tất cả học phần đã đăng ký</h2>

    <?php if (isset($message)) { ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php } ?>

    <!-- Thông tin sinh viên -->
    <div class="card p-3 mb-4" style="max-width: 600px;">
        <h5>Thông tin sinh viên</h5>
        <p><strong>Mã SV:</strong> <?= htmlspecialchars($student['MaSV'] ?? '') ?></p>
        <p><strong>Họ tên:</strong> <?= htmlspecialchars($student['HoTen'] ?? '') ?></p>
        <p><strong>Ngày sinh:</strong> <?= htmlspecialchars($student['NgaySinh'] ?? '') ?></p>
        <p><strong>Ngành học:</strong> <?= htmlspecialchars($student['MaNganh'] ?? '') ?></p>
    </div>

    <!-- Danh sách học phần đã đăng ký -->
    <?php if (empty($courses)): ?>
        <div class="alert alert-warning text-center">Sinh viên chưa đăng ký học phần nào.</div>
    <?php else: ?>
        <?php
        $totalCredits = 0;
        foreach ($courses as $c) {
            $totalCredits += $c['SoTinChi'];
        }
        ?>
        <table class="table table-bordered table-hover" style="max-width: 800px;">
            <thead class="table-dark">
                <tr>
                    <th>Mã ĐK</th>
                    <th>Ngày ĐK</th>
                    <th>Mã HP</th>
                    <th>Tên HP</th>
                    <th>Số tín chỉ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['MaDK']) ?></td>
                        <td><?= htmlspecialchars($c['NgayDK']) ?></td>
                        <td><?= htmlspecialchars($c['MaHP']) ?></td>
                        <td><?= htmlspecialchars($c['TenHP']) ?></td>
                        <td><?= htmlspecialchars($c['SoTinChi']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="MaHP" value="<?= htmlspecialchars($c['MaHP']) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hủy Đăng Ký</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Tổng số tín chỉ:</strong> <?= $totalCredits ?></p>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary">Quay lại</a>
</div>
<?php include 'footer.php'; ?>