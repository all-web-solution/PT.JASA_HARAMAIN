
    document.addEventListener("DOMContentLoaded", function () {
        const addBadalBtn = document.getElementById("addBadal");
        const badalWrapper = document.getElementById("badalWrapper");

        // Fungsi tambah badal
        addBadalBtn.addEventListener("click", function () {
            const badalForm = document.createElement("div");
            badalForm.classList.add("badal-form", "bg-white", "p-3", "border", "mb-3");

            badalForm.innerHTML = `
                <div class="form-group mb-2">
                    <label class="form-label">Nama yang dibadalkan</label>
                    <input type="text" class="form-control" name="nama_badal[]">
                </div>
                <div class="form-group mb-2">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control" name="harga_badal[]">
                </div>
                <div class="mt-2 text-end">
                    <button type="button" class="btn btn-danger btn-sm removeBadal">Hapus Badal</button>
                </div>
            `;

            badalWrapper.appendChild(badalForm);
        });

        // Fungsi hapus badal (pakai event delegation)
        badalWrapper.addEventListener("click", function (e) {
            if (e.target.classList.contains("removeBadal")) {
                e.target.closest(".badal-form").remove();
            }
        });
    });

