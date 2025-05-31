CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email varchar(100) not null UNIQUE,
	fullname varchar(100) not null,
    birthday DATE not null,
    username varchar(50) not null UNIQUE,
    pwd varchar(255) not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
