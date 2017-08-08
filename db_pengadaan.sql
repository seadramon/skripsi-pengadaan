-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.27-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table db_pengadaan.auth_pages
CREATE TABLE IF NOT EXISTS `auth_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `menu_id` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=177 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table db_pengadaan.auth_pages: ~63 rows (approximately)
DELETE FROM `auth_pages`;
/*!40000 ALTER TABLE `auth_pages` DISABLE KEYS */;
INSERT INTO `auth_pages` (`id`, `group_id`, `menu_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 1, 4),
	(5, 1, 5),
	(6, 1, 7),
	(35, 1, 18),
	(36, 1, 19),
	(37, 1, 20),
	(38, 1, 21),
	(39, 1, 22),
	(40, 1, 23),
	(42, 1, 25),
	(43, 1, 26),
	(44, 1, 27),
	(45, 1, 28),
	(46, 1, 29),
	(65, 1, 31),
	(66, 1, 32),
	(67, 1, 33),
	(68, 1, 34),
	(69, 1, 35),
	(70, 1, 36),
	(71, 1, 37),
	(72, 1, 38),
	(73, 1, 39),
	(124, 1, 40),
	(125, 3, 23),
	(126, 3, 25),
	(127, 3, 28),
	(128, 3, 31),
	(129, 3, 32),
	(130, 3, 33),
	(131, 3, 38),
	(132, 3, 39),
	(133, 5, 23),
	(134, 5, 40),
	(135, 5, 31),
	(136, 5, 38),
	(137, 5, 39),
	(153, 4, 23),
	(154, 4, 29),
	(155, 4, 31),
	(156, 4, 34),
	(157, 4, 35),
	(158, 4, 36),
	(159, 4, 37),
	(160, 2, 18),
	(161, 2, 19),
	(162, 2, 20),
	(163, 2, 21),
	(164, 2, 22),
	(165, 2, 23),
	(166, 2, 26),
	(167, 2, 27),
	(168, 2, 29),
	(169, 2, 31),
	(170, 2, 32),
	(171, 2, 33),
	(172, 2, 34),
	(173, 2, 35),
	(174, 2, 36),
	(175, 2, 37),
	(176, 1, 41);
/*!40000 ALTER TABLE `auth_pages` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `idbarang` varchar(6) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'aktif',
  `deskripsi` varchar(50) NOT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idbarang`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.barang: ~15 rows (approximately)
DELETE FROM `barang`;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` (`idbarang`, `nama`, `satuan`, `status`, `deskripsi`, `urut`) VALUES
	('BG0001', 'Tawas Vip', 'gram', 'aktif', 'urgent', 1),
	('BG0002', 'Barang Tes', 'kg', 'aktif', 'bahan material', 2),
	('BG0003', 'Minex 7', 'kg', 'aktif', '', 3),
	('BG0004', 'Ancamine K 54', 'kg', 'aktif', '', 4),
	('BG0005', 'Lead Octoate 30%', 'kg', 'aktif', '', 5),
	('BG0006', 'Acrysol Rm 2020npr', 'kg', 'aktif', '', 6),
	('BG0007', 'Triton Cf-10', 'kg', 'aktif', '', 7),
	('BG0008', 'Octoate', 'kg', 'aktif', '', 8),
	('BG0009', 'Octoate 50%', 'kg', 'aktif', '', 9),
	('BG0010', 'Gas LPG 30', 'kg', 'aktif', '', 10),
	('BG0011', 'Gas LPG LO', 'kg', 'aktif', '', 11),
	('BG0012', 'Gas LPG 51%', 'kg', 'aktif', '', 12),
	('BG0013', 'Alcohols', 'liter', 'aktif', 'alcohol 100%', 13),
	('BG0014', 'Minyak Telon Aromaterapi', 'liter', 'aktif', '', 14),
	('BG0015', 'Buku', 'kg', 'aktif', '', 15),
	('BG0016', 'Pulpen', 'kg', 'aktif', '', 16);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.barangkeluar
CREATE TABLE IF NOT EXISTS `barangkeluar` (
  `idbarangkeluar` varchar(7) NOT NULL,
  `idminta` varchar(7) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idbarangkeluar`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.barangkeluar: ~3 rows (approximately)
DELETE FROM `barangkeluar`;
/*!40000 ALTER TABLE `barangkeluar` DISABLE KEYS */;
INSERT INTO `barangkeluar` (`idbarangkeluar`, `idminta`, `tanggal`, `keterangan`, `urut`) VALUES
	('BK00001', 'PM00001', '2016-12-31', '', 1),
	('BK00002', 'PM00002', '2017-01-20', 'dipakai produksi cat', 2),
	('BK00003', 'PM00003', '2017-01-20', 'keluar', 3),
	('BK00004', 'PM00010', '2017-01-17', 'aaaa', 4),
	('BK00005', 'PM00012', '2017-01-10', 'a', 5);
