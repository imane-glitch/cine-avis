<?php require_once __DIR__ . '/functions.php'; render_header('Inscription'); ?>
<h1>Inscription</h1>
<form action="register_process.php" method="post" class="form">
    <label>Pseudo <input type="text" name="pseudo" required minlength="3" maxlength="30"></label>
    <label>Adresse électronique <input type="email" name="email" required></label>
    <label>Mot de passe <input type="password" name="password" required minlength="6"></label>
    <button type="submit">Créer mon compte</button>
</form>
<?php render_footer(); ?>
