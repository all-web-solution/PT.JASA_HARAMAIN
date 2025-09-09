// // document.addEventListener("DOMContentLoaded", function () {
// //     // ======= CART ELEMENT =======
// //     const cartSection = document.querySelector("#cart-total-price");
// //     const cartItems = document.querySelector("#cart-items");
// //     const cartTotal = document.querySelector("#cart-total");
// //     const cartTotalText = document.querySelector("#cart-total-text");

// //     // ======= DATA =======
// //     let tickets = [];
// //     let hotels = [];
// //     let selectedRoutes = {};
// //     let setCounter = 0;

// //     // ======= UPDATE CART =======
// //     function updateCart() {
// //         cartItems.innerHTML = "";
// //         let total = 0;

// //         // TRANSPORTASI
// //         Object.values(selectedRoutes).forEach(item => {
// //             if(item.price > 0){
// //                 const li = document.createElement("li");
// //                 li.className = "list-group-item d-flex justify-content-between align-items-center";
// //                 li.textContent = item.routeName;
// //                 const span = document.createElement("span");
// //                 span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(item.price)}`;
// //                 li.appendChild(span);
// //                 cartItems.appendChild(li);
// //                 total += item.price;
// //             }
// //         });

// //         // TIKET PESAWAT
// //         tickets.forEach((ticket, index) => {
// //             if(ticket.price > 0){
// //                 const li = document.createElement("li");
// //                 li.className = "list-group-item d-flex justify-content-between align-items-center";
// //                 li.textContent = `Tiket x${index + 1}`;
// //                 const span = document.createElement("span");
// //                 span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(ticket.price)}`;
// //                 li.appendChild(span);
// //                 cartItems.appendChild(li);
// //                 total += ticket.price;
// //             }
// //         });

// //         // HOTEL
// //         hotels.forEach((hotel, index) => {
// //             if(hotel.price > 0){
// //                 const li = document.createElement("li");
// //                 li.className = "list-group-item d-flex justify-content-between align-items-center";
// //                 li.textContent = `Hotel x${index + 1}`;
// //                 const span = document.createElement("span");
// //                 span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(hotel.price)}`;
// //                 li.appendChild(span);
// //                 cartItems.appendChild(li);
// //                 total += hotel.price;
// //             }
// //         });

// //         // DOKUMEN
// //         const docForms = document.querySelectorAll("[id^='doc-'][id$='-form'], [id^='child-'][id$='-form']");
// //         docForms.forEach(form => {
// //             const jumlahInput = form.querySelector("input[name^='jumlah_']");
// //             const hargaInput = form.querySelector("input[name^='harga_']");
// //             if(jumlahInput && hargaInput){
// //                 const jumlah = parseInt(jumlahInput.value) || 0;
// //                 const harga = parseInt(hargaInput.value) || 0;
// //                 const subtotal = jumlah * harga;
// //                 if(subtotal > 0){
// //                     const li = document.createElement("li");
// //                     li.className = "list-group-item d-flex justify-content-between align-items-center";
// //                     li.textContent = form.querySelector("h3")?.textContent || "Dokumen";
// //                     const span = document.createElement("span");
// //                     span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
// //                     li.appendChild(span);
// //                     cartItems.appendChild(li);
// //                     total += subtotal;
// //                 }
// //             }
// //         });

// //         cartSection.style.display = total > 0 ? "block" : "none";
// //         cartTotal.value = total;
// //         cartTotalText.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(total)}`;
// //     }

// //     // ======= TRANSPORTASI =======
// //     const transportContainer = document.getElementById("new-transport-forms");

// //     function initTransportSet(set, setId) {
// //         set.dataset.setId = setId;

// //         const cars = set.querySelectorAll(".service-car");
// //         cars.forEach(car => {
// //             car.addEventListener("click", function() {
// //                 cars.forEach(c => c.classList.remove("selected"));
// //                 car.classList.add("selected");

// //                 const radio = car.querySelector("input[type='radio']");
// //                 if(radio) radio.checked = true;

