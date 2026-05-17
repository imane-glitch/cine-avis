<?php require_once __DIR__ . '/functions.php'; require_login(); render_header('Ajouter un film'); ?>
<h1>Ajouter un film</h1>
<form action="add_element_process.php" method="post" class="form">
    <label>Titre <input type="text" name="title" required maxlength="100"></label>
    <label>Description <textarea name="description" required rows="5"></textarea></label>
    <button type="submit">Ajouter</button>
</form>
<?php render_footer(); ?>
