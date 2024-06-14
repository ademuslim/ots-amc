-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 14 Jun 2024 pada 16.37
-- Versi server: 8.0.30
-- Versi PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_lembur`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` varchar(36) NOT NULL,
  `nama_jabatan` varchar(50) NOT NULL,
  `harga_lembur` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `harga_lembur`) VALUES
('80b5aa7e-5f73-4927-80ff-8f909988b5f9', 'staff', 20000.00),
('a4f07a00-d76c-4e30-b813-ff239bd3ec77', 'kepala perusahaan', 35000.00),
('bac82142-2293-4fbc-a32f-bc078e57d850', 'pic', 20000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` varchar(36) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `id_jabatan` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `no_hp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `id_jabatan`, `no_hp`, `tanggal_masuk`) VALUES
('0de28f55-688e-4312-bbf1-753985b185c3', 'lukas', 'a4f07a00-d76c-4e30-b813-ff239bd3ec77', '', '2024-06-01'),
('2c42b9ef-3ed7-4e58-bb89-09cba14a4077', 'irvanda nur arifin', 'bac82142-2293-4fbc-a32f-bc078e57d850', '085770772721', '2023-01-02'),
('90e1f286-9c7b-4a2e-88b2-826561cdf5a1', 'jumadi', 'bac82142-2293-4fbc-a32f-bc078e57d850', '087723392276', '2024-06-09'),
('94972980-a9fb-4d81-95f9-777383123eaa', 'mohamad zen', 'bac82142-2293-4fbc-a32f-bc078e57d850', '', '2023-01-14'),
('af60dbe4-0cf1-4810-9935-c2e1e87bdd10', 'fuanda', '80b5aa7e-5f73-4927-80ff-8f909988b5f9', '', '2023-01-02'),
('caa6bba9-2766-4e6c-9eb7-b1403a8af10f', 'amin', 'bac82142-2293-4fbc-a32f-bc078e57d850', '', '2024-01-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` varchar(36) NOT NULL,
  `id_pengguna` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `aktivitas` varchar(225) NOT NULL,
  `tabel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `keterangan` text NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_pengguna`, `aktivitas`, `tabel`, `keterangan`, `tanggal`) VALUES
