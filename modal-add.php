<div id="addModal" class="modal" style="display:none;position:fixed;z-index:2000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.7);">
    <div class="modal-content" style="background:white;margin:4% auto;padding:35px;width:90%;max-width:560px;border-radius:18px;position:relative;">
        <span class="close" onclick="closeModal()" style="position:absolute;top:15px;right:22px;font-size:36px;cursor:pointer;color:#999;">×</span>
        <h2 style="text-align:center;margin-bottom:25px;color:#4361ee;font-size:26px;"><?= e($texts['add_free']) ?></h2>
        
        <form id="addForm" method="post" action="process-add.php" enctype="multipart/form-data">
            <select name="type" required style="width:100%;padding:14px;margin:12px 0;border:1px solid #ddd;border-radius:10px;font-size:16px;">
                <option value=""><?= e($texts['type_select']) ?></option>
                <option value="service"><?= e($texts['type_service']) ?></option>
                <option value="sale"><?= e($texts['type_sale']) ?></option>
                <option value="event"><?= e($texts['type_event']) ?></option>
                <option value="other"><?= e($texts['type_other']) ?></option>
            </select>

            <input type="text" name="title" placeholder="<?= e($texts['description']) ?> *" required style="width:100%;padding:14px;margin:12px 0;border:1px solid #ddd;border-radius:10px;font-size:16px;">

            <textarea name="description" rows="4" placeholder="<?= e($texts['description']) ?>" style="width:100%;padding:14px;margin:12px 0;border:1px solid #ddd;border-radius:10px;font-size:16px;"></textarea>

            <input type="text" name="city" id="cityInput" placeholder="<?= e($texts['city']) ?>" style="width:100%;padding:14px;margin:12px 0;border:1px solid #ddd;border-radius:10px;font-size:16px;">

            <button type="button" id="findCoordsBtn" style="width:100%;padding:14px;background:#4361ee;color:white;border:none;border-radius:10px;font-size:16px;margin:12px 0;cursor:pointer;"><?= e($texts['find_coords']) ?></button>

            <div id="coordsResult" style="margin:8px 0;min-height:20px;"></div>

            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">

            <input type="text" name="price" placeholder="<?= e($texts['price']) ?>" style="width:100%;padding:14px;margin:12px 0;border:1px solid #ddd;border-radius:10px;font-size:16px;">

            <input type="text" name="contact" placeholder="<?= e($texts['contact']) ?>" style="width:100%;padding:14px;margin:12px 0;border:1px solid #ddd;border-radius:10px;font-size:16px;">

            <div style="margin:15px 0;">
                <label style="display:block;margin-bottom:6px;font-weight:500;"><?= e($texts['photo']) ?></label>
                <input type="file" name="photo" accept="image/*" style="width:100%;padding:14px;border:1px solid #ddd;border-radius:10px;">
            </div>

            <div style="margin:20px 0;padding:15px;background:#f8f9fa;border-radius:8px;font-size:0.95em;">
                <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer;">
                    <input type="checkbox" name="gdpr_consent" required style="margin-top:4px;">
                    <div><?= $texts['gdpr_consent'] ?> <span style="color:#d32f2f;">*</span></div>
                </label>
            </div>

            <button type="submit" style="width:100%;padding:16px;background:#28a745;color:white;border:none;border-radius:10px;font-size:18px;cursor:pointer;margin-top:15px;"><?= e($texts['submit']) ?></button>
        </form>
    </div>
</div>

<script>
document.getElementById('findCoordsBtn')?.addEventListener('click', async () => {
    const city = document.getElementById('cityInput').value.trim();
    if (!city) return alert('Введіть місто');

    const resultDiv = document.getElementById('coordsResult');
    resultDiv.textContent = 'Пошук...';

    try {
        const res = await fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(city + ", Norway")}&format=json&limit=1`);
        const data = await res.json();
        
        if (data?.[0]) {
            const { lat, lon } = data[0];
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lon;
            resultDiv.innerHTML = `<span style="color:#28a745;">${'<?= e($texts['coords_found']) ?>'} ${parseFloat(lat).toFixed(5)}, ${parseFloat(lon).toFixed(5)}</span>`;
        } else {
            resultDiv.innerHTML = `<span style="color:#d32f2f;">${'<?= e($texts['coords_not_found']) ?>'}</span>`;
        }
    } catch (e) {
        resultDiv.innerHTML = 'Помилка пошуку';
    }
});
</script>
<!-- Toast сповіщення -->
<div id="toast" style="position:fixed; bottom:30px; right:30px; background:#28a745; color:white; padding:1.2rem 2rem; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,0.25); transform:translateX(120%); opacity:0; transition:all 0.4s ease; z-index:3000; max-width:380px; font-size:1.05rem; display:flex; align-items:center; gap:1rem;">
    <i class="fas fa-check-circle" style="font-size:1.8rem;"></i>
    <span id="toastMessage"></span>
</div>

<script>
function showSuccessModal(message) {
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed; z-index: 3000; left: 0; top: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center;
    `;
    
    modal.innerHTML = `
        <div style="
            background: white; border-radius: 24px; padding: 3rem; max-width: 480px; width: 90%;
            text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.3); transform: scale(0.8); opacity: 0;
            transition: all 0.4s ease;
        ">
            <div style="font-size: 5rem; color: #28a745; margin-bottom: 1rem; animation: bounce 1s ease;">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2 style="font-size: 1.8rem; color: #2b2d42; margin: 0 0 1rem;">Успіх!</h2>
            <p style="color: #555; font-size: 1.1rem; margin-bottom: 2rem; line-height: 1.5;">${message}</p>
            <button onclick="this.closest('div').parentElement.remove()" style="
                padding: 0.9rem 2.5rem; background: #28a745; color: white; border: none; border-radius: 12px;
                font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s;
            ">Закрити</button>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Анімація появи
    setTimeout(() => {
        modal.querySelector('div').style.transform = 'scale(1)';
        modal.querySelector('div').style.opacity = '1';
    }, 10);
    
    // Анімація іконки
    const style = document.createElement('style');
    style.textContent = `
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }
    `;
    document.head.appendChild(style);
}
</script>