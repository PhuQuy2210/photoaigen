CREATE DATABASE news_image_app;
USE news_image_app;



-- Bảng roles: Vai trò người dùng
CREATE TABLE roles (
    id INT PRIMARY KEY,
    name VARCHAR(20) NOT NULL
);

-- Bảng users: Thông tin người dùng
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(100) DEFAULT '',
    phone_number VARCHAR(10) NOT NULL,
    address VARCHAR(200) DEFAULT '',
    password VARCHAR(100) NOT NULL DEFAULT '',
    is_active TINYINT(1) DEFAULT 1,
    date_of_birth DATE,
    facebook_account_id INT DEFAULT 0,
    google_account_id INT DEFAULT 0,
    role_id INT,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);



-- Bảng tokens: Token xác thực người dùng
CREATE TABLE tokens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    token VARCHAR(255) UNIQUE NOT NULL,
    token_type VARCHAR(50) NOT NULL,
    expiration_date DATETIME,
    revoked TINYINT(1) NOT NULL,
    expired TINYINT(1) NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Bảng social_accounts: Liên kết tài khoản mạng xã hội
CREATE TABLE social_accounts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    provider VARCHAR(20) NOT NULL COMMENT 'Tên nhà social network',
    provider_id VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL COMMENT 'Email tài khoản',
    name VARCHAR(100) NOT NULL COMMENT 'Tên người dùng',
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Bảng danhmucanh: Danh mục cho hình ảnh
CREATE TABLE danhmucanh (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL COMMENT 'Tên danh mục cho hình ảnh'
);

-- Bảng danhmuctin: Danh mục cho tin tức
CREATE TABLE danhmuctin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL COMMENT 'Tên danh mục cho tin tức'
);

-- Bảng hinhanh: Lưu trữ thông tin hình ảnh
CREATE TABLE hinhanh (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL COMMENT 'Tiêu đề hình ảnh',
    url VARCHAR(300) NOT NULL COMMENT 'URL của hình ảnh',
    description TEXT COMMENT 'Mô tả hình ảnh',
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày đăng tải',
    luotxem INT,
    category_id INT,
    like_count INT DEFAULT 0 COMMENT 'Số lượt thích của hình ảnh',
    FOREIGN KEY (category_id) REFERENCES danhmucanh(id)
);

-- Bảng tintuc: Lưu trữ thông tin tin tức
CREATE TABLE tintuc (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL COMMENT 'Tiêu đề tin tức',
    content TEXT NOT NULL COMMENT 'Nội dung tin tức',
    published_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày xuất bản',
    author_id INT,
    luotxem INT,
    category_id INT,
    FOREIGN KEY (author_id) REFERENCES users(id),
    FOREIGN KEY (category_id) REFERENCES danhmuctin(id)
);

-- Bảng user_likes: Lưu trữ thông tin về các hình ảnh mà người dùng đã thích
CREATE TABLE user_likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    hinhanh_id INT,
    liked_at DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Ngày thích hình ảnh',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (hinhanh_id) REFERENCES hinhanh(id)
);


