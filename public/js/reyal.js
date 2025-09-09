const cardTamis = document.getElementById("card-tamis");
const cardTumis = document.getElementById("card-tumis");
const formTamis = document.getElementById("form-tamis");
const formTumis = document.getElementById("form-tumis");
const radioTamis = document.getElementById("radio-tamis");
const radioTumis = document.getElementById("radio-tumis");

// Klik card Tamis
cardTamis.addEventListener("click", () => {
    formTamis.style.display = "block";
    formTumis.style.display = "none";
    radioTamis.checked = true;
});

// Klik card Tumis
cardTumis.addEventListener("click", () => {
    formTumis.style.display = "block";
    formTamis.style.display = "none";
    radioTumis.checked = true;
});

// Input Tamis (Rupiah -> Reyal)
document.querySelectorAll("#rupiah-tamis, #kurs-tamis").forEach(input => {
    input.addEventListener("input", () => {
        const rupiah = parseFloat(document.getElementById("rupiah-tamis").value) || 0;
        const kurs = parseFloat(document.getElementById("kurs-tamis").value) || 0;
        const hasil = kurs > 0 ? (rupiah / kurs) : 0;
        document.getElementById("hasil-tamis").value = hasil.toFixed(2);
    });
});

// Input Tumis (Reyal -> Rupiah)
document.querySelectorAll("#reyal-tumis, #kurs-tumis").forEach(input => {
    input.addEventListener("input", () => {
        const reyal = parseFloat(document.getElementById("reyal-tumis").value) || 0;
        const kurs = parseFloat(document.getElementById("kurs-tumis").value) || 0;
        const hasil = reyal * kurs;
        document.getElementById("hasil-tumis").value = hasil.toFixed(2);
    });
});
