// cart.js
document.addEventListener('DOMContentLoaded', () => {
    const cartSection = document.getElementById('cart-total-price');
    const cartItemsEl = document.getElementById('cart-items');
    const cartTotalInput = document.getElementById('cart-total');
    const cartTotalText = document.getElementById('cart-total-text');

    const cart = {}; // key -> {label, price, qty, meta}

    const parsePrice = (v) => {
        if (v === undefined || v === null) return 0;
        if (typeof v === 'number') return v;
        return Number(String(v).replace(/[^\d.-]/g, '')) || 0;
    };
    const formatRp = (amount) => 'Rp. ' + new Intl.NumberFormat('id-ID').format(amount || 0);

    const updateCartUI = () => {
        cartItemsEl.innerHTML = '';
        let total = 0;
        Object.entries(cart).forEach(([key, item]) => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            const left = document.createElement('div');
            left.innerHTML = `<div><strong>${item.label}</strong></div>
                              <div style="font-size:.9em;color:#6b7280">${item.meta || ''}</div>`;
            const right = document.createElement('div');
            const subtotal = Math.round(item.price * item.qty);
            right.innerHTML = `<div style="text-align:right">${formatRp(subtotal)}</div>
                               <div style="font-size:.85em;color:#6b7280">x ${item.qty}</div>`;
            li.appendChild(left);
            li.appendChild(right);
            cartItemsEl.appendChild(li);
            total += subtotal;
        });
        cartTotalInput.value = total;
        cartTotalText.textContent = formatRp(total);
        cartSection.style.display = Object.keys(cart).length > 0 ? '' : 'none';
    };

    const addCartItem = (key, label, price, qty = 1, meta = '') => {
        qty = Number(qty) || 1;
        price = parsePrice(price);
        cart[key] = { label, price, qty, meta };
        updateCartUI();
    };
    const removeCartItem = (key) => {
        if (cart[key]) {
            delete cart[key];
            updateCartUI();
        }
    };

    // --- GENERIC ITEM HANDLER ---
    const initItemHandler = (selector, keyPrefix, getLabelFromEl = el => el.querySelector('.service-name')?.textContent || keyPrefix) => {
        document.querySelectorAll(selector).forEach(el => {
            const hiddenCheckbox = el.querySelector("input[type='checkbox']");
            const dataId = el.dataset.id || Math.random().toString(36).slice(2,9);
            const key = `${keyPrefix}-${dataId}`;

            el.addEventListener('click', (e) => {
                e.preventDefault();
                const isSelected = el.classList.contains('selected');
                if (isSelected) {
                    el.classList.remove('selected');
                    if (hiddenCheckbox) hiddenCheckbox.checked = false;
                    removeCartItem(key);
                    const form = document.getElementById(el.dataset.target || `form-${dataId}`);
                    if (form) form.classList.add('hidden');
                } else {
                    el.classList.add('selected');
                    if (hiddenCheckbox) hiddenCheckbox.checked = true;
                    const label = getLabelFromEl(el);
                    const price = parsePrice(el.dataset.price || 0);
                    addCartItem(key, label, price, 1);
                    const form = document.getElementById(el.dataset.target || `form-${dataId}`);
                    if (form) form.classList.remove('hidden');
                }
            });
        });
    };

    // --- Pendamping ---
    const pendampings = {};
    initItemHandler('.pendamping-item', 'pendamping', el => {
        const name = el.querySelector('.service-name')?.textContent || 'Pendamping';
        const price = parsePrice(el.dataset.price);
        return `${name} (${formatRp(price)})`;
    });
    document.querySelectorAll('.jumlah-pendamping').forEach(input => {
        const id = input.dataset.id;
        input.addEventListener('input', () => {
            const qty = Number(input.value) || 0;
            const name = input.dataset.name;
            const price = parsePrice(input.dataset.price);
            const key = `pendamping-${id}`;
            if (qty <= 0) {
                delete pendampings[id];
                removeCartItem(key);
            } else {
                pendampings[id] = { name, price, qty };
                addCartItem(key, name, price, qty);
            }
        });
    });

    // --- Content ---
    initItemHandler('.content-item', 'content', el => {
        const name = el.querySelector('.service-name')?.textContent || 'Content';
        const price = parsePrice(el.dataset.price);
        return `${name} (${formatRp(price)})`;
    });
    document.querySelectorAll('.content-form input[type="number"]').forEach(input => {
        const id = input.dataset.id;
        input.addEventListener('input', () => {
            const qty = Number(input.value) || 0;
            const price = parsePrice(input.dataset.price);
            const name = input.dataset.name || 'Content';
            const key = `content-${id}`;
            if (qty <= 0) removeCartItem(key);
            else addCartItem(key, name, price, qty);
        });
    });

    // --- Meal ---
    initItemHandler('.meal-item', 'meal', el => {
        const name = el.querySelector('.service-name')?.textContent || 'Meal';
        const price = parsePrice(el.dataset.price);
        return `${name} (${formatRp(price)})`;
    });
    document.querySelectorAll('.jumlah-meal').forEach(input => {
        const slug = input.dataset.slug;
        input.addEventListener('input', () => {
            const qty = Number(input.value) || 0;
            const price = parsePrice(input.dataset.price);
            const name = input.dataset.name || 'Meal';
            const key = `meal-${slug}`;
            if (qty <= 0) removeCartItem(key);
            else addCartItem(key, name, price, qty);
        });
    });

    // --- Dorongan ---
    initItemHandler('.dorongan-item', 'dorongan', el => {
        const name = el.querySelector('.service-name')?.textContent || 'Dorongan';
        const price = parsePrice(el.dataset.price);
        return `${name} (${formatRp(price)})`;
    });
    document.querySelectorAll('.jumlah-dorongan').forEach(input => {
        const id = input.dataset.id;
        input.addEventListener('input', () => {
            const qty = Number(input.value) || 0;
            const price = parsePrice(input.dataset.price);
            const name = input.dataset.name || 'Dorongan';
            const key = `dorongan-${id}`;
            if (qty <= 0) removeCartItem(key);
            else addCartItem(key, name, price, qty);
        });
    });

    // --- Wakaf ---
    initItemHandler('.wakaf-item', 'wakaf', el => {
        const name = el.querySelector('.service-name')?.textContent || 'Wakaf';
        const price = parsePrice(el.querySelector('.service-desc')?.textContent || el.dataset.price);
        return `${name} (${formatRp(price)})`;
    });
    document.querySelectorAll('.wakaf-form input[type="number"]').forEach(input => {
        const id = input.dataset.id;
        input.addEventListener('input', () => {
            const qty = Number(input.value) || 0;
            const price = parsePrice(input.dataset.price);
            const name = input.dataset.name || 'Wakaf';
            const key = `wakaf-${id}`;
            if (qty <= 0) removeCartItem(key);
            else addCartItem(key, name, price, qty);
        });
    });

    // --- Badal ---
    initItemHandler('.badal-item', 'badal', el => {
        const name = el.querySelector('.service-name')?.textContent || 'Badal';
        const price = parsePrice(el.dataset.price);
        return `${name} (${formatRp(price)})`;
    });
    document.querySelectorAll('.badal-form').forEach(form => {
        const nameInput = form.querySelector("input[name='nama_badal[]']");
        const priceInput = form.querySelector("input[name='harga_badal[]']");
        const key = `badal-${Math.random().toString(36).slice(2,9)}`;
        function updateBadalCart() {
            const name = nameInput.value || 'Badal';
            const price = parsePrice(priceInput.value);
            if (!price) removeCartItem(key);
            else addCartItem(key, name, price, 1);
        }
        nameInput.addEventListener('input', updateBadalCart);
        priceInput.addEventListener('input', updateBadalCart);
    });

    // --- Tour + Transport ---
    initItemHandler('.service-tour', 'tour', el => el.querySelector('.service-name')?.textContent || 'Tour');
    document.querySelectorAll('.tour-transport select').forEach(sel => {
        sel.addEventListener('change', () => {
            const key = sel.dataset.key;
            const option = sel.options[sel.selectedIndex];
            if (!option.value) removeCartItem(key);
            else {
                const price = parsePrice(option.dataset.price);
                const name = option.dataset.routeName || 'Tour';
                addCartItem(key, name, price, 1);
            }
        });
    });

    // --- Tickets ---
    document.querySelectorAll('.ticket-input').forEach((input, idx) => {
        input.addEventListener('input', () => {
            const price = parsePrice(input.value);
            const key = `ticket-${idx}`;
            if (!price) removeCartItem(key);
            else addCartItem(key, `Tiket ${idx+1}`, price, 1);
        });
    });

    // --- Hotels ---
    document.querySelectorAll('.hotel-input').forEach((input, idx) => {
        input.addEventListener('input', () => {
            const price = parsePrice(input.value);
            const key = `hotel-${idx}`;
            if (!price) removeCartItem(key);
            else addCartItem(key, `Hotel ${idx+1}`, price, 1);
        });
    });

    // --- Dokumen ---
    document.querySelectorAll('.doc-form input').forEach(input => {
        input.addEventListener('input', () => {
            const jumlah = parseInt(input.dataset.jumlah) || 1;
            const price = parsePrice(input.dataset.price);
            const name = input.dataset.name || 'Dokumen';
            const key = `doc-${input.dataset.id}`;
            addCartItem(key, name, price, jumlah);
        });
    });

    updateCartUI();
});
