<?php
require_once __DIR__ . '/functions.php';
$pseudo = trim($_POST['pseudo'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($pseudo === '' || $email === '' || $password === '') redirect_with_message('register.php', 'Tous les champs sont obligatoires.');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) redirect_with_message('register.php', 'Adresse électronique invalide.');
if (strlen($password) < 6) redirect_with_message('register.php', 'Le mot de passe doit contenir au moins 6 caractères.');

$stmt = db()->prepare('SELECT id FROM users WHERE pseudo = ?');
$stmt->execute([$pseudo]);
if ($stmt->fetch()) redirect_with_message('register.php', 'Ce pseudo est déjà pris, choisissez-en un autre.');

$stmt = db()->prepare('INSERT INTO users (pseudo, email, password_hash) VALUES (?, ?, ?)');
$stmt->execute([$pseudo, $email, password_hash($password, PASSWORD_DEFAULT)]);
redirect_with_message('login.php', 'Inscription réussie, vous pouvez vous connecter.');
