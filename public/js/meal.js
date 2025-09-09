document.addEventListener('DOMContentLoaded', function() {
    // Ambil semua document-item
    const documentItems = document.querySelectorAll('.document-item');

    documentItems.forEach(item => {
        item.addEventListener('click', function() {
            const handlingType = this.getAttribute('data-handling');

            // Toggle form sesuai handling
            const form = document.querySelector(`.form-group[data-handling="${handlingType}"]`);
            const checkbox = this.querySelector(`input[type="checkbox"]`);

            if (form.style.display === 'none') {
                form.style.display = 'block';
                checkbox.checked = true;
                this.classList.add('active'); // Bisa dipakai untuk styling
            } else {
                form.style.display = 'none';
                checkbox.checked = false;
                this.classList.remove('active');
            }
        });
    });
});
