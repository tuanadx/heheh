<?php
class Categories extends Controller {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = $this->model('Category');
    }

    public function index() {
        // Get categories
        $categories = $this->categoryModel->getCategories();

        $data = [
            'categories' => $categories
        ];

        $this->view('categories/index', $data);
    }

    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'description_err' => ''
            ];

            // Validate data
            if(empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập tên danh mục';
            }

            // Make sure no errors
            if(empty($data['name_err'])) {
                // Validated
                if($this->categoryModel->addCategory($data)) {
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Thêm danh mục thành công'
                    ];
                    header('Location: ' . URLROOT . '/categories');
                } else {
                    die('Đã xảy ra lỗi');
                }
            } else {
                // Load view with errors
                $this->view('categories/add', $data);
            }

        } else {
            $data = [
                'name' => '',
                'description' => '',
                'name_err' => '',
                'description_err' => ''
            ];
    
            $this->view('categories/add', $data);
        }
    }

    public function edit($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'description' => trim($_POST['description']),
                'name_err' => '',
                'description_err' => ''
            ];

            // Validate data
            if(empty($data['name'])) {
                $data['name_err'] = 'Vui lòng nhập tên danh mục';
            }

            // Make sure no errors
            if(empty($data['name_err'])) {
                // Validated
                if($this->categoryModel->updateCategory($data)) {
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Cập nhật danh mục thành công'
                    ];
                    header('Location: ' . URLROOT . '/categories');
                } else {
                    die('Đã xảy ra lỗi');
                }
            } else {
                // Load view with errors
                $this->view('categories/edit', $data);
            }

        } else {
            // Get existing category from model
            $category = $this->categoryModel->getCategoryById($id);

            $data = [
                'id' => $id,
                'name' => $category->name,
                'description' => $category->description,
                'name_err' => '',
                'description_err' => ''
            ];
    
            $this->view('categories/edit', $data);
        }
    }

    public function delete($id) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kiểm tra nếu danh mục đang được sử dụng
            if($this->categoryModel->isCategoryInUse($id)) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Không thể xóa danh mục này vì đang được sử dụng!'
                ];
                header('Location: ' . URLROOT . '/categories');
                return;
            }
            
            // Xóa danh mục
            if($this->categoryModel->deleteCategory($id)) {
                $_SESSION['flash'] = [
                    'type' => 'success', 
                    'message' => 'Xóa danh mục thành công!'
                ];
                header('Location: ' . URLROOT . '/categories');
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Có lỗi xảy ra khi xóa danh mục!'
                ];
                header('Location: ' . URLROOT . '/categories');
            }
        } else {
            header('Location: ' . URLROOT . '/categories');
        }
    }
} 