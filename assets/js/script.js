// Untuk Kategori (hanya satu yang bisa dipilih)
document.querySelectorAll(".category-btn").forEach(function (button) {
  button.addEventListener("click", function () {
    // Hapus active dari semua tombol
    document.querySelectorAll(".category-btn").forEach(function (btn) {
      btn.classList.remove("active");
    });
    // Tambahkan active ke tombol yang dipilih
    this.classList.add("active");
    // Simpan ID kategori yang dipilih ke input tersembunyi
    document.getElementById("selected-category").value =
      this.getAttribute("data-category-id");
  });
});

// Untuk Tags (bisa memilih lebih dari satu)
document.querySelectorAll(".tag-btn").forEach(function (button) {
  button.addEventListener("click", function () {
    this.classList.toggle("active");
  });
});
