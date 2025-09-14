// document.addEventListener('DOMContentLoaded', function() {
//     // Ambil semua item dokumen, baik parent maupun child
//     const documentItems = document.querySelectorAll('.document-item');
//     const childItems = document.querySelectorAll('.child-item');

//     // Tangani klik pada item dokumen utama (parent)
//     documentItems.forEach(item => {
//         item.addEventListener('click', function() {
//             const documentId = this.getAttribute('data-document');

//             // Cari form yang sesuai, bisa form group untuk child atau form tunggal
//             const formContainer = document.querySelector(`#doc-${documentId}-details, #doc-${documentId}-form`);
//             const checkbox = this.querySelector('input[type="checkbox"]');

//             if (formContainer) {
//                 // Tampilkan atau sembunyikan form dan ubah status checkbox
//                 if (formContainer.classList.contains('hidden')) {
//                     formContainer.classList.remove('hidden');
//                     checkbox.checked = true;
//                     this.classList.add('active');
//                 } else {
//                     formContainer.classList.add('hidden');
//                     checkbox.checked = false;
//                     this.classList.remove('active');
//                 }
//             }
//         });
//     });

//     // Tangani klik pada item dokumen anak (child)
//     childItems.forEach(item => {
//         item.addEventListener('click', function(event) {
//             // Hentikan "gelembung" event agar klik child tidak memicu event parent
//             event.stopPropagation();

//             const childId = this.getAttribute('data-child');
//             const childForm = document.querySelector(`#${childId}-form`);
//             const checkbox = this.querySelector('input[type="checkbox"]');

//             if (childForm) {
//                 // Tampilkan atau sembunyikan form anak dan ubah status checkbox
//                 if (childForm.classList.contains('hidden')) {
//                     childForm.classList.remove('hidden');
//                     checkbox.checked = true;
//                     this.classList.add('active');
//                 } else {
//                     childForm.classList.add('hidden');
//                     checkbox.checked = false;
//                     this.classList.remove('active');
//                 }
//             }
//         });
//     });
// });


document.addEventListener('DOMContentLoaded', function() {
    // Select all elements with the class 'document-item'
    const handlingItems = document.querySelectorAll('.document-item');

    // Loop through each item to add a click event listener
    handlingItems.forEach(item => {
        item.addEventListener('click', function() {
            // Get the value of the 'data-handling' attribute
            const handlingType = this.dataset.handling;

            // Find the form group that matches the data-handling attribute
            const formGroup = document.querySelector(`.form-group[data-handling="${handlingType}"]`);

            // Find the hidden checkbox within the clicked item
            const checkbox = this.querySelector('input[type="checkbox"]');

            // Check if the form group and checkbox exist
            if (formGroup && checkbox) {
                // Toggle the display style of the form group
                if (formGroup.style.display === 'none' || formGroup.style.display === '') {
                    formGroup.style.display = 'block';
                    checkbox.checked = true; // Check the checkbox
                } else {
                    formGroup.style.display = 'none';
                    checkbox.checked = false; // Uncheck the checkbox
                }
            }
        });
    });
});
