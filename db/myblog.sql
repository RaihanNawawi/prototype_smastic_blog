-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Sep 2025 pada 09.35
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myblog`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(12, 'Tech'),
(13, 'Artificial Intelligense'),
(14, 'Carrier'),
(15, 'Lifestyle'),
(17, 'Laravel');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL COMMENT 'FK dari tabel posts',
  `user_id` int(11) NOT NULL COMMENT 'FK tabel users',
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `created_at`) VALUES
(7, 114, 16, 'halo', '2025-03-16 03:12:54'),
(8, 114, 18, 'halo', '2025-09-21 07:20:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `interactions`
--

CREATE TABLE `interactions` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `interaction_type` enum('like','dislike','save') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `interactions`
--

INSERT INTO `interactions` (`id`, `post_id`, `user_id`, `interaction_type`, `created_at`) VALUES
(203, 114, 1, 'like', '2024-10-25 15:09:00'),
(204, 114, 1, 'save', '2024-10-25 15:09:01'),
(205, 113, 1, 'like', '2024-10-25 15:10:27'),
(206, 113, 1, 'save', '2024-10-25 15:10:28'),
(238, 100, 1, 'like', '2025-02-13 15:47:47'),
(240, 113, 15, 'like', '2025-02-17 07:26:59'),
(241, 113, 15, 'save', '2025-02-17 07:27:01'),
(243, 114, 16, 'save', '2025-02-20 15:19:54'),
(246, 34, 16, 'like', '2025-02-23 07:34:57'),
(252, 114, 17, 'like', '2025-02-25 14:37:00'),
(254, 114, 17, 'save', '2025-02-25 14:37:27'),
(255, 81, 17, 'like', '2025-02-27 10:30:44'),
(256, 81, 17, 'save', '2025-02-27 10:32:16'),
(257, 114, 16, 'dislike', '2025-03-16 03:13:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `posts`
--

CREATE TABLE `posts` (
  `id_post` int(11) NOT NULL,
  `tittle` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT 'FK dari tabel categories',
  `tag_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL COMMENT 'FK dari tabel users',
  `images` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `posts`
--

