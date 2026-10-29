CREATE TABLE admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE products (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(180) NOT NULL,
  category VARCHAR(80) NOT NULL,
  subcategory VARCHAR(80) NOT NULL,
  device VARCHAR(100) DEFAULT '',
  brand VARCHAR(100) DEFAULT '',
  reference_code VARCHAR(100) NOT NULL UNIQUE,
  compatibility VARCHAR(180) DEFAULT '',
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  stock INT NOT NULL DEFAULT 0,
  icon VARCHAR(20) DEFAULT '📦',
  image_path VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO products (name,category,subcategory,device,brand,reference_code,compatibility,price,stock,icon) VALUES
('Pantalla iPhone 13','Moviles','Pantallas','','Apple','IP13-LCD-001','iPhone 13',49.90,3,'📱'),
('Batería iPhone 13','Moviles','Baterias','','Apple','IP13-BAT-001','iPhone 13',24.90,5,'🔋'),
('Pantalla Samsung A32','Moviles','Pantallas','','Samsung','SAM-A32-LCD','Galaxy A32 4G',42.90,2,'📱'),
('Joystick PS5 (módulo)','Consolas','Joystick','PS5','Sony','PS5-JOY-001','DualSense / PS5',12.90,8,'🎮'),
('Pasta térmica para PS5','Consolas','Pasta termica','PS5','Sony','PS5-PT-001','PS5',8.90,12,'🧰'),
('Joystick Nintendo Switch','Consolas','Joystick','Nintendo Switch','Nintendo','NS-JOY-001','Joy-Con Switch',14.90,5,'🕹️'),
('Pantalla portátil 15.6','Portatiles','Pantallas','','','LCD15-001','Varios modelos',89.90,7,'💻'),
('Batería portátil universal','Portatiles','Baterias','','','BAT-UNI-001','Varios modelos',54.90,6,'🔋'),
('Cargador USB-C 20W','Accesorios','Cargadores','','','USBC-20W-001','Dispositivos USB-C',14.90,10,'🔌');
