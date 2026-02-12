## Prodexa - Sistem Manajemen Produk

### Deskripsi

**Prodexa** adalah aplikasi manajemen inventaris produk berbasis web yang dikembangkan menggunakan PHP Native dengan arsitektur **MVC**.

---

### Struktur Proyek

Struktur folder dikembangkan untuk memisahkan backend, frontend, dan akses publik:

```
Prodexa/
├── app/                        
│   ├── Config/                 
│   │   └── Database.php
│   ├── Controllers/            
│   │   └── ApiController.php
│   ├── Models/                 
│   │   └── ProductModel.php
│   ├── Services/               
│   │   └── UploadService.php
│   └── Views/                  
│       ├── components/
│       ├── layouts/
│       └── pages/
│
├── public/                     
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   ├── uploads/                
│   ├── api.php                 
│   └── index.php               
│
├── .env                        
└── .gitignore
```

---

### Instalasi & Menjalankan Proyek

#### 1️⃣ Clone Repositori

```
git clone https://github.com/nurfihsn/Prodexa.git
cd prodexa
```

#### 2️⃣ Konfigurasi Database

Buat database baru, misalnya `database`, lalu jalankan query berikut:

```
CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(255) NOT NULL,
    harga DECIMAL(15, 2) NOT NULL,
    stok INT NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### 3️⃣ Konfigurasi Environment

Buat file `.env`, lalu isi dengan kredensial database:

```
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=PHP
DB_USERNAME=root
DB_PASSWORD=
```

#### 4️⃣ Menjalankan Aplikasi

Gunakan server PHP seperti XAMPP/Laragon.

**Akses melalui browser:**

```
http://localhost
```

---

**Prodexa - Simple, Modular, Efficient Product Management**
