//  const serviceTour = document.querySelectorAll(".service-tour");

//             serviceTour.forEach(tour => {
//                 tour.addEventListener("click", (event) => {
//                     event.preventDefault(); // cegah toggle radio default
//                     const typeTour = tour.getAttribute('data-tour');
//                     const detailForm = document.getElementById(`tour-${typeTour}-form`);
//                     const radioTour = tour.querySelector('input[type="checkbox"]');

//                     // toggle class selected
//                     const isSelected = tour.classList.toggle('selected');

//                     // toggle radio checked sesuai selected
//                     radioTour.checked = isSelected;

//                     // tampilkan atau sembunyikan form sesuai toggle
//                     if (detailForm) {
//                         detailForm.style.display = isSelected ? 'block' : 'none';
//                     }
//                 });
//             });

//             const tourOptions = document.querySelectorAll('.service-car');
//         const tourForms = document.querySelectorAll('.tour-form');

//         tourOptions.forEach(option => {
//             option.addEventListener('click', () => {
//                 const tourType = option.dataset.tour;

//                 // Sembunyikan semua form terlebih dahulu
//                 tourForms.forEach(form => {
//                     form.classList.add('hidden');
//                 });

//                 // Tampilkan form yang sesuai
//                 const selectedForm = document.getElementById(`tour-${tourType}-form`);
//                 if (selectedForm) {
//                     selectedForm.classList.remove('hidden');
//                 }
//             });
//         });


function setupTourSelection() {
  const tourContainer = document.querySelector('.tours');
  if (!tourContainer) {
    console.error('Tour container not found.');
    return;
  }

  // Add a click event listener to the tour container
  tourContainer.addEventListener('click', (event) => {
    // Find the closest parent with the class 'service-tour' to handle clicks anywhere on the label
    const selectedTourLabel = event.target.closest('.service-tour');
    if (!selectedTourLabel) {
      return;
    }

    const tourSlug = selectedTourLabel.dataset.tour;
    const transportFormId = `tour-${tourSlug}-form`;
    const transportForm = document.getElementById(transportFormId);

    if (transportForm) {
      // Toggle the 'hidden' class to show or hide the form
      transportForm.classList.toggle('hidden');
    }
  });
}

// Call the function when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', setupTourSelection);
