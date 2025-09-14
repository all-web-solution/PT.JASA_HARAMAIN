// Tunggu sampai halaman selesai dimuat sebelum menjalankan kode
document.addEventListener('DOMContentLoaded', function() {
  // Pilih semua elemen yang memiliki class 'content-item'
  const contentItems = document.querySelectorAll('.content-item');

  // Lakukan perulangan untuk setiap item konten
  contentItems.forEach(item => {
    // Tambahkan 'event listener' untuk mendeteksi klik
    item.addEventListener('click', function() {
      // Temukan formulir tersembunyi yang ada di dalam 'content-wrapper'
      const wrapper = this.closest('.content-wrapper');
      const contentForm = wrapper.querySelector('.content-form');
      const checkbox = this.querySelector('input[type="checkbox"]');

      // Periksa apakah item saat ini sudah dipilih atau belum
      const isSelected = this.classList.contains('selected');

      // Jika item belum dipilih, maka pilih dan tampilkan formulirnya
      if (!isSelected) {
        this.classList.add('selected');
        contentForm.classList.remove('hidden');
        checkbox.checked = true;
      } else { // Jika item sudah dipilih, maka batalkan pilihan dan sembunyikan formulirnya
        this.classList.remove('selected');
        contentForm.classList.add('hidden');
        checkbox.checked = false;
      }
    });
  });
});
