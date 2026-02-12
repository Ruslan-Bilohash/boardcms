<?php
// footer.php — Повністю оновлений футер (02.01.2026)
// ✅ Усі переклади винесені прямо в цей файл
// ✅ Адаптивний для всіх пристроїв (clamp, flex-wrap, media-запити)
// ✅ Виправлено undefined key — дефолтні значення для кожної мови
// ✅ Форма зворотного зв'язку з базовою обробкою

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // для $current_lang та $texts (якщо є)

// Масив перекладів ТІЛЬКИ для футера (ua/en/no)
$texts_footer = [
    'ua' => [
        'copyright'        => '© %s MapsMe.no — MapsMe Board CMS Norway, Ukraine, Lithuania',
        'github_link'      => 'GitHub проєкту',
        'download_boardcms' => 'Скачати Board CMS Free',
        'download_boardcms_mysql' => 'Board CMS Free MySQL v1.3 PHP 8.1-8.4',
        'feedback_title'   => 'Зворотний зв\'язок',
        'feedback_name'    => 'Ваше ім\'я',
        'feedback_email'   => 'Email',
        'feedback_message' => 'Повідомлення',
        'feedback_send'    => 'Надіслати',
        'feedback_success' => 'Дякуємо! Ваше повідомлення надіслано.',
        'feedback_error'   => 'Помилка надсилання. Спробуйте ще раз.',
        'support_dev'      => 'Підтримати розробника',
        'support_text'     => 'Проєкт розвивається завдяки вашій підтримці. Дякуємо!',
    ],
    'en' => [
        'copyright'        => '© %s MapsMe.no — MapsMe Board CMS Norway, Ukraine, Lithuania',
        'github_link'      => 'Project on GitHub',
        'download_boardcms' => 'Download Board CMS Free',
        'download_boardcms_mysql' => 'Board CMS Free MySQL v1.3 PHP 8.1-8.4',
        'feedback_title'   => 'Feedback',
        'feedback_name'    => 'Your name',
        'feedback_email'   => 'Email',
        'feedback_message' => 'Message',
        'feedback_send'    => 'Send',
        'feedback_success' => 'Thank you! Your message has been sent.',
        'feedback_error'   => 'Error sending. Please try again.',
        'support_dev'      => 'Support the developer',
        'support_text'     => 'The project is developing thanks to your support. Thank you!',
    ],
    'no' => [
        'copyright'        => '© %s MapsMe.no — MapsMe Board CMS Norge, Ukraina, Litauen',
        'github_link'      => 'Prosjekt på GitHub',
        'download_boardcms' => 'Last ned Board CMS Free',
        'download_boardcms_mysql' => 'Board CMS Free MySQL v1.3 PHP 8.1-8.4',
        'feedback_title'   => 'Tilbakemelding',
        'feedback_name'    => 'Ditt navn',
        'feedback_email'   => 'E-post',
        'feedback_message' => 'Melding',
        'feedback_send'    => 'Send',
        'feedback_success' => 'Takk! Din melding er sendt.',
        'feedback_error'   => 'Feil ved sending. Prøv igjen.',
        'support_dev'      => 'Støtt utvikleren',
        'support_text'     => 'Prosjektet utvikles takket være din støtte. Takk!',
    ]
];

// Вибираємо переклади для поточної мови (fallback на українську)
$current_texts = $texts_footer[$current_lang] ?? $texts_footer['ua'];

// Обробка форми зворотного зв'язку
$feedback_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback_submit'])) {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $to      = 'rbilohash@gmail.com';
        $subject = 'Зворотній зв\'язок з MapsMe.no';
        $body    = "Ім'я: $name\nEmail: $email\n\nПовідомлення:\n$message";
        $headers = "From: $email\r\nReply-To: $email\r\n";

        if (mail($to, $subject, $body, $headers)) {
            $feedback_message = '<div style="background:#d4edda;color:#155724;padding:1rem;border-radius:8px;margin:1.5rem 0;">' . htmlspecialchars($current_texts['feedback_success']) . '</div>';
        } else {
            $feedback_message = '<div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:8px;margin:1.5rem 0;">' . htmlspecialchars($current_texts['feedback_error']) . '</div>';
        }
    } else {
        $feedback_message = '<div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:8px;margin:1.5rem 0;">Заповніть усі поля коректно!</div>';
    }
}
?>

<?php include 'about.php'; ?>

