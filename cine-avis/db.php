<?php
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dataDir = __DIR__ . '/data';
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0777, true);
        }
        $pdo = new PDO('sqlite:' . $dataDir . '/site_avis.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('PRAGMA foreign_keys = ON');
        init_db($pdo);
    }
    return $pdo;
}

function init_db(PDO $pdo): void {
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pseudo TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL,
        password_hash TEXT NOT NULL,
        is_admin INTEGER NOT NULL DEFAULT 0,
        created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS elements (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        created_by INTEGER NOT NULL,
        created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (created_by) REFERENCES users(id)
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        element_id INTEGER NOT NULL,
        rating INTEGER NOT NULL CHECK (rating BETWEEN 0 AND 5),
        comment TEXT NOT NULL,
        created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (element_id) REFERENCES elements(id)
    )");

    $count = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($count === 0) {
        $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password_hash, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', 'admin@example.com', password_hash('admin123', PASSWORD_DEFAULT), 1]);
        $stmt->execute(['demo', 'demo@example.com', password_hash('demo123', PASSWORD_DEFAULT), 0]);

        $adminId = 1;
        $stmt = $pdo->prepare("INSERT INTO elements (title, description, created_by) VALUES (?, ?, ?)");
        $stmt->execute(['Interstellar', 'Film de science-fiction autour du voyage spatial et du temps.', $adminId]);
        $stmt->execute(['Le Château ambulant', 'Film d’animation de Hayao Miyazaki.', $adminId]);
        $stmt->execute(['Intouchables', 'Comédie dramatique française.', $adminId]);
    }
}