// //                 const routes = JSON.parse(car.dataset.routes || "[]");
// //                 const carName = car.querySelector(".service-name").innerText.trim();

// //                 const routeWrapper = set.querySelector(".route-select");
// //                 const select = routeWrapper.querySelector("select");
// //                 select.innerHTML = `<option value="">-- Pilih Rute (${carName}) --</option>`;
// //                 routes.forEach(r => {
// //                     const opt = document.createElement("option");
// //                     opt.value = r.id;
// //                     opt.textContent = `${r.route} (Rp. ${new Intl.NumberFormat('id-ID').format(r.price)})`;
// //                     opt.dataset.price = r.price;
// //                     opt.dataset.routeName = r.route;
// //                     select.appendChild(opt);
// //                 });
// //                 routeWrapper.classList.remove("hidden");
// //                 selectedRoutes[setId] = { routeName: "", price: 0 };
// //                 updateCart();
// //             });
// //         });

// //         const routeSelect = set.querySelector(".route-select select");
// //         routeSelect.addEventListener("change", function() {
// //             const opt = routeSelect.options[routeSelect.selectedIndex];
// //             if(!opt.value){
// //                 selectedRoutes[setId] = { routeName: "", price: 0 };
// //             } else {
// //                 selectedRoutes[setId] = { routeName: opt.dataset.routeName, price: parseInt(opt.dataset.price) };
// //             }
// //             updateCart();
// //         });
// //     }

// //     transportContainer.querySelectorAll(".transport-set").forEach(set => {
// //         initTransportSet(set, setCounter++);
// //     });

// //     document.getElementById("add-transport-btn").addEventListener("click", function(){
// //         const firstSet = transportContainer.querySelector(".transport-set");
// //         const newSet = firstSet.cloneNode(true);
// //         newSet.querySelector(".route-select").classList.add("hidden");
// //         newSet.querySelector(".route-select select").innerHTML = `<option value="">-- Pilih Rute --</option>`;
// //         newSet.querySelectorAll(".service-car").forEach(c => {
// //             c.classList.remove("selected");
// //             const r = c.querySelector("input[type='radio']");
// //             if(r) r.checked = false;
// //         });
// //         transportContainer.appendChild(newSet);
// //         initTransportSet(newSet, setCounter++);
// //     });

// //     // ======= TIKET PESAWAT =======
// //     const ticketWrapper = document.getElementById("ticketWrapper");

// //     function setupTicketForm(ticketForm){
// //         const priceInput = ticketForm.querySelector("input[name='harga[]']");
// //         const index = tickets.length;
// //         tickets.push({ price: parseInt(priceInput.value) || 0 });

// //         priceInput.addEventListener("input", function(){
// //             tickets[index].price = parseInt(priceInput.value) || 0;
// //             updateCart();
// //         });

// //         ticketForm.querySelector(".removeTicket").addEventListener("click", function(){
// //             if(ticketWrapper.children.length > 1){
// //                 ticketForm.remove();
// //                 tickets.splice(index, 1);
// //                 updateCart();
// //             } else {
// //                 alert("Minimal harus ada 1 tiket!");
// //             }
// //         });
// //     }

// //     ticketWrapper.querySelectorAll(".ticket-form").forEach(form => setupTicketForm(form));

// //     document.getElementById("addTicket").addEventListener("click", function(){
// //         const newTicket = ticketWrapper.firstElementChild.cloneNode(true);
// //         newTicket.querySelectorAll("input").forEach(input => input.value = "");
// //         ticketWrapper.appendChild(newTicket);
// //         setupTicketForm(newTicket);
// //     });

// //     // ======= HOTEL =======
// //     const hotelWrapper = document.getElementById("hotelWrapper");

// //     function setupHotelForm(hotelForm){
// //         const priceInput = hotelForm.querySelector("input[name='harga_per_kamar[]']");
// //         const index = hotels.length;
// //         hotels.push({ price: parseInt(priceInput.value) || 0 });

// //         priceInput.addEventListener("input", function(){
// //             hotels[index].price = parseInt(priceInput.value) || 0;
// //             updateCart();
// //         });

