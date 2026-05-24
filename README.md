# 🚀 Wong Kirito - Live Crypto Tracker

> Platform khusus bagi yang sedang fokus Kiripto ( •̀ ω •́ )✧

Wong Kirito adalah *Single Page Application* (SPA) interaktif yang dibangun menggunakan **Laravel** dan **Vanilla JS** untuk memantau pergerakan harga aset kripto secara *real-time*. 

Proyek ini sangat menitikberatkan pada manipulasi DOM tanpa memuat ulang halaman (*page reload*), menggunakan teknik AJAX *polling* untuk menyajikan harga paling *update* dari proxy **Binance API**. Tampilannya dirancang dengan tata letak *Bento Box UI* premium yang dikemas dengan kombinasi warna tajam dan *layout* yang bersih.

---

## ✨ Fitur Unggulan

- **AJAX Background Polling:** Memperbarui data harga secara otomatis setiap 5 detik di latar belakang.
- **Smart Debounce Search:** Memiliki *delay* 500ms saat mengetik untuk mencegah *spam request* ke server, membuat aplikasi terasa lebih ringan dan pintar.
- **Live Flash Indicator:** Harga akan memberikan efek kilatan hijau saat naik, dan kilatan merah saat turun—memberikan sensasi layaknya *dashboard* *trading* profesional.
- **Secure API Proxy:** *Controller* Laravel bertindak sebagai jembatan (*proxy*) untuk mengambil data dari Binance API, sehingga sisi *frontend* terhindar dari pemblokiran CORS.

## 🛠️ Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** HTML5 & Vanilla JavaScript (Fetch API)
- **Styling:** Tailwind CSS
- **Data Source:** [Binance Public API](https://github.com/binance/binance-spot-api-docs)

---

## 💻 Cara Instalasi & Menjalankan (Local Setup)

Proyek ini sangat ringan dan bahkan tidak memerlukan setup *database*. Ikuti langkah sederhana ini untuk menjalankannya di laptop/PC kamu:

1. **Clone repository ini**
   ```bash
   git clone https://github.com/username-kamu/Wong_Kirito.git
   cd Wong_Kirito
   ```

2. **Install dependensi Composer**
   Pastikan kamu sudah menginstal Composer di komputermu, lalu jalankan:
   ```bash
   composer install
   ```

3. **Atur file Environment (.env)**
   Copy file `.env.example` bawaan menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Lalu *generate* *app key* Laravel:
   ```bash
   php artisan key:generate
   ```

4. **Nyalakan Server Lokal**
   Gunakan server bawaan artisan untuk mulai menjalankan aplikasi:
   ```bash
   php artisan serve
   ```

5. **Let's Go! 📈**
   Buka browser favoritmu dan akses: `http://127.0.0.1:8000`. Coba ketik "BTC" atau "SOL" dan lihat *magic*-nya!

---

## 👨‍💻 Pengembang

**Fajar Ilham Arifiyanto**  
Sistem Informasi - Universitas Jember (Fasilkom UNEJ)

> *Proyek ini dibuat sebagai implementasi praktis arsitektur MVC & AJAX untuk pemenuhan Tugas Opsional / Poin Keaktifan.*
