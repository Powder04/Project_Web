CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    fullname VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    birthday int,
    pwd VARCHAR(255) NOT NULL,
    total_bill INT DEFAULT 0,
    status TINYINT DEFAULT 1,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_price DECIMAL(15,0) DEFAULT 0,
    total_quantity INT,
    address VARCHAR(500) COLLATE utf8mb4_unicode_ci NOT NULL,
    payment_method ENUM(
        'Thanh toán khi nhận hàng',
        'Chuyển khoản qua ngân hàng',
        'Thanh toán qua Momo'
    ) NOT NULL DEFAULT 'Thanh toán khi nhận hàng',
    order_status ENUM(
        'Đang xử lý',
        'Thành công',
        'Hủy đơn'
    ) NOT NULL DEFAULT 'Đang xử lý',
    FOREIGN KEY (email) REFERENCES user(email)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE order_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id VARCHAR(100) NOT NULL,
    product_name VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(15,0),
    CONSTRAINT fk_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    category VARCHAR(100) COLLATE utf8mb4_unicode_ci,
    price DECIMAL(15,0) DEFAULT 0,
    quantity INT DEFAULT 0,
    sold_count INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id VARCHAR(100) NOT NULL,
    filename VARCHAR(200) NOT NULL,
    mime_type VARCHAR(50) NOT NULL,
    file_size INT NOT NULL,
    image_data MEDIUMBLOB NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Đang xử lý', 'Đã xử lý') DEFAULT 'Đang xử lý',
    FOREIGN KEY (email) REFERENCES user(email)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;