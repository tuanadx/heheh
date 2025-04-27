<?php
// Script cập nhật dữ liệu từ edit_product.json vào cơ sở dữ liệu
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'core/APCuCache.php';

// Biến lưu trạng thái xử lý
$processed = false;
$startTime = 0;
$endTime = 0;
$successCount = 0;
$errorCount = 0;
$errors = [];
$cacheHit = false;

// Xử lý khi người dùng muốn xóa cache
if (isset($_POST['clear_cache'])) {
    APCuCache::clear();
    $cacheCleared = true;
}

// Xử lý khi form được gửi đi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $startTime = microtime(true);
    
    // Kiểm tra file JSON
    if (!file_exists('data/edit_product.json')) {
        $errors[] = "Không tìm thấy file data/edit_product.json";
    } else {
        // Đọc dữ liệu từ file
        $jsonData = file_get_contents('data/edit_product.json');
        $products = json_decode($jsonData, true);
        
        if (!$products || !is_array($products)) {
            $errors[] = "Dữ liệu JSON không hợp lệ hoặc rỗng";
        } else {
            // Kết nối đến cơ sở dữ liệu
            $db = new Database();
            
            // Bắt đầu transaction
            $db->query("START TRANSACTION");
            $db->execute();
            
            // Sử dụng APCuCache để lấy mapping sản phẩm
            $cacheKey = 'product_id_map';
            $productMap = APCuCache::get($cacheKey);
            
            if ($productMap !== null) {
                // Cache hit - sử dụng dữ liệu từ cache
                $cacheHit = true;
            } else {
                // Cache miss - lấy dữ liệu từ database
                $productMap = [];
                
                // Lấy tất cả sản phẩm từ cơ sở dữ liệu một lần duy nhất
                $db->query("SELECT id, name FROM medicines");
                $allProducts = $db->resultSet();
                
                // Tạo mapping tên sản phẩm -> ID, chuẩn hóa tên để dễ tìm kiếm
                foreach ($allProducts as $product) {
                    // Chuẩn hóa tên sản phẩm để làm khóa (bỏ khoảng trắng, chữ thường)
                    $normalizedName = trim(strtolower($product->name));
                    $productMap[$normalizedName] = $product->id;
                }
                
                // Lưu vào cache với thời gian 1 giờ
                APCuCache::set($cacheKey, $productMap, 3600);
            }
            
            // Xử lý từng sản phẩm
            foreach ($products as $product) {
                // Kiểm tra tên sản phẩm
                if (empty($product['name'])) {
                    $errors[] = "Có sản phẩm không có tên";
                    continue;
                }
                
                // Chuẩn hóa tên sản phẩm từ file JSON để tìm kiếm
                $searchName = trim(strtolower($product['name']));
                
                // Tìm sản phẩm bằng tên đã chuẩn hóa
                if (isset($productMap[$searchName])) {
                    $productId = $productMap[$searchName];
                    
                    // Tiến hành update với ID đã biết
                    $db->query("UPDATE medicines SET 
                               price = :price,
                               quantity = :quantity,
                               expiry_date = :expiry_date
                               WHERE id = :id");
                    
                    $db->bind(':price', $product['price']);
                    $db->bind(':quantity', $product['quantity']);
                    $db->bind(':expiry_date', $product['expiry_date']);
                    $db->bind(':id', $productId);
                    
                    if ($db->execute()) {
                        $successCount++;
                    } else {
                        $errorCount++;
                        $errors[] = "Lỗi khi cập nhật: " . $product['name'];
                    }
                } else {
                    $errors[] = "Không tìm thấy sản phẩm: " . $product['name'];
                    $errorCount++;
                }
            }
            
            // Commit hoặc rollback transaction
            if ($successCount > 0) {
                $db->query("COMMIT");
                $db->execute();
            } else {
                $db->query("ROLLBACK");
                $db->execute();
                $errors[] = "Không có sản phẩm nào được cập nhật thành công. Đã rollback.";
            }
        }
    }
    
    $endTime = microtime(true);
    $processed = true;
}

// Đọc dữ liệu xem trước từ file JSON
$previewData = [];
$fileExists = false;
$fileSize = 0;
$productCount = 0;

