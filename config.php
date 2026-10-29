<?php
// Configuración de Microtech
// En Hostinger u otro servidor de producción, se utilizará MySQL automáticamente.
// En entorno local (localhost), si no hay un servidor MySQL corriendo, recurre a SQLite automáticamente sin requerir configuración adicional.

const DB_HOST = 'localhost';
const DB_NAME = 'microtech';
const DB_USER = 'admin';
const DB_PASS = '12345';
const WHATSAPP_NUMBER = '34624945545';

function init_sqlite(PDO $pdo): void {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admins (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT NOT NULL UNIQUE,
            password_hash TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            category TEXT NOT NULL,
            subcategory TEXT NOT NULL,
            device TEXT DEFAULT '',
            brand TEXT DEFAULT '',
            reference_code TEXT NOT NULL UNIQUE,
            compatibility TEXT DEFAULT '',
            price REAL NOT NULL DEFAULT 0,
            stock INTEGER NOT NULL DEFAULT 0,
            icon TEXT DEFAULT '📦',
            image_path TEXT DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    $count = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    if ($count === 0) {
        $st = $pdo->prepare("
            INSERT OR IGNORE INTO products (name, category, subcategory, device, brand, reference_code, compatibility, price, stock, icon)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $defaults = [
            ['Pantalla iPhone 13', 'Moviles', 'Pantallas', '', 'Apple', 'IP13-LCD-001', 'iPhone 13', 49.90, 3, '📱'],
            ['Batería iPhone 13', 'Moviles', 'Baterias', '', 'Apple', 'IP13-BAT-001', 'iPhone 13', 24.90, 5, '🔋'],
            ['Pantalla Samsung A32', 'Moviles', 'Pantallas', '', 'Samsung', 'SAM-A32-LCD', 'Galaxy A32 4G', 42.90, 2, '📱'],
            ['Joystick PS5 (módulo)', 'Consolas', 'Joystick', 'PS5', 'Sony', 'PS5-JOY-001', 'DualSense / PS5', 12.90, 8, '🎮'],
            ['Pasta térmica para PS5', 'Consolas', 'Pasta termica', 'PS5', 'Sony', 'PS5-PT-001', 'PS5', 8.90, 12, '🧰'],
            ['Joystick Nintendo Switch', 'Consolas', 'Joystick', 'Nintendo Switch', 'Nintendo', 'NS-JOY-001', 'Joy-Con Switch', 14.90, 5, '🕹️'],
            ['Pantalla portátil 15.6', 'Portatiles', 'Pantallas', '', '', 'LCD15-001', 'Varios modelos', 89.90, 7, '💻'],
            ['Batería portátil universal', 'Portatiles', 'Baterias', '', '', 'BAT-UNI-001', 'Varios modelos', 54.90, 6, '🔋'],
            ['Cargador USB-C 20W', 'Accesorios', 'Cargadores', '', '', 'USBC-20W-001', 'Dispositivos USB-C', 14.90, 10, '🔌']
        ];
        foreach ($defaults as $row) {
            $st->execute($row);
        }
    }

    $adminCount = (int)$pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    if ($adminCount === 0) {
        $hash = password_hash('admin12345', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT OR IGNORE INTO admins (email, password_hash) VALUES (?, ?)")
            ->execute(['admin@microtech.es', $hash]);
    }
}

function db(): PDO {
    static $pdo;
    if (!$pdo) {
        $connected = false;
        // 1. Intentar conectar con MySQL si está disponible
        if (defined('DB_HOST') && DB_HOST) {
            try {
                $pdo = new PDO(
                    'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_TIMEOUT => 1,
                    ]
                );
                $connected = true;
            } catch (Throwable $e) {
                $connected = false;
            }
        }

        // 2. Si MySQL no está disponible, utilizar SQLite local
        if (!$connected) {
            $sqliteFile = __DIR__ . '/database.sqlite';
            $pdo = new PDO('sqlite:' . $sqliteFile, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            init_sqlite($pdo);
        }
    }
    return $pdo;
}

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function csrf(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function verify_csrf(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403);
        exit('Solicitud no válida.');
    }
}
