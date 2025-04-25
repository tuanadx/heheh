<?php
class Suppliers extends Controller {
    private $supplierModel;

    public function __construct() {
        $this->supplierModel = $this->model('Supplier');
    }

    public function index() {
        // Lấy tất cả nhà cung cấp
        $suppliers = $this->supplierModel->getSuppliers();

        $data = [
            'suppliers' => $suppliers
        ];

        $this->view('suppliers/index', $data);
    }

    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý dữ liệu form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'address' => trim($_POST['address']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'name_err' => '',
                'address_err' => '',
                'phone_err' => '',
                'email_err' => ''
            ];

            // Kiểm tra dữ liệu
            if(empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập tên nhà cung cấp';
            }

            if(empty($data['phone'])) {
                $data['phone_err'] = 'Vui lòng nhập số điện thoại';
            }

            if(!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Email không hợp lệ';
            }

            // Kiểm tra lỗi
            if(empty($data['name_err']) && empty($data['phone_err']) && empty($data['email_err'])) {
                // Thêm nhà cung cấp
                if($this->supplierModel->addSupplier($data)) {
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Thêm nhà cung cấp thành công!'
                    ];
                    header('Location: ' . URLROOT . '/suppliers');
                } else {
                    die('Đã xảy ra lỗi');
                }
            } else {
                // Hiển thị form với lỗi
                $this->view('suppliers/add', $data);
            }
        } else {
            $data = [
                'name' => '',
                'address' => '',
                'phone' => '',
                'email' => '',
                'name_err' => '',
                'address_err' => '',
                'phone_err' => '',
                'email_err' => ''
            ];

            $this->view('suppliers/add', $data);
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý dữ liệu form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'address' => trim($_POST['address']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'name_err' => '',
                'address_err' => '',
                'phone_err' => '',
                'email_err' => ''
            ];

            // Kiểm tra dữ liệu
            if(empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập tên nhà cung cấp';
            }

            if(empty($data['phone'])) {
                $data['phone_err'] = 'Vui lòng nhập số điện thoại';
            }

            if(!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Email không hợp lệ';
            }

            // Kiểm tra lỗi
            if(empty($data['name_err']) && empty($data['phone_err']) && empty($data['email_err'])) {
                // Cập nhật nhà cung cấp
                if($this->supplierModel->updateSupplier($data)) {
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Cập nhật nhà cung cấp thành công!'
                    ];
                    header('Location: ' . URLROOT . '/suppliers');
                } else {
                    die('Đã xảy ra lỗi');
                }
            } else {
                // Hiển thị form với lỗi
                $this->view('suppliers/edit', $data);
            }
        } else {
            // Lấy thông tin nhà cung cấp
            $supplier = $this->supplierModel->getSupplierById($id);

            // Kiểm tra nhà cung cấp tồn tại
            if(!$supplier) {
                header('Location: ' . URLROOT . '/suppliers');
            }

            $data = [
                'id' => $id,
                'name' => $supplier->name,
                'address' => $supplier->address,
                'phone' => $supplier->phone,
                'email' => $supplier->email,
                'name_err' => '',
                'address_err' => '',
                'phone_err' => '',
                'email_err' => ''
            ];

            $this->view('suppliers/edit', $data);
        }
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kiểm tra nếu nhà cung cấp đang được sử dụng
            if($this->supplierModel->isSupplierInUse($id)) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Không thể xóa nhà cung cấp này vì đang được sử dụng!'
                ];
                header('Location: ' . URLROOT . '/suppliers');
                return;
            }
            
            // Xóa nhà cung cấp
            if($this->supplierModel->deleteSupplier($id)) {
                $_SESSION['flash'] = [
                    'type' => 'success', 
                    'message' => 'Xóa nhà cung cấp thành công!'
                ];
                header('Location: ' . URLROOT . '/suppliers');
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Có lỗi xảy ra khi xóa nhà cung cấp!'
                ];
                header('Location: ' . URLROOT . '/suppliers');
            }
        } else {
            header('Location: ' . URLROOT . '/suppliers');
        }
    }
} 