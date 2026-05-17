<?php
require_once __DIR__ . '/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM elements WHERE id = ?');
$stmt->execute([$id]);
$element = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$element) redirect_with_message('index.php', 'Film introuvable.');
$stats = db()->prepare('SELECT COUNT(*) AS total, ROUND(AVG(rating), 2) AS avg FROM reviews WHERE element_id = ?');
$stats->execute([$id]);
$stats = $stats->fetch(PDO::FETCH_ASSOC);
$dist = db()->prepare('SELECT rating, COUNT(*) AS count FROM reviews WHERE element_id = ? GROUP BY rating ORDER BY rating DESC');
$dist->execute([$id]);
$reviews = db()->prepare('SELECT r.*, u.pseudo FROM reviews r JOIN users u ON u.id = r.user_id WHERE r.element_id = ? ORDER BY r.created_at DESC');
$reviews->execute([$id]);
render_header($element['title']);
?>
<h1><?= h($element['title']) ?></h1>
<p><?= h($element['description']) ?></p>
<p><strong><?= (int)$stats['total'] ?></strong> avis — moyenne : <strong><?= $stats['avg'] !== null ? h($stats['avg']) : 'aucune' ?>/5</strong></p>
<div class="stats">
<?php foreach ($dist as $row): ?><span><?= (int)$row['rating'] ?>/5 : <?= (int)$row['count'] ?> avis</span><?php endforeach; ?>
</div>
<?php if (current_user()): ?><p><a class="button" href="add_review.php?element_id=<?= (int)$id ?>">Déposer un avis</a></p><?php endif; ?>
<h2>Avis</h2>
<?php foreach ($reviews as $review): ?>
    <article class="review">
        <p class="rating"><?= stars((int)$review['rating']) ?> <span><?= (int)$review['rating'] ?>/5</span></p>
        <p><?= nl2br(h($review['comment'])) ?></p>
        <p class="meta">Par <a href="user_reviews.php?id=<?= (int)$review['user_id'] ?>"><?= h($review['pseudo']) ?></a>, le <?= h($review['created_at']) ?></p>
    </article>
<?php endforeach; ?>
<?php render_footer(); ?>
