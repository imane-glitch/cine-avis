<?php
session_start();
require_once __DIR__ . '/db.php';

function h(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function current_user(): ?array {
    if (!isset($_SESSION['user_id'])) return null;
    $stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user ?: null;
}

function require_login(): void {
    if (!current_user()) {
        header('Location: login.php?message=' . urlencode('Vous devez être connecté.'));
        exit;
    }
}

function require_admin(): void {
    $user = current_user();
    if (!$user || (int)$user['is_admin'] !== 1) {
        header('Location: index.php?message=' . urlencode('Accès réservé à l’administrateur.'));
        exit;
    }
}

function redirect_with_message(string $url, string $message): void {
    header('Location: ' . $url . (str_contains($url, '?') ? '&' : '?') . 'message=' . urlencode($message));
    exit;
}

function render_header(string $title): void {
    $user = current_user();
    echo '<!doctype html><html lang="fr"><head><meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . h($title) . ' - CinéAvis</title>';
    echo '<link rel="stylesheet" href="style.css"></head><body>';
    echo '<header class="topbar"><a class="logo" href="index.php">CinéAvis</a><nav>';
    echo '<a href="index.php">Accueil</a>';
    if ($user) {
        echo '<a href="add_element.php">Ajouter un film</a>';
        echo '<a href="user_reviews.php?id=' . (int)$user['id'] . '">Mes avis</a>';
        if ((int)$user['is_admin'] === 1) echo '<a href="admin.php">Administration</a>';
        echo '<a href="logout.php">Déconnexion (' . h($user['pseudo']) . ')</a>';
    } else {
        echo '<a href="register.php">Inscription</a><a href="login.php">Connexion</a>';
    }
    echo '</nav></header><main class="container">';
    if (isset($_GET['message'])) echo '<p class="message">' . h($_GET['message']) . '</p>';
}

function render_footer(): void {
    echo '</main><footer>Projet L1 — Site d’avis en HTML, CSS et PHP</footer></body></html>';
}

function stars(int $rating): string {
    return str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);
}