/*!40000 ALTER TABLE `barangkeluar` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_pengadaan.ci_sessions: ~0 rows (approximately)
DELETE FROM `ci_sessions`;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.detail_barangkeluar
CREATE TABLE IF NOT EXISTS `detail_barangkeluar` (
  `idbarangkeluar` varchar(7) NOT NULL,
  `idbarang` varchar(6) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`idbarangkeluar`,`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.detail_barangkeluar: ~8 rows (approximately)
DELETE FROM `detail_barangkeluar`;
/*!40000 ALTER TABLE `detail_barangkeluar` DISABLE KEYS */;
INSERT INTO `detail_barangkeluar` (`idbarangkeluar`, `idbarang`, `jumlah`) VALUES
	('BK00001', 'BG0007', 200),
	('BK00001', 'BG0008', 200),
	('BK00002', 'BG0001', 2),
	('BK00002', 'BG0006', 1),
	('BK00003', 'BG0009', 70),
	('BK00003', 'BG0010', 40),
	('BK00004', 'BG0006', 10),
	('BK00004', 'BG0008', 15),
	('BK00005', 'BG0004', 50),
	('BK00005', 'BG0005', 40);
/*!40000 ALTER TABLE `detail_barangkeluar` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.detail_order
CREATE TABLE IF NOT EXISTS `detail_order` (
  `idpo` varchar(7) NOT NULL,
  `idbarang` varchar(6) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `jumlah_harga` int(11) NOT NULL,
  `tanggal_pengiriman` date NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idpo`,`idbarang`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.detail_order: ~16 rows (approximately)
DELETE FROM `detail_order`;
/*!40000 ALTER TABLE `detail_order` DISABLE KEYS */;
INSERT INTO `detail_order` (`idpo`, `idbarang`, `jumlah`, `harga_satuan`, `jumlah_harga`, `tanggal_pengiriman`, `keterangan`, `urut`) VALUES
	('PO00001', 'BG0007', 200, 1000, 200000, '2016-12-30', '', 21),
	('PO00001', 'BG0008', 200, 2000, 400000, '2016-12-30', '', 22),
	('PO00002', 'BG0001', 2, 1000, 2000, '2017-01-17', '', 23),
	('PO00002', 'BG0006', 1, 3000, 3000, '2017-01-09', '', 24),
	('PO00003', 'BG0009', 70, 30, 2100, '2017-01-12', '', 25),
	('PO00003', 'BG0010', 40, 30, 1196, '2017-01-12', '', 26),
	('PO00004', 'BG0002', 20, 30, 500, '2017-01-13', '', 27),
	('PO00004', 'BG0007', 30, 50, 1500, '2017-01-12', '', 28),
	('PO00005', 'BG0015', 20, 2000, 4000, '2017-01-20', '', 29),
	('PO00005', 'BG0016', 10, 1000, 10000, '2017-01-14', '', 30),
	('PO00006', 'BG0016', 20, 3000, 6000, '2017-01-20', '', 31),
	('PO00007', 'BG0006', 25, 2000, 50000, '2017-01-20', '', 32),
	('PO00007', 'BG0007', 30, 35000, 75000, '2017-01-20', '', 33),
	('PO00008', 'BG0006', 10, 20, 200, '2017-01-27', 'notes', 34),
	('PO00009', 'BG0006', 10, 30, 300, '2017-01-06', 'aaaa', 41),
	('PO00009', 'BG0008', 20, 40, 800, '2017-01-07', 'vvvvv', 42),
	('PO00010', 'BG0004', 50, 1000, 50000, '2017-01-07', 'tes', 43),
	('PO00010', 'BG0005', 40, 8000, 320000, '2017-01-07', 'po', 44);
