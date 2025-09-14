  document.addEventListener("DOMContentLoaded", function () {
        const pendampingItems = document.querySelectorAll(".pendamping-item");

        pendampingItems.forEach(item => {
            item.addEventListener("click", function () {
                const checkbox = this.querySelector("input[type='checkbox']");
                const formId = "form-" + this.dataset.pendamping;
                const form = document.getElementById(formId);

                if (checkbox.checked) {
                    // uncheck → sembunyikan form
                    checkbox.checked = false;
                    form.classList.add("hidden");
                } else {
                    // check → tampilkan form
                    checkbox.checked = true;
                    form.classList.remove("hidden");
                }
            });
        });
    });
