document.addEventListener("DOMContentLoaded", () => {
    const doronganItems = document.querySelectorAll(".dorongan-item");
    const template = document.getElementById("jumlah-dorongan-form");
    const container = document.getElementById("jumlah-dorongan-container");
    const cartSection = document.getElementById("cart-total-price");
    const cartItems = document.getElementById("cart-items");
    const cartTotalInput = document.getElementById("cart-total");
    const cartTotalText = document.getElementById("cart-total-text");

    let cart = {};

    function updateCartTotal() {
        let total = 0;
        cartItems.innerHTML = "";

        Object.keys(cart).forEach(nama => {
            const item = cart[nama];
            total += item.total;

            const li = document.createElement("li");
            li.classList.add("list-group-item", "d-flex", "justify-content-between", "align-items-center");
            li.innerHTML = `
                ${nama} (x${item.qty})
                <span>Rp ${item.total.toLocaleString("id-ID")}</span>
            `;
            cartItems.appendChild(li);
        });

        cartTotalInput.value = total;
        cartTotalText.innerText = "Rp. " + total.toLocaleString("id-ID");
        cartSection.style.display = total > 0 ? "block" : "none";
    }

    doronganItems.forEach(item => {
        item.addEventListener("click", () => {
            const nama = item.getAttribute("data-content");
            const harga = parseInt(item.getAttribute("data-price")) || 0;
            const existingForm = document.getElementById("form-" + nama);

            if (existingForm) {
                // toggle off → hapus form & cart
                existingForm.remove();
                delete cart[nama];
                item.classList.remove("active");
                updateCartTotal();
            } else {
                // clone form jumlah
                const clone = template.cloneNode(true);
                clone.id = "form-" + nama;
                clone.classList.remove("hidden");

                const label = clone.querySelector("label");
                label.innerText = `Jumlah ${nama}`;

                const jumlahInput = clone.querySelector("input[type='number']");
                jumlahInput.name = `jumlah_dorongan[${nama}]`;
                jumlahInput.value = 1;

                const hiddenInput = clone.querySelector("input[type='hidden']");
                hiddenInput.name = `jenis_dorongan[${nama}]`;
                hiddenInput.value = nama;

                cart[nama] = { price: harga, qty: 1, total: harga };

                jumlahInput.addEventListener("input", () => {
                    const qty = parseInt(jumlahInput.value) || 0;
                    cart[nama].qty = qty;
                    cart[nama].total = qty * harga;
                    updateCartTotal();
                });

                container.appendChild(clone);
                item.classList.add("active");
                updateCartTotal();
            }
        });
    });
});
