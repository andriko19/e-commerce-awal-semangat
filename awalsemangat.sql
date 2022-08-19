-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2022 at 11:41 AM
-- Server version: 10.3.35-MariaDB-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sugarkop_awalsemangat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `cookie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `cookie`) VALUES
(1, 'admin', '$2y$10$pKGfQG2etJ5lDW06PZncIOqY94RJTioYG4oM4n0/Up.cUpnX5HkRO', 'i9BjkXpzH08tMZY1FeHFqozayn8jUU5xvAmY9vToEMg732XuhDtklfLhb7K5GdyJ');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `img` varchar(30) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `img`, `url`) VALUES
(15, '1602041618492.jpg', '#');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `img` varchar(30) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `weight` int(11) NOT NULL,
  `ket` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `slug` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`, `slug`) VALUES
(8, 'Makanan', '1597743887720.png', 'makanan'),
(9, 'Minuman', '1599809761896.png', 'minuman');

-- --------------------------------------------------------

--
-- Table structure for table `cod`
--

CREATE TABLE `cod` (
  `id` int(11) NOT NULL,
  `regency_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cod`
--

INSERT INTO `cod` (`id`, `regency_id`) VALUES
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cost_delivery`
--

CREATE TABLE `cost_delivery` (
  `id` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cost_delivery`
--

INSERT INTO `cost_delivery` (`id`, `destination`, `price`) VALUES
(1, 177, 40000),
(2, 105, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `email_send`
--

CREATE TABLE `email_send` (
  `id` int(11) NOT NULL,
  `mail_to` int(11) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`id`, `page`, `type`) VALUES
(1, 1, 1),
(2, 3, 1),
(3, 2, 2),
(4, 1, 1),
(5, 4, 1),
(6, 5, 1),
(7, 6, 2),
(8, 7, 2),
(9, 8, 2),
(10, 7, 1),
(11, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `grosir`
--

CREATE TABLE `grosir` (
  `id` int(11) NOT NULL,
  `min` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `product` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `img_product`
--

CREATE TABLE `img_product` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `img` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `img_product`
--

INSERT INTO `img_product` (`id`, `id_product`, `img`) VALUES
(1, 22, '1589840767903.jpg'),
(2, 22, '1589840786550.jpg'),
(5, 22, '1589840836102.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `invoice_code` varchar(10) NOT NULL,
  `label` varchar(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `province` int(11) NOT NULL,
  `regency` int(11) NOT NULL,
  `district` varchar(50) NOT NULL,
  `village` varchar(50) NOT NULL,
  `zipcode` int(11) NOT NULL,
  `address` text NOT NULL,
  `courier` varchar(5) NOT NULL,
  `courier_service` varchar(70) NOT NULL,
  `ongkir` varchar(10) NOT NULL,
  `total_price` int(11) NOT NULL,
  `total_all` int(11) NOT NULL,
  `date_input` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `resi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `user`, `invoice_code`, `label`, `name`, `email`, `telp`, `province`, `regency`, `district`, `village`, `zipcode`, `address`, `courier`, `courier_service`, `ongkir`, `total_price`, `total_all`, `date_input`, `status`, `resi`) VALUES
(1, 1, '112782507', 'Rumah', 'Andrik', 'andrik.suprayitno@gmail.com', '083276543213', 11, 444, 'Benowo', 'Sememi', 60191, 'Sememi gang II no. 39', 'jne', 'CTC', '7000', 15000, 22000, '2020-10-21 11:11:47', 3, '112782507');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `content`, `slug`) VALUES
(1, 'Tentang Kami', '<p>Lakukan tugas Anda dengan senang hati dan gunakan humor Anda di waktu kerja terutama saat sulit dan tegang-tegang, itulah salah satu budaya (fun) kami.</p><p>Religious, Passionate, Tough, Knowledgeable, Fun &amp; Customer Service adalah budaya-budaya yang ada di Bhinneka.Com, dan kami sangat menjunjung tinggi budaya kami dengan cara memberikan yang terbaik bagi pelanggan, diri kita, keluarga, dan masyarakat.</p><h2>Visi dan Misi</h2><h3>Visi</h3><p>\"Menjadi sebuah perusahaan kelas dunia dengan semangat pemanfaatan informasi teknologi, dan menjadi kebanggaan bangsa.\"</p><h3>Misi</h3><p>\"Menjadi webstore nomor satu di Indonesia yang menyediakan kelengkapan dan kemudahan belanja, serta memperhatikan dan memberikan pengalaman belanja yang berkesan kepada pelanggan, melalui nilai-nilai delapan dimensi pengalaman.\"</p><h2>Sekapur Sirih</h2><p>Sejak awal Bhinneka.Com berdiri, kami bertekad membangun bisnis yang berdaya tahan panjang. Mengutamakan citra merk dengan pelayanan dan menjadikannya bagian dari budaya kerja. Fokus pada pelayanan berarti memberi nilai tambah dalam setiap layanan. Sebab itulah mengapa pelanggan kami menekan tombol\'beli\' dan tetap kembali lagi di kemudian hari.</p><p>Menengok sejenak ke belakang, kami bersyukur fokus pada pelayanan dan \'human touch\' dalam membangun Bhinneka.Com, yang dirumuskan dengan sebuah kalimat sederhana \'Pelayanan Dari Hati\'. Dan sekarang, kalimat ini telah menjadi esensi dalam setiap langkah yang kami lakukan, mudah dicerna tanpa perlu segala embel-embel dan frase-frase yang sulit untuk dipahami seluruh Bhinnekaners dalam melayani pelanggan kami.</p><p>Standar pelayanan kami pun semakin tinggi setiap tahun. Berinovasi dan menyajikan pengalamanan berbelanja yang berkesan, mulai dari produk yang lengkap, harga yang kompetitif, mudah dalam bertransaksi, jaminan purna jual, hingga kejutan-kejutan mengasyikkan untuk setiap pelanggan kami, yang menjadikan belanja di Bhinneka.Com semakin nyaman, baik online maupun offline.</p><p>Untuk teman-teman komunitas Bhinneka.Com yang bersama dengan kami sejak awal perkembangan internet dimulai di Indonesia, kami akan terus perhatikan dan senantiasa mengembangkan banyak fitur yang akan semakin asyik untuk saling bertemu, berbagi, berbincang, belajar, atau sekedar melakukan jual-beli produk. Offline store Bhinneka juga menjadi tempat untuk workshop, tempat berkumpul, dan ngobrol antar komunitas.</p><p>Akhirnya, saya sangat berbahagia Bhinneka.Com dapat berkontribusi untuk negeri ini dan membawa nilai lebih untuk masyarakat Indonesia. Kami akan selalu berusaha dan mendorong diri kami sendiri untuk menjadi salah satu perusahaan berbasis teknologi yang menjadi kebanggaan bangsa Indonesia.</p>', 'about'),
(2, 'Kontak Kami', '<p>Hubungi Tim Penjualan Kami</p><p><strong>Konsultan Penjualan</strong></p><p>Melayani kebutuhan Anda untuk seluruh kategori produk. Silakan hubungi 021-29292828 atau <a href=\"https://www.bhinneka.com/hubungi-kami-form\">email kami</a>.</p><p><strong>Korporasi &amp; Pemerintah.</strong></p><p>Melayani kebutuhan korporasi &amp; proyek. Silakan email kami ke <a href=\"mailto:corporate@bhinneka.com\">corporate@bhinneka.com</a>.</p><p><strong>Solusi Software &amp; Lisensi</strong></p><p>Melayani kebutuhan lisensi &amp; konsultasi software. Silakan email kami ke <a href=\"mailto:licensing@bhinneka.com\">licensing@bhinneka.com</a>.</p><p><strong>Solusi Percetakan &amp; Signage</strong></p><p>Melayani kebutuhan printer besar, signage, &amp; produk 3D. Silakan <a href=\"https://www.bhinneka.com/hubungi-kami-form\">email kami</a>.</p><p><strong>Kantor Pusat</strong><br>Jl. Gunung Sahari Raya 73C No. 5-6<br>Jakarta 10610, Indonesia</p><p>Hubungi Tim Pendukung Kami</p><p><strong>Layanan Klaim Garansi</strong></p><p>Untuk bantuan teknisi dan klaim garansi produk, silakan telepon ke (021) 2929-2828 atau <a href=\"https://www.bhinneka.com/hubungi-kami-form\">email kami</a>.</p><p><strong>Layanan Pengembalian Barang &amp; Refund</strong></p><p>Jika produk yang diterima salah/cacat/rusak &amp; ingin mengurus pengembalian dana, untuk laporan dan bantuan dapat menghubungi kami <a href=\"https://www.bhinneka.com/hubungi-kami-form\">email kami</a>.</p><p><strong>Layanan Pelanggan</strong></p><p>Silakan berikan feedback atas pelayanan yang kurang berkenan dari tim kami. Tuliskan masukan Anda <a href=\"https://www.bhinneka.com/hubungi-kami-form\">email kami</a>.</p><p><strong>Status Pengiriman</strong></p><p>Untuk bantuan tracking status pesanan &amp; status pengiriman, silakan telepon ke (021) 2929-2828 atau Anda dapat menghubungi kami <a href=\"https://www.bhinneka.com/hubungi-kami-form\">email kami</a>.</p><p><strong>Merchant Bhinneka Marketplace</strong></p><p>Ingin memulai jualan di Bhinneka? Anda bisa mendaftar menjadi merchant &amp; bertanya seputar Bhinneka Marketplace <a href=\"https://www.bhinneka.com/hubungi-kami-form\">email kami</a>.</p><p><strong>Tidak Dapat Menemukan Tim yang Anda Cari?</strong></p><p>Anda dapat menghubungi kami <a href=\"https://www.bhinneka.com/hubungi-kami-form\">email kami</a>.</p>', 'contact'),
(3, 'Testimoni', '<p>redirect page</p>', 'testimoni'),
(4, 'Kebijakan Privasi', '<h2><strong>KEBIJAKAN PRIVASI SITUS DAN APLIKASI MATAHARI</strong></h2><p>MATAHARI memahami dan menghormati privasi Anda dan nilai hubungan kami dengan Anda. Kebijakan Privasi ini menjelaskan bagaimana Matahari mengumpulkan, mengatur dan melindungi informasi Anda ketika Anda mengunjungi dan/atau menggunakan situs atau aplikasi MATAHARI, bagaimana Matahari menggunakan informasi dan kepada siapa Matahari dapat berbagi. Kebijakan privasi ini juga memberitahu Anda bagaimana Anda dapat meminta Matahari untuk mengakses atau mengubah informasi Anda serta menjawab pertanyaan Anda sehubungan dengan Kebijakan Privasi ini.<br>Kata-kata yang dimulai dengan huruf besar dalam Kebijakan Privacy ini mempunyai pengertian yang sama dengan Syarat dan Ketentuan penggunaan situs dan aplikasi MATAHARI.</p><h2><strong>Informasi yang kami kumpulkan</strong></h2><p>Matahari dapat memperoleh dan mengumpulkan informasi dan/atau konten dari situs dan aplikasi yang Anda atau pengguna lain sambungkan atau disambungkan oleh situs atau aplikasi MATAHARI dengan situs atau pengguna tertentu dan informasi dan/atau konten yang Anda berikan melalui penggunaan situs atau aplikasi MATAHARI dan/atau pengisian Aplikasi.<br>Ketika Anda mengunjungi situs atau aplikasi MATAHARI, Matahari dapat mengumpulkan informasi apapun yang telah dipilih bisa terlihat oleh semua orang dan setiap informasi publik yang tersedia. Informasi ini dapat mencakup nama Anda, gambar profil, jenis kelamin, kota saat ini, hari lahir, email, jaringan, daftar teman, dan informasi-informasi Anda lainnya yang tersedia dalam jaringan. Selain itu, ketika Anda menggunakan aplikasi MATAHARI, atau berinteraksi dengan alat terkait, widget atau plug-in, Matahari dapat mengumpulkan informasi tertentu dengan cara otomatis, seperti cookies dan web beacon. Informasi yang Matahari kumpulkan dengan cara ini termasuk alamat IP, perangkat pengenal unik, karakteristik perambah, karakteristik perangkat, sistem operasi, preferensi bahasa, URL, informasi tentang tindakan yang dilakukan, tanggal dan waktu kegiatan. Melalui metode pengumpulan otomatis ini, Matahari mendapatkan informasi mengenai Anda. Matahari mungkin menghubungkan unsur-unsur tertentu atas data yang telah dikumpulkan melalui sarana otomatis, seperti informasi browser Anda, dengan informasi lain yang diperoleh tentang Anda, misalnya, apakah Anda telah membuka email yang dikirimkan kepada Anda. Matahari juga dapat menggunakan alat analisis pihak ketiga yang mengumpulkan informasi tentang lalu lintas pengunjung situs atau aplikasi MATAHARI. Browser Anda mungkin memberitahu Anda ketika Anda menerima cookie jenis tertentu atau cara untuk membatasi atau menonaktifkan beberapa jenis cookies. Harap dicatat, bahwa tanpa cookie Anda mungkin tidak dapat menggunakan semua fitur dari situs atau aplikasi MATAHARI.<br>Situs atau aplikasi MATAHARI mungkin berisi link ke tempat pihak lain yang dapat dioperasikan oleh pihak lain tersebut yang mungkin tidak memiliki kebijakan privasi yang sama dengan Matahari. Matahari sangat menyarankan Anda untuk membaca dan mempelajari kebijakan privasi dan ketentuan-ketentuan pihak lain tersebut sebelum masuk atau menggunakannya. Matahari tidak bertanggung jawab atas pengumpulan dan/atau penyebaran informasi pribadi Anda oleh pihak lain atau yang berkaitan dengan penggunaan media sosial seperti Facebook dan Twitter dan Matahari dibebaskan dari segala akibat yang timbul atas penyebaran dan/atau penyalahgunaan informasi tersebut.</p><h2><strong>BAGAIMANA MATAHARI MENGGUNAKAN INFORMASI</strong></h2><p>Matahari dapat menggunakan informasi Anda yang diperoleh untuk menyediakan produk dan layanan yang Anda minta, sebagai data riset atau berkomunikasi tentang dan/atau mengelola partisipasi Anda dalam survei atau undian atau kontes atau acara khusus lainnya yang diadakan oleh Matahari, pengoperasian Matahari, memberikan dukungan kepada Anda sebagai pengunjung dan/atau pengguna situs atau aplikasi MATAHARI, merespon dan berkomunikasi dengan Anda mengenai permintaan Anda, pertanyaan dan/atau komentar Anda, membiarkan Anda untuk meninggalkan komentar di situs atau aplikasi MATAHARI atau melalui media sosial lainnya, membangun dan mengelola Akun Anda, mengirimkan berita-berita dan/atau penawaran-penawaran yang berlaku bagi Anda selaku pengunjung dan penguna situs atau aplikasi MATAHARI, untuk mengoperasikan, mengevaluasi dan meningkatkan bisnis Matahari termasuk untuk mengembangkan produk dan layanan baru; untuk mengelola komunikasi Matahari, menentukan efektifitas layanan, pemasaran dan periklanan situs atau aplikasi MATAHARI, dan melakukan akutansi, audit, dan kegiatan Matahari lainnya, melakukan analisis data termasuk pasar dan pencarian konsumen, analisis trend, keuangan, dan informasi pribadi, melaksanakan kerjasama dengan mitra Matahari yang terkait dengan program-program yang diadakan oleh Matahari, melindungi, mengidentifikasi, dan mencegah penipuan dan kegiatan kriminal lainnya, klaim dan kewajiban lainnya, membantu mendiagnosa masalah teknis dan layanan, untuk memelihara, mengoperasikan, atau mengelola situs atau aplikasi MATAHARIyang dilakukan oleh Matahari atau pihak lain yang ditentukan oleh Matahari, mengidentifikasi pengguna situs atau aplikasi MATAHARI, serta mengumpulkan informasi demografis tentang pengguna situs atau aplikasi MATAHARI, untuk cara lain yang Matahari beritahukan pada saat pengumpulan informasi.<br>Matahari tidak akan menjual atau memberikan informasi pribadi Anda kepada pihak lain, kecuali seperti yang dijelaskan dalam kebijakan privasi ini. Matahari akan berbagi informasi dengan afiliasi Matahari atau pihak lain yang melakukan layanan berdasarkan petunjuk dari Matahari. Pihak lain tersebut tidak diizinkan untuk menggunakan atau mengungkapkan informasi tersebut kecuali diperlukan untuk melakukan layanan atas nama Matahari atau untuk mematuhi persyaratan hukum. Matahari juga dapat berbagi informasi dengan pihak lain yang merupakan mitra Matahari untuk menawarkan produk atau jasa yang mungkin menarik bagi Anda<br>Matahari dapat mengungkapkan informasi jika dianggap perlu dalam kebijakan tunggal Matahari, untuk mematuhi hukum yang berlaku, peraturan, proses hukum atau permintaan pemerintah, dan peraturan yang berlaku di Matahari. Selain itu, Matahari dapat mengungkapkan informasi ketika percaya, pengungkapan diperlukan atau wajib dilakukan untuk mencegah kerusakan fisik atau kerugian finansial atau hal lainnya sehubungan dengan dugaan atau terjadinya kegiatan ilegal. Matahari juga berhak untuk mengungkapkan dan/atau mengalihkan informasi yang dimiliki apabila sebagian atau seluruh bisnis atau aset Matahari dijual atau dialihkan.<br>Matahari dapat menyimpan dan/atau memusnahkan informasi tentang Anda sesuai kebijakan yang berlaku atau jika diperlukan.</p><h2><strong>UPDATE KEBIJAKAN PRIVASI INI</strong></h2><p>Kebijakan Privasi ini mungkin diperbarui secara berkala dan tanpa pemberitahuan sebelumnya kepada Anda untuk mencerminkan perubahan dalam praktik informasi pribadi. Matahari akan menampilkan pemberitahuan di bagian info profil website untuk memberitahu Anda tentang perubahan terhadap Kebijakan Privasi dan menunjukkan di bagian atas Kebijakan saat ketika Kebijakan Privasi ini terakhir diperbarui. Kebijakan Privasi ini merupakan satu kesatuan dan menjadi bagian yang tidak terpisahkan dari Syarat dan Ketentuan Penggunaan situs dan aplikasi MATAHARI.</p>', 'privacy-policy'),
(5, 'Syarat dan Ketentuan', '<h2><strong>SYARAT DAN KETENTUAN SITUS DAN APLIKASI MATAHARI</strong></h2><p>Selamat datang dan terima kasih telah mengunjungi situs/aplikasi MATAHARI. Silahkan membaca Syarat dan Ketentuan ini dengan seksama. Syarat dan Ketentuan ini mengatur akses, penelusuran, penggunaan, dan pembelian barang-barang yang ditawarkan atau dijual di www.MATAHARI.com kepada Anda. Dengan mengakses, menelusuri, dan menggunakan situs/aplikasi MATAHARI ini, berarti Anda telah membaca, mengerti, dan setuju untuk tunduk dan terikat pada Syarat dan Ketentuan ini, dan Anda juga setuju untuk tidak mempengaruhi, mengganggu, atau berusaha mempengaruhi atau mengganggu jalannya situs/aplikasi MATAHARI dengan cara apapun. Jika Anda tidak menyetujui salah satu, sebagian, atau seluruh isi Syarat dan Ketentuan ini, maka Anda tidak diperkenankan untuk mengakses, menelusuri atau menggunakan situs/aplikasi MATAHARI ini. Akses, penelusuran, dan penggunaan situs/aplikasi MATAHARI ini hanya untuk penggunaan pribadi Anda. Anda tidak diperkenankan untuk mendistribusikan, memodifikasi, menjual, atau mengirimkan apapun yang Anda akses dari situs/aplikasi MATAHARI ini, termasuk tetapi tidak terbatas pada teks, gambar, audio, dan video untuk keperluan bisnis, komersial, publik atau kepeluan non-personal lainnya.<br>Penggunaan konten situs/aplikasi MATAHARI, logo MATAHARI, merek layanan dan/atau merek dagang yang tidak sah dapat melanggar undang-undang hak kekayaan intelektual, hak cipta, merek, privasi, publisitas, hukum perdata dan pidana tertentu. Syarat dan Ketentuan ini termasuk hak kekayaan intelektual milik MATAHARI yang dilindungi hak cipta. Setiap penggunaan Syarat dan Ketentuan ini oleh pihak manapun, baik sebagian maupun seluruhnya, tidak diizinkan. Pelanggaran atas hak atas kekayaan intelektual MATAHARI ini dapat dikenakan tindakan atau sanksi berdasarkan ketentuan hukum yang berlaku.<br>Anda perlu mengunjungi halaman ini secara berkala untuk mengetahui setiap perubahan Syarat dan Ketentuan ini.</p>', 'terms'),
(6, 'Cara Berbelanja', '<p>Anda bisa mengklik “Blanja sekarang” di blanja.com untuk membeli produk, atau Anda bisa menambahkan produk ke Favorit dahulu lalu menempatkan pesanan.</p><p><strong>1. Blanja sekarang</strong></p><p>1.1 Jika Anda ingin membeli produk langsung ketika Anda melihatnya di Product Detail Page (gambar di bawah), Anda bisa mengklik “Blanja sekarang” setelah Anda memilih atribut, jumlah, dll. dari produk tersebut.</p><figure class=\"image\"><img src=\"https://s2.blanja.com/static/marketplace/images/help-center/questionlist-11-1_001.jpg\" alt=\"register_1\"></figure><p>1.2 Setelah Anda mengkonfirmasi alamat pengiriman, informasi pesanan dan informasi lainnya, klik “Selanjutnya”.</p><figure class=\"image\"><img src=\"https://s2.blanja.com/static/marketplace/images/help-center/questionlist-11-1_002.jpg\" alt=\"register_1\"></figure><p>1.3 Anda bisa masuk ke “My blanja”-“Pesanan Saya” dan melihat pesanan yang telah ditempatkan. Jika Anda sudah mengkonfirmasi jumlah dari pesanan tersebut, klik “Bayar”.</p><figure class=\"image\"><img src=\"https://s2.blanja.com/static/marketplace/images/help-center/questionlist-11-1_003.jpg\" alt=\"register_1\"></figure><p>1.4 Masuk ke halaman pembayaran dan bayarkan pesanan. Status pemesanan akan berubah menjadi “Telah dibayar”, yang artinya barang sedang menunggu dikirim oleh penjual.</p><figure class=\"image\"><img src=\"https://s2.blanja.com/static/marketplace/images/help-center/questionlist-11-1_004.jpg\" alt=\"register_1\"></figure><p>1.5 Setelah penjual berhasil mengirimkan barang, status pemesanan akan berubah menjadi “Telah dikirim”. Ketika anda menerima barang dan mengkonfirmasi, mohon klik “Konfirmasi”.</p><figure class=\"image\"><img src=\"https://s2.blanja.com/static/marketplace/images/help-center/questionlist-11-1_005.jpg\" alt=\"register_1\"></figure><p>Anda harus memasukkan password Dompet Blanja sebelum mengklik “Konfirmasi”.</p><figure class=\"image\"><img src=\"https://s2.blanja.com/static/marketplace/images/help-center/questionlist-11-1_006.png\" alt=\"register_1\"></figure><p>1.6 Ketika status berubah ke \"Selesai\", maka berarti transaksi telah selesai</p><figure class=\"image\"><img src=\"https://s2.blanja.com/static/marketplace/images/help-center/questionlist-11-1_007.jpg\" alt=\"register_1\"></figure><p><strong>Checkout beberapa produk yang telah ditambahkan ke Troli blanja secara bersamaan</strong></p><p>Anda bisa menambahkan beberapa produk ke Troli blanja dan membelinya secara bersamaan, lalu menempatkan pesanan dan membayar sekali sekaligus. Prosesnya sama seperti proses “Blanja sekarang”.</p>', 'shopping-help'),
(7, 'Pengiriman Barang', '<ol><li>Pengiriman barang untuk setiap transaksi yang terjadi melalui Platform Bukalapak menggunakan layanan pengiriman barang yang disediakan Bukalapak atas kerjasama Bukalapak dengan pihak jasa ekspedisi pengiriman barang resmi.</li><li>Pengguna memahami dan menyetujui bahwa segala bentuk peraturan terkait dengan syarat dan ketentuan pengiriman barang sepenuhnya ditentukan oleh pihak jasa ekspedisi pengiriman barang dan sepenuhnya menjadi tanggung jawab pihak jasa ekspedisi pengiriman barang.</li><li>Bukalapak hanya berperan sebagai media perantara antara Pengguna dengan pihak jasa ekspedisi pengiriman barang.</li><li>Pengguna wajib memahami, menyetujui, serta mengikuti ketentuan-ketentuan pengiriman barang yang telah dibuat oleh pihak jasa ekspedisi pengiriman barang.</li><li>Pengiriman barang atas transaksi melalui sistem Bukalapak menggunakan jasa ekspedisi pengiriman barang dilakukan dengan tujuan agar barang dapat dipantau melalui sistem Bukalapak.</li><li>Pelapak (Penjual) wajib bertanggung jawab penuh atas barang yang dikirimnya.</li><li>Pengguna memahami dan menyetujui bahwa segala bentuk kerugian yang dapat timbul akibat kerusakan ataupun kehilangan pada barang, baik pada saat pengiriman barang tengah berlangsung maupun pada saat pengiriman barang telah selesai, adalah sepenuhnya tanggung jawab pihak jasa ekspedisi pengiriman barang.</li><li>Dalam hal diperlukan untuk dilakukan proses pengembalian barang, maka Pengguna, baik Pelapak (Penjual) maupun Pembeli, diwajibkan untuk melakukan pengiriman barang langsung ke masing-masing Pembeli maupun Pelapak (Penjual). Bukalapak tidak menerima pengembalian atau pengiriman barang atas transaksi yang dilakukan oleh Pengguna dalam kondisi apa pun.</li></ol>', 'pengiriman-barang'),
(8, 'Konfirmasi Pembayaran', '', 'payment/confirmation');

-- --------------------------------------------------------

--
-- Table structure for table `payment_proof`
--

CREATE TABLE `payment_proof` (
  `id` int(11) NOT NULL,
  `invoice` varchar(30) NOT NULL,
  `file` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_proof`
--

INSERT INTO `payment_proof` (`id`, `invoice`, `file`, `status`) VALUES
(1, '112782507', '1603253676455.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `condit` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `img` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date_submit` datetime NOT NULL,
  `publish` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `transaction` int(11) NOT NULL,
  `promo_price` int(11) NOT NULL,
  `viewer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `stock`, `category`, `condit`, `weight`, `img`, `description`, `date_submit`, `publish`, `slug`, `transaction`, `promo_price`, `viewer`) VALUES
(24, 'Salad Buah 500 gram', 15000, 9, 8, 1, 500, '1599792571421.JPG', '<p>Salad buah sari rasa kemasan 500 gram harga Rp.15.000.-</p>', '2020-09-11 09:49:31', 2, 'salad-buah-500-gram', 1, 0, 40),
(25, 'Salad Buah 400 gram', 10000, 10, 8, 1, 400, '1599792709869.JPG', '<p>Salad buah sari rasa kemasan 40 gram harga Rp.10.000.-</p>', '2020-09-11 09:51:49', 2, 'salad-buah-400-gram', 0, 0, 26),
(26, 'Salad Buah 200 gram', 8000, 10, 8, 1, 200, '1599792806679.JPG', '<p>Salad buah sari rasa kemasan 200 gram harga Rp.8.000.-</p>', '2020-09-11 09:53:26', 2, 'salad-buah-200-gram', 0, 0, 25),
(28, 'Choco RedVelvet', 10000, 10, 9, 1, 500, '1602042422512.JPG', 'Choco RedVelvet', '2020-10-07 10:47:02', 1, 'redvelvet-choco', 0, 0, 66),
(29, 'Special Oreo', 10000, 10, 9, 1, 500, '1602042569225.jpg', 'Special Oreo', '2020-10-07 10:49:29', 1, 'special-oreo', 0, 0, 43),
(30, 'Special RedVelvet', 10000, 10, 9, 1, 500, '1602042764461.jpg', 'Special RedVelvet', '2020-10-07 10:52:44', 1, 'special-redvelvet', 0, 0, 37),
(31, 'Special Choco', 10000, 10, 9, 1, 500, '1602042985585.JPG', 'Special Choco', '2020-10-07 10:56:25', 1, 'special-choco', 0, 0, 44),
(32, 'Special Cappucino', 10000, 10, 9, 1, 500, '1602043296358.JPG', 'Special Cappucino', '2020-10-07 11:01:36', 1, 'special-cappucino', 0, 0, 34),
(33, 'Chappucino Choco', 10000, 10, 9, 1, 500, '1602043434326.JPG', 'Chappucino Choco', '2020-10-07 11:03:54', 1, 'chappucino-choco', 0, 0, 36),
(34, 'Special GreenTea', 10000, 10, 9, 1, 500, '1602043597685.JPG', 'Special GreenTea', '2020-10-07 11:06:37', 1, 'special-greentea', 0, 0, 30),
(35, 'RedVelvet GreenTea', 10000, 10, 9, 1, 500, '1602043761469.JPG', 'RedVelvet GreenTea', '2020-10-07 11:09:21', 1, 'redvelvet-greentea', 0, 0, 29),
(36, 'GreenTea Choco', 10000, 10, 9, 1, 500, '1602043886130.JPG', 'GreenTea Choco', '2020-10-07 11:11:26', 1, 'greentea-choco', 0, 0, 45),
(37, 'Special Taro', 10000, 10, 9, 1, 500, '1602044016978.JPG', 'Special Taro', '2020-10-07 11:13:36', 1, 'special-taro', 0, 0, 28),
(38, 'Choco Nutella', 15000, 10, 9, 1, 500, '1602044164151.JPG', 'Choco Nutella', '2020-10-07 11:16:04', 1, 'choco-nutella', 0, 0, 23),
(39, 'Taro Choco', 10000, 10, 9, 1, 500, '1602044290781.JPG', 'Taro Choco', '2020-10-07 11:18:10', 1, 'taro-choco', 0, 0, 67),
(40, 'Manggo Yakult', 15000, 10, 9, 1, 500, '1602215863742.JPG', 'Manggo Yakult', '2020-10-09 10:57:43', 1, 'manggo-yakult', 0, 0, 50),
(41, 'Brown Sugar Macchiato', 17500, 10, 9, 1, 500, '1602216009919.jpg', 'Brown Sugar Macchiato', '2020-10-09 11:00:09', 2, 'brown-sugar-macchiato', 0, 0, 40),
(44, 'Lychee Yakult', 15000, 10, 9, 1, 500, '1602227117118.jpg', 'Lychee Yakult', '2020-10-09 14:05:17', 1, 'lychee-yakult', 0, 0, 67),
(45, 'Strawberry Yakult', 15000, 50, 9, 1, 500, '1634112667671.png', '<p>Strawberry Yakult</p>', '2021-10-13 15:11:07', 1, 'strawberry-yakult', 0, 0, 9),
(51, 'Special BubbleGum', 10000, 50, 9, 1, 500, '1655202054207.png', '<p>Special BubbleGum</p>', '2022-06-14 17:20:54', 1, 'special-bubblegum', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id` int(11) NOT NULL,
  `rekening` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id`, `rekening`, `name`, `number`) VALUES
(1, 'DANA', 'Toni Suwendi', '088215005600'),
(3, 'GOPAY', 'Toni Suwendi', '088215005600'),
(7, 'OVO', 'Toni Suwendi', '088215005600');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `promo` int(11) NOT NULL,
  `promo_time` varchar(40) NOT NULL,
  `short_desc` text NOT NULL,
  `address` varchar(100) NOT NULL,
  `regency_id` int(11) NOT NULL,
  `verify` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `promo`, `promo_time`, `short_desc`, `address`, `regency_id`, `verify`) VALUES
(1, 0, '2020-08-20T17:03', 'Awal Semangat adalah sebuah situs toko online mudah dan terpercaya. Kami memiliki toko fisik yang bisa Anda kunjungi. Disini jual beragam makanan dan minuman.', 'Jl. Raya Benowo.', 444, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sosmed`
--

CREATE TABLE `sosmed` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `link` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sosmed`
--

INSERT INTO `sosmed` (`id`, `name`, `icon`, `link`) VALUES
(1, 'Facebook', 'fab fa-facebook-f', 'https://www.facebook.com/sari.rasa.79219754'),
(3, 'Instagram', 'fab fa-instagram', 'https://www.instagram.com/sarirasa93/'),
(4, 'Bukalapak', 'fas fa-shopping-cart', 'https://www.bukalapak.com/u/sarirasa93'),
(5, 'Tokopedia', 'fas fa-dumpster', 'https://www.tokopedia.com/sarisara');

-- --------------------------------------------------------

--
-- Table structure for table `subscriber`
--

CREATE TABLE `subscriber` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_subs` datetime NOT NULL,
  `code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriber`
--

INSERT INTO `subscriber` (`id`, `email`, `date_subs`, `code`) VALUES
(0, 'Semua Email', '2020-04-21 13:59:23', ''),
(1, 'andrik.suprayitno@gmail.com', '2020-08-18 14:45:19', '159773671919791'),
(2, 'andriksuprayitno@uwp.ac.id', '2020-10-21 10:19:36', '160325037627002102'),
(3, 'andriksuprayitno@uwp.ac.id', '2021-10-13 09:58:59', '16340939391229825071'),
(4, 'andriksuprayitno@uwp.ac.id', '2021-10-13 11:18:17', '1634098697387652827'),
(5, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:08:35', '16341017151856414216'),
(6, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:12:50', '16341019702020349256'),
(7, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:15:04', '16341021042016177546'),
(8, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:19:35', '1634102375652762295'),
(9, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:21:43', '16341025031017733104'),
(10, 'andriksuprayitno@gmail.com', '2021-10-13 12:26:54', '16341028141771909497'),
(11, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:28:44', '16341029241011665526'),
(12, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:40:48', '16341036482048304155'),
(13, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:43:37', '16341038172007858470'),
(14, 'andrisuprayitno@uwp.ac.id', '2021-10-13 12:46:05', '1634103965563204976'),
(15, 'andriksuprayitno@uwp.ac.id', '2021-10-13 12:46:39', '16341039991420601966'),
(16, 'mutini002002@gmail.com', '2021-10-13 12:49:40', '163410418026088215'),
(17, 'andriksuprayitno@uwp.ac.id', '2021-10-13 13:13:28', '1634105608172456721'),
(18, 'ajengraka035@gmail.com', '2022-07-14 10:05:41', '16577679411141389295');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial`
--

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `photo` varchar(30) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testimonial`
--

INSERT INTO `testimonial` (`id`, `name`, `photo`, `content`) VALUES
(2, 'Een Enarsih - Banten', '', 'Sis barang ny dh sya trima,mkasih bnyak untuk layan’n ny sngat m’muaskan untuk sya,smu prtanya’n di jwab…\r\nRespon ny jga sngat baek,smoga usaha ny smakin brkembang'),
(3, 'Ayung Darma - Pekalongan', '', 'Oia mf sis,Nich brg nya brsan aja ampe, mksh ya\r\nBrg nya bgs banget, sesuai yg digambarnya, makasih ya'),
(5, 'Dewanti - Solo', '', 'Barang tidak mengecewakan.. cs nya fast respon, resi besoknya langsung di share tanpa kita tanya.. mantap awal semangat'),
(6, 'Dina - Malang', '', 'Respon cs baik, tapi untuk pengirimannya agak lama, padahal pakai ekspedisi ”sicepat”\r\nharusnya bisa cepat sampainya.');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `ket` varchar(100) NOT NULL,
  `img` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `id_invoice`, `user`, `product_name`, `price`, `qty`, `slug`, `ket`, `img`) VALUES
(1, 112782507, 1, 'Salad Buah 500 gram', 15000, 1, 'salad-buah-500-gram', '', '1599792571421.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `date_register` datetime NOT NULL,
  `is_activate` int(1) NOT NULL,
  `token` varchar(100) NOT NULL,
  `token_reset` varchar(100) NOT NULL,
  `cookie` varchar(100) NOT NULL,
  `photo_profile` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `email`, `password`, `date_register`, `is_activate`, `token`, `token_reset`, `cookie`, `photo_profile`) VALUES
(1, 'Andrik', 'andrik', 'andrik.suprayitno@gmail.com', '$2y$10$CO.bE7K7vQj1pqtbGWx5eOJO1qtQMSg/yc1qdFadOsgcZgFR4RFLu', '2020-08-18 14:45:19', 1, 'e6fffc104fe98b8a2191863cf132f72e15ae2c72', '', '', '1597740625861.jpg'),
(17, 'Raka Ajeng Pertiwi Lubis ', 'raka-ajeng-pertiwi-lubis', 'ajengraka035@gmail.com', '$2y$10$ZAv4JCQZ3V1yaNGOs0ljgeo9iS3kSDVDtLIwBwWG1GEUwIVSWNp7y', '2022-07-14 10:05:41', 0, '1b1c2c13d7cbc1234925342419298f0e597a33bd', '', '', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cod`
--
ALTER TABLE `cod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cost_delivery`
--
ALTER TABLE `cost_delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_send`
--
ALTER TABLE `email_send`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grosir`
--
ALTER TABLE `grosir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `img_product`
--
ALTER TABLE `img_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_proof`
--
ALTER TABLE `payment_proof`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sosmed`
--
ALTER TABLE `sosmed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriber`
--
ALTER TABLE `subscriber`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial`
--
ALTER TABLE `testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cod`
--
ALTER TABLE `cod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cost_delivery`
--
ALTER TABLE `cost_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `email_send`
--
ALTER TABLE `email_send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `grosir`
--
ALTER TABLE `grosir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `img_product`
--
ALTER TABLE `img_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payment_proof`
--
ALTER TABLE `payment_proof`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sosmed`
--
ALTER TABLE `sosmed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subscriber`
--
ALTER TABLE `subscriber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `testimonial`
--
ALTER TABLE `testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
