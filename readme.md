<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## BonusHub

BonusHub adalah sebuah platform atau aplikasi yang dirancang untuk membantu perusahaan dalam mengelola dan mengatur sistem bonus bagi karyawan. Dengan BonusHub, pengelolaan bonus menjadi lebih efisien dan terorganisir, memungkinkan perusahaan untuk memberikan penghargaan kepada karyawan berdasarkan kinerja mereka.

## Instalasi

Setelah Anda berhasil mengkloning repositori proyek ini, langkah pertama yang perlu dilakukan adalah menjalankan seeder untuk pertama kalinya. Proses ini penting untuk menambahkan data awal ke dalam database, termasuk akun admin yang akan memiliki hak akses penuh terhadap aplikasi, serta data karyawan yang diperlukan untuk pengujian dan pengelolaan lebih lanjut.

Seeder ini akan menjalankan dua tugas utama:

Menambahkan Data User: Anda perlu menjalankan perintah berikut untuk menambahkan data pengguna awal, termasuk akun admin yang memiliki akses penuh terhadap aplikasi:

php artisan db:seed --class=UserSeeder

Perintah ini akan menambahkan akun pengguna (termasuk admin) ke dalam tabel users di database.

Menambahkan Data Karyawan: Setelah menambahkan data pengguna, Anda perlu menjalankan perintah berikut untuk menambahkan data karyawan:

php artisan db:seed --class=EmployeeSeeder

Perintah ini akan menyisipkan data karyawan ke dalam tabel employees, yang diperlukan untuk pengelolaan dan pengujian lebih lanjut dalam aplikasi.

Setelah kedua perintah tersebut dijalankan, database Anda akan terisi dengan data pengguna dan karyawan yang relevan, memastikan aplikasi siap untuk digunakan dengan data yang valid dan sesuai kebutuhan.

## Catatan

User yang mendaftar melalui formulir registrasi akan otomatis diberikan role regular, yang membatasi akses mereka ke fitur-fitur tertentu dalam aplikasi.