<footer style="background: linear-gradient(135deg, #1e293b, #0f172a); color: #e2e8f0; padding: clamp(3rem, 6vw, 4rem) 0 2rem; margin-top: 6rem; text-align: center;">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 clamp(1rem, 5vw, 5%);">
        <p><?= sprintf($current_texts['copyright'], date("Y")) ?></p>

        <!-- Кнопки GitHub + Скачати -->
        <div style="margin: clamp(1.5rem, 4vw, 2rem) 0; display: flex; flex-wrap: wrap; justify-content: center; gap: clamp(1rem, 3vw, 1.5rem);">
            <!-- GitHub -->
            <a href="https://github.com/Ruslan-Bilohash/boardcms"
               target="_blank"
               style="display: inline-flex; align-items: center; gap: 0.8rem; padding: 1rem 2rem; background: linear-gradient(135deg, #24292e, #1f2328); color: white; border-radius: 50px; text-decoration: none; font-weight: 600; box-shadow: 0 6px 20px rgba(36,41,46,0.3); transition: all 0.3s; font-size: clamp(0.9rem, 2.5vw, 1.1rem);">
                <i class="fab fa-github" style="font-size: 1.6rem;"></i>
                <?= htmlspecialchars($current_texts['github_link']) ?>
            </a>

            <!-- Скачати Board CMS Free -->
            <a href="/board_cms_free.zip"
               download
               style="display: inline-flex; align-items: center; gap: 0.8rem; padding: 1rem 2rem; background: linear-gradient(135deg, #4361ee, #3a56d4); color: white; border-radius: 50px; text-decoration: none; font-weight: 600; box-shadow: 0 6px 20px rgba(67,97,238,0.3); transition: all 0.3s; font-size: clamp(0.9rem, 2.5vw, 1.1rem);">
                <i class="fas fa-download" style="font-size: 1.4rem;"></i>
                <?= htmlspecialchars($current_texts['download_boardcms']) ?>
            </a>

            <!-- Board CMS Free MySQL -->
            <a href="/board_cms_free_mysql.zip"
               download
               style="display: inline-flex; align-items: center; gap: 0.8rem; padding: 1rem 2rem; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 50px; text-decoration: none; font-weight: 600; box-shadow: 0 6px 20px rgba(16,185,129,0.3); transition: all 0.3s; font-size: clamp(0.9rem, 2.5vw, 1.1rem);">
                <i class="fas fa-database" style="font-size: 1.4rem;"></i>
                <?= htmlspecialchars($current_texts['download_boardcms_mysql']) ?> 
            </a>03.01.2026
        </div>

        <!-- Форма зворотного зв'язку -->
        <div style="max-width: 600px; margin: 3rem auto; padding: 2rem; background: rgba(255,255,255,0.05); border-radius: 16px;">
            <h3 style="margin-bottom: 1.5rem; color: #fff; font-size: clamp(1.2rem, 3vw, 1.6rem);">
                <?= htmlspecialchars($current_texts['feedback_title']) ?>
            </h3>

            <?= $feedback_message ?>

            <form method="POST" style="display: grid; gap: 1.2rem;">
                <input type="text" name="name" placeholder="<?= htmlspecialchars($current_texts['feedback_name']) ?>" required style="padding:1rem;border-radius:10px;border:1px solid #444;background:#2d3748;color:white;">
                <input type="email" name="email" placeholder="<?= htmlspecialchars($current_texts['feedback_email']) ?>" required style="padding:1rem;border-radius:10px;border:1px solid #444;background:#2d3748;color:white;">
                <textarea name="message" rows="5" placeholder="<?= htmlspecialchars($current_texts['feedback_message']) ?>" required style="padding:1rem;border-radius:10px;border:1px solid #444;background:#2d3748;color:white;"></textarea>
                <button type="submit" name="feedback_submit" style="padding:1.1rem;background:#4361ee;color:white;border:none;border-radius:12px;font-weight:600;cursor:pointer;transition:all 0.3s;">
                    <?= htmlspecialchars($current_texts['feedback_send']) ?>
                </button>
            </form>
        </div>

        <!-- Донат блок -->
        <div style="margin-top:2rem;">
            <h3 style="color:#FF813F;font-size:1.4rem;"><?= htmlspecialchars($current_texts['support_dev']) ?></h3>
            <p style="margin:1rem 0;color:#ccc;"><?= htmlspecialchars($current_texts['support_text']) ?></p>
            <img src="https://mapsme.no/qr-code.png" alt="QR-код" style="width: clamp(140px, 30vw, 160px); height: auto; border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.3);">
        </div>
    </div>
</footer>

<!-- Адаптивні стилі -->
<style>
    @media (max-width: 768px) {
        footer { padding: 3rem 0 2rem; }
        .container { padding: 0 1.5rem; }
        div[style*="flex-wrap"] { flex-direction: column; align-items: stretch; }
        a[style*="inline-flex"] { width: 100%; justify-content: center; }
    }
</style>
