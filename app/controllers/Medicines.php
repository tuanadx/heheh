<?php
class Medicines extends Controller {
    private $medicineModel;
    private $categoryModel;
    private $supplierModel;

    public function __construct() {
        $this->medicineModel = $this->model('Medicine');
        $this->categoryModel = $this->model('Category');
        $this->supplierModel = $this->model('Supplier');
    }

    public function index() {
        // Get all medicines
        $medicines = $this->medicineModel->getMedicines();
        
        $data = [
            'medicines' => $medicines
        ];

        $this->view('medicines/index', $data);
    }

    public function add() {
        // Get categories and suppliers for dropdown
        $categories = $this->categoryModel->getCategories();
        $suppliers = $this->supplierModel->getSuppliers();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'category_id' => $_POST['category_id'],
                'supplier_id' => $_POST['supplier_id'],
                'price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity']),
                'expiry_date' => trim($_POST['expiry_date']),
                'categories' => $categories,
                'suppliers' => $suppliers,
                'name_err' => '',
                'description_err' => '',
                'category_id_err' => '',
                'supplier_id_err' => '',
                'price_err' => '',
                'quantity_err' => '',
                'expiry_date_err' => ''
            ];

            // Validate inputs
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter medicine name';
            }

            if(empty($data['category_id'])) {
                $data['category_id_err'] = 'Please select a category';
            }

            if(empty($data['supplier_id'])) {
                $data['supplier_id_err'] = 'Please select a supplier';
            }

            if(empty($data['price'])) {
                $data['price_err'] = 'Please enter price';
            } elseif(!is_numeric($data['price']) || $data['price'] <= 0) {
                $data['price_err'] = 'Please enter a valid price';
            }

            if(empty($data['quantity'])) {
                $data['quantity_err'] = 'Please enter quantity';
            } elseif(!is_numeric($data['quantity']) || $data['quantity'] < 0) {
                $data['quantity_err'] = 'Please enter a valid quantity';
            }

            if(empty($data['expiry_date'])) {
                $data['expiry_date_err'] = 'Please enter expiry date';
            }

            // Check if all errors are empty
            if(empty($data['name_err']) && empty($data['category_id_err']) && 
               empty($data['supplier_id_err']) && empty($data['price_err']) && 
               empty($data['quantity_err']) && empty($data['expiry_date_err'])) {
                // Add medicine
                if($this->medicineModel->addMedicine($data)) {
                    // Set flash message
                    // Redirect to medicines page
                    header('Location: ' . URLROOT . '/medicines');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('medicines/add', $data);
            }
        } else {
            $data = [
                'name' => '',
                'description' => '',
                'category_id' => '',
                'supplier_id' => '',
                'price' => '',
                'quantity' => '',
                'expiry_date' => '',
                'categories' => $categories,
                'suppliers' => $suppliers,
                'name_err' => '',
                'description_err' => '',
                'category_id_err' => '',
                'supplier_id_err' => '',
                'price_err' => '',
                'quantity_err' => '',
                'expiry_date_err' => ''
            ];

            $this->view('medicines/add', $data);
        }
    }

    public function edit($id) {
        // Get categories and suppliers for dropdown
        $categories = $this->categoryModel->getCategories();
        $suppliers = $this->supplierModel->getSuppliers();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'category_id' => $_POST['category_id'],
                'supplier_id' => $_POST['supplier_id'],
                'price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity']),
                'expiry_date' => trim($_POST['expiry_date']),
                'categories' => $categories,
                'suppliers' => $suppliers,
                'name_err' => '',
                'description_err' => '',
                'category_id_err' => '',
                'supplier_id_err' => '',
                'price_err' => '',
                'quantity_err' => '',
                'expiry_date_err' => ''
            ];

            // Validate inputs
            if(empty($data['name'])) {
                $data['name_err'] = 'Please enter medicine name';
            }

            if(empty($data['category_id'])) {
                $data['category_id_err'] = 'Please select a category';
            }

            if(empty($data['supplier_id'])) {
                $data['supplier_id_err'] = 'Please select a supplier';
            }

            if(empty($data['price'])) {
                $data['price_err'] = 'Please enter price';
            } elseif(!is_numeric($data['price']) || $data['price'] <= 0) {
                $data['price_err'] = 'Please enter a valid price';
            }

            if(empty($data['quantity'])) {
                $data['quantity_err'] = 'Please enter quantity';
            } elseif(!is_numeric($data['quantity']) || $data['quantity'] < 0) {
                $data['quantity_err'] = 'Please enter a valid quantity';
            }

            if(empty($data['expiry_date'])) {
                $data['expiry_date_err'] = 'Please enter expiry date';
            }

            // Check if all errors are empty
            if(empty($data['name_err']) && empty($data['category_id_err']) && 
               empty($data['supplier_id_err']) && empty($data['price_err']) && 
               empty($data['quantity_err']) && empty($data['expiry_date_err'])) {
                // Update medicine
                if($this->medicineModel->updateMedicine($data)) {
                    // Set flash message
                    // Redirect to medicines page
                    header('Location: ' . URLROOT . '/medicines');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('medicines/edit', $data);
            }
        } else {
            // Get medicine by ID
            $medicine = $this->medicineModel->getMedicineById($id);

            // Check if medicine exists
            if(!$medicine) {
                // Redirect to medicines page
                header('Location: ' . URLROOT . '/medicines');
            }

            $data = [
                'id' => $id,
                'name' => $medicine->name,
                'description' => $medicine->description,
                'category_id' => $medicine->category_id,
                'supplier_id' => $medicine->supplier_id,
                'price' => $medicine->price,
                'quantity' => $medicine->quantity,
                'expiry_date' => $medicine->expiry_date,
                'categories' => $categories,
                'suppliers' => $suppliers,
                'name_err' => '',
                'description_err' => '',
                'category_id_err' => '',
                'supplier_id_err' => '',
                'price_err' => '',
                'quantity_err' => '',
                'expiry_date_err' => ''
            ];

            $this->view('medicines/edit', $data);
        }
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete medicine
            if($this->medicineModel->deleteMedicine($id)) {
                // Set flash message
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Xóa thuốc thành công!'
                ];
                // Redirect to medicines page
                header('Location: ' . URLROOT . '/medicines');
            } else {
                // Set flash message
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Có lỗi xảy ra khi xóa thuốc!'
                ];
                // Redirect to medicines page
                header('Location: ' . URLROOT . '/medicines');
            }
        } else {
            // Redirect to medicines page
            header('Location: ' . URLROOT . '/medicines');
        }
    }
} 