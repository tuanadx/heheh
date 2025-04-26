<?php
// Tệp tạo dữ liệu JSON cho 1000 sản phẩm thuốc

// Kết nối đến cơ sở dữ liệu để lấy các category_id và supplier_id
require_once 'config/config.php';
require_once 'core/Database.php';

// Tạo đối tượng database để lấy dữ liệu thật
$db = new Database();

// Lấy danh sách category_id
$db->query("SELECT id FROM categories");
$categories = $db->resultSet();
$category_ids = [];
foreach ($categories as $category) {
    $category_ids[] = $category->id;
}

// Nếu không có category nào, thêm một giá trị mặc định
if (empty($category_ids)) {
    $category_ids = [1];
}

// Lấy danh sách supplier_id
$db->query("SELECT id FROM suppliers");
$suppliers = $db->resultSet();
$supplier_ids = [];
foreach ($suppliers as $supplier) {
    $supplier_ids[] = $supplier->id;
}

// Nếu không có supplier nào, thêm một giá trị mặc định
if (empty($supplier_ids)) {
    $supplier_ids = [1];
}

// Define common medicine prefixes and suffixes
$prefixes = [
    'Para', 'Aceta', 'Ibu', 'Amox', 'Cefi', 'Lora', 'Cipro', 'Metro', 
    'Diclo', 'Aspi', 'Simva', 'Ator', 'Clari', 'Azithro', 'Doxy', 
    'Ome', 'Raniti', 'Famo', 'Furo', 'Hydro', 'Levo', 'Cefa', 'Peni',
    'Tetra', 'Eritro', 'Neo', 'Tri', 'Keto', 'Pred', 'Dexa'
];

$suffixes = [
    'min', 'zole', 'profen', 'cillin', 'xime', 'tadine', 'floxacin',
    'nidazole', 'fenac', 'rin', 'statin', 'vastatin', 'thromycin',
    'mycin', 'cycline', 'prazole', 'dine', 'tidine', 'semide', 'thiacide',
    'cort', 'sone', 'zepam', 'lam', 'pril', 'sartan', 'olol', 'parine'
];

$formats = [
    'viên', 'ống', 'gói', 'chai', 'lọ', 'tuýp', 'vỉ', 'hộp', 'ampule', 'vial',
    'lọ nhỏ giọt', 'bình xịt', 'miếng dán', 'gói bột', 'túi truyền'
];

$strengths = [
    '100mg', '200mg', '250mg', '325mg', '400mg', '500mg', '650mg', '750mg', '1g',
    '5mg', '10mg', '15mg', '20mg', '25mg', '30mg', '40mg', '50mg', '75mg', '80mg',
    '100mcg', '200mcg', '500mcg', '1mg/ml', '2mg/ml', '5mg/ml', '10mg/ml',
    '20mg/2ml', '40mg/4ml', '80mg/8ml', '1%', '2%', '5%', '10%', '0.5%'
];

$doseForms = [
    'viên nén', 'viên nang', 'viên sủi', 'siro', 'thuốc tiêm', 'thuốc nhỏ mắt',
    'thuốc nhỏ mũi', 'thuốc xịt', 'kem bôi', 'gel', 'dung dịch', 'cốm', 'bột',
    'miếng dán', 'viên nén bao phim', 'viên nang mềm', 'viên sủi bọt', 'viên ngậm',
    'thuốc đạn', 'thuốc mỡ', 'thuốc nhỏ tai', 'thuốc truyền', 'hỗn dịch'
];

