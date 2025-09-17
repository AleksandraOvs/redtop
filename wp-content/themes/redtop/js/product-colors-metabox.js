document.addEventListener('DOMContentLoaded', () => {
    const list = document.getElementById('product-colors-list');
    const hidden = document.getElementById('available_colors');
    const addBtn = document.getElementById('add-color');

    addBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const frame = wp.media({
            title: 'Выберите изображение или вставьте HEX',
            button: { text: 'Использовать' },
            multiple: false
        });

        frame.on('select', () => {
            const attachment = frame.state().get('selection').first().toJSON();
            const url = attachment.url;
            const li = document.createElement('li');
            li.className = 'product-color-item';
            li.innerHTML = `
        <img src="${url}" style="width:40px;height:40px;vertical-align:middle;" />
        <input type="text" class="product-color-value" value="${url}" placeholder="HEX или URL" />
        <input type="text" class="product-color-label" placeholder="Название" />
        <button class="remove-color button">×</button>
      `;
            list.appendChild(li);
            updateHidden();
        });

        frame.open();
    });

    // Удаление
    list.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-color')) {
            e.preventDefault();
            e.target.closest('.product-color-item').remove();
            updateHidden();
        }
    });

    // Изменение input
    list.addEventListener('input', (e) => {
        if (e.target.classList.contains('product-color-value') || e.target.classList.contains('product-color-label')) {
            updateHidden();
        }
    });

    function updateHidden() {
        const items = list.querySelectorAll('.product-color-item');
        const values = [];
        items.forEach((item) => {
            const val = item.querySelector('.product-color-value').value.trim();
            const label = item.querySelector('.product-color-label').value.trim();
            if (val) values.push(`${val}|${label}`);
        });
        hidden.value = values.join(', ');
    }
});
