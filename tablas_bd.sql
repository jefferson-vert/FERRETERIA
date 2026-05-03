-- ================================================
-- BASE DE DATOS: ferreteria
-- Ejecutar en MySQL: source tablas_bd.sql
-- ================================================

-- Tabla de roles
CREATE TABLE IF NOT EXISTS roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO roles (nombre) VALUES ('cliente'), ('admin') ON DUPLICATE KEY UPDATE nombre = nombre;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    rol_id INT DEFAULT 1,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

INSERT INTO categorias (nombre) VALUES 
('Herramientas'), ('Electricos'), ('Pintura'), ('Plomeria'), 
('Construccion'), ('Cocina'), ('Banos'), ('Jardineria'), ('Electrodomesticos') 
ON DUPLICATE KEY UPDATE nombre = nombre;

-- Tabla de productos (con campo stock)
CREATE TABLE IF NOT EXISTS productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(200) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    categoria_id INT,
    stock INT DEFAULT 0,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabla de compras
CREATE TABLE IF NOT EXISTS compras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla de detalle de compras
CREATE TABLE IF NOT EXISTS detalle_compras (
    id INT PRIMARY KEY AUTO_INCREMENT,
    compra_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (compra_id) REFERENCES compras(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- ================================================
-- DATOS DE PRUEBA (opcional - comentar si no se desea)
-- ================================================

-- Usuario admin de prueba (contraseña: admin123)
INSERT INTO usuarios (usuario, nombre, apellido, email, clave, rol_id) VALUES 
('admin', 'Administrador', 'Sistema', 'admin@ferreteria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2)
ON DUPLICATE KEY UPDATE usuario = usuario;

-- Productos de prueba
INSERT INTO productos (nombre, precio, imagen, categoria_id, stock) VALUES 
('Taladro Electrico', 150.00, 'img/taladro.jpg', 1, 25),
('Martillo', 45.00, 'img/martillo.jpg', 1, 50),
('Destornillador Set', 80.00, 'img/destornillador.jpg', 1, 30),
('Cables Electricos 10m', 35.00, 'img/cables.jpg', 2, 100),
('Interruptor Simple', 15.00, 'img/interruptor.jpg', 2, 200),
('Pintura Blanca 5L', 120.00, 'img/pintura.jpg', 3, 40),
('Rodillo Pintura', 25.00, 'img/rodillo.jpg', 3, 60),
('Tubo PVC 3m', 18.00, 'img/tubo_pvc.jpg', 4, 150),
('Llave Francesa', 65.00, 'img/llave_francesa.jpg', 4, 35),
('Cemento 50kg', 85.00, 'img/cemento.jpg', 5, 80),
('Tornillos Mix', 12.00, 'img/tornillos.jpg', 1, 500),
('Serrucho', 55.00, 'img/serrucho.jpg', 1, 40)
ON DUPLICATE KEY UPDATE nombre = nombre;

SELECT 'Tablas creadas exitosamente!' AS mensaje;