$descriptions = [
    "Điều trị các triệu chứng đau nhẹ đến vừa",
    "Điều trị nhiễm khuẩn đường hô hấp",
    "Điều trị các bệnh về đường tiêu hóa",
    "Điều trị viêm nhiễm và đau",
    "Thuốc kháng sinh phổ rộng",
    "Điều trị tăng huyết áp",
    "Điều trị các triệu chứng dị ứng",
    "Điều trị các rối loạn tiêu hóa",
    "Điều trị đau đầu và đau nửa đầu",
    "Điều trị các triệu chứng cảm lạnh và cúm",
    "Thuốc chống viêm không steroid",
    "Hỗ trợ điều trị các bệnh về tim mạch",
    "Hỗ trợ điều trị các bệnh về huyết áp",
    "Hỗ trợ điều trị các bệnh về tiểu đường",
    "Thuốc kháng sinh điều trị nhiễm trùng",
    "Thuốc chống nấm dùng cho da và niêm mạc",
    "Điều trị các rối loạn giấc ngủ",
    "Điều trị rối loạn lo âu và trầm cảm",
    "Thuốc giảm đau và hạ sốt",
    "Điều trị các bệnh về đường tiết niệu",
    "Thuốc bổ sung vitamin và khoáng chất",
    "Điều trị các bệnh về hô hấp",
    "Thuốc điều trị các bệnh về mắt",
    "Thuốc điều trị các bệnh về da"
];

// Tạo mảng để lưu trữ 1000 sản phẩm thuốc
$products = [];

// Tạo 1000 sản phẩm thuốc với thông tin ngẫu nhiên
for ($i = 1; $i <= 1000; $i++) {
    // Lấy ngẫu nhiên category_id và supplier_id
    $category_id = $category_ids[array_rand($category_ids)];
    $supplier_id = $supplier_ids[array_rand($supplier_ids)];
    
    // Tạo tên thuốc ngẫu nhiên
    $prefix = $prefixes[array_rand($prefixes)];
    $suffix = $suffixes[array_rand($suffixes)];
    $strength = $strengths[array_rand($strengths)];
    $format = $formats[array_rand($formats)];
    $doseForm = $doseForms[array_rand($doseForms)];
    
    // Tạo tên thuốc với các định dạng khác nhau
    $rand = rand(1, 5);
    switch ($rand) {
        case 1:
            $name = $prefix . $suffix . ' ' . $strength;
            break;
        case 2:
            $name = $prefix . $suffix . ' ' . $strength . ' ' . $format;
            break;
        case 3:
            $name = $prefix . $suffix . ' ' . $doseForm . ' ' . $strength;
            break;
        case 4:
            $name = $prefix . $suffix . ' ' . $doseForm;
            break;
        case 5:
            $name = $prefix . $suffix . ' ' . rand(25, 500) . 'mg';
            break;
    }
    
    // Tạo mô tả ngẫu nhiên
    $description = $descriptions[array_rand($descriptions)];
    
    // Tạo giá ngẫu nhiên từ 5,000đ đến 500,000đ, làm tròn đến 1,000đ
    $price = round(rand(5000, 500000) / 1000) * 1000;
    
    // Tạo số lượng ngẫu nhiên từ 10 đến 1000
    $quantity = rand(10, 1000);
    
    // Tạo ngày hết hạn ngẫu nhiên từ 1 đến 3 năm kể từ ngày hiện tại
    $expiry_date = date('Y-m-d', strtotime('+' . rand(12, 36) . ' months'));
    
    // Thêm sản phẩm vào mảng
    $products[] = [
        'name' => $name,
        'description' => $description,
        'category_id' => $category_id,
        'supplier_id' => $supplier_id,
        'price' => $price,
        'quantity' => $quantity,
        'expiry_date' => $expiry_date
    ];
}

// Chuyển đổi mảng thành chuỗi JSON
$json_data = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Lưu vào file product.json
file_put_contents('product.json', $json_data);

// Hiển thị thông báo
echo "Đã tạo thành công file product.json với 1000 sản phẩm thuốc!";
echo "<br>Kích thước file: " . round(filesize('product.json') / 1024, 2) . " KB";
echo "<br><a href='product.json' download>Tải xuống file product.json</a>";

// Hiển thị ví dụ 5 sản phẩm đầu tiên
echo "<h3>Ví dụ 5 sản phẩm đầu tiên:</h3>";
echo "<pre>";
echo json_encode(array_slice($products, 0, 5), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "</pre>";
?> 