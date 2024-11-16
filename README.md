## About

Techstack : Laravel, Bootstrap, MySQL

## Requirement

PHP >= 8.2

## Install

- Clone repositori ini ke web server
- Buat database MySQL
- Edit file .env dengan mengupdate nama, username, dan password database
- Jalankan perintah ini pada terminal : php artisan optimize
- Jika default versi php pada server < 8.2, ubah terlebih ke 8.2 dan jalankan perintah di atas
- Jalankan migrasi dan seeder : php artisan migrate --seed
- Ubah kembali versi php ke default
- Selesai
