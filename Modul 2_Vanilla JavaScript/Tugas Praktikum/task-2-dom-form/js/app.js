'use strict';

const peserta = [
  { id: 1, nama: 'Alya', prodi: 'Teknik Informatika' },
  { id: 2, nama: 'Bima', prodi: 'Sistem Informasi' },
];

const form = document.querySelector('#form-peserta');
const namaInput = document.querySelector('#nama');
const prodiInput = document.querySelector('#prodi');
const filterInput = document.querySelector('#filter-prodi');
const daftar = document.querySelector('#daftar-peserta');
const status = document.querySelector('#status');
const errorNama = document.querySelector('#error-nama');
const errorProdi = document.querySelector('#error-prodi');

function validasiPeserta(calon) {
  const nama = calon.nama.trim();

  const errorNama =
    nama.length < 3
      ? 'Nama minimal 3 karakter.'
      : '';

  const errorProdi =
    calon.prodi === ''
      ? 'Program studi wajib dipilih.'
      : '';

  return {
    valid: errorNama === '' && errorProdi === '',
    errorNama,
    errorProdi
  };
}

function buatKartuPeserta(item) {
  const article = document.createElement('article');
  const judul = document.createElement('h2');
  const prodi = document.createElement('p');

  judul.textContent = item.nama;
  prodi.textContent = item.prodi;

  article.classList.add('kartu');
  article.append(judul, prodi);

  return article;
}

function renderPeserta(data) {
  daftar.replaceChildren();

  if (data.length === 0) {
    const pesan = document.createElement('p');
    pesan.textContent = 'Tidak ada peserta';
    daftar.append(pesan);
    return;
  }

  data.forEach((item) => {
    daftar.append(buatKartuPeserta(item));
  });
}

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const calon = {
    nama: namaInput.value,
    prodi: prodiInput.value
  };

  const hasilValidasi = validasiPeserta(calon);

  namaInput.setAttribute(
    'aria-invalid',
    hasilValidasi.errorNama !== '' ? 'true' : 'false'
  );

  prodiInput.setAttribute(
    'aria-invalid',
    hasilValidasi.errorProdi !== '' ? 'true' : 'false'
  );

  errorNama.textContent = hasilValidasi.errorNama;
  errorProdi.textContent = hasilValidasi.errorProdi;

  if (!hasilValidasi.valid) {
    return;
  }

const pesertaBaru = {
  id: Date.now(),
  nama: calon.nama.trim(),
  prodi: calon.prodi
};

peserta.push(pesertaBaru);

form.reset();

namaInput.setAttribute('aria-invalid', 'false');
prodiInput.setAttribute('aria-invalid', 'false');

errorNama.textContent = '';
errorProdi.textContent = '';

renderPeserta(peserta);
});

filterInput.addEventListener('change', () => {
  const pilihan = filterInput.value;

  const hasilFilter =
    pilihan === 'semua'
      ? peserta
      : peserta.filter((item) => item.prodi === pilihan);

  renderPeserta(hasilFilter);
});

renderPeserta(peserta);