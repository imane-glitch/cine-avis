<?php
require_once __DIR__ . '/functions.php';
$pseudo = trim($_POST['pseudo'] ?? '');
$password = $_POST['password'] ?? '';
$stmt = db()->prepare('SELECT * FROM users WHERE pseudo = ?');
$stmt->execute([$pseudo]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user || !password_verify($password, $user['password_hash'])) redirect_with_message('login.php', 'Pseudo ou mot de passe incorrect.');
$_SESSION['user_id'] = $user['id'];
redirect_with_message('index.php', 'Connexion réussie.');
