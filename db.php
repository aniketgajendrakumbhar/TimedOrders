<?php

// Connect to MySQL server
$conn = mysqli_connect("localhost", "root", "");

if (!$conn) {
    die("MySQL connection failed: " . mysqli_connect_error());
}

// Create database
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS timedorders");

// Select database
mysqli_select_db($conn, "timedorders");


// 1. CUSTOMERS TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mobile VARCHAR(15) NOT NULL
) ENGINE=InnoDB");


// 2. ORDERS TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    items TEXT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB");


// 3. RESTAURANTS TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS restaurants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    cuisine VARCHAR(80),
    rating DECIMAL(2,1) DEFAULT 0.0,
    delivery_time VARCHAR(30),
    image_url VARCHAR(500)
) ENGINE=InnoDB");


// 4. MENU ITEMS TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    name VARCHAR(120) NOT NULL,
    category VARCHAR(80),
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(500),
    is_available TINYINT(1) DEFAULT 1,

    FOREIGN KEY (restaurant_id)
    REFERENCES restaurants(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB");


// 5. CUSTOMER ADDRESSES TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS customer_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    address_line VARCHAR(255) NOT NULL,
    city VARCHAR(80) NOT NULL,
    state VARCHAR(80),
    pincode VARCHAR(10) NOT NULL,
    address_type VARCHAR(30) DEFAULT 'Home',

    FOREIGN KEY (customer_id)
    REFERENCES customers(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB");


// 6. ORDER ITEMS TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NULL,
    item_name VARCHAR(120) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (order_id)
    REFERENCES orders(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    FOREIGN KEY (menu_item_id)
    REFERENCES menu_items(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE

) ENGINE=InnoDB");


// 7. PAYMENTS TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(40) DEFAULT 'Cash on Delivery',
    payment_status VARCHAR(30) DEFAULT 'Pending',
    transaction_reference VARCHAR(100),
    payment_date DATETIME NULL,

    FOREIGN KEY (order_id)
    REFERENCES orders(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB");


// 8. REVIEWS TABLE
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    restaurant_id INT NOT NULL,
    rating TINYINT NOT NULL,
    comment TEXT,
    review_date DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (customer_id)
    REFERENCES customers(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    FOREIGN KEY (restaurant_id)
    REFERENCES restaurants(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE

) ENGINE=InnoDB");



?>
