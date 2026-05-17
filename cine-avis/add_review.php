<?php
require_once __DIR__ . '/functions.php'; require_login();
$elementId = (int)($_GET['element_id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM elements WHERE id = ?');
$stmt->execute([$elementId]);
$element = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$element) redirect_with_message('index.php', 'Film introuvable.');
render_header('Déposer un avis');
?>
<h1>Déposer un avis sur <?= h($element['title']) ?></h1>
<form action="add_review_process.php" method="post" class="form">
    <input type="hidden" name="element_id" value="<?= (int)$element['id'] ?>">
    <label>Note
        <select name="rating" required>
            <?php for ($i = 0; $i <= 5; $i++): ?><option value="<?= $i ?>"><?= $i ?>/5</option><?php endfor; ?>
        </select>
    </label>
    <label>Commentaire <textarea name="comment" required rows="6"></textarea></label>
    <button type="submit">Publier l’avis</button>
</form>
<?php render_footer(); ?>
