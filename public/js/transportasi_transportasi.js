document.addEventListener("DOMContentLoaded", function () {
    const addBtn = document.getElementById("add-transport-btn");
    const container = document.getElementById("new-transport-forms");

    // Elemen cart
    const cartSection = document.querySelector("#cart-total-price");
    const cartItems = document.querySelector("#cart-items");
    const cartTotal = document.querySelector("#cart-total");
    const cartTotalText = document.querySelector("#cart-total-text");

    let selectedRoutes = {};
    let setCounter = 0;

    // Render ulang cart
    function renderCart() {
        cartItems.innerHTML = "";
        let total = 0;

        Object.values(selectedRoutes).forEach(item => {
            if (item.price > 0) {
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.textContent = `${item.routeName}`;
                const span = document.createElement("span");
                span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(item.price)}`;
                li.appendChild(span);
                cartItems.appendChild(li);
                total += item.price;
            }
        });

        cartSection.style.display = total > 0 ? "block" : "none";
        cartTotal.value = total;
        cartTotalText.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(total)}`;
    }

    // Klik card
    function setupCardClick(card, setId) {
        card.addEventListener("click", function () {
            const set = card.closest(".transport-set");
            const allCards = set.querySelectorAll(".service-car");
            allCards.forEach(c => c.classList.remove("selected"));
            card.classList.add("selected");

            const radio = card.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;

            const routes = JSON.parse(card.dataset.routes || "[]") || [];
            const carName = card.querySelector(".service-name").innerText.trim();

            const routeSelectWrapper = set.querySelector(".route-select");
            const routeSelect = routeSelectWrapper.querySelector("select");
            routeSelectWrapper.classList.remove("hidden");
            routeSelect.innerHTML = `<option value="">-- Pilih Rute (${carName}) --</option>`;
            routes.forEach(route => {
                const opt = document.createElement("option");
                opt.value = route.id;
                opt.textContent = `${route.route} (Rp. ${new Intl.NumberFormat('id-ID').format(route.price)})`;
                opt.dataset.price = route.price;
                opt.dataset.routeName = route.route;
                routeSelect.appendChild(opt);
            });

            selectedRoutes[setId] = { routeName: "", price: 0 };
            renderCart();
        });
    }

    // Pilih rute
    function setupRouteSelect(select, setId) {
        select.addEventListener("change", function () {
            const selectedOption = select.options[select.selectedIndex];
            if (!selectedOption.value) {
                selectedRoutes[setId] = { routeName: "", price: 0 };
            } else {
                selectedRoutes[setId] = {
                    routeName: selectedOption.dataset.routeName,
                    price: parseInt(selectedOption.dataset.price)
                };
            }
            renderCart();
        });
    }

    // Tambah tombol hapus (hanya untuk set tambahan)
    function setupDeleteButton(set, setId) {
        const deleteBtn = document.createElement("button");
        deleteBtn.type = "button";
        deleteBtn.className = "btn btn-danger btn-sm mt-2";
        deleteBtn.textContent = "Hapus Transportasi";

        deleteBtn.addEventListener("click", function () {
            delete selectedRoutes[setId];
            set.remove();
            renderCart();
        });

        set.appendChild(deleteBtn);
    }

    // Inisialisasi set
    function initTransportSet(set, setId, withDelete = true) {
        set.dataset.setId = setId;

        const cards = set.querySelectorAll(".service-car");
        cards.forEach(card => setupCardClick(card, setId));

        const select = set.querySelector(".route-select select");
        if (select) setupRouteSelect(select, setId);

        if (withDelete) {
            setupDeleteButton(set, setId);
        }

        selectedRoutes[setId] = { routeName: "", price: 0 };
    }

    // Inisialisasi set awal (tanpa tombol hapus)
    container.querySelectorAll(".transport-set").forEach(set => {
        initTransportSet(set, setCounter++, false);
    });

    // Tombol tambah transportasi
    addBtn.addEventListener("click", function () {
        const firstSet = container.querySelector(".transport-set");
        const newSet = firstSet.cloneNode(true);

        // Reset clone
        const select = newSet.querySelector(".route-select select");
        if (select) {
            select.innerHTML = `<option value="">-- Pilih Rute --</option>`;
        }
        newSet.querySelector(".route-select").classList.add("hidden");

        newSet.querySelectorAll(".service-car").forEach(card => {
            card.classList.remove("selected");
            const radio = card.querySelector('input[type="radio"]');
            if (radio) radio.checked = false;
        });

        container.appendChild(newSet);
        initTransportSet(newSet, setCounter++, true); // tambahan → ada tombol hapus
    });
});
