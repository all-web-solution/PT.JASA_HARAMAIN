document.addEventListener("DOMContentLoaded", function () {
    const documentItems = document.querySelectorAll(".document-item");

    documentItems.forEach(item => {
        item.addEventListener("click", function () {
            const docId = this.dataset.document;
            const checkbox = this.querySelector("input[type='checkbox']");
            const detailSection = document.getElementById(`doc-${docId}-details`);
            const formSection = document.getElementById(`doc-${docId}-form`);

            // Toggle checked (pilih/batal pilih)
            checkbox.checked = !checkbox.checked;
            this.classList.toggle("selected", checkbox.checked);

            // Kalau ada children
            if (detailSection) {
                if (checkbox.checked) {
                    detailSection.classList.remove("hidden");
                } else {
                    detailSection.classList.add("hidden");

                    // Reset semua child kalau parent batal dipilih
                    detailSection.querySelectorAll(".child-item").forEach(child => {
                        const childCheckbox = child.querySelector("input[type='checkbox']");
                        childCheckbox.checked = false;
                        child.classList.remove("selected");

                        const childForm = document.getElementById(`${child.dataset.child}-form`);
                        if (childForm) childForm.classList.add("hidden");
                    });
                }
            }

            // Kalau tidak punya children → langsung form
            if (formSection) {
                if (checkbox.checked) {
                    formSection.classList.remove("hidden");
                } else {
                    formSection.classList.add("hidden");
                }
            }
        });
    });

    // Handle klik child
    const childItems = document.querySelectorAll(".child-item");
    childItems.forEach(child => {
        child.addEventListener("click", function () {
            const checkbox = this.querySelector("input[type='checkbox']");
            const childForm = document.getElementById(`${this.dataset.child}-form`);

            // Toggle checked
            checkbox.checked = !checkbox.checked;
            this.classList.toggle("selected", checkbox.checked);

            if (childForm) {
                if (checkbox.checked) {
                    childForm.classList.remove("hidden");
                } else {
                    childForm.classList.add("hidden");
                }
            }
        });
    });
});



// Fungsi bantu: disable/enable input dalam elemen tertentu
function toggleInputs(container, disable = true) {
    container.querySelectorAll("input, select, textarea").forEach(el => {
        el.disabled = disable;
    });
}

// Awal: semua child-form hidden harus disabled
document.querySelectorAll(".child-form.hidden").forEach(form => toggleInputs(form, true));

// Saat user pilih child
document.querySelectorAll(".child-item").forEach(childItem => {
    childItem.addEventListener("click", function () {
        const childId = this.dataset.child;
        const form = document.getElementById(`${childId}-form`);

        // toggle tampil/sembunyi
        if (form.classList.contains("hidden")) {
            form.classList.remove("hidden");
            toggleInputs(form, false); // aktifkan input
        } else {
            form.classList.add("hidden");
            toggleInputs(form, true); // nonaktifkan input
        }
    });
});
