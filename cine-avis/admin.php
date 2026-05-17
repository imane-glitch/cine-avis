<?php
require_once __DIR__ . '/functions.php'; require_admin();
$elements = db()->query('SELECT * FROM elements ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
$reviews = db()->query('SELECT r.*, e.title, u.pseudo FROM reviews r JOIN elements e ON e.id = r.element_id JOIN users u ON u.id = r.user_id ORDER BY r.created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
render_header('Administration');
?>
<h1>Administration</h1>
<h2>Supprimer un film</h2>
<table>
<tr><th>Titre</th><th>Action</th></tr>
<?php foreach ($elements as $element): ?>
<tr><td><?= h($element['title']) ?></td><td><a class="danger" href="delete.php?type=element&id=<?= (int)$element['id'] ?>" onclick="return confirm('Supprimer ce film et ses avis ?')">Supprimer</a></td></tr>
<?php endforeach; ?>
</table>
<h2>Supprimer un avis</h2>
<table>
<tr><th>Film</th><th>Auteur</th><th>Note</th><th>Commentaire</th><th>Action</th></tr>
<?php foreach ($reviews as $review): ?>
<tr><td><?= h($review['title']) ?></td><td><?= h($review['pseudo']) ?></td><td><?= (int)$review['rating'] ?>/5</td><td><?= h($review['comment']) ?></td><td><a class="danger" href="delete.php?type=review&id=<?= (int)$review['id'] ?>" onclick="return confirm('Supprimer cet avis ?')">Supprimer</a></td></tr>
<?php endforeach; ?>
</table>
<?php render_footer(); ?>
