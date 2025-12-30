<div class="section" style="margin: 50px 0;">
    <h2 style="text-align: center; margin-bottom: 30px; color: #4361ee; font-size: 28px;"><?= e($texts['announcements']) ?> (<?= e($texts['published_free']) ?>)</h2>
    
    <?php
    $ads = getApprovedAds();
    if (empty($ads)):
    ?>
        <p style="text-align: center; color: #666;"><?= e($texts['no_ads_yet']) ?></p>
    <?php else: ?>
        <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px;">
            <?php foreach ($ads as $ad): ?>
                <div class="card">
                    <?php if (!empty($ad['photo'])): ?>
                        <img src="<?= e($ad['photo']) ?>" alt="<?= e($ad['title'] ?? '') ?>" style="width: 100%; height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body" style="padding: 20px;">
                        <div class="card-title" style="font-size: 20px; margin-bottom: 10px; color: #4361ee;">
                            <?= e($ad['title'] ?? 'Без назви') ?>
                        </div>
                        <p><?= nl2br(e($ad['description'] ?? '')) ?></p>
                        <?php if (!empty($ad['city'])): ?>
                            <div><strong><?= e($texts['city']) ?>:</strong> <?= e($ad['city']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($ad['price'])): ?>
                            <div class="price" style="font-weight: bold; color: #06d6a0; font-size: 18px;"><?= e($ad['price']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($ad['contact'])): ?>
                            <div><strong><?= e($texts['contact']) ?>:</strong> <?= e($ad['contact']) ?></div>
                        <?php endif; ?>
                        <small style="color: #888;"><?= date('d.m.Y H:i', strtotime($ad['created_at'] ?? '')) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>