if (file_exists('data/edit_product.json')) {
    $fileExists = true;
    $fileSize = round(filesize('data/edit_product.json') / 1024, 2);
    $jsonData = file_get_contents('data/edit_product.json');
    $previewData = json_decode($jsonData, true);
    
    if ($previewData && is_array($previewData)) {
        $productCount = count($previewData);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Từ edit_product.json</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h4 mb-0">Cập Nhật Sản Phẩm Từ edit_product.json</h1>
                    </div>
                    <div class="card-body">
                        <?php   if (isset($cacheCleared)): ?>
                            <div class="alert alert-info mb-4">
                                <p class="mb-0">Đã xóa cache thành công!</p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($processed): ?>
                            <?php if (empty($errors)): ?>
                                <div class="alert alert-success mb-4">
                                    <h5 class="alert-heading">Cập nhật thành công!</h5>
                                    <p>Đã cập nhật <strong><?php echo $successCount; ?></strong> sản phẩm vào cơ sở dữ liệu.</p>
                                    <hr>
                                    <p>Thời gian thực hiện: <strong><?php echo number_format($endTime - $startTime, 4); ?> giây</strong></p>
                                    <p class="mb-0">Cache: <strong><?php echo $cacheHit ? 'Hit (sử dụng dữ liệu từ cache)' : 'Miss (tải từ cơ sở dữ liệu)'; ?></strong></p>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning mb-4">
                                    <h5 class="alert-heading">Cập nhật với cảnh báo!</h5>
                                    <p>Đã cập nhật <strong><?php echo $successCount; ?></strong> sản phẩm. Có <strong><?php echo $errorCount; ?></strong> lỗi.</p>
                                    <hr>
                                    <p>Thời gian thực hiện: <strong><?php echo number_format($endTime - $startTime, 4); ?> giây</strong></p>
                                    <p>Cache: <strong><?php echo $cacheHit ? 'Hit (sử dụng dữ liệu từ cache)' : 'Miss (tải từ cơ sở dữ liệu)'; ?></strong></p>
                                    
                                    <div class="mt-3">
                                        <p class="mb-2 fw-bold">Chi tiết lỗi:</p>
                                        <ul class="mb-0">
                                            <?php foreach ($errors as $error): ?>
                                                <li><?php echo $error; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php if (extension_loaded('apcu')): ?>
                            <div class="mb-3">
                                <form method="post" action="">
                                    <button type="submit" name="clear_cache" class="btn btn-warning mb-3">
                                        <i class="bi bi-trash"></i> Xóa cache
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($fileExists): ?>
                            <div class="alert alert-info mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-info-circle fs-4"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="alert-heading">Thông tin file edit_product.json</h5>
                                        <p class="mb-1">Kích thước: <strong><?php echo $fileSize; ?> KB</strong></p>
                                        <p class="mb-0">Số lượng sản phẩm: <strong><?php echo $productCount; ?></strong></p>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($productCount > 0): ?>
                                <h5 class="card-title mb-3">Xem trước dữ liệu:</h5>
                                <div class="table-responsive mb-4">
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
                                            $previewCount = min(5, $productCount);
                                            for ($i = 0; $i < $previewCount; $i++): 
                                            ?>
                                            <tr>
                                                <td><?php echo $previewData[$i]['name']; ?></td>
                                                <td class="text-end"><?php echo number_format($previewData[$i]['price']); ?> đ</td>
                                                <td class="text-end"><?php echo $previewData[$i]['quantity']; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($previewData[$i]['expiry_date'])); ?></td>
                                            </tr>
                                            <?php endfor; ?>
                                            
                                            <?php if ($productCount > 5): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted fst-italic">... còn <?php echo $productCount - 5; ?> sản phẩm khác</td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <form method="post" action="">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="confirm" name="confirm" required>
                                        <label class="form-check-label" for="confirm">
                                            Tôi đã kiểm tra và xác nhận cập nhật những thay đổi này vào cơ sở dữ liệu
                                        </label>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="submit" name="update" class="btn btn-primary">
                                            Cập nhật vào cơ sở dữ liệu
                                        </button>
                                        <a href="index.php" class="btn btn-outline-secondary">
                                            Về trang chủ
                                        </a>
                                    </div>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <p class="mb-0">File JSON không chứa dữ liệu sản phẩm hợp lệ.</p>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="create_edit_product_json.php" class="btn btn-primary">
                                        Tạo file edit_product.json mới
                                    </a>
                                    <a href="index.php" class="btn btn-outline-secondary">
                                        Về trang chủ
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning mb-4">
                                <h5 class="alert-heading">Không tìm thấy file!</h5>
                                <p class="mb-0">File <code>data/edit_product.json</code> không tồn tại. Vui lòng tạo file trước khi tiếp tục.</p>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <a href="create_edit_product_json.php" class="btn btn-primary">
                                    Tạo file edit_product.json
                                </a>
                                <a href="index.php" class="btn btn-outline-secondary">
                                    Về trang chủ
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>