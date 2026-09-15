CREATE DATABASE IF NOT EXISTS pcscms_db
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pcscms_db;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    role ENUM('admin','inventory_staff') NOT NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS employees (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    employee_no VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100) NULL,
    last_name VARCHAR(100) NOT NULL,
    department VARCHAR(150) NULL,
    position VARCHAR(150) NULL,
    contact_number VARCHAR(50) NULL,
    email VARCHAR(150) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS assets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    property_no VARCHAR(80) NOT NULL UNIQUE,
    item_name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    category VARCHAR(100) NULL,
    serial_no VARCHAR(100) NULL,
    acquisition_date DATE NULL,
    acquisition_cost DECIMAL(12,2) NULL,
    status ENUM('available','assigned','damaged','lost','disposed') NOT NULL DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS stock_cards (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    stock_card_no VARCHAR(80) NOT NULL UNIQUE,
    item_name VARCHAR(150) NOT NULL,
    unit VARCHAR(50) NULL,
    quantity INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mr_records (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mr_no VARCHAR(80) NOT NULL UNIQUE,
    employee_id INT UNSIGNED NOT NULL,
    asset_id INT UNSIGNED NULL,
    issue_date DATE NOT NULL,
    expiry_date DATE NOT NULL,
    status ENUM('active','expired','returned') NOT NULL DEFAULT 'active',
    remarks TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_mr_employee FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_mr_asset FOREIGN KEY (asset_id) REFERENCES assets(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Initial accounts are created safely by setup.php using password_hash().
-- Do not insert plaintext passwords here.
