<?php
require_once __DIR__ . '/functions.php'; require_login();
$user = current_user();
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
if ($title === '' || $description === '') redirect_with_message('add_element.php', 'Le titre et la description sont obligatoires.');
$stmt = db()->prepare('INSERT INTO elements (title, description, created_by) VALUES (?, ?, ?)');
$stmt->execute([$title, $description, $user['id']]);
redirect_with_message('index.php', 'Film ajouté.');
