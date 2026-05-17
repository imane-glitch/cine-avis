<?php require_once __DIR__ . '/functions.php'; render_header('Connexion'); ?>
<h1>Connexion</h1>
<form action="login_process.php" method="post" class="form">
    <label>Pseudo <input type="text" name="pseudo" required></label>
    <label>Mot de passe <input type="password" name="password" required></label>
    <button type="submit">Se connecter</button>
</form>
<?php render_footer(); ?>
