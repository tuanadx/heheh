<?php
class Medicine {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get all medicines with category and supplier names
    public function getMedicines() {
        $this->db->query("SELECT m.*, c.name as category_name, s.name as supplier_name 
                         FROM medicines m 
                         JOIN categories c ON m.category_id = c.id 
                         JOIN suppliers s ON m.supplier_id = s.id 
                         ORDER BY m.name ASC");
        
        return $this->db->resultSet();
    }

    // Get medicine by ID
    public function getMedicineById($id) {
        $this->db->query("SELECT * FROM medicines WHERE id = :id");
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }

    // Add medicine
    public function addMedicine($data) {
        $this->db->query("INSERT INTO medicines (name, description, category_id, supplier_id, price, quantity, expiry_date) 
                         VALUES (:name, :description, :category_id, :supplier_id, :price, :quantity, :expiry_date)");
        
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':supplier_id', $data['supplier_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Update medicine
    public function updateMedicine($data) {
        $this->db->query("UPDATE medicines SET 
                         name = :name, 
                         description = :description, 
                         category_id = :category_id, 
                         supplier_id = :supplier_id, 
                         price = :price, 
                         quantity = :quantity, 
                         expiry_date = :expiry_date 
                         WHERE id = :id");
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':supplier_id', $data['supplier_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete medicine
    public function deleteMedicine($id) {
        // Bắt đầu transaction
        $this->db->query("START TRANSACTION");
        $this->db->execute();
        
        // Xóa các bản ghi liên quan trong bảng sales trước
        $this->db->query("DELETE FROM sales WHERE medicine_id = :id");
        $this->db->bind(':id', $id);
        $salesDeleted = $this->db->execute();
        
        // Xóa thuốc
        $this->db->query("DELETE FROM medicines WHERE id = :id");
        $this->db->bind(':id', $id);
        $medicineDeleted = $this->db->execute();
        
        // Commit hoặc rollback transaction
        if($salesDeleted && $medicineDeleted) {
            $this->db->query("COMMIT");
            $this->db->execute();
            return true;
        } else {
            $this->db->query("ROLLBACK");
            $this->db->execute();
            return false;
        }
    }

    // Get total number of medicines
    public function getTotalMedicines() {
        $this->db->query("SELECT COUNT(*) as total FROM medicines");
        
        $result = $this->db->single();
        return $result->total;
    }

    // Get low stock medicines (quantity < 10)
    public function getLowStockMedicines() {
        $this->db->query("SELECT m.*, c.name as category_name
                         FROM medicines m
                         JOIN categories c ON m.category_id = c.id
                         WHERE m.quantity < 10
                         ORDER BY m.quantity ASC");
        
        return $this->db->resultSet();
    }
} 