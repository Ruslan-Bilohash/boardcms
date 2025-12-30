<?php
// add.php
$title = "Додати оголошення — MapsMe Norway";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background:#f8f9fc; padding:20px; max-width:700px; margin:0 auto; }
        .form-group { margin-bottom:20px; }
        label { display:block; margin-bottom:6px; font-weight:500; }
        input, textarea, select {
            width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; font-size:16px;
        }
        button {
            background:#28a745; color:white; border:none; padding:16px; font-size:18px;
            border-radius:8px; cursor:pointer; width:100%; font-weight:bold;
        }
        .message { padding:12px; margin:20px 0; border-radius:8px; }
        .success { background:#d4edda; color:#155724; }
        .error   { background:#f8d7da; color:#721c24; }
    </style>
</head>
<body>

<h1>Додати оголошення</h1>

<form id="addForm" method="post" action="process-add.php">
    <div class="form-group">
        <label>Тип оголошення *</label>
        <select name="type" required>
            <option value="">— Оберіть —</option>
            <option value="service">Майстер/Послуга</option>
            <option value="sale">Продам/Куплю</option>
            <option value="event">Подія/Зустріч</option>
            <option value="other">Інше</option>
        </select>
    </div>

    <div class="form-group">
        <label>Заголовок *</label>
        <input type="text" name="title" required placeholder="Наприклад: Сантехнік у Осло">
    </div>

    <div class="form-group">
        <label>Опис</label>
        <textarea name="description" rows="5" placeholder="Деталі, контакти, що саме пропонуєте..."></textarea>
    </div>

    <div class="form-group">
        <label>Місто</label>
        <input type="text" name="city" placeholder="Oslo, Bergen, Stavanger, Trondheim...">
    </div>

    <div class="form-group">
        <label>Ціна (NOK)</label>
        <input type="text" name="price" placeholder="350, 250/год, безкоштовно...">
    </div>

    <div class="form-group">
        <label>Телефон / WhatsApp / Telegram</label>
        <input type="tel" name="phone" placeholder="+47 123 45 678 або @username">
    </div>

    <div class="form-group" style="font-size:14px; color:#555;">
        <label>
            <input type="checkbox" name="consent" required>
            Згоден(на) з <a href="/personvern.php" target="_blank">політикою конфіденційності</a>
        </label>
    </div></br>
<div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; font-size: 0.95em;">
    <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
        <input type="checkbox" name="gdpr_consent" required style="margin-top: 4px;">
        <div>
            Я погоджуюсь з <a href="/personvern.php" target="_blank">політикою конфіденційності</a> 
            та даю згоду на обробку персональних даних відповідно до GDPR.
            <span style="color: #d32f2f;">*</span>
        </div>
    </label>
</div>
    <button type="submit">Надіслати на модерацію</button>
</form>

<div id="result" class="message" style="display:none;"></div>

<script>
document.getElementById('addForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const resultDiv = document.getElementById('result');
    resultDiv.style.display = 'block';
    
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form)
        });
        
        const data = await response.json();
        
        if (data.success) {
            resultDiv.className = 'message success';
            resultDiv.textContent = data.message;
            form.reset();
        } else {
            resultDiv.className = 'message error';
            resultDiv.textContent = data.error || data.errors?.join('\n') || 'Щось пішло не так...';
        }
    } catch (err) {
        resultDiv.className = 'message error';
        resultDiv.textContent = 'Помилка зв\'язку з сервером';
    }
});
</script>

</body>
</html>