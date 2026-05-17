<?php
require_once __DIR__ . '/functions.php'; require_login();
$user = current_user();
$elementId = (int)($_POST['element_id'] ?? 0);
$rating = (int)($_POST['rating'] ?? -1);
$comment = trim($_POST['comment'] ?? '');
if ($rating < 0 || $rating > 5 || $comment === '') redirect_with_message('add_review.php?element_id=' . $elementId, 'Note ou commentaire invalide.');
$stmt = db()->prepare('SELECT id FROM elements WHERE id = ?');
$stmt->execute([$elementId]);
if (!$stmt->fetch()) redirect_with_message('index.php', 'Film introuvable.');
$stmt = db()->prepare('INSERT INTO reviews (user_id, element_id, rating, comment) VALUES (?, ?, ?, ?)');
$stmt->execute([$user['id'], $elementId, $rating, $comment]);
redirect_with_message('element.php?id=' . $elementId, 'Avis publié.');