// //         hotelForm.querySelector(".removeHotel").addEventListener("click", function(){
// //             if(hotelWrapper.children.length > 1){
// //                 hotelForm.remove();
// //                 hotels.splice(index, 1);
// //                 updateCart();
// //             } else {
// //                 alert("Minimal harus ada 1 hotel!");
// //             }
// //         });
// //     }

// //     hotelWrapper.querySelectorAll(".hotel-form").forEach(form => setupHotelForm(form));

// //     document.getElementById("addHotel").addEventListener("click", function(){
// //         const newHotel = hotelWrapper.firstElementChild.cloneNode(true);
// //         newHotel.querySelectorAll("input").forEach(input => input.value = "");
// //         hotelWrapper.appendChild(newHotel);
// //         setupHotelForm(newHotel);
// //     });

// //     // ======= DOKUMEN =======
// //     const documentItems = document.querySelectorAll(".document-item");
// //     const childItems = document.querySelectorAll(".child-item");

// //     function updateDocumentCart() { updateCart(); }

// //     documentItems.forEach(item => {
// //         item.addEventListener("click", function () {
// //             const checkbox = item.querySelector("input[type='checkbox']");
// //             checkbox.checked = !checkbox.checked;

// //             const docId = item.dataset.document;
// //             const formParent = document.getElementById(`doc-${docId}-details`);
// //             const singleForm = document.getElementById(`doc-${docId}-form`);

// //             if(formParent) formParent.classList.toggle("hidden", !checkbox.checked);
// //             if(singleForm) singleForm.classList.toggle("hidden", !checkbox.checked);

// //             updateDocumentCart();
// //         });
// //     });

// //     childItems.forEach(child => {
// //         child.addEventListener("click", function () {
// //             const checkbox = child.querySelector("input[type='checkbox']");
// //             checkbox.checked = !checkbox.checked;

// //             const childId = child.dataset.child;
// //             const formChild = document.getElementById(`${childId}-form`);
// //             if(formChild) formChild.classList.toggle("hidden", !checkbox.checked);

// //             updateDocumentCart();
// //         });
// //     });

// //     const docInputs = document.querySelectorAll("[id^='doc-'][id$='-form'] input, [id^='child-'][id$='-form'] input");
// //     docInputs.forEach(input => {
// //         if(input.name.startsWith("jumlah_") || input.name.startsWith("harga_")){
// //             input.addEventListener("input", updateDocumentCart);
// //         }
// //     });
// // });


// document.addEventListener("DOMContentLoaded", function() {
//     // ======= CART ELEMENT =======
//     const cartSection = document.querySelector("#cart-total-price");
//     const cartItems = document.querySelector("#cart-items");
//     const cartTotal = document.querySelector("#cart-total");
//     const cartTotalText = document.querySelector("#cart-total-text");

//     // ======= DATA =======
//     let tickets = [];
//     let hotels = [];
//     let selectedRoutes = {};
//     let setCounter = 0;
//     let pendampings = {};

//     // ======= UPDATE CART =======
//     function updateCart() {
//         cartItems.innerHTML = "";
//         let total = 0;

//         // Transportasi
//         Object.values(selectedRoutes).forEach(item => {
//             if(item.price > 0){
//                 const li = document.createElement("li");
//                 li.className = "list-group-item d-flex justify-content-between align-items-center";
//                 li.textContent = item.routeName;
//                 const span = document.createElement("span");
//                 span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(item.price)}`;
//                 li.appendChild(span);
//                 cartItems.appendChild(li);
//                 total += item.price;
//             }
//         });

//         // Tiket Pesawat
//         tickets.forEach((ticket, index) => {
//             if(ticket.price > 0){
//                 const li = document.createElement("li");
//                 li.className = "list-group-item d-flex justify-content-between align-items-center";
//                 li.textContent = `Tiket x${index + 1}`;
//                 const span = document.createElement("span");
//                 span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(ticket.price)}`;
//                 li.appendChild(span);
//                 cartItems.appendChild(li);
//                 total += ticket.price;
//             }
//         });

