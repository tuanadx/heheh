<?php
// Script tạo file edit_product.json từ database
require_once 'config/config.php';
require_once 'core/Database.php';

// Tạo thư mục data nếu chưa tồn tại
if (!file_exists('data')) {
    mkdir('data', 0777, true);
}

// Tạo đối tượng database
$db = new Database();

// Lấy danh sách sản phẩm từ database
$db->query("SELECT * FROM medicines ORDER BY id");
$medicines = $db->resultSet();

// Mảng chứa dữ liệu sản phẩm để xuất ra JSON
$products = [];

// Xử lý từng sản phẩm và cập nhật giá trị mới
foreach ($medicines as $medicine) {
    // Thay đổi giá (tăng lên từ 10-20%)
    $newPrice = round($medicine->price * (1 + (rand(10, 20) / 100)));
    
    // Thay đổi số lượng (thêm từ 10-50 đơn vị)
    $newQuantity = $medicine->quantity + rand(10, 50);
    
    // Thay đổi ngày hết hạn (thêm từ 6-12 tháng)
    $expiryDate = new DateTime($medicine->expiry_date);
    $expiryDate->modify('+' . rand(6, 12) . ' months');
    $newExpiryDate = $expiryDate->format('Y-m-d');
    
    // Thêm sản phẩm vào mảng
    $products[] = [
        'name' => $medicine->name,
        'description' => $medicine->description,
        'category_id' => $medicine->category_id,
        'supplier_id' => $medicine->supplier_id,
        'price' => $newPrice,
        'quantity' => $newQuantity,
        'expiry_date' => $newExpiryDate
    ];
}

// Chuyển đổi mảng thành JSON
$jsonData = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Lưu vào file
file_put_contents('data/edit_product.json', $jsonData);

// Hiển thị thông báo
$fileSize = round(filesize('data/edit_product.json') / 1024, 2);
$productCount = count($products);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo File edit_product.json</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h1 class="h4 mb-0">Tạo File edit_product.json (5000 sản phẩm)</h1>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success mb-4">
                            <h5 class="alert-heading">Thành công!</h5>
                            <p>Đã tạo file <code>data/edit_product.json</code> với dữ liệu đã được cập nhật.</p>
                            <hr>
                            <p class="mb-0">Kích thước file: <strong><?php echo $fileSize; ?> KB</strong></p>
                            <p class="mb-0">Số lượng sản phẩm: <strong><?php echo $productCount; ?></strong></p>
                        </div>
                        
                        <h5 class="card-title">Xem trước dữ liệu:</h5>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th class="text-end">Giá</th>
                                        <th class="text-end">Số lượng</th>
                                        <th>Ngày hết hạn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Hiển thị 5 sản phẩm đầu tiên
                                    $previewCount = min(5, count($products));
                                    for ($i = 0; $i < $previewCount; $i++): 
                                    ?>
                                    <tr>
                                        <td><?php echo $products[$i]['name']; ?></td>
                                        <td class="text-end"><?php echo number_format($products[$i]['price']); ?> đ</td>
                                        <td class="text-end"><?php echo $products[$i]['quantity']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($products[$i]['expiry_date'])); ?></td>
                                    </tr>
                                    <?php endfor; ?>
                                    
                                    <?php if (count($products) > 5): ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted fst-italic">... còn <?php echo count($products) - 5; ?> sản phẩm khác</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <a href="index.php" class="btn btn-primary">Về trang chủ</a>
                            <a href="data/edit_product.json" class="btn btn-success ms-2" download>Tải file JSON</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 