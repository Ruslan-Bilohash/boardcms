<?php
// includes/news-section.php
$news_items = getNews();
?>

<div class="section">
    <h2>Новини та події</h2>
    
    <?php if (empty($news_items)): ?>
        <p style="text-align:center; color:#666;">Поки що немає новин</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($news_items as $item): ?>
                <div class="card">
                    <!-- Якщо буде фото події - можна додати -->
                    <div class="card-body">
                        <div class="card-title"><?= htmlspecialchars($item['title'] ?? 'Без назви') ?></div>
                        <p><?= nl2br(htmlspecialchars($item['description'] ?? '')) ?></p>
                        
                        <?php if (!empty($item['date'])): ?>
                            <div><strong>Дата:</strong> <?= htmlspecialchars($item['date']) ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($item['price'])): ?>
                            <div class="price"><?= htmlspecialchars($item['price']) ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($item['location'])): ?>
                            <div><strong>Місце:</strong> <?= htmlspecialchars($item['location']) ?></div>
                        <?php endif; ?>
                        
                        <small style="color:#888;"><?= date('d.m.Y H:i', strtotime($item['created_at'] ?? '')) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>