<?php
require_once __DIR__ . '/functions.php'; require_admin();
$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);
if ($type === 'review') {
    $stmt = db()->prepare('DELETE FROM reviews WHERE id = ?');
    $stmt->execute([$id]);
    redirect_with_message('admin.php', 'Avis supprimé.');
}
if ($type === 'element') {
    $stmt = db()->prepare('DELETE FROM reviews WHERE element_id = ?');
    $stmt->execute([$id]);
    $stmt = db()->prepare('DELETE FROM elements WHERE id = ?');
    $stmt->execute([$id]);
    redirect_with_message('admin.php', 'Film supprimé avec ses avis.');
}
redirect_with_message('admin.php', 'Action inconnue.');
