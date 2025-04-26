<?php
// Tệp nhập dữ liệu từ product.json vào cơ sở dữ liệu

// Kết nối đến cơ sở dữ liệu
require_once 'config/config.php';
require_once 'core/Database.php';

// Kiểm tra nếu dữ liệu được gửi từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tạo đối tượng database
    $db = new Database();
    
    // Kiểm tra xem file product.json tồn tại không
    if (!file_exists('product.json')) {
        die("Lỗi: File product.json không tồn tại! Vui lòng chạy create_json.php trước.");
    }
    
    // Đọc file JSON
    $json_data = file_get_contents('product.json');
    $products = json_decode($json_data, true);
    
    if (!$products || !is_array($products)) {
        die("Lỗi: File product.json không hợp lệ!");
    }
    
    // Bắt đầu transaction
    $db->query("START TRANSACTION");
    $db->execute();
    
    $success_count = 0;
    $error_count = 0;
    
    // Lưu trữ các queries cho bulk insert
    $values = [];
    $params = [];
    $index = 0;
    $batch_size = 100; // Số lượng bản ghi mỗi batch
    
    // Chuẩn bị query cơ bản
    $base_query = "INSERT INTO medicines (name, description, category_id, supplier_id, price, quantity, expiry_date) VALUES ";
    
    // Lặp qua từng sản phẩm
    foreach ($products as $product) {
        // Kiểm tra các trường bắt buộc
        if (empty($product['name']) || 
            empty($product['category_id']) || 
            empty($product['supplier_id']) || 
            !isset($product['price']) || 
            !isset($product['quantity']) || 
            empty($product['expiry_date'])) {
            $error_count++;
            continue;
        }
        
        // Tạo tham số cho prepared statement
        $name_param = ":name" . $index;
        $desc_param = ":desc" . $index;
        $cat_param = ":cat" . $index;
        $sup_param = ":sup" . $index;
        $price_param = ":price" . $index;
        $qty_param = ":qty" . $index;
        $date_param = ":date" . $index;
        
        // Thêm giá trị vào values
        $values[] = "($name_param, $desc_param, $cat_param, $sup_param, $price_param, $qty_param, $date_param)";
        
        // Thêm tham số vào params
        $params[$name_param] = $product['name'];
        $params[$desc_param] = $product['description'] ?? '';
        $params[$cat_param] = $product['category_id'];
        $params[$sup_param] = $product['supplier_id'];
        $params[$price_param] = $product['price'];
        $params[$qty_param] = $product['quantity'];
        $params[$date_param] = $product['expiry_date'];
        
        $index++;
        
        // Thực hiện insert khi đạt đến batch_size hoặc đến phần tử cuối cùng
        if (count($values) >= $batch_size || $index === count($products)) {
            if (!empty($values)) {
                // Tạo query cho batch hiện tại
                $query = $base_query . implode(", ", $values);
                $db->query($query);
                
                // Bind các tham số
                foreach ($params as $param => $value) {
                    $db->bind($param, $value);
                }
                
                // Thực hiện query
                if ($db->execute()) {
                    $success_count += count($values);
                } else {
                    $error_count += count($values);
                }
                
                // Reset các mảng
                $values = [];
                $params = [];
            }
        }
    }
    
    // Commit hoặc rollback transaction
    if ($success_count > 0) {
        $db->query("COMMIT");
        $db->execute();
        $message = "Đã nhập thành công $success_count sản phẩm vào cơ sở dữ liệu. $error_count sản phẩm không thể nhập.";
        $success = true;
    } else {
        $db->query("ROLLBACK");
        $db->execute();
        $message = "Không có sản phẩm nào được nhập thành công. Vui lòng kiểm tra lại dữ liệu.";
        $success = false;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập Dữ Liệu Từ JSON</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h4 mb-0">Nhập Dữ Liệu Từ product.json</h1>
                    </div>
                    <div class="card-body">
                        <?php if (isset($message)): ?>
                            <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?>">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <p>Công cụ này sẽ nhập 1000 sản phẩm thuốc từ file <code>product.json</code> vào cơ sở dữ liệu.</p>
                        
                        <?php if (file_exists('product.json')): ?>
                            <div class="alert alert-info">
                                <p>Đã tìm thấy file product.json!</p>
                                <p>Kích thước: <?php echo round(filesize('product.json') / 1024, 2); ?> KB</p>
                                <p>Thời gian tạo: <?php echo date("d/m/Y H:i:s", filemtime('product.json')); ?></p>
                                <p>Số lượng sản phẩm: <?php echo count(json_decode(file_get_contents('product.json'), true)); ?></p>
                            </div>
                            
                            <form method="post" action="">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirm" name="confirm" required>
                                        <label class="form-check-label" for="confirm">
                                            Tôi đã kiểm tra và muốn nhập dữ liệu vào cơ sở dữ liệu
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-database-add"></i> Nhập Dữ Liệu
                                    </button>
                                    <a href="create_json.php" class="btn btn-secondary">
                                        <i class="bi bi-arrow-repeat"></i> Tạo Lại File JSON
                                    </a>
                                    <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; ?>" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left"></i> Quay Lại
                                    </a>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <p>Không tìm thấy file product.json!</p>
                                <p>Vui lòng tạo file trước bằng cách chạy <a href="create_json.php">create_json.php</a></p>
                            </div>
                            
                            <a href="create_json.php" class="btn btn-primary">
                                <i class="bi bi-file-earmark-plus"></i> Tạo File product.json
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 