# Praktikum Modul 1 - Rena Fiantina / 251511028

## Ringkasan halaman

Halaman yang dibuat merupakan halaman Profil Mahasiswa menggunakan HTML dan CSS. Halaman terdiri dari header, navigasi, konten utama yang berisi informasi tentang mahasiswa, keterampilan, kontak, serta footer. Struktur HTML menggunakan elemen semantik seperti header, nav, main, section, dan footer. CSS ditempatkan pada file eksternal dan digunakan untuk mengatur tampilan, spacing, komponen card, serta responsive layout.

## Masalah, diagnosis, dan perbaikan

Salah satu masalah yang ditemukan adalah gambar profil tidak tampil ketika path gambar belum sesuai dengan lokasi file. Masalah diperiksa dengan melihat tampilan halaman dan kemudian diperbaiki dengan memastikan path `assets/profile.jpg` sesuai dengan struktur folder proyek.

## Hasil pengujian empat viewport

- 320px: card tersusun vertikal
- 375px: card tersusun vertikal
- 768px: card sudah menjadi satu baris
- 1024px: card sudah menjadi satu baris

Hasil pengujian digunakan untuk memastikan layout tetap terbaca dan tidak mengalami horizontal overflow.

## Refleksi belajar

Saya belajar bahwa perubahan struktur HTML dan CSS dapat memengaruhi tampilan halaman secara langsung. Kesalahan pada path gambar juga membantu saya memahami bahwa halaman yang terlihat benar belum tentu berhasil dimuat. Saya juga menjadi lebih memahami penggunaan Flexbox, box model, class reusable. Bagian yang masih perlu ditingkatkan adalah kemampuan menganalisis masalah CSS melalui DevTools secara mandiri, terutama ketika beberapa aturan CSS saling memengaruhi. Ke depannya saya perlu lebih terbiasa membaca computed style dan box model sebelum mengubah kode.

## Log AI atau sumber bantuan

AI digunakan sebagai bantuan pada tahap yang diizinkan untuk memahami konsep dan mengecek langkah pengerjaan. Setiap saran dibandingkan dengan hasil pada browser, DevTools, dan validator. Perubahan akhir pada HTML dan CSS dilakukan dan diperiksa kembali secara mandiri.