('00005cc2-e214-4676-ba35-bf8c932f59f2', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data jabatan', 'jabatan', 'Perubahan data jabatan: | 1. harga_lembur: &quot;80000.00&quot; diubah menjadi &quot;20000.00&quot; | ', '2024-06-14 12:28:02'),
('0139a115-93fb-4e9a-8dae-fc5989250908', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:48:22'),
('07ec2c26-0dae-4079-8e5c-0890c6321ebb', 'e1f853e9-19f2-444f-b9ac-348559476717', 'Ubah Data pengajuan lembur', 'pengajuan_lembur', 'Perubahan data pengajuan lembur: | 1. id_pengajuan: &quot;4449e813-ab0f-4b03-8437-0e39123d4cd8&quot; diubah menjadi &quot;&quot; | 2. id_karyawan: &quot;caa6bba9-2766-4e6c-9eb7-b1403a8af10f&quot; diubah menjadi &quot;&quot; | 3. tanggal_pengajuan: &quot;2024-06-15&quot; diubah menjadi &quot;&quot; | 4. waktu_mulai: &quot;22:00:00&quot; diubah menjadi &quot;&quot; | 5. waktu_selesai: &quot;23:59:00&quot; diubah menjadi &quot;&quot; | 6. keterangan: &quot;gfygkyut&quot; diubah menjadi &quot;&quot; | ', '2024-06-14 16:10:00'),
('08ee0fbc-720b-4d63-b61f-fa5908269938', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:22:09'),
('0c7ade3f-49d3-4b09-8a15-c9aa5930df84', 'e1f853e9-19f2-444f-b9ac-348559476717', 'Ubah Data pengajuan lembur', 'pengajuan_lembur', 'Perubahan data pengajuan lembur: | 1. id_pengajuan: &quot;4449e813-ab0f-4b03-8437-0e39123d4cd8&quot; diubah menjadi &quot;&quot; | 2. id_karyawan: &quot;caa6bba9-2766-4e6c-9eb7-b1403a8af10f&quot; diubah menjadi &quot;&quot; | 3. tanggal_pengajuan: &quot;2024-06-15&quot; diubah menjadi &quot;&quot; | 4. waktu_mulai: &quot;23:07:00&quot; diubah menjadi &quot;&quot; | 5. waktu_selesai: &quot;00:59:00&quot; diubah menjadi &quot;&quot; | 6. keterangan: &quot;gfygkyut&quot; diubah menjadi &quot;&quot; | ', '2024-06-14 16:09:20'),
('0d4deecf-24a8-47fd-afc0-ee0ea8f27231', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:45:08'),
('0e026725-cf6d-4243-8253-8bcf5cd8d087', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Login berhasil', 'pengguna', 'Pengguna dengan username mohamadzen berhasil login.', '2024-06-14 14:42:02'),
('11b5c0a5-6c9d-47ef-a262-4169f6ee818e', NULL, 'Login gagal', 'pengguna', 'Gagal login dengan username muhamadzen. Username atau password salah.', '2024-06-14 15:47:53'),
('12cbfa6e-8a5b-425c-83c9-2ea534b91444', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Log Out', NULL, 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb keluar dari sistem.', '2024-06-14 14:10:19'),
('164c9f0f-efcf-45d3-a71f-bc45cf540b37', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:50:40'),
('19928c47-fd93-4d98-a9eb-7a687740b4f8', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 14:04:46'),
('1c02fdaf-313a-4e9b-b763-63d844f752c6', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:28:08'),
('1e39caa0-866d-4608-b301-83cb3750abd9', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data jabatan', 'jabatan', 'Perubahan data jabatan: | 1. harga_lembur: &quot;200000.00&quot; diubah menjadi &quot;35000.00&quot; | ', '2024-06-14 12:27:52'),
('1ee923ae-02fe-424d-9224-d739b4362d80', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:11:56'),
('23fcf71e-8d23-4792-9cb4-6e52ee1467ad', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data karyawan', 'karyawan', 'Perubahan data karyawan: | 1. nama_karyawan: &quot;ade muslim&quot; diubah menjadi &quot;jumadi&quot; | 2. no_hp: &quot;085777777777&quot; diubah menjadi &quot;087723392276&quot; | ', '2024-06-14 12:22:37'),
('27d8cba6-0a87-4aea-b09b-d1828577dfc4', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Login berhasil', 'pengguna', 'Pengguna dengan username mohamadzen berhasil login.', '2024-06-14 14:03:30'),
('2a8b0c2a-05c4-4578-8b42-dffda61a0ae8', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Log Out', NULL, 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 keluar dari sistem.', '2024-06-14 14:41:54'),
('2b9f2b3b-3251-410d-9ab6-3d6c19cb19f1', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:21:26'),
('34786f6a-8027-4d0c-ad63-b94b59c4e74a', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data Pengguna', 'pengguna', 'Perubahan data pengguna: | 1. nama_pengguna: &quot;mohamadzen&quot; diubah menjadi &quot;mohamadzenmlaik&quot; | ', '2024-06-14 13:59:53'),
('34aca284-f2c2-4c9a-a3c2-00b64b98fe88', 'e1f853e9-19f2-444f-b9ac-348559476717', 'Ubah Data pengajuan lembur', 'pengajuan_lembur', 'Perubahan data pengajuan lembur: | 1. id_pengajuan: &quot;4449e813-ab0f-4b03-8437-0e39123d4cd8&quot; diubah menjadi &quot;&quot; | 2. id_karyawan: &quot;caa6bba9-2766-4e6c-9eb7-b1403a8af10f&quot; diubah menjadi &quot;&quot; | 3. tanggal_pengajuan: &quot;2024-06-15&quot; diubah menjadi &quot;&quot; | 4. waktu_mulai: &quot;22:00:00&quot; diubah menjadi &quot;&quot; | 5. waktu_selesai: &quot;23:00:00&quot; diubah menjadi &quot;&quot; | 6. keterangan: &quot;gfygkyut&quot; diubah menjadi &quot;&quot; | ', '2024-06-14 16:09:45'),
('357063bd-2ec0-4652-a5c5-ff72f2ac9895', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data Pengguna', 'pengguna', 'Perubahan data pengguna: | 1. nama_pengguna: &quot;mohamadzenmlaik&quot; diubah menjadi &quot;mohamadzen&quot; | ', '2024-06-14 14:00:03'),
('35b3e1b2-8f3d-447f-8961-e75202eeb44e', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:44:47'),
('35e9808d-88d0-4bc5-8add-51b99732bdcf', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Login berhasil', 'pengguna', 'Pengguna dengan username fuanda berhasil login.', '2024-06-14 15:51:14'),
('3643a5cb-dad0-4215-80ff-294bb6f5d2e7', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:28:31'),
('38f0cea7-4361-41c8-952e-8b8c9b8ed7c0', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Berhasil tambah karyawan', 'karyawan', 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b berhasil tambah karyawan dengan ID 0de28f55-688e-4312-bbf1-753985b185c3', '2024-06-14 12:28:31'),
('4402f8b6-fd91-4c9c-b20c-c2d80f071916', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Login berhasil', 'pengguna', 'Pengguna dengan username fuanda berhasil login.', '2024-06-14 16:10:35'),
('4529e3c7-7dba-4009-ba98-9a235f55c256', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Berhasil tambah karyawan', 'karyawan', 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b berhasil tambah karyawan dengan ID caa6bba9-2766-4e6c-9eb7-b1403a8af10f', '2024-06-14 12:23:29'),
('4648a59d-26e5-4377-90c1-b2536508ef99', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:21:00'),
('4bf2e193-f9c2-4a1d-8ad6-bb180f2b1a73', 'e1f853e9-19f2-444f-b9ac-348559476717', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID e1f853e9-19f2-444f-b9ac-348559476717 berhasil membuat pengajuan lembur dengan ID caa6bba9-2766-4e6c-9eb7-b1403a8af10f', '2024-06-14 16:08:25'),
('4fe45068-4dde-40e1-90df-e4ba4a5c70a4', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Ubah Data pengajuan lembur', 'pengajuan_lembur', 'Perubahan data pengajuan lembur: | 1. id_pengajuan: &quot;151333e1-6539-44b8-a07e-c357550f5848&quot; diubah menjadi &quot;&quot; | 2. id_karyawan: &quot;94972980-a9fb-4d81-95f9-777383123eaa&quot; diubah menjadi &quot;&quot; | 3. tanggal_pengajuan: &quot;2024-06-01&quot; diubah menjadi &quot;&quot; | 4. waktu_mulai: &quot;21:51:00&quot; diubah menjadi &quot;&quot; | 5. waktu_selesai: &quot;22:52:00&quot; diubah menjadi &quot;&quot; | 6. keterangan: &quot;tes lembur ditolak tgl 1&quot; diubah menjadi &quot;&quot; | ', '2024-06-14 14:53:12'),
('5167c980-70b8-4f13-b206-ded7cf3a151e', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Berhasil tambah pengguna', 'produk', 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b berhasil tambah pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb', '2024-06-14 13:59:22'),
('516f3cdc-5c38-4a25-8046-b8e1aa8888c5', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Log Out', NULL, 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b keluar dari sistem.', '2024-06-14 12:10:26'),
('535514ae-581d-40ae-9e29-1bbd4b8c906c', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data karyawan', 'karyawan', 'Perubahan data karyawan: | 1. no_hp: &quot;123123123123&quot; diubah menjadi &quot;085770772721&quot; | ', '2024-06-14 12:22:56'),
('53ee3c58-757f-48e1-a07f-da9301b0608e', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Berhasil hapus pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 berhasil hapus pengajuan lembur dengan ID 4449e813-ab0f-4b03-8437-0e39123d4cd8', '2024-06-14 16:36:22'),
('54be6758-426f-4c68-b296-7039115a7c69', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Log Out', NULL, 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb keluar dari sistem.', '2024-06-14 15:29:18'),
('58da30b0-34b3-449f-b9de-686fb5267bcb', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Log Out', NULL, 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b keluar dari sistem.', '2024-06-14 14:03:22'),
('63fc7a29-6e22-4d2b-b78e-27b31bdf0f28', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:27:00'),
('6889b493-55dd-4b00-8aa9-55e1a1d86baa', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Login berhasil', 'pengguna', 'Pengguna dengan username fuanda berhasil login.', '2024-06-14 15:29:23'),
('6ab98a6b-2a60-4609-8185-5610bcf34d73', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Log Out', NULL, 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb keluar dari sistem.', '2024-06-14 15:51:07'),
('773db520-5ad9-48cb-92e2-59a41d66a840', 'e1f853e9-19f2-444f-b9ac-348559476717', 'Ubah Data pengajuan lembur', 'pengajuan_lembur', 'Perubahan data pengajuan lembur: | 1. id_pengajuan: &quot;4449e813-ab0f-4b03-8437-0e39123d4cd8&quot; diubah menjadi &quot;&quot; | 2. id_karyawan: &quot;caa6bba9-2766-4e6c-9eb7-b1403a8af10f&quot; diubah menjadi &quot;&quot; | 3. tanggal_pengajuan: &quot;2024-06-15&quot; diubah menjadi &quot;&quot; | 4. waktu_mulai: &quot;23:07:00&quot; diubah menjadi &quot;&quot; | 5. waktu_selesai: &quot;00:00:00&quot; diubah menjadi &quot;&quot; | 6. keterangan: &quot;gfygkyut&quot; diubah menjadi &quot;&quot; | ', '2024-06-14 16:08:45'),
('78537214-9ed5-4c6b-abb8-59c6d0cf33fa', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Login berhasil', 'pengguna', 'Pengguna dengan username fuanda berhasil login.', '2024-06-14 14:10:34'),
('792fb1bd-b679-4470-b4d6-849deee0b0e7', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Login berhasil', 'pengguna', 'Pengguna dengan username fuanda berhasil login.', '2024-06-14 14:53:22'),
('800b05cc-ffd3-40d9-a70b-0860e90d655d', 'e1f853e9-19f2-444f-b9ac-348559476717', 'Log Out', NULL, 'Pengguna dengan ID e1f853e9-19f2-444f-b9ac-348559476717 keluar dari sistem.', '2024-06-14 16:10:25'),
('80505dac-9e7c-4633-99ea-e67779d792dc', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Log Out', NULL, 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 keluar dari sistem.', '2024-06-14 15:47:45'),
('888f4aa5-98fc-4fd6-a9a8-e92f0b0688b7', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Berhasil tambah pengguna', 'produk', 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b berhasil tambah pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47', '2024-06-14 13:59:41'),
('8ece4e7d-8e30-4e7c-8b0e-96e306f3bbfb', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Berhasil tambah karyawan', 'karyawan', 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b berhasil tambah karyawan dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 12:24:05'),
('90e29d4f-45c9-4afd-bc36-b3692d34c8c0', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data karyawan', 'karyawan', 'Perubahan data karyawan: | 1. nama_karyawan: &quot;lukas&quot; diubah menjadi &quot;fuanda&quot; | ', '2024-06-14 12:21:29'),
('933ace68-5554-47e0-880e-d223fb3de087', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Gagal hapus pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 mencoba hapus pengajuan lembur dengan ID ef6aafbf-453c-44c3-8b57-155d88ce5888 yang belum satu bulan sejak tanggal pengajuan dan status tidak pending', '2024-06-14 16:36:11'),
('942fbd32-fef9-4acc-9895-39b9927e7e2b', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 14:53:00'),
('95ed9423-133d-42aa-b9a5-4cb592d3f9ee', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Login berhasil', 'pengguna', 'Pengguna dengan username fuanda berhasil login.', '2024-06-14 15:45:20'),
('9cb36e78-28d2-458e-9e7b-97097ab30eb8', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Berhasil tambah pengguna', 'produk', 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b berhasil tambah pengguna dengan ID e1f853e9-19f2-444f-b9ac-348559476717', '2024-06-14 14:00:26'),
('a03e9bf8-9d16-489c-95e4-4213b1462c22', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Login berhasil', 'pengguna', 'Pengguna dengan username superadmin berhasil login.', '2024-06-14 12:17:44'),
('a2cadc38-cec5-4ae6-b1b0-26c8d6a66c2e', 'e1f853e9-19f2-444f-b9ac-348559476717', 'Login berhasil', 'pengguna', 'Pengguna dengan username amin berhasil login.', '2024-06-14 16:07:07'),
('adb78154-9b3c-4396-b9ce-aff097be6b3f', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Berhasil hapus pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 berhasil hapus pengajuan lembur dengan ID 0a340c78-6685-41e2-92ed-73dfd3a1fa95', '2024-06-14 16:36:15'),
('b002b611-54f2-442f-a5dd-c0ce45cabb6e', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Login berhasil', 'pengguna', 'Pengguna dengan username mohamadzen berhasil login.', '2024-06-14 14:53:48'),
('b087da61-f687-4692-9bab-a537807b4f53', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Gagal hapus pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 mencoba hapus pengajuan lembur dengan ID ef6aafbf-453c-44c3-8b57-155d88ce5888 yang belum satu bulan sejak tanggal pengajuan dan status tidak pending', '2024-06-14 16:35:55'),
('b34446c1-9d98-4df2-9a8e-83cf4fcc9eed', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data Pengguna', 'pengguna', 'Perubahan data pengguna: | 1. tipe_pengguna: &quot;staff&quot; diubah menjadi &quot;superadmin&quot; | ', '2024-06-14 13:39:16'),
('b708960e-1b82-42bd-a62b-1bedb6b9ed1a', 'e1f853e9-19f2-444f-b9ac-348559476717', 'Ubah Data pengajuan lembur', 'pengajuan_lembur', 'Perubahan data pengajuan lembur: | 1. id_pengajuan: &quot;4449e813-ab0f-4b03-8437-0e39123d4cd8&quot; diubah menjadi &quot;&quot; | 2. id_karyawan: &quot;caa6bba9-2766-4e6c-9eb7-b1403a8af10f&quot; diubah menjadi &quot;&quot; | 3. tanggal_pengajuan: &quot;2024-06-15&quot; diubah menjadi &quot;&quot; | 4. waktu_mulai: &quot;22:00:00&quot; diubah menjadi &quot;&quot; | 5. waktu_selesai: &quot;00:00:00&quot; diubah menjadi &quot;&quot; | 6. keterangan: &quot;gfygkyut&quot; diubah menjadi &quot;&quot; | ', '2024-06-14 16:10:17'),
('b7b461c3-d1ad-4f05-a9aa-2f5326cb4227', NULL, 'Login gagal', 'pengguna', 'Gagal login dengan email amuslim@am.ac.id. Email atau password salah.', '2024-06-10 13:52:33'),
('b875a13e-7a9f-4599-84cc-db9b7a9d2533', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Log Out', NULL, 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 keluar dari sistem.', '2024-06-14 16:07:02'),
('bc51ee40-c9fa-46ad-8380-90d356c4ab69', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Log Out', NULL, 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 keluar dari sistem.', '2024-06-14 14:53:41'),
('c2ec480a-383e-48d9-927a-7c8b631a03c2', 'cecd05c9-13e0-48a3-922a-2c1e150866dd', 'Login berhasil', 'pengguna', 'Pengguna dengan email amuslim@am.co.id berhasil login.', '2024-06-10 15:13:15'),
('c87f58cf-3dde-439f-b7a9-1ca3c5d462b8', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data jabatan', 'jabatan', 'Perubahan data jabatan: | 1. harga_lembur: &quot;60000.00&quot; diubah menjadi &quot;20000.00&quot; | ', '2024-06-14 12:27:23'),
('ca5b061b-f363-4333-88e3-09c7e517e1dd', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Log Out', NULL, 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb keluar dari sistem.', '2024-06-14 15:45:13'),
('cb547c2a-dac1-463a-89ac-96ecb6c84be2', '9d6be4f3-ad85-4b18-b507-b735bbcd918a', 'Log Out', NULL, 'Pengguna dengan ID 9d6be4f3-ad85-4b18-b507-b735bbcd918a keluar dari sistem.', '2024-06-10 15:37:07'),
('ccaa1968-ee6f-453e-9069-ff9d53f57d16', '7710b4e5-75d8-43f8-ba83-95e4c56e1d69', 'Log Out', NULL, 'Pengguna dengan ID 7710b4e5-75d8-43f8-ba83-95e4c56e1d69 keluar dari sistem.', '2024-06-10 15:40:29'),
('d006eae5-f3ba-4111-b588-5fefa11af5b2', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Log Out', NULL, 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 keluar dari sistem.', '2024-06-14 15:38:40'),
('d0bc0eae-c7c4-412f-b582-a312018cdd43', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Berhasil hapus pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 berhasil hapus pengajuan lembur dengan ID 0544aa2a-fbe3-4fa4-a68a-a4c85a7313a3', '2024-06-14 16:36:04'),
('d6029c37-e8c3-4ca1-8654-97512494713d', '7710b4e5-75d8-43f8-ba83-95e4c56e1d69', 'Log Out', NULL, 'Pengguna dengan ID 7710b4e5-75d8-43f8-ba83-95e4c56e1d69 keluar dari sistem.', '2024-06-10 14:26:41'),
('d61e5dcb-efa4-482d-8dbf-60c98bb0c810', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Ubah Data Pengguna', 'pengguna', 'Perubahan data pengguna: | 1. tipe_pengguna: &quot;superadmin&quot; diubah menjadi &quot;staff&quot; | ', '2024-06-14 13:39:09'),
('d9859dab-ed0b-419b-8d53-d04d1193d1ef', '6caa27cc-d338-46d4-9b51-3b394718dd47', 'Berhasil hapus pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 6caa27cc-d338-46d4-9b51-3b394718dd47 berhasil hapus pengajuan lembur dengan ID 11a46b3b-6776-44b5-b265-52aad4cb6eae', '2024-06-14 16:36:26'),
('d9db1424-acba-47e5-80a7-d5bb26d476ca', 'cecd05c9-13e0-48a3-922a-2c1e150866dd', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID cecd05c9-13e0-48a3-922a-2c1e150866dd berhasil membuat pengajuan lembur dengan ID 90e1f286-9c7b-4a2e-88b2-826561cdf5a1', '2024-06-10 13:53:37'),
('dcdc2dc6-59dc-4987-8c1d-f4cb6154b649', 'cecd05c9-13e0-48a3-922a-2c1e150866dd', 'Login berhasil', 'pengguna', 'Pengguna dengan email amuslim@am.co.id berhasil login.', '2024-06-10 13:54:49'),
('ded1fdef-cc55-4cba-98bb-340c7eef5784', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Login berhasil', 'pengguna', 'Pengguna dengan username mohamadzen berhasil login.', '2024-06-14 15:39:06'),
('df6d7981-57f4-43ab-815c-9cb674f44bed', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Log Out', NULL, 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb keluar dari sistem.', '2024-06-14 14:53:17'),
('e1f596f5-a48d-4c39-9a5b-3c1ac2bbd653', '9d6be4f3-ad85-4b18-b507-b735bbcd918a', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 9d6be4f3-ad85-4b18-b507-b735bbcd918a berhasil membuat pengajuan lembur dengan ID 2c42b9ef-3ed7-4e58-bb89-09cba14a4077', '2024-06-10 15:37:03'),
('e8d39888-d130-4f92-85e1-8abd79859fcb', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Login berhasil', 'pengguna', 'Pengguna dengan username superadmin berhasil login.', '2024-06-14 13:27:36'),
('e9f43980-a8d1-4af8-bca5-716736fba47d', 'cecd05c9-13e0-48a3-922a-2c1e150866dd', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID cecd05c9-13e0-48a3-922a-2c1e150866dd berhasil membuat pengajuan lembur dengan ID 90e1f286-9c7b-4a2e-88b2-826561cdf5a1', '2024-06-10 15:12:29'),
('ea260338-6f5c-4be6-a0c3-9ed4dea2d954', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Login berhasil', 'pengguna', 'Pengguna dengan username mohamadzen berhasil login.', '2024-06-14 15:48:00'),
('f0e43417-efd0-4635-87f6-7cbdff555a74', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Login berhasil', 'pengguna', 'Pengguna dengan email s.admin@gmail.com berhasil login.', '2024-06-10 15:36:04'),
('f37a56a8-f6e1-4efd-9dd0-a1c5fc707797', '7710b4e5-75d8-43f8-ba83-95e4c56e1d69', 'Login berhasil', 'pengguna', 'Pengguna dengan email lukas@gmail.com berhasil login.', '2024-06-10 14:39:18'),
('f447170f-acda-4015-8725-221849d1f282', '7710b4e5-75d8-43f8-ba83-95e4c56e1d69', 'Login berhasil', 'pengguna', 'Pengguna dengan email lukas@gmail.com berhasil login.', '2024-06-10 15:40:37'),
('f50dec23-ba51-4748-8a09-c60bcc7eac39', '7710b4e5-75d8-43f8-ba83-95e4c56e1d69', 'Login berhasil', 'pengguna', 'Pengguna dengan email lukas@gmail.com berhasil login.', '2024-06-10 15:12:43'),
('f9fb52ec-335c-4d03-8458-e19fc2c139e7', 'b58a7ec8-73ce-415b-b415-21835792464b', 'Berhasil tambah jabatan', 'jabatan', 'Pengguna dengan ID b58a7ec8-73ce-415b-b415-21835792464b berhasil tambah jabatan dengan ID a4f07a00-d76c-4e30-b813-ff239bd3ec77', '2024-06-14 12:25:25'),
('fa0f51fd-ed50-4f28-a93c-0c016e3bee91', 'cecd05c9-13e0-48a3-922a-2c1e150866dd', 'Log Out', NULL, 'Pengguna dengan ID cecd05c9-13e0-48a3-922a-2c1e150866dd keluar dari sistem.', '2024-06-10 15:12:36'),
('fb7d7b7c-ff67-4ce4-bb15-15aff58f387f', '7710b4e5-75d8-43f8-ba83-95e4c56e1d69', 'Gagal hapus pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 7710b4e5-75d8-43f8-ba83-95e4c56e1d69 mencoba hapus pengajuan lembur dengan ID d322e24e-bd5e-4b9d-b34d-df1658ac8d9a yang belum satu bulan sejak tanggal pengajuan dan status tidak pending', '2024-06-10 13:58:30'),
('fc7a7201-79b2-4db3-a3af-f430d711bee1', '232f87d8-f81f-46cf-a493-f66a7b954dfb', 'Berhasil tambah pengajuan lembur', 'pengajuan lembur', 'Pengguna dengan ID 232f87d8-f81f-46cf-a493-f66a7b954dfb berhasil membuat pengajuan lembur dengan ID 94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14 15:50:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengajuan_lembur`
--

CREATE TABLE `pengajuan_lembur` (
  `id_pengajuan` varchar(36) NOT NULL,
  `id_karyawan` varchar(36) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengajuan_lembur`
--

INSERT INTO `pengajuan_lembur` (`id_pengajuan`, `id_karyawan`, `tanggal_pengajuan`, `waktu_mulai`, `waktu_selesai`, `keterangan`) VALUES
('547b42f0-2cf6-4353-ace3-626f76b5c7f1', '94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-14', '22:44:00', '23:44:00', 'disetujui'),
('ef6aafbf-453c-44c3-8b57-155d88ce5888', '94972980-a9fb-4d81-95f9-777383123eaa', '2024-06-06', '23:44:00', '00:44:00', 'ditolak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` varchar(36) NOT NULL,
  `nama_pengguna` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipe_pengguna` enum('superadmin','staff','dept. head','pic') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_karyawan` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `password`, `tipe_pengguna`, `id_karyawan`) VALUES
('232f87d8-f81f-46cf-a493-f66a7b954dfb', 'mohamadzen', '$2y$10$sezObNxByCHeGhL1kOKyTOaFvKtsuh80b6yWZETlmsrbOWhAyDZ.K', 'pic', '94972980-a9fb-4d81-95f9-777383123eaa'),
('6caa27cc-d338-46d4-9b51-3b394718dd47', 'fuanda', '$2y$10$Xf/oYjS/oN6LKA5FcEjM1OvYPIUjIWEzOa5os/f9K4E/cW4Jp3Ww6', 'staff', 'af60dbe4-0cf1-4810-9935-c2e1e87bdd10'),
('b58a7ec8-73ce-415b-b415-21835792464b', 'superadmin', '$2y$10$Swdi8jKhbPrbt5pQD9CG5eyZ554DCBHE7n3OCT.0s9.w9Q3Nz2Cwy', 'superadmin', '2c42b9ef-3ed7-4e58-bb89-09cba14a4077'),
('e1f853e9-19f2-444f-b9ac-348559476717', 'amin', '$2y$10$C5AFXfm8k57ArAe6t66r8.C4qYHkRxM1OTg0JjqyGJjEoJViDrDxS', 'pic', 'caa6bba9-2766-4e6c-9eb7-b1403a8af10f');

-- --------------------------------------------------------

--
-- Struktur dari tabel `persetujuan_lembur`
--

CREATE TABLE `persetujuan_lembur` (
  `id_persetujuan` varchar(36) NOT NULL,
  `id_pengajuan` varchar(36) NOT NULL,
  `disetujui_oleh` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal_persetujuan` datetime DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `persetujuan_lembur`
--

INSERT INTO `persetujuan_lembur` (`id_persetujuan`, `id_pengajuan`, `disetujui_oleh`, `tanggal_persetujuan`, `status`) VALUES
('03d0405f-55b1-4dc2-a778-06c4186b7be4', 'ef6aafbf-453c-44c3-8b57-155d88ce5888', 'af60dbe4-0cf1-4810-9935-c2e1e87bdd10', '2024-06-14 15:45:42', 'ditolak'),
('2e87d3ce-7ef4-46d3-91b4-65aff960361b', '547b42f0-2cf6-4353-ace3-626f76b5c7f1', 'af60dbe4-0cf1-4810-9935-c2e1e87bdd10', '2024-06-14 15:45:35', 'disetujui'),
('5ecfd6d7-fb34-4609-8e3f-8f8386fba2ed', 'ef6aafbf-453c-44c3-8b57-155d88ce5888', NULL, NULL, 'pending'),
('b521d349-5b62-4649-bb9a-4183665935a2', '547b42f0-2cf6-4353-ace3-626f76b5c7f1', NULL, NULL, 'pending');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `pengajuan_lembur`
--
ALTER TABLE `pengajuan_lembur`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `persetujuan_lembur`
--
ALTER TABLE `persetujuan_lembur`
  ADD PRIMARY KEY (`id_persetujuan`),
  ADD KEY `id_pengajuan` (`id_pengajuan`),
  ADD KEY `disetujui_oleh` (`disetujui_oleh`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `pengajuan_lembur`
--
ALTER TABLE `pengajuan_lembur`
  ADD CONSTRAINT `pengajuan_lembur_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `persetujuan_lembur`
--
ALTER TABLE `persetujuan_lembur`
  ADD CONSTRAINT `persetujuan_lembur_ibfk_1` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan_lembur` (`id_pengajuan`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `persetujuan_lembur_ibfk_2` FOREIGN KEY (`disetujui_oleh`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