INSERT INTO `posts` (`id_post`, `tittle`, `content`, `slug`, `category_id`, `tag_id`, `author_id`, `images`, `created_at`, `updated_at`) VALUES
(1, 'There\\\\\\\'s an AI for That: Panduan Alat AI untuk Segala Kebutuhan', '<p><strong>There\'s an AI for That: Panduan Alat AI untuk Segala Kebutuhan</strong></p><p>Di era digital ini, kecerdasan buatan (AI) semakin mempengaruhi berbagai aspek kehidupan. Dari otomatisasi hingga peningkatan efisiensi, AI menghadirkan solusi inovatif untuk berbagai tugas sehari-hari. <a href=\"https://theresanaiforthat.com/\"><strong>theresanaiforthat.com</strong></a> adalah platform yang mengumpulkan berbagai alat AI yang dapat digunakan untuk berbagai keperluan, seperti penulisan, pembuatan gambar, musik, dan banyak lagi. Dengan koleksi alat yang lengkap, situs ini memudahkan Anda menemukan teknologi AI yang tepat untuk berbagai kebutuhan, baik untuk produktivitas maupun kreativitas.</p>', 'there-s-an-ai-for-that-panduan-alat-ai-untuk-segala-kebutuhan', 13, 0, 1, 'there-s-an-ai-for-that-panduan-alat-ai-untuk-segala-kebutuhan-there-s-an-ai-for-that.png', '2024-10-25 14:22:38', '2024-10-25 14:22:38'),
(2, 'Dataline: AI Visualisasi Data di Local Storage', '<p><strong>Pernah merasa tenggelam dalam lautan data?</strong> Atau mungkin Anda pernah menunggu berhari-hari hanya untuk mendapatkan satu insight dari data Anda? Dataline hadir sebagai solusi cerdas untuk permasalahan Anda.</p><p><strong>Bayangkan Anda punya banyak data penjualan, dari produk A sampai Z. Dengan Dataline, Anda bisa dengan mudah mengelompokkan data penjualan ini berdasarkan kategori produk, wilayah, atau waktu.</strong></p><p><strong>Caranya gampang banget!</strong> Anda tinggal minta, <i>\"Tampilkan grafik batang penjualan produk elektronik selama 6 bulan terakhir.\"</i> AI Dataline akan langsung membuatkan grafik yang menunjukkan sebaran penjualan produk elektronik Anda setiap bulannya. <strong>Tidak perlu lagi repot-repot membuat pivot table atau menulis query yang rumit.</strong></p><p><strong>Selain grafik batang, Dataline juga bisa membuat berbagai jenis visualisasi lain, seperti:</strong></p><ul><li><strong>Pie chart:</strong> Untuk melihat proporsi penjualan setiap produk.</li><li><strong>Line chart:</strong> Untuk melihat tren penjualan dari waktu ke waktu.</li><li><strong>Scatter plot:</strong> Untuk melihat hubungan antara dua variabel, misalnya harga dan jumlah yang terjual.</li></ul><p><strong>Mengapa memilih Dataline?</strong></p><ul><li><strong>Mudah digunakan:</strong> Antarmuka Dataline sangat intuitif, sehingga Anda bisa mulai menggunakannya tanpa perlu belajar bahasa pemrograman.</li><li><strong>Fleksibel:</strong> Anda bisa menyesuaikan visualisasi sesuai dengan kebutuhan Anda, misalnya mengubah warna, ukuran font, atau menambahkan label.</li><li><strong>Cepat:</strong> Dataline menghasilkan visualisasi dalam hitungan detik, sehingga Anda bisa mendapatkan insight dengan cepat.</li><li><strong>Pribadi:</strong> Semua data Anda disimpan secara lokal di perangkat Anda, sehingga privasi Anda terjamin.</li></ul><p><strong>Contoh kasus:</strong></p><p>Misalnya, Anda memiliki toko online yang menjual berbagai macam produk. Dengan Dataline, Anda bisa:</p><ul><li><strong>Mengidentifikasi produk terlaris:</strong> Mengetahui produk mana yang paling banyak diminati oleh pelanggan.</li><li><strong>Menganalisis tren penjualan:</strong> Melihat pola penjualan musiman atau tren jangka panjang.</li><li><strong>Membuat prediksi penjualan:</strong> Memprediksi penjualan di masa depan berdasarkan data historis.</li></ul><p><strong>Dengan Dataline, Anda bisa membuat keputusan bisnis yang lebih baik berdasarkan data yang akurat dan terkini.</strong></p><p><strong>Yuk, coba Dataline sekarang dan rasakan sendiri kemudahannya!</strong></p><p>Dataline AI : <a href=\"https://dataline.app\">https://dataline.app</a></p>', 'dataline-ai-visualisasi-data-di-local-storage', 13, 0, 1, 'dataline-ai-visualisasi-data-di-local-storage-Dateline.png', '2024-10-25 14:23:55', '2024-10-25 14:23:55'),
(13, 'Stop Wasting Time on Personal Portfolio Websites 🚫', '<p><strong>Kenapa Portofolio Pribadi Bukan Proyek Utama di CV Anda (Kecuali Anda Desainer)</strong></p><p>Dalam dunia teknologi, banyak pelamar kerja yang sering menuliskan portofolio pribadi sebagai proyek utama di CV mereka. Namun, kecuali Anda melamar untuk posisi yang fokus pada desain, hal ini sebenarnya tidak terlalu mengesankan bagi kebanyakan perusahaan.</p><p>Lalu, bagaimana cara menunjukkan pengalaman teknologi Anda dengan lebih baik? Berikut beberapa tips yang dapat membantu Anda membuat CV lebih menonjol dan relevan:</p><p><strong>Tampilkan Pengalaman Nyata di Bidang Teknologi</strong> Perusahaan lebih tertarik melihat pengalaman kerja nyata Anda atau proyek-proyek yang benar-benar memecahkan masalah di dunia nyata. Jangan hanya menampilkan proyek-proyek yang bersifat umum atau template.</p><p><strong>Ikut dalam Proyek Freelance atau Kontribusi Open-Source</strong> Dengan berkontribusi dalam proyek freelance atau open-source, Anda bisa menunjukkan keterampilan Anda secara praktis. Ini adalah cara yang bagus untuk memperlihatkan bahwa Anda dapat bekerja dalam lingkungan nyata dan berkolaborasi dengan orang lain.</p><p><strong>Hindari Proyek-Proyek Umum</strong> Proyek seperti aplikasi to-do list, pelacak cryptocurrency, atau aplikasi kebugaran sudah terlalu sering digunakan sebagai contoh proyek. Proyek-proyek semacam ini tidak akan membuat CV Anda menonjol di antara yang lain.</p><p><strong>Bangun Solusi Dunia Nyata</strong> Fokuslah pada membangun solusi yang menyelesaikan masalah nyata. Ini akan menunjukkan kemampuan Anda dalam pemecahan masalah, yang merupakan keterampilan yang sangat berharga di dunia teknologi.</p><p>Jika Anda merasa bingung menentukan proyek apa yang bisa benar-benar membuat Anda diperhatikan oleh perusahaan, jangan khawatir <a href=\"https://www.instagram.com/reel/C_gHAGEPFBn/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==\">bashi_fuirkashi</a> memiliki roadmap proyek dalam komunitas <i>Become a Software Engineer</i> yang dapat memandu Anda membangun proyek berdampak dan belajar kode dengan cara yang tepat. Dengan mengikuti roadmap ini, Anda akan lebih siap untuk melamar pekerjaan di industri teknologi dengan percaya diri.</p><p><br>&nbsp;Source: <a href=\"https://www.instagram.com/reel/C_gHAGEPFBn/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==\">bashi_fuirkashi</a></p>', 'stop-wasting-time-on-personal-portfolio-websites-', 14, 0, 1, 'stop-wasting-time-on-personal-portfolio-websites--portofolio-1png.png', '2024-10-25 14:25:19', '2024-10-25 14:25:19'),
(14, 'Panduan Praktis Menguasai AI Engineering di 2024: Langkah Awal hingga Proyek Nyata', '<p>Menguasai AI Engineering mungkin terdengar menakutkan, tapi di tahun 2024, belajar teknologi ini tidak lagi harus mahal atau rumit. Banyak tutorial dan sumber daya gratis yang bisa membimbing Anda menjadi ahli di bidang AI tanpa harus mengeluarkan biaya besar. Anda hanya perlu disiplin, tekad, dan peta jalan yang jelas.</p><h3>1. Tidak Perlu Kursus Mahal, Tapi...</h3><p>Benar, Anda tidak harus membayar mahal untuk kursus yang menjanjikan jalan pintas menjadi ahli AI. Banyak sumber daya gratis di luar sana seperti video tutorial di YouTube, atau situs web edukatif seperti GeeksforGeeks. Tapi, jika Anda tipe orang yang kesulitan belajar secara mandiri, kursus berbayar bisa membantu Anda tetap fokus.</p><p><strong>Langkah pertama</strong>: Pilih tutorial yang mudah diikuti. Pastikan tutorial ini mencakup teori dasar sekaligus memberikan proyek interaktif, sehingga Anda bisa mempraktikkan apa yang dipelajari.</p><h3>2. Mulailah dengan Python: Bahasa Pemrograman Favorit AI</h3><p>Sebelum masuk ke AI yang lebih rumit, Anda harus mengenal Python. Kenapa? Python mudah dipelajari dan sangat populer di kalangan AI engineer.</p><p><strong>Hal-hal yang perlu Anda pelajari di Python:</strong></p><ul><li><strong>Variabel dan Tipe Data</strong>: Dasar dari semua bahasa pemrograman.</li><li><strong>Operasi dan Operator</strong>: Cara melakukan perhitungan dan logika.</li><li><strong>Struktur Data</strong>: Pelajari <strong>list</strong>, <strong>tuple</strong>, dan <strong>dictionary</strong> untuk memudahkan pengolahan data.</li><li><strong>Fungsi dan OOP</strong>: Cara membuat kode yang lebih terstruktur dan efisien.</li><li><strong>API dan Library</strong>: Ini sangat penting karena dalam AI, Anda akan sering menggunakan <strong>libraries</strong> seperti TensorFlow atau PyTorch untuk memproses data.</li></ul><h3>3. Membangun Dasar dalam Data Science</h3><p>Data adalah fondasi dari AI. Untuk itu, setelah menguasai Python, langkah selanjutnya adalah mempelajari <strong>data analysis</strong> dan <strong>machine learning</strong>. Anda tidak harus menjadi data scientist, tetapi Anda harus <strong>data-literate</strong>—artinya, mampu memahami dan memanfaatkan data dalam skenario AI.</p><p><strong>Topik penting yang perlu Anda kuasai:</strong></p><ul><li><strong>Data Preparation</strong>: Cara menyiapkan data sebelum digunakan dalam model AI.</li><li><strong>Feature Engineering</strong>: Teknik untuk membuat fitur yang relevan dari data mentah.</li><li><strong>Supervised vs Unsupervised Learning</strong>: Pahami bedanya agar Anda tahu kapan harus menggunakan yang mana.</li><li><strong>Tree Algorithms &amp; Neural Networks</strong>: Algoritma dasar untuk membangun model prediktif.</li></ul><h3>4. Pahami Machine Learning &amp; Deep Learning</h3><p>Untuk menjadi AI engineer yang mahir, Anda juga perlu memahami inti dari <strong>machine learning</strong> dan <strong>deep learning</strong>. Ini adalah area di mana Anda akan benar-benar mengasah kemampuan dalam membuat prediksi berdasarkan data.</p><p><strong>Topik lanjutan yang perlu dipelajari:</strong></p><ul><li><strong>Supervised dan Unsupervised Learning</strong>: Bagaimana melatih model dengan data berlabel atau tanpa label.</li><li><strong>Tree Algorithms</strong>: Seperti <strong>Random Forest</strong> atau <strong>XGBoost</strong>.</li><li><strong>Neural Networks</strong>: Fondasi dari deep learning yang digunakan dalam banyak aplikasi AI modern seperti <strong>computer vision</strong> dan <strong>NLP</strong>.</li></ul><h3>5. Eksplorasi NLP dan LLMs</h3><p>LLMs (Large Language Models) seperti GPT dan BERT sedang naik daun, dan sebagian besar berfokus pada <strong>Natural Language Processing (NLP)</strong>. Di sinilah Anda akan belajar bagaimana AI memahami dan menghasilkan bahasa manusia.</p><p><strong>Poin penting tentang LLMs:</strong></p><ul><li><strong>Tokens dan Context Window</strong>: Bagaimana model bahasa besar memproses teks.</li><li><strong>Attention Mechanism &amp; Transformer</strong>: Teknologi di balik model-model AI bahasa yang paling canggih.</li><li><strong>Temperature</strong>: Mengontrol kreativitas model ketika membuat teks.</li></ul><h3>6. Prompt Engineering: Teknik Baru dalam AI</h3><p>Meski terdengar teknis, <strong>prompt engineering</strong> adalah teknik yang memungkinkan Anda membuat model AI bekerja lebih efektif. Ini mungkin bukan bagian inti dari AI engineering, tapi pemahaman dasar tentang prompt engineering akan membantu Anda mengoptimalkan performa model.</p><p><strong>Beberapa prinsip yang harus diingat:</strong></p><ul><li><strong>Kejelasan</strong>: Pastikan Anda selalu spesifik tentang tujuan prompt Anda.</li><li><strong>Konteks</strong>: Berikan konteks yang cukup kepada model agar ia bisa memahami apa yang Anda inginkan.</li><li><strong>Iterasi</strong>: Selalu siap untuk menyempurnakan prompt melalui proses berulang.</li></ul><h3>7. Hindari Loop Tutorial: Mulailah Membangun Proyek Nyata</h3><p>Satu kesalahan besar yang sering dilakukan pemula adalah terjebak dalam lingkaran tutorial tanpa pernah benar-benar membangun sesuatu yang nyata. Jangan lakukan ini. Segera setelah Anda mempelajari konsep dasar, tantang diri Anda untuk <strong>berpikir out of the box</strong> dan mulai membangun proyek sendiri.</p><p><strong>Tips Membangun Proyek:</strong></p><ul><li><strong>Pilih Topik yang Relevan</strong>: Pilihlah topik yang menarik minat Anda dan relevan dengan industri saat ini, misalnya proyek di bidang <strong>data analysis</strong> atau <strong>machine learning</strong>.</li><li><strong>Mulai dari Proyek Kecil</strong>: Tidak perlu memulai dengan sesuatu yang besar. Bangunlah proyek kecil terlebih dahulu, lalu terus perbaiki dan kembangkan.</li><li><strong>Lepaskan Diri dari Tutorial</strong>: Setelah memahami dasar-dasar, coba terapkan sendiri tanpa terus-menerus terpaku pada tutorial.</li></ul><p>Dengan menyelesaikan proyek nyata, Anda akan:</p><ul><li>Memahami konsep secara lebih mendalam.</li><li>Meningkatkan kepercayaan diri.</li><li>Memperkaya portofolio Anda dengan proyek yang relevan dan bermanfaat.</li></ul><h3>8. Tingkatkan Pengetahuan Anda dengan Teknologi Terbaru</h3><p>AI berkembang sangat cepat, dan untuk menjadi ahli di bidang ini, Anda perlu terus meningkatkan pengetahuan. Beberapa teknologi terbaru yang wajib dipelajari adalah:</p><ul><li><strong>RAG (Retrieval-Augmented Generation)</strong>: Teknik yang menggabungkan generasi teks dengan pencarian data.</li><li><strong>LangChain</strong>: Framework untuk membangun model yang dapat bekerja dengan berbagai sumber data.</li><li><strong>HuggingFace</strong>: Platform populer untuk berbagai model AI.</li><li><strong>Vector Databases &amp; Embedding</strong>: Teknologi yang memungkinkan pengolahan data dalam bentuk vektor untuk aplikasi AI.</li><li><strong>Open-source LLMs</strong>: Seperti LLaMA dan GPT-J, yang menawarkan alternatif open-source.</li><li><strong>Image Generators</strong>: Seperti <strong>DALL-E 3</strong> untuk menghasilkan gambar dari deskripsi teks.</li><li><strong>Voice Models</strong>: Model suara seperti <strong>Whisper</strong> dan <strong>TTS (Text-to-Speech)</strong>.</li></ul><h3>Kesimpulan: Pelajari dengan Cara yang Benar di 2024</h3><p>Di tahun 2024, belajar AI tidak lagi memerlukan biaya yang mahal. Namun, kunci sukses adalah bagaimana Anda belajar dan berlatih. Gunakan sumber daya gratis yang ada, mulai dari dasar pemrograman Python hingga membangun proyek AI kompleks seperti machine learning dan deep learning. Selain itu, jangan lupa untuk memahami LLMs dan prompt engineering sebagai alat yang membantu Anda lebih efisien.</p><p>Terakhir, tetaplah up-to-date dengan teknologi terbaru seperti <strong>RAG</strong>, <strong>LangChain</strong>, atau <strong>HuggingFace</strong>, dan pastikan Anda membangun proyek nyata untuk benar-benar menguasai konsep yang dipelajari.</p><p>Dengan mengikuti panduan ini, Anda akan lebih siap menghadapi dunia AI yang terus berkembang dan mampu mengembangkan solusi nyata yang berdampak di dunia kerja. Semakin Anda mengasah keterampilan, semakin besar pula kepercayaan diri Anda dalam mengembangkan proyek yang lebih kuat.</p><p>Source: <a href=\"https://www.instagram.com/reel/C_LVK_JNiPS/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==\">codingmermaid.ai</a></p>', 'panduan-praktis-menguasai-ai-engineering-di-2024-langkah-awal-hingga-proyek-nyata', 14, 0, 1, 'panduan-praktis-menguasai-ai-engineering-di-2024-langkah-awal-hingga-proyek-nyata-AI-1.png', '2024-10-25 14:26:04', '2024-10-25 14:26:04'),
(34, 'Cara Mudah Membuat Fitur Login dan Register di Laravel untuk Pemula', '<h3>Panduan Mudah Membuat Fitur Login &amp; Register dengan Laravel – Langkah demi Langkah</h3><p>Apakah Anda sudah menggunakan Laravel dan ingin menambahkan fitur <strong>login</strong> dan <strong>register</strong> ke dalam aplikasi Anda? Dalam panduan ini, saya akan menunjukkan cara cepat dan mudah untuk menambahkan fitur tersebut menggunakan alat bawaan Laravel, tanpa harus memulai dari awal.</p><h3>Mengapa Laravel untuk Otentikasi?</h3><p>Laravel terkenal dengan fitur otentikasi bawaan yang sangat memudahkan pengembang. Dengan hanya beberapa perintah artisan, Anda bisa membuat sistem login dan register yang aman dan responsif.</p><h4>Keuntungan Menggunakan Otentikasi Bawaan Laravel:</h4><ul><li><strong>Keamanan Terjamin</strong>: Laravel sudah dilengkapi dengan proteksi CSRF dan hashing password secara otomatis.</li><li><strong>Kemudahan Penggunaan</strong>: Laravel menyediakan scaffolding untuk otentikasi yang memudahkan pengaturan form login dan register.</li><li><strong>Cepat dan Efisien</strong>: Dalam waktu singkat, Anda bisa memiliki sistem otentikasi yang siap digunakan di aplikasi Anda.</li></ul><h3>Keunggulan Otentikasi di Laravel</h3><p>Dengan menggunakan fitur otentikasi bawaan Laravel, Anda tidak hanya menghemat waktu, tetapi juga mendapatkan keamanan yang sudah terbukti andal. Laravel meng-hash password pengguna dengan algoritma <strong>bcrypt</strong>, serta menyediakan fitur <strong>remember me</strong> dan <strong>logout</strong> yang mudah untuk digunakan.</p><p>Selain itu, Anda bisa menyesuaikan tampilan atau menambahkan fitur tambahan seperti <strong>login via media sosial</strong> (Google, Facebook, dll.) menggunakan paket seperti <strong>Laravel Socialite</strong>.</p><h3>Ajakan untuk Berinteraksi</h3><p>Semoga tutorial ini membantu Anda dalam memahami cara membangun fitur login dan register di Laravel dengan cepat dan efisien. Jika Anda merasa artikel ini bermanfaat, silakan bagikan kepada teman-teman pengembang web Anda!</p><p>Dan jika Anda ingin melihat panduan lebih jelas, simak video tutorial langkah demi langkah kami di Instagram Reels berikut ini:&nbsp;</p><p><a href=\"https://www.instagram.com/reel/C_58Hr2SHhZ/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==\">Simak Video Tutorial di Sini</a> by <a href=\"https://www.instagram.com/teknikrekayasa_/?e=93f766e0-9d41-437d-b54f-de34c3f0d177&amp;g=5\">teknikrekayasa</a></p>', 'cara-mudah-membuat-fitur-login-dan-register-di-laravel-untuk-pemula', 17, 0, 1, 'cara-mudah-membuat-fitur-login-dan-register-di-laravel-untuk-pemula-laravel.png', '2024-10-25 14:26:59', '2024-10-25 14:26:59'),
(35, '3 Langkah Penting dalam Membangun Web App: Dari Kebutuhan Hingga Desain UI/UX', '<p>Apakah kamu berencana membangun web app tapi bingung harus mulai dari mana? Jangan khawatir, tiga langkah ini akan membantu kamu mempersiapkan dan menentukan setiap detail penting. Mulai dari menganalisis kebutuhan sistem hingga menentukan teknologi dan desain yang tepat, semuanya ada di sini. Dengan memahami langkah-langkah berikut, kamu bisa mengurangi potensi kesalahan dan membuat proyek web app kamu berjalan dengan lancar.</p><h2><strong>1. Analisis Kebutuhan Sistem</strong></h2><p>Langkah pertama dalam membangun web app yang sukses adalah menganalisis kebutuhan sistem secara mendalam. Ini adalah fondasi utama yang akan menentukan bagaimana web app kamu akan berfungsi. Pertanyaan yang harus kamu jawab di tahap ini adalah:</p><ul><li>Fitur apa saja yang dibutuhkan?</li><li>Bagaimana alur data yang akan diterapkan di dalam sistem?</li><li>Siapa pengguna utamanya dan bagaimana interaksinya dengan sistem?</li></ul><p>Untuk menjawab pertanyaan-pertanyaan ini, penting untuk mendapatkan informasi langsung dari klien atau pengguna akhir. Gunakan alat seperti Excel atau dokumen lainnya untuk mencatat setiap kebutuhan. Jika sudah ada data yang pernah dibuat, seperti jurnal atau laporan, itu bisa menjadi referensi tambahan.</p><p><strong>Tips Penting:</strong></p><ul><li>Diskusikan dengan klien secara detail, jangan ragu untuk menanyakan kebutuhan spesifik yang mungkin terlewatkan.</li><li>Buatlah sketsa alur data untuk memvisualisasikan bagaimana informasi akan bergerak di dalam sistem.</li></ul><h2><strong>2. Menentukan Teknologi yang Tepat</strong></h2><p>Setelah kebutuhan sistem jelas, langkah berikutnya adalah memilih teknologi yang akan digunakan untuk membangun web app. Ini penting karena teknologi yang kamu pilih akan memengaruhi performa, skalabilitas, dan kemudahan pengembangan di masa depan. Beberapa hal yang harus kamu pertimbangkan adalah:</p><ul><li><strong>Skala proyek:</strong> Apakah proyek ini sederhana atau membutuhkan pengembangan yang kompleks?</li><li><strong>Budget klien:</strong> Teknologi yang lebih canggih mungkin memerlukan biaya lebih tinggi.</li><li><strong>Fitur:</strong> Apakah sistem memerlukan backend dan frontend yang terpisah, atau framework all-in-one seperti Laravel sudah cukup?</li></ul><p>Jika proyek yang kamu kerjakan relatif sederhana, Laravel bisa menjadi pilihan yang tepat. Laravel adalah framework PHP yang sudah mencakup berbagai fungsi penting seperti routing, keamanan, dan manajemen database. Namun, jika kamu memprediksi adanya perkembangan lebih lanjut atau aplikasi yang lebih kompleks, mungkin kamu harus mempertimbangkan teknologi lain seperti Node.js untuk backend atau React.js untuk frontend.</p><p><strong>Tips Penting:</strong></p><ul><li>Sesuaikan teknologi dengan kebutuhan proyek, bukan sebaliknya.</li><li>Pertimbangkan faktor kemudahan dalam pengelolaan dan pemeliharaan sistem jangka panjang.</li></ul><h2><strong>3. Desain UI/UX yang Menarik dan Fungsional</strong></h2><p>Desain yang baik bukan hanya soal tampilan yang menarik, tetapi juga tentang bagaimana pengguna berinteraksi dengan sistem. Desain UI/UX (User Interface/User Experience) yang fungsional akan meningkatkan kepuasan pengguna dan efisiensi aplikasi itu sendiri. Pertimbangkan beberapa hal berikut dalam merancang UI/UX:</p><ul><li><strong>Simplicity:</strong> Desain yang sederhana dan intuitif selalu lebih disukai daripada desain yang rumit.</li><li><strong>Responsiveness:</strong> Pastikan web app kamu dapat diakses dengan nyaman di berbagai perangkat, baik desktop maupun mobile.</li><li><strong>User flow:</strong> Desain alur penggunaan yang logis sehingga pengguna dapat mencapai tujuannya dengan langkah yang minimal.</li></ul><p>Kamu juga harus mempertimbangkan apakah akan menggunakan template UI yang sudah jadi atau merancangnya dari awal. Penggunaan template bisa menghemat waktu dan biaya, tetapi jika klien menginginkan desain yang unik, merancang dari awal mungkin lebih tepat.</p><p><strong>Tips Penting:</strong></p><ul><li>Uji desain UI/UX dengan melibatkan pengguna akhir untuk mendapatkan feedback langsung.</li><li>Pastikan desainnya sesuai dengan branding dan kebutuhan spesifik klien.</li></ul><p>&nbsp;</p><p>Nah, itulah tiga hal penting yang harus kamu siapkan sebelum mulai membangun web app: analisis kebutuhan sistem, pemilihan teknologi, dan desain UI/UX yang baik. Dengan mengikuti langkah-langkah ini, kamu dapat memastikan bahwa web app yang dibangun tidak hanya fungsional tetapi juga sesuai dengan harapan klien dan pengguna akhir.</p><p>Sudahkah kamu mempersiapkan semuanya? Jika ya, kamu sudah satu langkah lebih dekat ke keberhasilan dalam membangun web app yang efektif dan efisien. Jangan ragu untuk meninggalkan komentar atau membagikan artikel ini jika menurutmu bermanfaat.</p>', '3-langkah-penting-dalam-membangun-web-app-dari-kebutuhan-hingga-desain-ui-ux', 12, 0, 1, '3-langkah-penting-dalam-membangun-web-app-dari-kebutuhan-hingga-desain-ui-ux-tech-1.png', '2024-10-25 14:27:42', '2024-10-25 14:27:42'),
(36, 'JUPPTR AI: Solusi Terbaik untuk Pembuatan Video Profesional Otomatis', '<p>Bayangkan bisa membuat video berkualitas profesional dalam waktu singkat, tanpa harus mempelajari software editing rumit atau menghabiskan berjam-jam mencari footage tambahan. Dengan <a href=\"https://jupitrr.com/\">JUPPTR AI</a>, pembuatan video menjadi lebih mudah, cepat, dan efisien. Alat canggih berbasis kecerdasan buatan ini dirancang untuk merevolusi cara kita membuat video, mulai dari otomatisasi B-roll hingga menghasilkan GIF animasi menarik.</p><p><strong>Mengapa JUPPTR AI Unik?</strong><br>JUPPTR AI menonjol dengan berbagai fitur yang otomatis dan inovatif. Berikut adalah beberapa fitur unggulan yang menjadikan JUPPTR AI pilihan utama dalam pembuatan video:</p><ul><li><strong>Otomatisasi B-roll:</strong><br>Dengan teknologi AI, JUPPTR secara otomatis menambahkan B-roll yang relevan dengan konten video utama Anda. Ini menghemat waktu dalam pencarian footage tambahan, menjadikan video lebih kaya dan dinamis tanpa usaha ekstra.</li><li><strong>Generasi GIF:</strong><br>Membuat GIF animasi dari video tidak pernah semudah ini. JUPPTR menghasilkan GIF dengan langkah-langkah penting dari video Anda, ideal untuk media sosial.</li><li><strong>Overlay Teks Otomatis:</strong><br>Anda dapat menambahkan teks overlay secara otomatis ke video Anda, baik untuk subtitle, keterangan, atau bahkan call to action. Fitur ini mempermudah penonton untuk memahami pesan yang disampaikan.</li><li><strong>Dukungan Multibahasa:</strong><br>JUPPTR mendukung subtitle dalam berbagai bahasa, memungkinkan konten video Anda menjangkau audiens global tanpa repot membuat versi yang berbeda.</li><li><strong>Resizing Otomatis untuk Berbagai Platform:</strong><br>Dengan JUPPTR, video Anda bisa langsung disesuaikan dengan berbagai ukuran platform media sosial, menghilangkan kebutuhan untuk mengedit ukuran video secara manual.</li></ul><p><strong>Cara Kerja JUPPTR AI</strong><br>JUPPTR menggunakan algoritma pembelajaran mesin untuk menganalisis audio dan visual dari video Anda. Berdasarkan analisis ini, JUPPTR dapat menghasilkan B-roll, GIF, dan teks overlay yang relevan, membuat keseluruhan proses editing menjadi jauh lebih cepat dan sederhana.</p><p><strong>Keuntungan Menggunakan JUPPTR AI</strong></p><ul><li><strong>Efisiensi Waktu:</strong><br>Dalam industri yang serba cepat, waktu adalah segalanya. JUPPTR memungkinkan Anda menyelesaikan pembuatan video dalam hitungan menit, bukan jam.</li><li><strong>Kualitas Profesional:</strong><br>Video yang dihasilkan memiliki kualitas yang setara dengan hasil profesional, tanpa harus memiliki keterampilan teknis tinggi dalam editing video.</li><li><strong>Fleksibilitas dalam Penggunaan:</strong><br>JUPPTR cocok untuk berbagai jenis video, mulai dari video tutorial, promosi produk, hingga materi pembelajaran.</li></ul><p><strong>Contoh Kasus Penggunaan</strong><br>Misalkan Anda sedang membuat video tutorial memasak. Dengan JUPPTR, Anda hanya perlu merekam proses memasak dan memberikan narasi. Setelah itu, JUPPTR akan secara otomatis:</p><ul><li>Menemukan dan menambahkan footage tambahan dari langkah-langkah penting seperti memotong bahan atau menyajikan makanan.</li><li>Membuat GIF dari langkah-langkah penting untuk digunakan di media sosial.</li><li>Menambahkan teks overlay berupa resep atau tips memasak.</li><li>Menyesuaikan ukuran video agar sesuai dengan platform media sosial seperti YouTube dan Instagram.</li></ul><p><strong>Perbandingan dengan Alat Serupa</strong><br>Berbeda dengan alat pembuat video lainnya, JUPPTR AI unggul karena tingkat otomatisasinya yang tinggi. Alat serupa sering kali memerlukan lebih banyak input manual untuk mencapai hasil yang sama. Fokus JUPPTR pada B-roll otomatis dan generasi GIF menjadikannya unik di pasar.</p><p><strong>Tutorial Singkat Menggunakan JUPPTR AI</strong><br>Berikut adalah langkah-langkah mudah menggunakan JUPPTR AI:</p><ol><li><strong>Unggah Video:</strong> Unggah video Anda ke platform JUPPTR.</li><li><strong>Pilih Template:</strong> Pilih template yang sesuai dengan jenis video yang Anda buat.</li><li><strong>Kustomisasi:</strong> Sesuaikan teks, font, dan warna sesuai keinginan.</li><li><strong>Render:</strong> Biarkan JUPPTR memproses video Anda.</li><li><strong>Unduh:</strong> Setelah selesai, unduh video dalam format yang diinginkan.</li></ol><p><strong>Jawaban atas Pertanyaan Umum</strong></p><p><strong>Apakah JUPPTR AI gratis?</strong><br>Ada versi gratis dengan fitur terbatas dan versi berbayar untuk akses penuh. Kunjungi website resmi JUPPTR untuk informasi harga terbaru.</p><p><strong>Bahasa apa saja yang didukung oleh JUPPTR AI?</strong><br>Untuk daftar bahasa terbaru, kunjungi website resmi JUPPTR karena dukungan bahasa terus diperbarui.</p><p><strong>Bagaimana kualitas video yang dihasilkan?</strong><br>Kualitas video yang dihasilkan cukup baik untuk sebagian besar penggunaan, terutama di media sosial. Namun, jika Anda membutuhkan kontrol lebih rinci, software editing video profesional mungkin masih diperlukan.</p><p><br>JUPPTR AI hadir dengan teknologi mutakhir yang memungkinkan siapa saja untuk membuat video berkualitas profesional dalam waktu singkat. Dengan fitur-fitur seperti otomatisasi B-roll, generasi GIF, dan overlay teks, JUPPTR menawarkan solusi sempurna bagi pembuat konten, pemasar, dan pendidik. Siapa pun yang ingin meningkatkan kualitas video mereka dengan mudah, JUPPTR AI adalah jawabannya.</p><p>Anda bisa mencobanya disini: <a href=\"https://jupitrr.com/\">Jupiter.ai</a></p>', 'jupptr-ai-solusi-terbaik-untuk-pembuatan-video-profesional-otomatis', 13, 0, 1, 'jupptr-ai-solusi-terbaik-untuk-pembuatan-video-profesional-otomatis-ai-tool-1.png', '2024-10-25 14:29:48', '2024-10-25 14:29:48'),
(37, 'Dampak Video Pendek pada Otak: Bagaimana Kebiasaan Menonton Dapat Menghambat Kemampuan Belajar Anda', '<p>Pernahkah Anda merasa sulit untuk fokus setelah berjam-jam menonton video pendek di TikTok atau Instagram? Menariknya, penelitian menunjukkan bahwa kebiasaan menonton video singkat secara berulang dapat berdampak negatif pada cara otak kita memproses informasi. Di era digital yang serba cepat ini, di mana segala sesuatu tersedia secara instan, apakah kita secara tidak sadar merusak kemampuan otak kita untuk belajar dan berkembang?</p><p><strong>Mengapa Video Pendek Bisa Berbahaya bagi Otak?</strong><br>Dengan video pendek yang membanjiri platform media sosial, otak kita terus-menerus dihadapkan pada rentetan informasi singkat dan cepat. Meskipun tampaknya tidak berbahaya, ada dua fenomena penting yang dapat terjadi pada otak ketika kita sering terpapar video singkat: <strong>Community Overload</strong> dan <strong>Instant Gratification</strong>.</p><ul><li><strong>Community Overload:</strong><br>Istilah ini menggambarkan kondisi di mana otak kita dipenuhi dengan terlalu banyak informasi dalam waktu singkat. Otak menjadi \"overloaded\", dan ini dapat mengurangi kapasitas kita untuk mencerna informasi yang lebih mendalam. Ketika otak berada dalam keadaan community overload, kemampuan untuk menyaring dan mengingat informasi jangka panjang menurun drastis.</li><li><strong>Instant Gratification:</strong><br>Dalam konteks konsumsi media, instant gratification merujuk pada kepuasan instan yang kita rasakan saat menikmati sesuatu yang cepat dan mudah. Video-video pendek memenuhi kebutuhan ini dengan cepat, memberikan dorongan dopamin singkat yang membuat kita terus menonton. Namun, kepuasan ini bersifat sementara, dan membuat otak kita cenderung menghindari aktivitas yang membutuhkan upaya lebih besar, seperti belajar atau menyelesaikan tugas yang lebih kompleks.</li></ul><p><strong>Berbanding Terbalik dengan Cognitive Development dan Delayed Gratification</strong><br>Sebaliknya, untuk mengembangkan kemampuan belajar yang kuat, kita memerlukan <strong>Cognitive Development</strong> dan <strong>Delayed Gratification</strong>. Cognitive development terjadi ketika otak kita mampu menyerap dan memahami informasi secara bertahap dan mendalam. Ini membutuhkan waktu dan kesabaran, yang justru berbanding terbalik dengan kebiasaan menonton video singkat yang cepat dan terus-menerus.</p><p><strong>Delayed Gratification</strong> adalah kemampuan untuk menunda kepuasan langsung dan bersabar menunggu hasil yang lebih besar di masa depan. Dalam konteks belajar, kemampuan ini sangat penting karena membantu kita fokus pada tugas-tugas yang membutuhkan waktu lama untuk diselesaikan, seperti membaca buku atau mempelajari keterampilan baru. Video singkat, di sisi lain, merusak pola ini dengan menawarkan kepuasan instan yang terus-menerus.</p><p><strong>Dampak Jangka Panjang dari Kebiasaan Menonton Video Pendek</strong><br>Menurut berbagai penelitian, kebiasaan menonton video pendek dapat memiliki dampak negatif pada kemampuan belajar kita. Beberapa dampak jangka panjang yang mungkin terjadi antara lain:</p><ul><li><strong>Penurunan Kemampuan Konsentrasi:</strong><br>Karena video singkat sering kali hanya berlangsung beberapa detik hingga beberapa menit, otak kita menjadi terbiasa dengan alur informasi yang cepat dan instan. Akibatnya, kemampuan kita untuk berkonsentrasi pada tugas yang lebih kompleks dan membutuhkan waktu lebih lama semakin menurun.</li><li><strong>Kesulitan dalam Mengembangkan Pemikiran Kritis:</strong><br>Pemikiran kritis memerlukan analisis mendalam dan pemahaman yang komprehensif, sesuatu yang tidak bisa dicapai hanya dengan mengonsumsi informasi singkat dan dangkal. Ketika kita terbiasa dengan informasi instan, kita kehilangan kemampuan untuk menggali lebih dalam dan memproses informasi secara kritis.</li><li><strong>Ketergantungan pada Konten Cepat:</strong><br>Semakin sering kita menikmati video singkat, semakin sulit bagi otak kita untuk menikmati aktivitas yang memerlukan waktu lebih lama, seperti membaca buku atau menonton film panjang. Ini menciptakan ketergantungan pada kepuasan instan, yang pada akhirnya menghambat pengembangan kognitif kita.</li></ul><p><strong>Bagaimana Mengatasi Dampak Negatif Video Pendek?</strong></p><ul><li><strong>Batasi Konsumsi Video Singkat:</strong><br>Cobalah untuk secara sadar membatasi waktu yang Anda habiskan menonton video singkat setiap hari. Berikan diri Anda batasan waktu untuk menggunakan platform seperti TikTok, Instagram, dan YouTube Shorts.</li><li><strong>Perkuat Kebiasaan Belajar yang Mendalam:</strong><br>Alihkan fokus Anda pada kegiatan yang melibatkan pemikiran mendalam dan proses yang lebih lama, seperti membaca, menulis, atau belajar keterampilan baru. Ini akan membantu otak Anda mengembangkan kembali kemampuan untuk fokus dalam jangka panjang.</li><li><strong>Latih Delayed Gratification:</strong><br>Mulailah melatih kemampuan Anda untuk menunda kepuasan. Misalnya, ketika Anda ingin menonton video pendek untuk hiburan, cobalah menunda keinginan tersebut selama beberapa menit. Seiring waktu, ini akan membantu meningkatkan kemampuan Anda untuk fokus pada tugas-tugas yang lebih kompleks.</li></ul><p><br>Kebiasaan menonton video pendek mungkin tampak tidak berbahaya, tetapi dampaknya pada otak kita dapat sangat signifikan, terutama dalam hal kemampuan belajar dan konsentrasi. Dengan mengenali risiko yang terlibat dan mengambil langkah untuk membatasi konsumsi konten singkat, kita dapat melindungi otak kita dari community overload dan instant gratification, serta menjaga kemampuan belajar yang penting untuk perkembangan jangka panjang.</p><p>Jadi, apakah Anda akan terus membiarkan kebiasaan menonton video singkat mengendalikan cara Anda belajar? Atau, apakah Anda siap untuk mengambil kembali kendali dan mulai membangun kebiasaan yang lebih sehat untuk otak Anda?</p>', 'dampak-video-pendek-pada-otak-bagaimana-kebiasaan-menonton-dapat-menghambat-kemampuan-belajar-anda', 15, 0, 1, 'dampak-video-pendek-pada-otak-bagaimana-kebiasaan-menonton-dapat-menghambat-kemampuan-belajar-anda-lifestyle-1.png', '2024-09-26 06:50:40', '2024-09-26 06:50:40'),
(38, '3 Proyek Aplikasi Inovatif yang Meningkatkan Pengalaman Anda: Dari Sistem Tiket Digital hingga Pelacak Metrik Canggih untuk Perusahaan Besar', '<p>Apakah Anda tertarik menjadi seorang pengembang aplikasi? Di dunia yang semakin digital ini, keterampilan pengembangan perangkat lunak sangat berharga. Baik Anda seorang pemula yang baru memulai, seorang amatir yang ingin mengasah kemampuan, atau seorang profesional yang siap menghadapi tantangan baru, artikel ini memberikan ide proyek yang bisa Anda coba. Menurut data dari <i>Stack Overflow Developer Survey</i>, banyak pengembang aplikasi terus belajar dan mengasah keterampilan mereka melalui proyek nyata. Bagaimana dengan Anda? Yuk, mulai perjalanan pengembangan aplikasi Anda dengan salah satu dari tiga ide proyek berikut yang dirancang sesuai tingkat keterampilan Anda.</p><p><strong>Proyek untuk Pemula: Pengembangan Sistem Tiket dan Validasi</strong><br>Sebagai pengembang pemula, salah satu proyek yang cocok untuk mengasah keterampilan dasar Anda adalah membangun <strong>sistem tiket digital</strong>. Dalam proyek ini, Anda akan membuat perangkat lunak yang memungkinkan pengguna membeli tiket untuk berbagai acara. Di akhir pembelian, sistem akan menghasilkan tiket digital dalam bentuk <strong>QR code</strong> atau <strong>barcode</strong>.</p><p>Langkah pertama adalah membangun antarmuka pengguna (UI) yang intuitif agar pengguna dapat dengan mudah melakukan pembelian tiket. Anda juga perlu mengintegrasikan <strong>sistem pembayaran</strong> agar transaksi dapat berjalan lancar. Setelah tiket berhasil dibeli, Anda akan memanfaatkan pustaka <strong>QR code generator</strong> atau <strong>barcode generator</strong> untuk menghasilkan tiket digital.</p><p>Namun, pekerjaan Anda tidak berhenti di situ. Sebagai bagian dari proyek ini, Anda juga perlu membuat <strong>sistem validasi tiket</strong> yang akan digunakan di tempat acara. Sistem ini berfungsi untuk memindai tiket pengguna, memeriksa keabsahannya, dan memastikan bahwa tiket tersebut belum digunakan sebelumnya. Ini adalah dasar yang baik bagi Anda untuk belajar tentang pengolahan data real-time dan penggunaan API.</p><p><strong>Keuntungan:</strong></p><ul><li>Mengasah keterampilan dasar dalam membangun UI dan UX.</li><li>Belajar mengintegrasikan sistem pembayaran.</li><li>Memahami pemrosesan data real-time melalui validasi tiket.</li></ul><p><strong>Proyek untuk Amatir: Aplikasi Pengunggah Foto Acara Berbasis Cloud</strong><br>Jika Anda sudah memiliki pengalaman dasar dalam pengembangan aplikasi, proyek berikutnya akan menguji keterampilan Anda lebih lanjut. Proyek ini melibatkan pembuatan <strong>aplikasi pengunggah foto acara</strong> berbasis cloud. Setiap acara yang diadakan akan memiliki <strong>tautan khusus</strong> yang memungkinkan pengguna mengunggah foto-foto yang mereka ambil selama acara berlangsung.</p><p>Saat pengguna mengklik tautan tersebut, mereka akan diarahkan ke aplikasi tempat mereka dapat langsung mengambil gambar melalui perangkat mereka. Setelah foto diambil, gambar tersebut akan secara otomatis diunggah ke <strong>cloud storage</strong> yang telah ditentukan. Pada akhir acara, penyelenggara dapat dengan mudah mengakses semua foto yang diunggah oleh peserta.</p><p>Tantangan utama dalam proyek ini adalah integrasi dengan <strong>layanan cloud</strong> dan memastikan setiap gambar tersimpan dengan aman. Anda juga perlu memikirkan <strong>pengelolaan hak akses</strong>, agar hanya penyelenggara yang dapat melihat atau mengunduh gambar yang diunggah. Teknologi yang dapat Anda manfaatkan termasuk <strong>Firebase</strong>, <strong>Amazon S3</strong>, atau platform cloud lainnya.</p><p><strong>Keuntungan:</strong></p><ul><li>Mengembangkan kemampuan dalam integrasi layanan cloud.</li><li>Memahami sistem autentikasi dan manajemen hak akses.</li><li>Belajar menangani file media dengan efisien dalam aplikasi.</li></ul><p><strong>Proyek untuk Profesional: Pelacak Metrik untuk Aplikasi Web dan Mobile</strong><br>Bagi Anda yang sudah merasa cukup percaya diri dengan keterampilan pengembangan aplikasi, proyek ini akan menjadi tantangan yang lebih kompleks. Anda akan membuat <strong>pelacak metrik</strong> yang dapat diintegrasikan ke dalam aplikasi web atau mobile. Pelacak ini akan memberikan <strong>analisis mendalam</strong> tentang bagaimana pengguna berinteraksi dengan aplikasi.</p><p>Pelacak ini harus mampu <strong>mengumpulkan data pengguna</strong> seperti berapa lama waktu yang mereka habiskan pada fitur tertentu, tindakan yang mereka ambil, dan bagaimana mereka berpindah antar halaman atau layar. Data yang terkumpul ini akan membantu pengembang atau pemilik aplikasi memahami pola perilaku pengguna dan melakukan perbaikan berdasarkan wawasan tersebut.</p><p>Proyek ini membutuhkan <strong>kombinasi berbagai teknologi</strong>, mulai dari integrasi dengan API hingga pengolahan data besar (<i>big data</i>). Anda mungkin perlu menggunakan teknologi seperti <strong>Google Analytics</strong>, <strong>Mixpanel</strong>, atau membangun solusi pelacakan khusus menggunakan <strong>Node.js</strong> atau <strong>Python</strong> di sisi server, serta <strong>JavaScript</strong> di sisi klien. Selain itu, Anda perlu mengelola <strong>keamanan data</strong> pengguna, memastikan semua data dilindungi sesuai dengan regulasi seperti GDPR.</p><p><strong>Keuntungan:</strong></p><ul><li>Mengembangkan keterampilan dalam analisis data dan pengolahan big data.</li><li>Meningkatkan kemampuan dalam keamanan data dan enkripsi.</li><li>Belajar mengintegrasikan pelacakan di berbagai platform (web dan mobile).</li></ul><p><strong>Kesimpulan: Mulai Proyek Anda dan Tingkatkan Kemampuan Pengembangan Aplikasi</strong><br>Apakah Anda seorang pemula, amatir, atau profesional, ketiga proyek di atas menawarkan kesempatan untuk mengembangkan keterampilan pengembangan aplikasi Anda. Masing-masing proyek dirancang untuk memberikan tantangan yang sesuai dengan tingkat kemampuan Anda, sambil memungkinkan Anda mempelajari hal-hal baru di setiap langkahnya.</p><p>Untuk pemula, <strong>sistem tiket dan validasi</strong> akan memberikan fondasi yang baik dalam pengembangan UI dan pemrosesan data. Bagi amatir, <strong>aplikasi pengunggah foto berbasis cloud</strong> akan mengasah kemampuan integrasi layanan cloud dan manajemen file. Sedangkan bagi profesional, <strong>pelacak metrik</strong> akan menjadi proyek yang rumit namun berharga dalam memahami pola penggunaan aplikasi.</p><p>Jadi, proyek mana yang akan Anda pilih? Beranikan diri untuk memulai, karena setiap langkah yang Anda ambil akan membawa Anda lebih dekat menjadi pengembang aplikasi yang lebih baik.</p>', '3-proyek-aplikasi-inovatif-yang-meningkatkan-pengalaman-anda-dari-sistem-tiket-digital-hingga-pelacak-metrik-canggih-untuk-perusahaan-besar', 14, 0, 1, '3-proyek-aplikasi-inovatif-yang-meningkatkan-pengalaman-anda-dari-sistem-tiket-digital-hingga-pelacak-metrik-canggih-untuk-perusahaan-besar-carier-tech-1.jpg', '2024-10-02 06:53:17', '2024-10-02 06:53:17'),
(81, 'Bikin CRUD di Laravel 10x Lebih Cepat dengan Filament – Plugin Wajib Coba!', '<p>Dalam pengembangan Laravel, efisiensi adalah kunci. Salah satu cara tercepat dan paling praktis untuk mempercepat proses CRUD (Create, Read, Update, Delete) adalah dengan <strong>Filament</strong>, plugin yang dirancang khusus untuk meringankan beban pengembang. Dengan Filament, fitur CRUD dapat dibangun lebih cepat tanpa menulis kode dari awal.</p><h4>Kenapa Pilih Filament?</h4><p>Biasanya, pengembang Laravel perlu menulis setiap fungsi CRUD secara manual, dari antarmuka hingga logika backend. Namun, <strong>Filament</strong> otomatis menangani form, validasi, dan penyimpanan data. Dengan beberapa perintah sederhana, plugin ini menyediakan antarmuka admin yang intuitif, siap pakai, dan efisien.</p><h4>Cara Kerja Filament</h4><p>Instalasi Filament sangat mudah. Setelah menjalankan beberapa perintah dasar, plugin ini langsung bisa digunakan. Cukup modifikasi file web.php, dan aplikasi siap berjalan lebih mulus. Proses CRUD yang biasanya manual—seperti create, update, dan delete—sekarang otomatis. Anda bahkan bisa menyesuaikan tampilan table dan form sesuai kebutuhan.</p><h4>Fleksibilitas dan Keunggulan Filament</h4><p>Selain menghemat waktu, Filament menawarkan fleksibilitas penuh untuk penyesuaian. Anda dapat menyesuaikan resource dan form agar sesuai dengan proyek Anda, sehingga bisa fokus pada fitur-fitur yang lebih penting tanpa terganggu oleh tugas-tugas berulang.</p><h4>Wajib Coba untuk Pengembang Laravel</h4><p>Bagi Anda yang ingin mempercepat workflow Laravel tanpa mengorbankan kualitas, <strong>Filament adalah jawabannya</strong>. Dengan kombinasi efisiensi dan kemudahan, plugin ini adalah tool yang harus dicoba. Rasakan sendiri bagaimana Filament bisa menyederhanakan hidup Anda sebagai pengembang!</p><p>Dengan artikel ini, saya harap Anda mendapatkan wawasan baru tentang bagaimana Filament dapat meningkatkan efisiensi kerja Anda. Tidak hanya mempercepat pengembangan aplikasi, tetapi juga membuka peluang untuk lebih fokus pada inovasi. Jadi, tunggu apa lagi? Segera coba Filament dan optimalkan proyek Laravel Anda sekarang!</p><p><strong>Tonton Video Tutorial Lengkap di Sini: </strong><a href=\"https://www.instagram.com/reel/DAaZY3yoAlx/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==\"><strong>cwicaksono</strong></a></p>', 'bikin-crud-di-laravel-10x-lebih-cepat-dengan-filament-plugin-wajib-coba-', 17, 0, 1, 'bikin-crud-di-laravel-10x-lebih-cepat-dengan-filament-plugin-wajib-coba--laravel-3.jpg', '2024-10-25 14:37:20', '2024-10-25 14:37:20'),
(100, 'Cara Cepat Menguasai Bahasa Pemrograman: Teknik Belajar dari Para Developer Elite', '<p>Banyak yang berpikir bahwa menguasai bahasa pemrograman dalam sehari adalah hal yang mustahil. Dan memang, kenyataannya, tidak mungkin menjadi ahli dalam satu hari. Namun, ada cara untuk belajar lebih cepat dan efektif. Jika Anda pernah terjebak dalam \"tutorial hell,\" artikel ini akan memberikan solusi untuk keluar dari situ dan menguasai keterampilan coding lebih cepat dari sebelumnya.</p><p><strong>1. Memanfaatkan Sumber Daya Online</strong>&nbsp;</p><p>Langkah pertama dalam belajar bahasa pemrograman dengan cepat adalah memanfaatkan sumber daya yang ada, seperti YouTube. Banyak crash course yang tersedia, misalnya untuk <strong>Next JS</strong> atau <strong>TypeScript</strong>. Kursus ini memberikan pengenalan menyeluruh dalam waktu yang singkat. Namun, jangan hanya menonton tanpa beraksi!</p><p><strong>2. Praktik Aktif: Kunci Belajar Efektif</strong>&nbsp;</p><p>Inilah yang membedakan antara developer elite dan pemula: <strong>praktik aktif</strong>. Saat menonton video, jangan hanya pasif menerima informasi. Setiap 30 menit, berhenti sejenak dan cobalah menulis kode berdasarkan apa yang baru saja Anda pelajari. Dengan begitu, Anda akan langsung memperkuat konsep yang baru saja Anda serap melalui pengalaman langsung.</p><p><strong>3. Hindari “Tutorial Hell” dengan Metode Belajar Mandiri</strong>&nbsp;</p><p>Banyak yang terjebak dalam “tutorial hell” — situasi di mana Anda terus-menerus mengikuti tutorial tanpa pernah benar-benar memahami cara mengimplementasikan apa yang telah Anda pelajari. Praktik mandiri ini mengajarkan Anda untuk tidak terlalu bergantung pada tutorial. Cobalah menulis kode proyek kecil Anda sendiri setelah menonton video, sehingga Anda bisa lebih memahami bagaimana konsep-konsep tersebut diterapkan dalam skenario dunia nyata.</p><p><strong>4. Belajar dengan Cara Developer Elite</strong>&nbsp;</p><p>Para developer elite sering menggunakan metode <strong>Active Learning</strong> atau pembelajaran aktif. Mereka tidak hanya menghafal sintaks atau konsep, tetapi juga langsung mempraktikannya dalam proyek-proyek kecil. Metode ini mempercepat proses belajar karena Anda langsung merasakan dan menyelesaikan masalah nyata yang akan Anda hadapi di dunia kerja.</p><p><strong>5. Mengatasi Hambatan Umum dalam Belajar Bahasa Pemrograman</strong>&nbsp;</p><p>Salah satu kesalahan umum adalah berharap semuanya akan berjalan mulus dalam waktu singkat. Pada kenyataannya, belajar bahasa pemrograman membutuhkan waktu, kesabaran, dan dedikasi. Jangan takut membuat kesalahan, karena kesalahan adalah bagian dari proses belajar yang sangat penting.</p><p>Jika Anda ingin belajar bahasa pemrograman dengan cepat, kuncinya bukan hanya menemukan kursus yang tepat, tetapi juga berlatih dengan aktif dan konsisten. Hindari jebakan tutorial hell dan mulailah membuat kode Anda sendiri. Dengan metode yang tepat, Anda bisa menguasai dasar-dasar bahasa pemrograman dalam waktu yang lebih singkat dari yang Anda bayangkan.</p>', 'cara-cepat-menguasai-bahasa-pemrograman-teknik-belajar-dari-para-developer-elite', 14, 0, 1, 'cara-cepat-menguasai-bahasa-pemrograman-teknik-belajar-dari-para-developer-elite-coding-1.jpeg', '2024-09-28 21:10:07', '2024-09-28 21:10:07');
INSERT INTO `posts` (`id_post`, `tittle`, `content`, `slug`, `category_id`, `tag_id`, `author_id`, `images`, `created_at`, `updated_at`) VALUES
(113, 'Meningkatkan Pengalaman Pengguna dengan Fitur Throttling Jaringan di DevTools', '<p>Pernahkah Anda berpikir tentang bagaimana website Anda tampil dan berfungsi di jaringan lambat? Apakah pengguna dengan koneksi 3G atau 4G lambat bisa menikmati pengalaman yang sama baiknya seperti mereka yang menggunakan jaringan super cepat? Inilah tantangan yang sering dihadapi developer web saat mengoptimalkan performa situs mereka. Untungnya, Google Chrome DevTools memiliki fitur <strong>Throttling Jaringan</strong>, yang memungkinkan simulasi berbagai kecepatan jaringan dengan mudah dan cepat.</p><p>&nbsp;</p><p><strong>Fitur Throttling Jaringan: Apa dan Bagaimana Cara Kerjanya?</strong></p><p>Fitur <strong>Throttling Jaringan</strong> pada Google Chrome DevTools memungkinkan developer untuk mensimulasikan berbagai kondisi jaringan. Dengan fitur ini, Anda dapat memilih preset seperti jaringan 4G cepat, 4G lambat, 3G, Offline atau bahkan membuat pengaturan jaringan kustom sesuai kebutuhan. Ini sangat membantu dalam menguji performa website, memastikan situs dapat tetap berjalan optimal meskipun pengguna mengaksesnya dengan koneksi internet yang lebih lambat.</p><p>&nbsp;</p><figure class=\"image\"><img src=\"http://localhost/myblog/assets/img/uploads/devtools.png\"></figure><p>Pada gambar di atas, Anda dapat melihat cara menggunakan fitur ini, yang diakses melalui tab <i>Jaringan (Network)</i> pada DevTools. Anda dapat memilih berbagai opsi jaringan untuk melihat bagaimana waktu muat (loading time) berubah sesuai kecepatan jaringan yang dipilih.</p><p>&nbsp;</p><p><strong>Mengapa Fitur Throttling Jaringan Penting bagi Pengembangan Website?</strong></p><ul><li><strong>Mengoptimalkan Kinerja di Berbagai Jaringan:</strong> Throttling Jaringan memungkinkan Anda untuk memastikan bahwa website dapat berfungsi dengan baik dalam kondisi jaringan apa pun. Ini sangat penting bagi pengguna yang berada di area dengan konektivitas yang tidak stabil.</li><li><strong>Meningkatkan Pengalaman Pengguna:</strong> Dengan mengetahui cara website Anda merespons jaringan lambat, Anda dapat melakukan optimasi yang diperlukan, seperti mengurangi ukuran gambar atau meminifikasi file JavaScript dan CSS, untuk memastikan website tetap cepat dimuat.</li><li><strong>Mengidentifikasi Masalah Sebelum Peluncuran:</strong> Pengujian dengan Throttling Jaringan membantu Anda mengidentifikasi potensi masalah yang mungkin muncul sebelum website diluncurkan, mengurangi risiko bounce rate yang tinggi karena waktu muat yang lama.</li></ul><p>&nbsp;</p><p><strong>Cara Menggunakan Throttling Jaringan:</strong></p><p>Sebelum menggunakan fitur ini, pastikan Anda telah memahami pentingnya pengujian jaringan. Anda dapat mengakses Throttling Jaringan di tab <i>Network</i> pada DevTools. Pilih preset jaringan yang ingin Anda simulasikan dan perhatikan bagaimana elemen-elemen di website Anda dimuat dalam kondisi tersebut.</p><p>Walaupun tutorial teknis detail tidak akan kita bahas di artikel ini, &nbsp;video ini akan memandu anda dengan visual yang menarik tentang cara mengatur DevTools untuk simulasi jaringan, serta memberikan contoh-contoh langsung bagaimana pengaturan ini bekerja dalam skenario nyata.</p><p>Tutorial video by : <a href=\"https://www.instagram.com/reel/C_c2fXyvqW0/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==\">tipspemograman</a></p><p>&nbsp;</p><p>Pengujian kinerja website dalam berbagai kondisi jaringan adalah langkah penting untuk memastikan pengalaman pengguna yang optimal. Dengan menggunakan DevTools, Anda dapat dengan mudah mensimulasikan kondisi ini dan melakukan penyesuaian yang diperlukan. Jadi, apakah Anda sudah siap untuk menguji website Anda dan memberikan pengalaman pengguna yang lebih baik?</p>', 'meningkatkan-pengalaman-pengguna-dengan-fitur-throttling-jaringan-di-devtools', 12, 0, 1, 'meningkatkan-pengalaman-pengguna-dengan-fitur-throttling-jaringan-di-devtools-devtools-1.jpg', '2024-10-03 20:24:14', '2024-10-03 20:24:14'),
(114, 'Membuat Fitur Login Menggunakan Akun Google dengan Laravel Jetstream', '<p>Apakah Anda pernah berpikir, “Bagaimana cara membuat fitur login yang cepat dan aman menggunakan akun Google?” Bagi para developer, menambahkan fitur login Google ke dalam aplikasi bukan hanya soal meningkatkan keamanan, tetapi juga menyederhanakan proses login untuk pengguna.</p><p>Salah satu cara terbaik untuk menambahkan fitur login Google ini adalah dengan menggunakan <strong>Laravel Jetstream</strong>, yang menawarkan integrasi yang mulus dan kuat. Apakah Anda seorang developer yang ingin memberikan pengalaman login yang cepat bagi pengguna aplikasi Laravel Anda? Artikel ini akan memberikan wawasan tentang cara membuat fitur login Google dengan mudah dan efisien menggunakan Laravel Jetstream.</p><p><strong>Mengapa Harus Menggunakan Login Google?</strong> Fitur login Google menawarkan sejumlah manfaat yang sangat berguna bagi aplikasi Anda, termasuk:</p><ol><li><strong>Keamanan yang Lebih Baik:</strong> Menggunakan OAuth 2.0 dari Google untuk otentikasi berarti Anda memanfaatkan sistem keamanan Google yang terkenal kuat.</li><li><strong>Pengalaman Pengguna yang Lebih Cepat:</strong> Pengguna tidak perlu mengisi formulir registrasi panjang; cukup klik \"Login dengan Google\", dan mereka sudah terdaftar.</li><li><strong>Kemudahan Integrasi:</strong> Dengan Laravel Jetstream, Anda bisa dengan mudah mengintegrasikan fitur login menggunakan akun Google tanpa harus memulai dari nol.</li></ol><p><strong>Mengapa Memilih Laravel Jetstream?</strong> Laravel Jetstream adalah framework untuk manajemen otentikasi yang dirancang secara elegan dan kaya fitur. Dengan Jetstream, Anda tidak hanya mendapatkan sistem otentikasi standar, tetapi juga fitur lanjutan seperti verifikasi email, otentikasi dua faktor, dan sesi tim. Jetstream juga mendukung <strong>Socialite</strong>, paket Laravel untuk integrasi login media sosial, termasuk login dengan akun Google.</p><p><strong>Apa yang Dapat Anda Capai dengan Login Google di Laravel?</strong> Dengan menambahkan login Google ke aplikasi Laravel Anda, Anda menawarkan pilihan yang lebih nyaman kepada pengguna untuk mengakses layanan Anda. Tidak ada lagi rasa frustrasi karena lupa password atau proses registrasi yang panjang. Fitur ini sangat bermanfaat untuk meningkatkan <strong>retensi pengguna</strong> dan <strong>mendorong konversi</strong> bagi aplikasi yang membutuhkan otentikasi pengguna.</p><p>Selain itu, fitur login Google yang terintegrasi dengan Jetstream juga memungkinkan Anda untuk menambah <strong>lapisan keamanan tambahan</strong>, seperti otentikasi dua faktor, yang menjamin keamanan data pengguna.</p><p><strong>Optimasi SEO untuk Integrasi Login Google:</strong> Jika Anda ingin meningkatkan pengalaman pengguna sekaligus memperkuat optimasi SEO, menambahkan fitur login Google juga dapat berkontribusi. Pengguna yang login melalui Google dapat dengan mudah terhubung dengan layanan Google lainnya, yang memberikan <strong>pengalaman pengguna yang lebih mulus dan cepat</strong>. Dengan semakin banyaknya pengguna yang mengakses situs web melalui perangkat seluler, waktu login yang lebih cepat juga akan meningkatkan <strong>retensi pengguna</strong> dan <strong>pengalaman SEO keseluruhan</strong>.</p><p>Untuk tutorial langkah demi langkah, saya sangat menyarankan Anda untuk melihat video yang telah saya sertakan di artikel ini. Video tersebut akan membantu Anda memahami setiap tahap pembuatan fitur login Google dengan jelas.&nbsp;</p><p>Meskipun tutorial video ini bukan milik saya, saya telah memilihnya karena kualitas penyajiannya yang sangat baik dan detail teknisnya yang relevan dengan topik yang kita bahas.</p><blockquote><p><strong>Tonton Video Tutorial:</strong> <a href=\"https://www.instagram.com/reel/DAkQX4Uyowr/?utm_source=ig_web_copy_link&amp;igsh=MzRlODBiNWFlZA==\">yosuahercules</a></p></blockquote><p>&nbsp;</p><p>Jadi, tunggu apa lagi? Cek video tutorialnya dan mulai buat fitur login Google di aplikasi Laravel Anda sekarang juga!</p><p>&nbsp;</p>', 'membuat-fitur-login-menggunakan-akun-google-dengan-laravel-jetstream', 17, 0, 1, 'membuat-fitur-login-menggunakan-akun-google-dengan-laravel-jetstream-laravel-jetstream-1.png', '2025-02-28 03:51:38', '2025-02-28 03:51:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `post_tags`
--

CREATE TABLE `post_tags` (
  `id_posts` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `post_tags`
--

INSERT INTO `post_tags` (`id_posts`, `id_tag`) VALUES
(2, 3),
(14, 3),
(13, 6),
(37, 6),
(81, 19),
(81, 26),
(100, 29),
(100, 30),
(1, 4),
(1, 3),
(38, 29),
(38, 32),
(114, 34),
(114, 19),
(113, 33),
(35, 32),
(35, 82),
(34, 19),
(36, 3),
(36, 86);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(2, 'Internet'),
(3, 'Artificial intelligence'),
(4, 'Tools'),
(6, 'Self Improvement'),
(19, 'laravel-tips'),
(26, 'CRUD'),
(29, 'programming'),
(30, 'coding'),
(32, 'codingproject'),
(33, 'chromedevtools'),
(34, 'laravel-jetstream'),
(81, 'website'),
(82, 'webdevelopment'),
(84, 'TechCarrier'),
(85, 'DigitalLearning'),
(86, 'EditingTools'),
(87, 'new'),
(89, 'test');

-- --------------------------------------------------------

--
-- Struktur dari tabel `text_snippets`
--

CREATE TABLE `text_snippets` (
  `id` int(11) NOT NULL,
  `text_content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `text_snippets`
--

INSERT INTO `text_snippets` (`id`, `text_content`) VALUES
(1, 'SMA Islamic Center Siak: Mencetak Generasi Unggul, Berprestasi, dan Berkarakter.'),
(3, 'Temukan Informasi Penting Seputar Pendidikan dan Perkembangan Siswa di Blog Ini.'),
(4, 'Dapatkan Tips dan Trik Belajar Efektif, Informasi Kegiatan Sekolah, dan Lainnya di Blog Kami.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'hashed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Admin', 'adminphp@gmail.com', 'admin123', '2025-02-28 03:49:40'),
(15, 'New Admin', 'adminblog123@gmail.com', '$2y$10$ow1CmTMNimdZxSdlQzh77efh0trTtI/IyFVxuURzTNtDV5jmmR2sm', '2025-02-16 09:01:11'),
(16, 'rehan', 'admin123@gmail.com', '$2y$10$5qwVUp.fDpCcDjdUzijoluBj.CyTTJdgF.o/Pyli4T2e9V26Wjr/a', '2025-02-20 14:39:48'),
(17, 'Nawawi', 'nawawi123@gmail.com', '$2y$10$IFWZ3o7pJPRZCU08nfBe6egrbT2KTH6afQwxvUAx06hpOJ.jbyr56', '2025-02-24 09:41:22'),
(18, 'user123', 'user123@gmail.com', '$2y$10$baH1rsJfT0pbSO.5.q67nOEXBnPifQplqltHEgVlNs39B58C0Toku', '2025-09-21 02:20:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_posts` (`post_id`),
  ADD KEY `user_fk` (`user_id`);

--
-- Indeks untuk tabel `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`user_id`,`interaction_type`),
  ADD KEY `interactions_ibfk_2` (`user_id`);

--
-- Indeks untuk tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `FK_tags` (`tag_id`),
  ADD KEY `FK_categories` (`category_id`),
  ADD KEY `FK_users` (`author_id`);
ALTER TABLE `posts` ADD FULLTEXT KEY `tittle` (`tittle`,`content`);
ALTER TABLE `posts` ADD FULLTEXT KEY `tittle_2` (`tittle`,`content`);
ALTER TABLE `posts` ADD FULLTEXT KEY `tittle_3` (`tittle`,`content`);
ALTER TABLE `posts` ADD FULLTEXT KEY `tittle_4` (`tittle`,`content`);

--
-- Indeks untuk tabel `post_tags`
--
ALTER TABLE `post_tags`
  ADD KEY `FK_post` (`id_posts`),
  ADD KEY `FK_tags` (`id_tag`);

--
-- Indeks untuk tabel `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `text_snippets`
--
ALTER TABLE `text_snippets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `interactions`
--
ALTER TABLE `interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT untuk tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT untuk tabel `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT untuk tabel `text_snippets`
--
ALTER TABLE `text_snippets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `interactions`
--
ALTER TABLE `interactions`
  ADD CONSTRAINT `interactions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users` FOREIGN KEY (`author_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `FK_post` FOREIGN KEY (`id_posts`) REFERENCES `posts` (`id_post`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_tags` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
