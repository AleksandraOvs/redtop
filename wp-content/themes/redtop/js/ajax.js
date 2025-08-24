document.addEventListener("DOMContentLoaded", function () {
    const loadMoreBtn = document.getElementById("load-more");
    if (!loadMoreBtn) return;

    loadMoreBtn.addEventListener("click", function () {
        let page = parseInt(this.dataset.page) + 1;
        const max = parseInt(this.dataset.max);

        const data = new FormData();
        data.append('action', 'load_more_posts');
        data.append('page', page);

        fetch(ajaxData.ajax_url, {
            method: 'POST',
            body: data
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('archive-list').insertAdjacentHTML('beforeend', html);
            this.dataset.page = page;
            if (page >= max) {
                this.remove();
            }
        });
    });
});