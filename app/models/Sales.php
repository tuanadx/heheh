<?php
class Sales {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get all sales
    public function getSales() {
        $this->db->query("SELECT s.*, m.name as medicine_name 
                         FROM sales s 
                         JOIN medicines m ON s.medicine_id = m.id 
                         ORDER BY s.sale_date DESC");
        
        return $this->db->resultSet();
    }

    // Get sale by ID
    public function getSaleById($id) {
        $this->db->query("SELECT * FROM sales WHERE id = :id");
        $this->db->bind(':id', $id);
        
        return $this->db->single();
    }

    // Add sale
    public function addSale($data) {
        // Start transaction
        $this->db->query("START TRANSACTION");
        $this->db->execute();

        // Add sale
        $this->db->query("INSERT INTO sales (medicine_id, quantity, price, total_amount, customer_name, sale_date) 
                         VALUES (:medicine_id, :quantity, :price, :total_amount, :customer_name, :sale_date)");
        
        // Bind values
        $this->db->bind(':medicine_id', $data['medicine_id']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':total_amount', $data['total_amount']);
        $this->db->bind(':customer_name', $data['customer_name']);
        $this->db->bind(':sale_date', $data['sale_date']);
        
        // Execute sale insert
        $saleAdded = $this->db->execute();

        // Update medicine quantity
        $this->db->query("UPDATE medicines SET quantity = quantity - :sold_quantity WHERE id = :medicine_id");
        $this->db->bind(':medicine_id', $data['medicine_id']);
        $this->db->bind(':sold_quantity', $data['quantity']);
        
        // Execute medicine update
        $medicineUpdated = $this->db->execute();

        // Commit or rollback transaction
        if($saleAdded && $medicineUpdated) {
            $this->db->query("COMMIT");
            $this->db->execute();
            return true;
        } else {
            $this->db->query("ROLLBACK");
            $this->db->execute();
            return false;
        }
    }

    // Delete sale
    public function deleteSale($id) {
        // Get sale information first
        $this->db->query("SELECT * FROM sales WHERE id = :id");
        $this->db->bind(':id', $id);
        $sale = $this->db->single();

        if(!$sale) {
            return false;
        }

        // Start transaction
        $this->db->query("START TRANSACTION");
        $this->db->execute();

        // Delete sale
        $this->db->query("DELETE FROM sales WHERE id = :id");
        $this->db->bind(':id', $id);
        $saleDeleted = $this->db->execute();

        // Update medicine quantity
        $this->db->query("UPDATE medicines SET quantity = quantity + :sold_quantity WHERE id = :medicine_id");
        $this->db->bind(':medicine_id', $sale->medicine_id);
        $this->db->bind(':sold_quantity', $sale->quantity);
        $medicineUpdated = $this->db->execute();

        // Commit or rollback transaction
        if($saleDeleted && $medicineUpdated) {
            $this->db->query("COMMIT");
            $this->db->execute();
            return true;
        } else {
            $this->db->query("ROLLBACK");
            $this->db->execute();
            return false;
        }
    }

    // Get monthly sales for current year
    public function getMonthlySales() {
        $this->db->query("SELECT MONTH(sale_date) as month, SUM(total_amount) as total 
                         FROM sales 
                         WHERE YEAR(sale_date) = YEAR(CURDATE()) 
                         GROUP BY MONTH(sale_date) 
                         ORDER BY MONTH(sale_date)");
        
        return $this->db->resultSet();
    }

    // Get recent sales
    public function getRecentSales($limit = 5) {
        $this->db->query("SELECT s.*, m.name as medicine_name 
                         FROM sales s 
                         JOIN medicines m ON s.medicine_id = m.id 
                         ORDER BY s.sale_date DESC 
                         LIMIT :limit");
        
        $this->db->bind(':limit', $limit);
        
        return $this->db->resultSet();
    }

    // Get total sales amount
    public function getTotalSalesAmount() {
        $this->db->query("SELECT SUM(total_amount) as total FROM sales");
        
        $result = $this->db->single();
        return $result->total;
    }

    // Get today's sales
    public function getTodaySales() {
        $this->db->query("SELECT COUNT(*) as count, SUM(total_amount) as total 
                         FROM sales 
                         WHERE DATE(sale_date) = CURDATE()");
        
        return $this->db->single();
    }
} 