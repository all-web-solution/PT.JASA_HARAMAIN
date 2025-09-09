 const serviceTour = document.querySelectorAll(".service-tour");

            serviceTour.forEach(tour => {
                tour.addEventListener("click", (event) => {
                    event.preventDefault(); // cegah toggle radio default
                    const typeTour = tour.getAttribute('data-tour');
                    const detailForm = document.getElementById(`tour-${typeTour}-form`);
                    const radioTour = tour.querySelector('input[type="checkbox"]');

                    // toggle class selected
                    const isSelected = tour.classList.toggle('selected');

                    // toggle radio checked sesuai selected
                    radioTour.checked = isSelected;

                    // tampilkan atau sembunyikan form sesuai toggle
                    if (detailForm) {
                        detailForm.style.display = isSelected ? 'block' : 'none';
                    }
                });
            });

            const tourOptions = document.querySelectorAll('.service-car');
        const tourForms = document.querySelectorAll('.tour-form');

        tourOptions.forEach(option => {
            option.addEventListener('click', () => {
                const tourType = option.dataset.tour;

                // Sembunyikan semua form terlebih dahulu
                tourForms.forEach(form => {
                    form.classList.add('hidden');
                });

                // Tampilkan form yang sesuai
                const selectedForm = document.getElementById(`tour-${tourType}-form`);
                if (selectedForm) {
                    selectedForm.classList.remove('hidden');
                }
            });
        });
