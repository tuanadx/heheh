<?php
class Category {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Lấy tất cả danh mục
    public function getCategories() {
        $this->db->query("SELECT * FROM categories ORDER BY name ASC");
        return $this->db->resultSet();
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id) {
        $this->db->query("SELECT * FROM categories WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Thêm danh mục mới
    public function addCategory($data) {
        $this->db->query("INSERT INTO categories (name, description) VALUES (:name, :description)");
        
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Cập nhật danh mục
    public function updateCategory($data) {
        $this->db->query("UPDATE categories SET name = :name, description = :description WHERE id = :id");
        
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Kiểm tra xem danh mục có đang được sử dụng
    public function isCategoryInUse($id) {
        $this->db->query("SELECT COUNT(*) as count FROM medicines WHERE category_id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        
        return $row->count > 0;
    }

    // Xóa danh mục
    public function deleteCategory($id) {
        $this->db->query("DELETE FROM categories WHERE id = :id");
        
        // Bind values
        $this->db->bind(':id', $id);
        
        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Lấy tổng số danh mục
    public function getTotalCategories() {
        $this->db->query("SELECT COUNT(*) as total FROM categories");
        $result = $this->db->single();
        return $result->total;
    }
} 