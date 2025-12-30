<footer style="background: linear-gradient(135deg, #1e293b, #0f172a); color: #e2e8f0; padding: 4rem 0 2rem; margin-top: 6rem; text-align: center;">
    <div class="container">
        <p>© <?= date("Y") ?> MapsMe.no — MapsMe Board CMS Norway, Ukraine, Lithuania, </p>

        <!-- GitHub -->
  <a href="https://github.com/Ruslan-Bilohash/boardcms.zip" 
   download 
   style="display:inline-flex; align-items:center; gap:0.8rem; padding:1rem 2rem; background:linear-gradient(135deg,#24292e,#1f2328); color:white; border-radius:50px; text-decoration:none; font-weight:600; box-shadow:0 6px 20px rgba(36,41,46,0.3); transition:all 0.3s; font-size:1.1rem;">
    <i class="fab fa-github" style="font-size:1.6rem;"></i>
    Скачати скрипт з GitHub (безкоштовно)
</a>
<!-- Кнопка "Скачати скрипт" -->
<a href="https://github.com/Ruslan-Bilohash/boardcms" 
   download 
   style="padding:0.9rem 1.8rem; font-size:1.1rem; background:linear-gradient(135deg,#4361ee,#3a56d4); color:white; border:none; border-radius:50px; cursor:pointer; font-weight:600; box-shadow:0 4px 12px rgba(67,97,238,0.25); text-decoration:none; transition:all 0.3s; display:inline-flex; align-items:center; gap:0.6rem;">
    <i class="fas fa-download"></i> Скачати Board CMS Free
</a>
        <!-- Форма зворотного зв'язку -->
        <div style="max-width: 600px; margin: 3rem auto; padding: 2rem; background: rgba(255,255,255,0.05); border-radius: 16px;">
            <h3 style="margin-bottom: 1.5rem; color: #fff; font-size: 1.6rem;"><?= e($texts['feedback_title']) ?></h3>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_submit'])) {
                $name    = trim($_POST['name'] ?? '');
                $email   = trim($_POST['email'] ?? '');
                $message = trim($_POST['message'] ?? '');

                if ($name && $email && $message) {
                    $to      = 'rbilohash@gmail.com';
                    $subject = 'Зворотній зв\'язок з MapsMe.no';
                    $body    = "Ім'я: $name\nEmail: $email\n\nПовідомлення:\n$message";
                    $headers = "From: $email\r\nReply-To: $email\r\n";

                    if (mail($to, $subject, $body, $headers)) {
                        echo '<div style="background:#d4edda;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1.5rem;">' . e($texts['feedback_success']) . '</div>';
                    } else {
                        echo '<div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:8px;margin-bottom:1.5rem;">' . e($texts['feedback_error']) . '</div>';
                    }
                } else {
                    echo '<div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:8px;margin-bottom:1.5rem;">Заповніть усі поля!</div>';
                }
            }
            ?>

            <form method="POST" style="display: grid; gap: 1.2rem;">
                <input type="text" name="name" placeholder="<?= e($texts['feedback_name']) ?>" required style="padding:1rem;border-radius:10px;border:1px solid #444;background:#2d3748;color:white;">
                <input type="email" name="email" placeholder="<?= e($texts['feedback_email']) ?>" required style="padding:1rem;border-radius:10px;border:1px solid #444;background:#2d3748;color:white;">
                <textarea name="message" rows="5" placeholder="<?= e($texts['feedback_message']) ?>" required style="padding:1rem;border-radius:10px;border:1px solid #444;background:#2d3748;color:white;"></textarea>
                <button type="submit" name="feedback_submit" style="padding:1.1rem;background:#4361ee;color:white;border:none;border-radius:12px;font-weight:600;cursor:pointer;transition:all 0.3s;">
                    <?= e($texts['feedback_send']) ?>
                </button>
            </form>
        </div>

        <!-- Донат блок -->
        <div style="margin-top:2rem;">
            <h3 style="color:#FF813F;font-size:1.4rem;"><?= e($texts['support_dev']) ?></h3>
            <p style="margin:1rem 0;color:#ccc;"><?= e($texts['support_text']) ?></p>
            <img src="https://mapsme.no/qr-code.png" alt="QR-код" style="width:160px;height:160px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.3);">
        </div>
    </div>
</footer>