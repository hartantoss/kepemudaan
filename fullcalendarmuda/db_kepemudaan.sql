CREATE DATABASE IF NOT EXISTS db_kepemudaan;
USE db_kepemudaan;

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);

INSERT INTO categories (name) VALUES
('Seminar'), ('Lomba'), ('Workshop'), ('Pelatihan'), ('Musyawarah');

CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  start DATETIME NOT NULL,
  end DATETIME,
  description TEXT,
  category_id INT,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

INSERT INTO events (title, start, end, description, category_id) VALUES
('Pelatihan Desain Grafis', '2025-07-30 09:00:00', '2025-07-30 16:00:00', 'Workshop desain grafis untuk pemuda Serang.', 3),
('Lomba Futsal Antar RW', '2025-08-10 08:00:00', '2025-08-10 18:00:00', 'Lomba futsal tingkat RW.', 2);

CREATE TABLE IF NOT EXISTS admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

INSERT INTO admin_users (username, password)
VALUES ('admin', '$2y$10$4Fe0Qe8Gv5tFeW9t8NLkmu/N.D2dK7HtW4z0DLC2fIs.1nSIbdcXm');
