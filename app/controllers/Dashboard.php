<?php
class Dashboard extends Controller {
    private $medicineModel;
    private $categoryModel;
    private $supplierModel;
    private $salesModel;

    public function __construct() {
        $this->medicineModel = $this->model('Medicine');
        $this->categoryModel = $this->model('Category');
        $this->supplierModel = $this->model('Supplier');
        $this->salesModel = $this->model('Sales');
    }

    public function index() {
        // Get dashboard statistics
        $totalMedicines = $this->medicineModel->getTotalMedicines();
        $totalCategories = $this->categoryModel->getTotalCategories();
        $totalSuppliers = $this->supplierModel->getTotalSuppliers();
        $monthlySales = $this->salesModel->getMonthlySales();
        $lowStockMedicines = $this->medicineModel->getLowStockMedicines();
        $recentSales = $this->salesModel->getRecentSales();

        $data = [
            'totalMedicines' => $totalMedicines,
            'totalCategories' => $totalCategories,
            'totalSuppliers' => $totalSuppliers,
            'monthlySales' => $monthlySales,
            'lowStockMedicines' => $lowStockMedicines,
            'recentSales' => $recentSales
        ];

        $this->view('dashboard/index', $data);
    }
} 