//         // Hotel
//         hotels.forEach((hotel, index) => {
//             if(hotel.price > 0){
//                 const li = document.createElement("li");
//                 li.className = "list-group-item d-flex justify-content-between align-items-center";
//                 li.textContent = `Hotel x${index + 1}`;
//                 const span = document.createElement("span");
//                 span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(hotel.price)}`;
//                 li.appendChild(span);
//                 cartItems.appendChild(li);
//                 total += hotel.price;
//             }
//         });

//         // Dokumen
//         const docForms = document.querySelectorAll("[id^='doc-'][id$='-form'], [id^='child-'][id$='-form']");
//         docForms.forEach(form => {
//             const jumlahInput = form.querySelector("input[name^='jumlah_']");
//             const hargaInput = form.querySelector("input[name^='harga_']");
//             if(jumlahInput && hargaInput){
//                 const jumlah = parseInt(jumlahInput.value) || 0;
//                 const harga = parseInt(hargaInput.value) || 0;
//                 const subtotal = jumlah * harga;
//                 if(subtotal > 0){
//                     const li = document.createElement("li");
//                     li.className = "list-group-item d-flex justify-content-between align-items-center";
//                     li.textContent = form.querySelector("h3")?.textContent || "Dokumen";
//                     const span = document.createElement("span");
//                     span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
//                     li.appendChild(span);
//                     cartItems.appendChild(li);
//                     total += subtotal;
//                 }
//             }
//         });

//         // Pendamping
//         Object.values(pendampings).forEach(p => {
//             if(p.jumlah && p.price){
//                 const subtotal = p.jumlah * p.price;
//                 const li = document.createElement("li");
//                 li.className = "list-group-item d-flex justify-content-between align-items-center";
//                 li.textContent = p.name;
//                 const span = document.createElement("span");
//                 span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
//                 li.appendChild(span);
//                 cartItems.appendChild(li);
//                 total += subtotal;
//             }
//         });

//         cartSection.style.display = total > 0 ? "block" : "none";
//         cartTotal.value = total;
//         cartTotalText.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(total)}`;
//     }
//     function updatePendampingCart() {
//     const pendampingForms = document.querySelectorAll(".pendamping-form");
//     pendampings = {}; // reset
//     pendampingForms.forEach(form => {
//         if(!form.classList.contains("hidden")) {
//             const jumlahInput = form.querySelector(".jumlah-pendamping");
//             const guideId = form.id.replace("form-", "");
//             const name = jumlahInput.dataset.name;
//             const price = parseInt(jumlahInput.dataset.price) || 0;
//             const jumlah = parseInt(jumlahInput.value) || 0;
//             if(jumlah > 0){
//                 pendampings[guideId] = { name, price, jumlah };
//             }
//         }
//     });
// }

//     // ======= TRANSPORTASI =======
//     const transportItems = document.querySelectorAll(".transport-item");
//     transportItems.forEach(item => {
//         item.addEventListener("click", function() {
//             const type = item.dataset.transportasi;
//             transportItems.forEach(i => i.classList.remove("selected"));
//             item.classList.add("selected");

//             const forms = document.querySelectorAll("#transportasi-details .form-group[data-transportasi]");
//             forms.forEach(f => f.style.display = f.dataset.transportasi === type ? "block" : "none");
//         });
//     });

//     // Inisialisasi default: sembunyikan semua form transportasi
//     const transportForms = document.querySelectorAll("#transportasi-details .form-group[data-transportasi]");
//     transportForms.forEach(f => f.style.display = "none");

//     // ======= TIKET PESAWAT =======
//     const ticketWrapper = document.getElementById("ticketWrapper");
//     function setupTicketForm(ticketForm){
//         const priceInput = ticketForm.querySelector("input[name='harga[]']");
//         const index = tickets.length;
//         tickets.push({ price: parseInt(priceInput.value) || 0 });

