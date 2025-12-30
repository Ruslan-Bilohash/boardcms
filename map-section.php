<div class="section" style="margin: 50px 0;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #4361ee; font-size: 28px;"><?= e($texts['news_events']) ?></h2>
    
    <?php
    $news_items = getNews();
    if (empty($news_items)):
    ?>
        <p style="text-align: center; color: #666;"><?= e($texts['no_news_yet']) ?></p>
    <?php else: ?>
        <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
            <?php foreach ($news_items as $item): ?>
                <div class="card">
                    <div class="card-body" style="padding: 20px;">
                        <div class="card-title" style="font-size: 20px; margin-bottom: 10px; color: #4361ee;">
                            <?= e($item['title'] ?? 'Без назви') ?>
                        </div>
                        <p><?= nl2br(e($item['description'] ?? '')) ?></p>
                        <?php if (!empty($item['date'])): ?>
                            <div><strong>Дата:</strong> <?= e($item['date']) ?></div>
                        <?php endif; ?>
                        <small style="color: #888;"><?= date('d.m.Y H:i', strtotime($item['created_at'] ?? '')) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>