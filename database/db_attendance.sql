-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10 Mei 2016 pada 09.58
-- Versi Server: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_attendance`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `NIK` varchar(20) DEFAULT NULL,
  `OFFICE_ID` varchar(16) DEFAULT NULL,
  `ATTENDANCE_ID` varchar(16) NOT NULL DEFAULT '',
  `ATTENDANCE_IN_DATE` date DEFAULT NULL,
  `ATTENDANCE_IN_TIME` time DEFAULT NULL,
  `ATTENDANCE_OUT_DATE` date DEFAULT NULL,
  `ATTENDANCE_OUT_TIME` time DEFAULT NULL,
  `LATITUDE_IN` float DEFAULT NULL,
  `LONGITUDE_IN` float DEFAULT NULL,
  `LATITUDE_OUT` float DEFAULT NULL,
  `LONGITUDE_OUT` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `office`
--

CREATE TABLE IF NOT EXISTS `office` (
  `OFFICE_ID` varchar(16) NOT NULL,
  `OFFICE_NAME` varchar(64) DEFAULT NULL,
  `OFFICE_ADDRESS` varchar(256) DEFAULT NULL,
  `OFFICE_LATITUDE` float DEFAULT NULL,
  `OFFICE_LONGITUDE` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `office`
--

INSERT INTO `office` (`OFFICE_ID`, `OFFICE_NAME`, `OFFICE_ADDRESS`, `OFFICE_LATITUDE`, `OFFICE_LONGITUDE`) VALUES
('1', 'ITB', 'Jl. Ganesha 10', -6.88875, 107.612);

-- --------------------------------------------------------

--
-- Struktur dari tabel `office_working_hour`
--

CREATE TABLE IF NOT EXISTS `office_working_hour` (
  `OFFICE_ID` varchar(16) NOT NULL,
  `WORKING_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `office_working_hour`
--

INSERT INTO `office_working_hour` (`OFFICE_ID`, `WORKING_ID`) VALUES
('1', 1),
('1', 2),
('1', 3),
('1', 4),
('1', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payroll`
--

CREATE TABLE IF NOT EXISTS `payroll` (
  `NIK` varchar(20) DEFAULT NULL,
  `PAYROLL_ID` bigint(20) NOT NULL,
  `PAYROLL_NETT_VALUE` double DEFAULT NULL,
  `PAYROLL_DATE` date DEFAULT NULL,
  `PAYROLL_TIME` time DEFAULT NULL,
  `PAYROLL_TAX` double DEFAULT NULL,
  `PAYROLL_VALUE_TOTAL` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `NIK` varchar(20) NOT NULL,
  `USER_ROLE_ID` int(11) NOT NULL,
  `USER_ACTIVE_ID` int(11) NOT NULL,
  `PASSWORD` varchar(32) DEFAULT NULL,
  `FULL_NAME` varchar(64) DEFAULT NULL,
  `GENDER` char(2) DEFAULT NULL,
  `BIRTHDATE` date DEFAULT NULL,
  `ADDRESS` varchar(128) DEFAULT NULL,
  `IMEI_NUMBER` varchar(15) DEFAULT NULL,
  `REGISTER_DATE` datetime DEFAULT NULL,
  `LAST_LOGIN_DATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`NIK`, `USER_ROLE_ID`, `USER_ACTIVE_ID`, `PASSWORD`, `FULL_NAME`, `GENDER`, `BIRTHDATE`, `ADDRESS`, `IMEI_NUMBER`, `REGISTER_DATE`, `LAST_LOGIN_DATE`) VALUES
('1002150401060793', 2, 1, '79b013932a9a7efa4f9e7ee201b96aa7', 'Vera Juliantika', 'F', '1993-07-06', 'Jl. Terusan Kiara Condong', '352239068663309', '2015-03-30 10:32:23', '2015-04-01 07:32:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_activation`
--

CREATE TABLE IF NOT EXISTS `user_activation` (
  `USER_ACTIVE_ID` int(11) NOT NULL,
  `USER_ACTIVE_DESC` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_activation`
--

INSERT INTO `user_activation` (`USER_ACTIVE_ID`, `USER_ACTIVE_DESC`) VALUES
(1, 'active'),
(2, 'not active'),
(3, 'suspended');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `USER_ROLE_ID` int(11) NOT NULL,
  `USER_ROLE_NAME` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`USER_ROLE_ID`, `USER_ROLE_NAME`) VALUES
(1, 'admin'),
(2, 'karyawan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `working_hour`
--

CREATE TABLE IF NOT EXISTS `working_hour` (
  `WORKING_ID` int(11) NOT NULL,
  `DAY_NAME` varchar(16) DEFAULT NULL,
  `START_TIME` time DEFAULT NULL,
  `END_TIME` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `working_hour`
--

INSERT INTO `working_hour` (`WORKING_ID`, `DAY_NAME`, `START_TIME`, `END_TIME`) VALUES
(1, 'monday', '08:00:00', '17:00:00'),
(2, 'tuesday', '08:00:00', '17:00:00'),
(3, 'wednesday', '08:00:00', '17:00:00'),
(4, 'thursday', '08:00:00', '17:00:00'),
(5, 'friday', '08:00:00', '17:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`ATTENDANCE_ID`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`OFFICE_ID`);

--
-- Indexes for table `office_working_hour`
--
ALTER TABLE `office_working_hour`
  ADD PRIMARY KEY (`OFFICE_ID`,`WORKING_ID`), ADD KEY `FK_RELATIONSHIP_5` (`WORKING_ID`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`PAYROLL_ID`), ADD KEY `FK_RELATIONSHIP_6` (`NIK`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`NIK`), ADD KEY `FK_RELATIONSHIP_1` (`USER_ROLE_ID`), ADD KEY `FK_RELATIONSHIP_2` (`USER_ACTIVE_ID`);

--
-- Indexes for table `user_activation`
--
ALTER TABLE `user_activation`
  ADD PRIMARY KEY (`USER_ACTIVE_ID`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`USER_ROLE_ID`);

--
-- Indexes for table `working_hour`
--
ALTER TABLE `working_hour`
  ADD PRIMARY KEY (`WORKING_ID`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `office_working_hour`
--
ALTER TABLE `office_working_hour`
ADD CONSTRAINT `FK_RELATIONSHIP_4` FOREIGN KEY (`OFFICE_ID`) REFERENCES `office` (`OFFICE_ID`),
ADD CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`WORKING_ID`) REFERENCES `working_hour` (`WORKING_ID`);

--
-- Ketidakleluasaan untuk tabel `payroll`
--
ALTER TABLE `payroll`
ADD CONSTRAINT `FK_RELATIONSHIP_6` FOREIGN KEY (`NIK`) REFERENCES `user` (`NIK`);

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `FK_RELATIONSHIP_1` FOREIGN KEY (`USER_ROLE_ID`) REFERENCES `user_role` (`USER_ROLE_ID`),
ADD CONSTRAINT `FK_RELATIONSHIP_2` FOREIGN KEY (`USER_ACTIVE_ID`) REFERENCES `user_activation` (`USER_ACTIVE_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
