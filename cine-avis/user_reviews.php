<?php
require_once __DIR__ . '/functions.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) redirect_with_message('index.php', 'Utilisateur introuvable.');
$reviews = db()->prepare('SELECT r.*, e.title FROM reviews r JOIN elements e ON e.id = r.element_id WHERE r.user_id = ? ORDER BY r.created_at DESC');
$reviews->execute([$id]);
render_header('Avis de ' . $user['pseudo']);
?>
<h1>Avis postés par <?= h($user['pseudo']) ?></h1>
<?php foreach ($reviews as $review): ?>
    <article class="review">
        <h3><a href="element.php?id=<?= (int)$review['element_id'] ?>"><?= h($review['title']) ?></a></h3>
        <p class="rating"><?= stars((int)$review['rating']) ?> <span><?= (int)$review['rating'] ?>/5</span></p>
        <p><?= nl2br(h($review['comment'])) ?></p>
        <p class="meta">Posté le <?= h($review['created_at']) ?></p>
    </article>
<?php endforeach; ?>
<?php render_footer(); ?>
