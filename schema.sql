CREATE DATABASE IF NOT EXISTS kisubi_airlines CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kisubi_airlines;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS flights (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  flight_number VARCHAR(20) NOT NULL,
  origin VARCHAR(100) NOT NULL,
  destination VARCHAR(100) NOT NULL,
  departure_time DATETIME NOT NULL,
  arrival_time DATETIME NOT NULL,
  cabin ENUM('Economy', 'Business', 'First') DEFAULT 'Economy',
  base_price DECIMAL(10,2) NOT NULL,
  total_seats INT UNSIGNED NOT NULL,
  available_seats INT UNSIGNED NOT NULL,
  status ENUM('Scheduled','On Time','Delayed','Cancelled') DEFAULT 'Scheduled',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS bookings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  booking_ref VARCHAR(10) NOT NULL UNIQUE,
  user_id INT UNSIGNED NULL,
  flight_id INT UNSIGNED NOT NULL,
  customer_name VARCHAR(100) NOT NULL,
  customer_email VARCHAR(150) NOT NULL,
  passengers_count INT UNSIGNED NOT NULL DEFAULT 1,
  total_price DECIMAL(10,2) NOT NULL,
  status ENUM('Pending','Confirmed','Cancelled','Checked-in') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_bookings_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  CONSTRAINT fk_bookings_flight FOREIGN KEY (flight_id) REFERENCES flights(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS booking_passengers (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  booking_id INT UNSIGNED NOT NULL,
  full_name VARCHAR(100) NOT NULL,
  gender ENUM('M','F','Other') DEFAULT 'Other',
  date_of_birth DATE NULL,
  CONSTRAINT fk_passengers_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  subject VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed an initial admin user (email: admin@kisubi.test, password: admin123)
INSERT INTO users (name, email, password_hash, role)
VALUES (
  'Kisubi Admin',
  'admin@kisubi.test',
  -- password_hash for 'admin123' using PHP password_hash() with PASSWORD_BCRYPT
  '$2y$10$2uA0uamf1vmuUc1pV3m7Iu9imHqv4kHGRkOshcRzscu2r7TBCbQ7W',
  'admin'
)
ON DUPLICATE KEY UPDATE email = email;

