// /admin/js/news.js — Скрипти для списку новин (AJAX + модалка)

document.addEventListener('DOMContentLoaded', function() {
    // Зміна статусу (AJAX)
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', async function() {
            const newsId = this.dataset.newsId;
            const newStatus = this.value;
            
            try {
                const response = await fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=change_status&news_id=${newsId}&new_status=${newStatus}`
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.parentElement.style.backgroundColor = '#d1fae5';
                    setTimeout(() => this.parentElement.style.backgroundColor = '', 1500);
                } else {
                    alert('Помилка зміни статусу: ' + (data.error || 'невідома помилка'));
                    this.value = this.dataset.currentStatus || 'draft';
                }
            } catch (e) {
                alert('Помилка зв\'язку з сервером');
                this.value = this.dataset.currentStatus || 'draft';
            }
        });
        
        select.dataset.currentStatus = select.value;
    });

    // Показ повного тексту + фото в модальному вікні
    document.querySelectorAll('.view').forEach(link => {
        link.addEventListener('click', function() {
            const title = this.dataset.title;
            const content = this.dataset.content;
            const photo = this.dataset.photo;

            document.getElementById('modalTitle').textContent = title;
            
            const photoDiv = document.getElementById('modalPhoto');
            if (photo && photo.trim() !== '') {
                photoDiv.innerHTML = `<img src="${photo}" alt="Головне фото" class="modal-img">`;
            } else {
                photoDiv.innerHTML = '<div style="color:#9ca3af; font-style:italic; padding:2rem 0;">Фото відсутнє</div>';
            }
            
            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('newsModal').style.display = 'flex';
        });
    });

    // Закриття модалки
    document.querySelector('.modal-close').addEventListener('click', closeModal);
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('newsModal');
        if (event.target === modal) closeModal();
    });
});

function closeModal() {
    document.getElementById('newsModal').style.display = 'none';
    document.getElementById('modalPhoto').innerHTML = '';
}
