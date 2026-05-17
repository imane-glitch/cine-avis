<?php require_once __DIR__ . '/functions.php'; render_header('Accueil');
$stmt = db()->query("SELECT e.*, COUNT(r.id) AS review_count, ROUND(AVG(r.rating), 2) AS average_rating
                    FROM elements e
                    LEFT JOIN reviews r ON r.element_id = e.id
                    GROUP BY e.id
                    ORDER BY e.created_at DESC");
$elements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="hero">
    <h1>Bienvenue sur CinéAvis</h1>
    <p>Consultez, ajoutez et partagez des avis sur des films.</p>
</section>

<h2>Films disponibles</h2>
<div class="grid">
<?php foreach ($elements as $element): ?>
    <article class="card">
        <h3><?= h($element['title']) ?></h3>
        <p><?= h($element['description']) ?></p>
        <p><strong><?= (int)$element['review_count'] ?></strong> avis
        <?php if ($element['average_rating'] !== null): ?> — moyenne : <strong><?= h($element['average_rating']) ?>/5</strong><?php endif; ?></p>
        <a class="button" href="element.php?id=<?= (int)$element['id'] ?>">Voir les avis</a>
        <?php if (current_user()): ?>
            <a class="button secondary" href="add_review.php?element_id=<?= (int)$element['id'] ?>">Déposer un avis</a>
        <?php endif; ?>
    </article>
<?php endforeach; ?>
</div>
<?php render_footer(); ?>
