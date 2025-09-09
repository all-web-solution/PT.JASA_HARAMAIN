document.addEventListener("DOMContentLoaded", () => {
    const doronganItems = document.querySelectorAll(".dorongan-item");
    const template = document.getElementById("jumlah-dorongan-form"); // template hidden
    const container = document.getElementById("jumlah-dorongan-container"); // wadah form
    const cartSection = document.getElementById("cart-total-price");
    const cartItems = document.getElementById("cart-items");
    const cartTotalInput = document.getElementById("cart-total");
    const cartTotalText = document.getElementById("cart-total-text");

    let cart = {}; // object untuk nyimpan item: {nama: {price, qty, total}}

    // fungsi update total cart
    // function updateCartTotal() {
    //     let total = 0;
    //     cartItems.innerHTML = "";

    //     Object.keys(cart).forEach(nama => {
    //         const item = cart[nama];
    //         total += item.total;

    //         const li = document.createElement("li");
    //         li.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
    //         li.innerHTML = `
    //             ${nama} (x${item.qty})
    //             <span>Rp ${item.total.toLocaleString("id-ID")}</span>
    //         `;
    //         cartItems.appendChild(li);
    //     });

    //     cartTotalInput.value = total;
    //     cartTotalText.innerText = "Rp. " + total.toLocaleString("id-ID");

    //     cartSection.style.display = total > 0 ? "block" : "none";
    // }

    doronganItems.forEach(item => {
        item.addEventListener("click", () => {
            const nama = item.getAttribute("data-content");
            let harga = item.getAttribute("data-price");

            // pastikan harga angka
            harga = parseInt(harga.toString().replace(/[^0-9]/g, "")) || 0;

            const existingForm = document.getElementById("form-" + nama);

            if (existingForm) {
                // kalau sudah ada → hapus dari form & cart
                existingForm.remove();
                delete cart[nama];
                item.classList.remove("active");
                updateCartTotal();
            } else {
                // clone form jumlah
                const clone = template.cloneNode(true);
                clone.id = "form-" + nama;
                clone.classList.remove("hidden");

                // label jumlah
                const label = clone.querySelector("label");
                label.innerText = `Jumlah ${nama}`;

                // input jumlah
                const jumlahInput = clone.querySelector("input[type='number']");
                jumlahInput.classList.add("jumlah-input");
                jumlahInput.name = `jumlah_dorongan[${nama}]`;
                jumlahInput.value = 1;

                // hidden input
                const hiddenInput = clone.querySelector("input[type='hidden']");
                hiddenInput.classList.add("jenis-dorongan");
                hiddenInput.name = `jenis_dorongan[${nama}]`;
                hiddenInput.value = nama;

                // default cart data
                cart[nama] = { price: harga, qty: 1, total: harga };

                // event kalau jumlah berubah
                jumlahInput.addEventListener("input", () => {
                    const qty = parseInt(jumlahInput.value) || 0;
                    cart[nama].qty = qty;
                    cart[nama].total = qty * harga;
                    updateCartTotal();
                });

                // masukkan form ke container
                container.appendChild(clone);

                // tandai aktif
                item.classList.add("active");

                // update cart
                updateCartTotal();
            }
        });
    });
});