//         priceInput.addEventListener("input", function(){
//             tickets[index].price = parseInt(priceInput.value) || 0;
//             updateCart();
//             updatePendampingCart();
//         });

//         ticketForm.querySelector(".removeTicket").addEventListener("click", function(){
//             if(ticketWrapper.children.length > 1){
//                 ticketForm.remove();
//                 tickets.splice(index, 1);
//                 updateCart();
//                 updatePendampingCart()
//             } else {
//                 alert("Minimal harus ada 1 tiket!");
//             }
//         });
//     }

//     ticketWrapper.querySelectorAll(".ticket-form").forEach(form => setupTicketForm(form));

//     document.getElementById("addTicket").addEventListener("click", function(){
//         const newTicket = ticketWrapper.firstElementChild.cloneNode(true);
//         newTicket.querySelectorAll("input").forEach(input => input.value = "");
//         ticketWrapper.appendChild(newTicket);
//         setupTicketForm(newTicket);
//     });

//     // ======= HOTEL =======
//     const hotelWrapper = document.getElementById("hotelWrapper");
//     function setupHotelForm(hotelForm){
//         const priceInput = hotelForm.querySelector("input[name='harga_per_kamar[]']");
//         const index = hotels.length;
//         hotels.push({ price: parseInt(priceInput.value) || 0 });

//         priceInput.addEventListener("input", function(){
//             hotels[index].price = parseInt(priceInput.value) || 0;
//             updateCart();
//             updatePendampingCart()
//         });
//     }

//     hotelWrapper.querySelectorAll(".hotel-form").forEach(form => setupHotelForm(form));

//     document.getElementById("addHotel").addEventListener("click", function(){
//         const newHotel = hotelWrapper.firstElementChild.cloneNode(true);
//         newHotel.querySelectorAll("input").forEach(input => input.value = "");
//         hotelWrapper.appendChild(newHotel);
//         setupHotelForm(newHotel);
//     });

//     // ======= DOKUMEN =======
//     const documentItems = document.querySelectorAll(".document-item");
//     const childItems = document.querySelectorAll(".child-item");

//     documentItems.forEach(item => {
//         item.addEventListener("click", function () {
//             const checkbox = item.querySelector("input[type='checkbox']");
//             checkbox.checked = !checkbox.checked;
//             const docId = item.dataset.document;
//             const formParent = document.getElementById(`doc-${docId}-details`);
//             const singleForm = document.getElementById(`doc-${docId}-form`);
//             if(formParent) formParent.classList.toggle("hidden", !checkbox.checked);
//             if(singleForm) singleForm.classList.toggle("hidden", !checkbox.checked);
//             updateCart();
//             updatePendampingCart()
//         });
//     });

//     childItems.forEach(child => {
//         child.addEventListener("click", function () {
//             const checkbox = child.querySelector("input[type='checkbox']");
//             checkbox.checked = !checkbox.checked;
//             const childId = child.dataset.child;
//             const formChild = document.getElementById(`${childId}-form`);
//             if(formChild) formChild.classList.toggle("hidden", !checkbox.checked);
//             updateCart();
//             updatePendampingCart()
//         });
//     });

//     const docInputs = document.querySelectorAll("[id^='doc-'][id$='-form'] input, [id^='child-'][id$='-form'] input");
//     docInputs.forEach(input => {
//         if(input.name.startsWith("jumlah_") || input.name.startsWith("harga_")){
//             input.addEventListener("input", updateCart);
//         }
//     });

//     // ======= PENDAMPING =======
//     const pendampingItems = document.querySelectorAll(".pendamping-item");
//     pendampingItems.forEach(item => {
//         item.addEventListener("click", function(){
//             const guideId = item.dataset.pendamping;
//             const form = document.getElementById("form-" + guideId);
//             const checkbox = item.querySelector("input[type='checkbox']");
//             checkbox.checked = !checkbox.checked;

//             if(form) form.classList.toggle("hidden", !checkbox.checked);