/*!40000 ALTER TABLE `detail_order` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.detail_penerimaan
CREATE TABLE IF NOT EXISTS `detail_penerimaan` (
  `idpenerimaan` varchar(7) NOT NULL,
  `idbarang` varchar(6) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `urut` int(7) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idpenerimaan`,`idbarang`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.detail_penerimaan: ~15 rows (approximately)
DELETE FROM `detail_penerimaan`;
/*!40000 ALTER TABLE `detail_penerimaan` DISABLE KEYS */;
INSERT INTO `detail_penerimaan` (`idpenerimaan`, `idbarang`, `jumlah`, `urut`) VALUES
	('PT00001', 'BG0007', 200, 14),
	('PT00001', 'BG0008', 200, 15),
	('PT00002', 'BG0001', 2, 16),
	('PT00002', 'BG0006', 1, 17),
	('PT00003', 'BG0009', 70, 18),
	('PT00003', 'BG0010', 40, 19),
	('PT00004', 'BG0002', 20, 20),
	('PT00004', 'BG0007', 30, 21),
	('PT00005', 'BG0015', 10, 22),
	('PT00005', 'BG0016', 10, 23),
	('PT00006', 'BG0016', 20, 24),
	('PT00007', 'BG0006', 10, 25),
	('PT00007', 'BG0007', 30, 26),
	('PT00008', 'BG0006', 10, 31),
	('PT00008', 'BG0008', 15, 32),
	('PT00009', 'BG0004', 50, 33),
	('PT00009', 'BG0005', 40, 34);
/*!40000 ALTER TABLE `detail_penerimaan` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.detail_permintaan
CREATE TABLE IF NOT EXISTS `detail_permintaan` (
  `idminta` varchar(7) NOT NULL,
  `idbarang` varchar(6) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_pengiriman` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idminta`,`idbarang`),
  KEY `idx_urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.detail_permintaan: ~20 rows (approximately)
DELETE FROM `detail_permintaan`;
/*!40000 ALTER TABLE `detail_permintaan` DISABLE KEYS */;
INSERT INTO `detail_permintaan` (`idminta`, `idbarang`, `jumlah`, `tanggal_pengiriman`, `status`, `keterangan`, `urut`) VALUES
	('PM00001', 'BG0007', 200, '2016-12-30', 'used', 'urgent', 19),
	('PM00001', 'BG0008', 200, '2016-12-30', 'used', 'slow', 20),
	('PM00002', 'BG0001', 4, '2017-02-04', 'requested', 'test', 56),
	('PM00002', 'BG0006', 3, '2017-01-08', 'requested', 'minta', 57),
	('PM00002', 'BG0009', 10, '2017-01-09', 'requested', 'baru', 58),
	('PM00003', 'BG0009', 70, '2017-01-13', 'used', '', 27),
	('PM00003', 'BG0010', 40, '2017-01-05', 'used', 'yoo', 26),
	('PM00004', 'BG0003', 20, '2017-01-13', 'disetujui', 'urgent', 24),
	('PM00004', 'BG0004', 10, '2017-01-06', 'disetujui', 'test', 25),
	('PM00005', 'BG0002', 20, '2017-01-12', 'arrived', 'test urgent', 28),
	('PM00005', 'BG0007', 30, '2017-01-12', 'arrived', 'urgent beneran', 29),
	('PM00006', 'BG0015', 20, '2017-01-03', 'arrived', 'urgent', 30),
	('PM00006', 'BG0016', 10, '2017-01-04', 'arrived', 'slow', 31),
	('PM00007', 'BG0016', 20, '2017-01-06', 'arrived', 'aaa', 32),
	('PM00008', 'BG0006', 25, '2017-01-19', 'arrived', '', 35),
	('PM00008', 'BG0007', 30, '2017-01-06', 'arrived', '', 34),
	('PM00008', 'BG0010', 10, '2017-01-05', 'disetujui', '', 33),
	('PM00009', 'BG0004', 100, '2017-01-20', 'disetujui', '', 36),
	('PM00010', 'BG0006', 10, '2017-01-20', 'used', '', 37),
	('PM00010', 'BG0008', 20, '2017-01-23', 'used', '', 38),
	('PM00011', 'BG0001', 20, '2017-01-02', 'requested', 'urgent', 53),
	('PM00011', 'BG0007', 16, '2017-01-13', 'requested', 'dasasas', 54),
	('PM00011', 'BG0010', 30, '2017-01-14', 'requested', 'snakmsaks', 55),
	('PM00012', 'BG0004', 50, '2017-01-03', 'used', 'test', 60),
	('PM00012', 'BG0005', 40, '2017-01-02', 'used', 'urgent', 59);
