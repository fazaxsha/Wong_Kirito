# Dokumen Spesifikasi Perangkat Lunak & Arsitektur
## Wong_Kirito - Live Crypto Price Tracker

**Pengembang:** Fajar Ilham Arifiyanto  
**Program Studi:** Sistem Informasi, Universitas Jember (Fasilkom UNEJ)  
**Tujuan Dokumen:** Perancangan implementasi Web Application berbasis AJAX (Tugas Opsional / Poin Keaktifan)  
**Tenggat Waktu:** Rabu, 27 Mei 2026  

---

### 1. Deskripsi Umum Sistem
**Wong_Kirito** adalah aplikasi *Single Page Application* (SPA) berbasis web yang dirancang untuk memantau pergerakan harga aset kripto secara *real-time*. Sistem ini dititikberatkan pada interaktivitas antarmuka tanpa perlu memuat ulang halaman (*page reload*), menggunakan teknologi AJAX (Asynchronous JavaScript and XML) yang diintegrasikan dengan arsitektur MVC (Model-View-Controller) dari framework Laravel.

Aplikasi ini menggunakan pendekatan antarmuka **Bento Box UI**—sebuah metode penyusunan tata letak berbasis *grid* yang mengisolasi informasi (seperti form pencarian, indikator harga utama, persentase 24 jam, dan pembaruan waktu) ke dalam kompartemen-kompartemen visual bersudut membulat (*rounded corners*).

---

### 2. System Requirements (Kebutuhan Sistem)

#### 2.1. Kebutuhan Perangkat Keras (Hardware)
Sistem ini cukup ringan dan tidak memerlukan spesifikasi server tingkat tinggi.
*   **Lingkungan Pengembangan (Development):** PC/Laptop dengan RAM minimal 4GB dan prosesor dual-core.
*   **Lingkungan Produksi/Deployment (Local Hosting):** Sangat dimungkinkan untuk dijalankan pada arsitektur ARM, seperti *homelab cluster* menggunakan Set-Top Box (STB) seri HG680P atau B860H.

#### 2.2. Kebutuhan Perangkat Lunak (Software / Tech Stack)
*   **Sistem Operasi:** Windows, macOS, atau distribusi Linux (Ubuntu/Arch/Armbian untuk server STB).
*   **Library Frontend:** Tailwind CSS (via CDN untuk *styling* antarmuka).
*   **Dependensi Manajer:** Composer (untuk *package* PHP).
*   **Web Server:** Built-in Laravel server (`php artisan serve`), Nginx, atau Apache.

---

### 3. Kebutuhan Fungsional (Functional Requirements)

1.  **Sistem Pencarian Live (Debounce Logic):** Sistem harus mampu menangkap input pengetikan simbol koin (misal: BTC) dari pengguna dan mengirimkan permintaan AJAX secara otomatis dengan jeda tunggu (debounce) selama 500 milidetik setelah pengetikan terakhir.
2.  **Pemanggilan Data Eksternal (API Proxying):** Sistem *backend* Laravel harus bertindak sebagai perantara (*proxy*) yang mengambil data dari *endpoint* publik Binance API (`https://api.binance.com/api/v3/ticker/24hr`) untuk mencegah *Cross-Origin Resource Sharing* (CORS) *issues* dan menyembunyikan logika pengambilan data dari sisi klien.
3.  **Pembaruan Otomatis (AJAX Polling):** Sistem *frontend* harus mampu melakukan pembaruan data harga secara mandiri (*background fetching*) setiap 5 detik melalui `setInterval()` tanpa intervensi pengguna.
4.  **Indikator Visual Pergerakan Harga (Flash Indicator):** Sistem harus mampu menyimpan memori harga sebelumnya dan membandingkannya dengan harga terbaru. 
    *   Jika harga naik -> Teks berubah menjadi warna *Emerald/Hijau*.
    *   Jika harga turun -> Teks berubah menjadi warna *Rose/Merah*.

---

### 4. Arsitektur Komunikasi Data (AJAX - MVC Flow)

Alur komunikasi data dirancang untuk menjaga keamanan menggunakan token CSRF:
1.  **Client (Browser):** Pengguna berinteraksi dengan DOM. Vanilla JS (Fetch API) men- *trigger* *request* `POST` asinkron.
2.  **Routing (Laravel):** `routes/web.php` menerima *request* pada *endpoint* `/ajax/get-coin-price` dan memverifikasi token CSRF.
3.  **Controller (Laravel):** `CoinController` memvalidasi input. Jika valid, Controller melakukan HTTP GET *request* ke server Binance.
4.  **External Service:** Binance API merespons dengan data JSON (harga, persentase naik/turun).
5.  **Response Handling:** `CoinController` memformat ulang data tersebut menjadi struktur JSON yang lebih rapi dan mengembalikannya ke *Client*.
6.  **Client Rendering:** JavaScript mem- *parsing* JSON dan memodifikasi *Document Object Model* (DOM) secara *on-the-fly* tanpa *reload* halaman.

---

### 5. Rencana Pengujian (Testing Scenario)
*   **Skenario 1 (Input Valid):** Memasukkan koin "SOL". **Ekspektasi:** Data harga Solana muncul dalam waktu kurang dari 2 detik dan harga berkedip memperbarui diri setiap 5 detik.
*   **Skenario 2 (Input Tidak Valid):** Memasukkan "ASDFG". **Ekspektasi:** Sistem AJAX menangkap error 404 dari Controller dan menampilkan pesan "Token tidak ditemukan" berwarna merah di layar, tanpa merusak tata letak *Bento Box*.
*   **Skenario 3 (Anti-Spam):** Mengetik "ETHEREUM" dengan sangat cepat. **Ekspektasi:** Sistem tidak mengirimkan 8 *request* berbeda ke server, melainkan hanya 1 *request* setelah pengguna selesai mengetik huruf "M" (efek dari fungsi *Debounce*).
