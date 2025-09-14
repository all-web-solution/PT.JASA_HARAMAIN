document.addEventListener('DOMContentLoaded', function () {
    const wakafItems = document.querySelectorAll('.wakaf-item');

    wakafItems.forEach(item => {
        item.addEventListener('click', function () {
            const targetFormId = this.getAttribute('data-target');
            const targetForm = document.getElementById(targetFormId);
            const checkbox = this.querySelector('input[type="checkbox"]');

            if (targetForm) {
                // Toggle the 'hidden' class on the target form
                targetForm.classList.toggle('hidden');

                // Toggle the 'checked' state of the checkbox
                checkbox.checked = !checkbox.checked;

                // Optional: Add/remove a class to the clicked item for visual feedback
                this.classList.toggle('selected');
            }
        });
    });
});