/*!40000 ALTER TABLE `detail_permintaan` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.divisi
CREATE TABLE IF NOT EXISTS `divisi` (
  `iddivisi` varchar(3) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'aktif',
  `keterangan` varchar(50) DEFAULT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`iddivisi`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.divisi: ~8 rows (approximately)
DELETE FROM `divisi`;
/*!40000 ALTER TABLE `divisi` DISABLE KEYS */;
INSERT INTO `divisi` (`iddivisi`, `nama`, `status`, `keterangan`, `urut`) VALUES
	('D01', 'Developer', 'aktif', 'yang mengolah bahan baku', 1),
	('D02', 'Purchasing', 'aktif', '', 2),
	('D03', 'Staff GBB', 'aktif', '', 3),
	('D04', 'Keuangan', 'aktif', '', 4),
	('D05', 'PPIC', 'aktif', '', 5),
	('D06', 'OB', 'aktif', '', 6),
	('D07', 'Opis Boys', 'aktif', '', 7),
	('D08', 'Opicer', 'aktif', '', 8);
/*!40000 ALTER TABLE `divisi` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.group
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `iddivisi` varchar(3) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table db_pengadaan.group: ~8 rows (approximately)
DELETE FROM `group`;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` (`id`, `name`, `is_admin`, `iddivisi`) VALUES
	(1, 'Developer', 1, 'D01'),
	(2, 'Purchasing', 1, 'D02'),
	(3, 'Staff GBB', 1, 'D03'),
	(4, 'Keuangan', 1, 'D04'),
	(5, 'PPIC', 1, 'D05'),
	(6, 'OB', 1, 'D06'),
	(7, 'Opis Boys', 1, 'D07'),
	(8, 'Opicer', 1, 'D08');
/*!40000 ALTER TABLE `group` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.karyawan
CREATE TABLE IF NOT EXISTS `karyawan` (
  `nik` varchar(8) COLLATE utf8_bin NOT NULL,
  `iddivisi` varchar(6) COLLATE utf8_bin NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '3',
  `nama` varchar(100) COLLATE utf8_bin NOT NULL,
  `alamat` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `jk` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `telp` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `jabatan` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `status` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'aktif',
  `login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created` date NOT NULL DEFAULT '0000-00-00',
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`nik`),
  KEY `idx_urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table db_pengadaan.karyawan: ~8 rows (approximately)
DELETE FROM `karyawan`;
/*!40000 ALTER TABLE `karyawan` DISABLE KEYS */;
INSERT INTO `karyawan` (`nik`, `iddivisi`, `group_id`, `nama`, `alamat`, `jk`, `telp`, `email`, `jabatan`, `password`, `status`, `login`, `logout`, `created`, `urut`) VALUES
	('09010007', 'D07', 7, 'pak de hartono', 'jakarta', 'laki-laki', '93829893', 'hartono@bina.com', 'opis boy', '$2a$08$09xoYUHXVcqAoEWexAHKcufhwI5hU6C6FIvJLS3uHu/9TqXeuCRse', 'aktif', '2009-01-03 08:09:42', '2009-01-03 08:09:42', '2009-01-03', 7),
	('09120002', 'D03', 3, 'Masno', 'pulo besar 1', 'laki-laki', '38392839', 'tarjo@bina.com', 'staf', '$2a$08$W4WRGWp9B7xY2TdKOhblne9s2/kEn.75DgomPCrB0xsYJLfvN7Evu', 'aktif', '2009-12-24 18:06:47', '2009-12-24 18:06:47', '2009-12-24', 2),
	('09120003', 'D02', 2, 'yon', 'jl.walank', 'laki-laki', '82198219', 'yon@bina.com', 'staff', '$2a$08$WS3i6sf.7rXg5kIdsWxUSuvrgSWVd5UL94GsU4fty3.y.cCeDnUtK', 'aktif', '2009-12-24 18:12:39', '2009-12-24 18:12:39', '2009-12-24', 3),
	('1', 'D01', 1, 'Damar Wiguno', 'Kokan Permata Blok E29 Jl. Boulevard Bukit Gading Raya \r\nKelapa Gading, Jakarta Utara 14240', 'laki-laki', '081584040918', 'damar@bantuin.id', 'admin', '$2a$08$1V8yu4BVbl.bj8Xu4G4m3O6yRHi4Wos2xuVe1.Z7hbXrtotBehHEi', 'aktif', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00', 1),
	('16120004', 'D05', 5, 'subekti', 'Jl.Pulbes 1', 'laki-laki', '8129192', 'bekti@bina.com', 'staff ppic', '$2a$08$PILz5WbtATCJlWC3lLpfz.Fy6II8/aGIW5JsJIXb4yJIFkKWDVq2C', 'aktif', '2016-12-24 21:30:20', '2016-12-24 21:30:20', '2016-12-24', 4),
	('16120005', 'D04', 4, 'ani', 'Jl.Kmp Tengah', 'perempuan', '82198', 'ani@bina.com', 'staff', '$2a$08$Lrv4OkCjzyvzjISTmtV0lurtANJVVDEQKz4n.XJgrVeS0058Epp0a', 'aktif', '2016-12-26 19:34:52', '2016-12-26 19:34:52', '2016-12-26', 5),
	('16120006', 'D06', 6, 'ucups', 'Jl.Pulbes', 'laki-laki', '821829', 'ucup@bina.com', 'opis boy', '$2a$08$1ghhnsWlBLlzNc.V//Mtleb4KIsXuC3Rhv3Ajqs4h79EbUthzRJZC', 'aktif', '2016-12-27 06:50:51', '2016-12-27 06:50:51', '2016-12-27', 6),
	('17010008', 'D08', 8, 'named', 'ciledug', 'laki-laki', '891999', 'unn@bina.com', 'unkown', '$2a$08$bW8/z.FQfmN8AtrCXqrB0u97Ya0Fg4x1O3Hu01zUA0nj/pR0cTTEe', 'aktif', '2017-01-03 13:19:12', '2017-01-03 13:19:12', '2017-01-03', 8);
/*!40000 ALTER TABLE `karyawan` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `file` varchar(255) COLLATE utf8_bin NOT NULL,
  `urut` tinyint(4) DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table db_pengadaan.menu: ~23 rows (approximately)
DELETE FROM `menu`;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `parent_id`, `name`, `file`, `urut`, `icon`) VALUES
	(1, 0, 'Admin Management', '#', 1, 'fa fa-tasks'),
	(2, 1, 'Group &amp; Auth', 'group', 3, 'fa fa-users'),
	(3, 1, 'Back End Menu', 'menu', 4, 'fa fa-cogs'),
	(4, 1, 'CMS User', 'user', 9, 'fa fa-users'),
	(18, 0, 'Master', '#', 10, 'fa fa-tasks'),
	(19, 18, 'Divisi', 'master/divisi', 11, 'fa fa-users'),
	(20, 18, 'Karyawan', 'user', 12, 'fa fa-users'),
	(21, 18, 'Supplier', 'master/supplier', 13, 'fa fa-users'),
	(22, 18, 'Barang', 'master/barang', 14, 'fa fa-cogs'),
	(23, 0, 'Transaksi', '#', 15, 'fa fa-tasks'),
	(25, 23, 'Permintaan Barang', 'permintaan', 16, 'fa fa-cogs'),
	(26, 23, 'Order Pembelian', 'po', 18, 'fa fa-cogs'),
	(27, 23, 'Penerimaan Barang', 'penerimaan', 19, 'fa fa-cogs'),
	(28, 23, 'Barang Keluar', 'barangkeluar', 20, 'fa fa-cogs'),
	(29, 23, 'Perintah Bayar', 'pembayaran', 21, 'fa fa-usd'),
	(31, 0, 'Laporan', '#', 22, 'fa fa-file'),
	(32, 31, 'Cetak Permintaan', 'laporan/permintaan', 23, 'fa fa-file'),
	(33, 31, 'Cetak Rekap Permintaan', 'laporan/rekappermintaan', 24, 'fa fa-file'),
	(34, 31, 'Cetak Order Pembelian', 'laporan/po', 25, 'fa fa-file'),
	(35, 31, 'Cetak Penerimaan', 'laporan/penerimaan', 26, 'fa fa-file'),
	(36, 31, 'Cetak Perintah Bayar', 'laporan/perintahbayar', 27, 'fa fa-file'),
	(37, 31, 'Pembayaran', 'laporan/pembayaran', 28, 'fa fa-file'),
	(38, 31, 'Stok Barang Masuk', 'laporan/barangmasuk', 29, 'fa fa-file'),
	(39, 31, 'Stok Barang Keluar', 'laporan/barangkeluar', 30, 'fa fa-file'),
	(40, 23, 'Approve Permintaan Barang', 'approvepermintaan', 17, 'fa fa-cogs'),
	(41, 0, 'Test Laporan', 'laporan/test', 31, 'fa fa-file');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.pembayaran
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `idpembayaran` varchar(7) NOT NULL,
  `idpo` varchar(7) NOT NULL,
  `tanggal_perintahbayar` date NOT NULL,
  `tanggal_dibayar` date DEFAULT NULL,
  `jml_bayar` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idpembayaran`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.pembayaran: ~3 rows (approximately)
DELETE FROM `pembayaran`;
/*!40000 ALTER TABLE `pembayaran` DISABLE KEYS */;
INSERT INTO `pembayaran` (`idpembayaran`, `idpo`, `tanggal_perintahbayar`, `tanggal_dibayar`, `jml_bayar`, `status`, `urut`) VALUES
	('BY00001', 'PO00001', '2016-12-31', '2016-12-31', 600000, 'paid', 1),
	('BY00002', 'PO00002', '2017-01-11', '2017-01-12', 5000, 'paid', 2),
	('BY00003', 'PO00004', '2017-01-16', '2017-01-18', 2000, 'paid', 3);
/*!40000 ALTER TABLE `pembayaran` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.penerimaan
CREATE TABLE IF NOT EXISTS `penerimaan` (
  `idpenerimaan` varchar(7) NOT NULL,
  `idpo` varchar(7) NOT NULL,
  `tanggal` date NOT NULL,
  `urut` int(7) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idpenerimaan`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.penerimaan: ~7 rows (approximately)
DELETE FROM `penerimaan`;
/*!40000 ALTER TABLE `penerimaan` DISABLE KEYS */;
INSERT INTO `penerimaan` (`idpenerimaan`, `idpo`, `tanggal`, `urut`) VALUES
	('PT00001', 'PO00001', '2016-12-31', 1),
	('PT00002', 'PO00002', '2017-01-10', 2),
	('PT00003', 'PO00003', '2017-01-12', 3),
	('PT00004', 'PO00004', '2017-01-12', 4),
	('PT00005', 'PO00005', '2017-01-22', 5),
	('PT00006', 'PO00006', '2017-01-25', 6),
	('PT00007', 'PO00007', '2017-01-23', 7),
	('PT00008', 'PO00009', '2017-01-12', 8),
	('PT00009', 'PO00010', '2017-01-09', 9);
/*!40000 ALTER TABLE `penerimaan` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.permintaan
CREATE TABLE IF NOT EXISTS `permintaan` (
  `idminta` varchar(7) NOT NULL,
  `nik` varchar(8) NOT NULL,
  `tanggal` date NOT NULL,
  `tanggal_disetujui` date DEFAULT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idminta`),
  UNIQUE KEY `idx_urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.permintaan: ~10 rows (approximately)
DELETE FROM `permintaan`;
/*!40000 ALTER TABLE `permintaan` DISABLE KEYS */;
INSERT INTO `permintaan` (`idminta`, `nik`, `tanggal`, `tanggal_disetujui`, `deskripsi`, `status`, `urut`) VALUES
	('PM00001', '09120002', '2016-12-27', '2016-12-27', '', 'disetujui', 1),
	('PM00002', '09120002', '2017-01-05', '2017-01-03', 'pemintaan', 'requested', 2),
	('PM00003', '09120002', '2017-01-03', '2017-01-03', 'minta barang', 'disetujui', 3),
	('PM00004', '09120002', '2017-01-03', '2017-01-03', 'minta', 'ditolak', 4),
	('PM00005', '09120002', '2017-01-03', '2017-01-03', 'testttttt', 'disetujui', 5),
	('PM00006', '09120002', '2017-01-03', '2017-01-03', 'test1', 'disetujui', 6),
	('PM00007', '09120002', '2017-01-03', '2017-01-03', 'test2', 'disetujui', 7),
	('PM00008', '09120002', '2017-01-03', '2017-01-03', 'permintaan baru', 'disetujui', 8),
	('PM00009', '09120002', '2017-01-03', '2017-01-03', '', 'disetujui', 9),
	('PM00010', '09120002', '2017-01-03', '2017-01-03', 'test permintaan', 'disetujui', 10),
	('PM00011', '09120002', '2017-01-05', NULL, 'deksirpso', 'requested', 11),
	('PM00012', '09120002', '2017-01-09', '2017-01-09', 'test', 'disetujui', 12);
/*!40000 ALTER TABLE `permintaan` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.permintaan_order
CREATE TABLE IF NOT EXISTS `permintaan_order` (
  `idminta` varchar(7) NOT NULL,
  `idpo` varchar(7) NOT NULL,
  `idbarang` varchar(6) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.permintaan_order: ~0 rows (approximately)
DELETE FROM `permintaan_order`;
/*!40000 ALTER TABLE `permintaan_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `permintaan_order` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.po
CREATE TABLE IF NOT EXISTS `po` (
  `idpo` varchar(7) NOT NULL,
  `idminta` varchar(7) NOT NULL,
  `idsupplier` varchar(5) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `total` int(11) DEFAULT NULL,
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idpo`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.po: ~8 rows (approximately)
DELETE FROM `po`;
/*!40000 ALTER TABLE `po` DISABLE KEYS */;
INSERT INTO `po` (`idpo`, `idminta`, `idsupplier`, `tanggal`, `deskripsi`, `total`, `urut`) VALUES
	('PO00001', 'PM00001', 'SP001', '2016-12-27', 'order', 600000, 1),
	('PO00002', 'PM00002', 'SP005', '2017-01-03', 'po', 5000, 2),
	('PO00003', 'PM00003', 'SP006', '2017-01-03', 'desc', 3296, 3),
	('PO00004', 'PM00005', 'SP007', '2017-01-03', 'aasasasas', 2000, 4),
	('PO00005', 'PM00006', 'SP008', '2017-01-03', 'test', 14000, 5),
	('PO00006', 'PM00007', 'SP009', '2017-01-03', '', 6000, 6),
	('PO00007', 'PM00008', 'SP008', '2017-01-03', 'test', 125000, 7),
	('PO00008', 'PM00010', 'SP009', '2017-01-03', 'aaa', 200, 8),
	('PO00009', 'PM00010', 'SP006', '2017-01-05', 'dessss', 1100, 9),
	('PO00010', 'PM00012', 'SP008', '2017-01-06', '', 370000, 10);
/*!40000 ALTER TABLE `po` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.setting
CREATE TABLE IF NOT EXISTS `setting` (
  `id_setting` int(11) NOT NULL,
  `id_site` int(11) NOT NULL DEFAULT '0',
  `type` varchar(150) COLLATE utf8_bin NOT NULL,
  `value` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Dumping data for table db_pengadaan.setting: ~9 rows (approximately)
DELETE FROM `setting`;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` (`id_setting`, `id_site`, `type`, `value`) VALUES
	(1, 1, 'app_title', 'Lumix'),
	(2, 1, 'web_description', 'Lumix\r\n'),
	(3, 1, 'app_footer', 'Copyright &copy; %s 2013. Lumix.'),
	(4, 1, 'maintenance_mode', '0'),
	(5, 1, 'ip_approved', '::1;127.0.0.1'),
	(6, 1, 'maintenance_message', 'This site currently on maintenance, please check again later.'),
	(7, 1, 'multilanguage_mode', '0'),
	(24, 1, 'email_contact', 'mac@gxrg.org'),
	(25, 1, 'email_contact_name', 'Faisal Latada');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;


-- Dumping structure for table db_pengadaan.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `idsupplier` varchar(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'aktif',
  `urut` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idsupplier`),
  KEY `urut` (`urut`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table db_pengadaan.supplier: ~9 rows (approximately)
DELETE FROM `supplier`;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` (`idsupplier`, `nama`, `alamat`, `email`, `telp`, `fax`, `status`, `urut`) VALUES
	('SP001', 'PT. Maju Jaya Terus', 'Jl.Sooko Sari no.70', 'sales@majujaya.com', '82918291', '92019201', 'aktif', 1),
	('SP002', 'PT. Sehat Jaya', 'Jl.Pulo besar 3', 'sehat@mail.com', '29102901', '83293892', 'aktif', 2),
	('SP003', 'PT. Berkah Mulia', 'Jl.Inspeksi Kali Sunter', 'berkah@mail.com', '182918', '9320390', 'aktif', 3),
	('SP004', 'PT. Sukses Bersama', 'Jl. Howitzer', 'sukses@mail.com', '930302', '8392839289', 'aktif', 4),
	('SP005', 'Snasjn', 'nsankmalmls', 'njjj@gmail.com', '732878', '389239', 'aktif', 5),
	('SP006', 'Media Kreasi Inov', 'jakarta', 'mki@media.coms', '73827382', '83298329', 'aktif', 6),
	('SP007', 'Dia Supplier', 'kalisari', 'dia@mail.com', '219219', '1919219', 'aktif', 7),
	('SP008', 'Budi', 'jl.petukangan', 'budi@mail.com', '738238', '37283782', 'aktif', 8),
	('SP009', 'Luhur', 'test', 'luhur@mail.com', '3298', '8932389', 'aktif', 9);
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
