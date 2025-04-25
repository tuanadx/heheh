<?php
class Supplier {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Lấy tất cả nhà cung cấp
    public function getSuppliers() {
        $this->db->query("SELECT * FROM suppliers ORDER BY name ASC");
        return $this->db->resultSet();
    }

    // Lấy nhà cung cấp theo ID
    public function getSupplierById($id) {
        $this->db->query("SELECT * FROM suppliers WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Thêm nhà cung cấp mới
    public function addSupplier($data) {
        $this->db->query("INSERT INTO suppliers (name, address, phone, email) VALUES (:name, :address, :phone, :email)");
        
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':email', $data['email']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Cập nhật nhà cung cấp
    public function updateSupplier($data) {
        $this->db->query("UPDATE suppliers SET name = :name, address = :address, phone = :phone, email = :email WHERE id = :id");
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':email', $data['email']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Kiểm tra xem nhà cung cấp có đang được sử dụng
    public function isSupplierInUse($id) {
        $this->db->query("SELECT COUNT(*) as count FROM medicines WHERE supplier_id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        
        return $row->count > 0;
    }

    // Xóa nhà cung cấp
    public function deleteSupplier($id) {
        $this->db->query("DELETE FROM suppliers WHERE id = :id");
        
        // Bind values
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Lấy tổng số nhà cung cấp
    public function getTotalSuppliers() {
        $this->db->query("SELECT COUNT(*) as total FROM suppliers");
        $result = $this->db->single();
        return $result->total;
    }
} 