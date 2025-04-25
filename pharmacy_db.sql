-- Create database
CREATE DATABASE IF NOT EXISTS pharmacy_db;
USE pharmacy_db;

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Suppliers table
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Medicines table
CREATE TABLE IF NOT EXISTS medicines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category_id INT,
    supplier_id INT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    expiry_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- Sales table
CREATE TABLE IF NOT EXISTS sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medicine_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    customer_name VARCHAR(100),
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (medicine_id) REFERENCES medicines(id)
);

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
-- Sample categories
INSERT INTO categories (name, description) VALUES
('Antibiotics', 'Medications that kill or stop the growth of bacteria'),
('Analgesics', 'Pain relievers'),
('Antipyretics', 'Fever reducers'),
('Antihistamines', 'Allergy medications'),
('Vitamins', 'Nutritional supplements');

-- Sample suppliers
INSERT INTO suppliers (name, address, phone, email) VALUES
('MediPharm Suppliers', '123 Pharmacy St, Medical City', '555-123-4567', 'contact@medipharm.com'),
('HealthCare Distribution', '456 Health Ave, Wellness Town', '555-987-6543', 'info@healthcaredist.com'),
('Global Pharma Inc.', '789 Medical Blvd, Remedy City', '555-456-7890', 'sales@globalpharma.com');

-- Sample medicines
INSERT INTO medicines (name, description, category_id, supplier_id, price, quantity, expiry_date) VALUES
('Amoxicillin 500mg', 'Antibiotic used to treat bacterial infections', 1, 1, 15.99, 100, '2025-12-31'),
('Paracetamol 500mg', 'Pain reliever and fever reducer', 2, 2, 5.99, 200, '2026-06-30'),
('Loratadine 10mg', 'Antihistamine for allergy relief', 4, 3, 12.50, 75, '2025-10-15'),
('Vitamin C 1000mg', 'Immune system support', 5, 2, 8.75, 150, '2026-03-20'),
('Ibuprofen 400mg', 'Anti-inflammatory pain reliever', 2, 1, 7.25, 120, '2025-08-10'),
('Azithromycin 250mg', 'Antibiotic for respiratory infections', 1, 3, 18.50, 80, '2024-11-30'),
('Cetirizine 10mg', 'Antihistamine for allergy symptoms', 4, 2, 9.99, 8, '2025-05-15'),
('Vitamin D3 2000IU', 'Bone health supplement', 5, 1, 11.25, 5, '2026-01-25');

-- Sample sales
INSERT INTO sales (medicine_id, quantity, price, total_amount, customer_name, sale_date) VALUES
(2, 2, 5.99, 11.98, 'John Smith', '2023-10-15 09:30:00'),
(4, 1, 8.75, 8.75, 'Jane Doe', '2023-10-15 10:45:00'),
(1, 1, 15.99, 15.99, 'Robert Johnson', '2023-10-15 14:20:00'),
(5, 3, 7.25, 21.75, 'Emily Wilson', '2023-10-16 11:10:00'),
(3, 1, 12.50, 12.50, 'Michael Brown', '2023-10-16 15:35:00'),
(4, 2, 8.75, 17.50, 'Sarah Davis', '2023-10-17 09:15:00'),
(2, 5, 5.99, 29.95, 'David Miller', '2023-10-17 13:40:00'),
(6, 1, 18.50, 18.50, 'Lisa Anderson', '2023-10-18 10:25:00'),
(1, 2, 15.99, 31.98, 'James Wilson', '2023-10-18 14:50:00'),
(5, 2, 7.25, 14.50, 'Jennifer Taylor', '2023-10-19 11:30:00');

-- Sample user
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@pharmacy.com', '$2y$10$8zUlXAZwABwmHaBUg6K9LObjn4gG7EWm1zFbSqCQ1MjfX8Z.V3sMK', 'admin'); -- Password: admin123 