//             if(checkbox.checked){
//                 const jumlahInput = form.querySelector(".jumlah-pendamping");
//                 pendampings[guideId] = {
//                     name: jumlahInput.dataset.name,
//                     price: parseInt(jumlahInput.dataset.price) || 0,
//                     jumlah: parseInt(jumlahInput.value) || 0
//                 };

//                 jumlahInput.addEventListener("input", function(){
//                     pendampings[guideId].jumlah = parseInt(jumlahInput.value) || 0;
//                     updateCart();
//                     updatePendampingCart()
//                 });
//             } else {
//                 delete pendampings[guideId];
//             }
//             updateCart();
//         });
//     });
// });


document.addEventListener("DOMContentLoaded", function() {
    const cartSection = document.querySelector("#cart-total-price");
    const cartItems = document.querySelector("#cart-items");
    const cartTotal = document.querySelector("#cart-total");
    const cartTotalText = document.querySelector("#cart-total-text");

    let tickets = [];
    let hotels = [];
    let selectedRoutes = {};
    let setCounter = 0;
    let pendampings = {};

    function updateCart() {
        cartItems.innerHTML = "";
        let total = 0;

        // ===== TRANSPORTASI =====
        Object.values(selectedRoutes).forEach(item => {
            if(item.price > 0){
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.textContent = item.routeName;
                const span = document.createElement("span");
                span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(item.price)}`;
                li.appendChild(span);
                cartItems.appendChild(li);
                total += item.price;
            }
        });

        // ===== TIKET PESAWAT =====
        tickets.forEach((ticket, index) => {
            const subtotal = parseInt(ticket.price) || 0;
            if(subtotal > 0){
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.textContent = `Tiket x${index + 1}`;
                const span = document.createElement("span");
                span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
                li.appendChild(span);
                cartItems.appendChild(li);
                total += subtotal;
            }
        });

        // ===== HOTEL =====
        hotels.forEach((hotel, index) => {
            const subtotal = parseInt(hotel.price) || 0;
            if(subtotal > 0){
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.textContent = `Hotel x${index + 1}`;
                const span = document.createElement("span");
                span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
                li.appendChild(span);
                cartItems.appendChild(li);
                total += subtotal;
            }
        });

        // ===== DOKUMEN =====
        const docForms = document.querySelectorAll("[id^='doc-'][id$='-form'], [id^='child-'][id$='-form']");
        docForms.forEach(form => {
            const jumlahInput = form.querySelector("input[name^='jumlah_']");
            const hargaInput = form.querySelector("input[name^='harga_']");
            if(jumlahInput && hargaInput){
                const jumlah = parseInt(jumlahInput.value) || 0;
                const harga = parseInt(hargaInput.value) || 0;
                const subtotal = jumlah * harga;
                if(subtotal > 0){
                    const li = document.createElement("li");
                    li.className = "list-group-item d-flex justify-content-between align-items-center";
                    li.textContent = form.querySelector("h3")?.textContent || "Dokumen";
                    const span = document.createElement("span");
                    span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
                    li.appendChild(span);
                    cartItems.appendChild(li);
                    total += subtotal;
                }
            }
        });

        // ===== PENDAMPING =====
        Object.values(pendampings).forEach(p => {
            const subtotal = (p.jumlah || 0) * (p.price || 0);
            if(subtotal > 0){
                const li = document.createElement("li");
                li.className = "list-group-item d-flex justify-content-between align-items-center";
                li.textContent = p.name;
                const span = document.createElement("span");
                span.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
                li.appendChild(span);
                cartItems.appendChild(li);
                total += subtotal;
            }
        });

        cartSection.style.display = total > 0 ? "block" : "none";
        cartTotal.value = total;
        cartTotalText.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(total)}`;
    }

    // ===== TRANSPORTASI =====
    const transportItems = document.querySelectorAll(".transport-item");
    transportItems.forEach(item => {
        item.addEventListener("click", function(){
            const type = item.dataset.transportasi;
            transportItems.forEach(i => i.classList.remove("selected"));
            item.classList.add("selected");

            const forms = document.querySelectorAll("#transportasi-details .form-group[data-transportasi]");
            forms.forEach(f => f.style.display = f.dataset.transportasi === type ? "block" : "none");

            // Reset selectedRoutes jika switch transportasi
            Object.keys(selectedRoutes).forEach(k => delete selectedRoutes[k]);
            updateCart();
        });
    });

    const transportContainer = document.getElementById("new-transport-forms");
    function initTransportSet(set, setId){
        set.dataset.setId = setId;
        const cars = set.querySelectorAll(".service-car");
        cars.forEach(car => {
            car.addEventListener("click", function(){
                cars.forEach(c => c.classList.remove("selected"));
                car.classList.add("selected");
                const radio = car.querySelector("input[type='radio']");
                if(radio) radio.checked = true;

                const routes = JSON.parse(car.dataset.routes || "[]");
                const carName = car.querySelector(".service-name").innerText.trim();

                const routeWrapper = set.querySelector(".route-select");
                const select = routeWrapper.querySelector("select");
                select.innerHTML = `<option value="">-- Pilih Rute (${carName}) --</option>`;
                routes.forEach(r => {
                    const opt = document.createElement("option");
                    opt.value = r.id;
                    opt.textContent = `${r.route} (Rp. ${new Intl.NumberFormat('id-ID').format(r.price)})`;
                    opt.dataset.price = r.price;
                    opt.dataset.routeName = r.route;
                    select.appendChild(opt);
                });
                routeWrapper.classList.remove("hidden");
                selectedRoutes[setId] = { routeName: "", price: 0 };
                updateCart();
            });
        });

        const routeSelect = set.querySelector("select");
        routeSelect.addEventListener("change", function(){
            const opt = routeSelect.options[routeSelect.selectedIndex];
            if(!opt.value){
                selectedRoutes[setId] = { routeName: "", price: 0 };
            } else {
                selectedRoutes[setId] = { routeName: opt.dataset.routeName, price: parseInt(opt.dataset.price) };
            }
            updateCart();
        });
    }

    transportContainer.querySelectorAll(".transport-set").forEach(set => initTransportSet(set, setCounter++));
    document.getElementById("add-transport-btn").addEventListener("click", function(){
        const firstSet = transportContainer.querySelector(".transport-set");
        const newSet = firstSet.cloneNode(true);
        newSet.querySelector(".route-select").classList.add("hidden");
        newSet.querySelector("select").innerHTML = `<option value="">-- Pilih Rute --</option>`;
        newSet.querySelectorAll(".service-car").forEach(c => c.classList.remove("selected"));
        transportContainer.appendChild(newSet);
        initTransportSet(newSet, setCounter++);
    });

    // ===== PENDAMPING =====
const pendampingItems = document.querySelectorAll(".pendamping-item");

pendampingItems.forEach(item => {
    const guideId = item.dataset.pendamping;
    const form = document.getElementById("form-" + guideId);
    const checkbox = item.querySelector("input[type='checkbox']");

    // Klik item hanya toggle form
    item.addEventListener("click", function(){
        checkbox.checked = !checkbox.checked;
        if(form) form.classList.toggle("hidden", !checkbox.checked);
    });

    // Event listener jumlah langsung update cart
    const jumlahInput = form.querySelector(".jumlah-pendamping");
    const name = jumlahInput.dataset.name;
    const price = parseInt(jumlahInput.dataset.price) || 0;

    jumlahInput.addEventListener("input", function(){
        const jumlah = parseInt(jumlahInput.value) || 0;
        if(jumlah > 0){
            pendampings[guideId] = { name, price, jumlah };
        } else {
            delete pendampings[guideId];
        }
        updateCart();
    });
});


    // ===== HARGA HOTEL =====
    const hotelForms = document.querySelectorAll(".hotel-form");
    hotelForms.forEach((hotelForm, index) => {
        const priceInput = hotelForm.querySelector("input[name='harga_per_kamar[]']");
        priceInput.addEventListener("input", function(){
            hotels[index] = { price: parseInt(priceInput.value) || 0 };
            updateCart();
        });
    });
});
