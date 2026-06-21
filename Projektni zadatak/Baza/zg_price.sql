-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 05:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zg_price`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `korisnicko_ime` varchar(50) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'miki', 'miki', 'miki', '$2y$10$6E3FGp7pto7ofqykiVcPF.GzpiNOZkPMJZrr7fpUG/pKtQTgrd9DC', 1),
(3, 'miki2', 'miki2', 'miki2', '$2y$10$i6ALKzdsKEL5wIswR4pNU.AljlhgUyeVgCZ0gLuOwUm80sdYF0iYW', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` datetime NOT NULL DEFAULT current_timestamp(),
  `naslov` varchar(255) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(255) NOT NULL,
  `kategorija` varchar(50) NOT NULL,
  `arhiva` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(1, '2026-06-21 11:46:54', 'Nove pješačke zone u centru: Gdje se od sutra više ne smije autom?', 'Promjene u prometu', 'Od sutra stupa na snagu nova odluka o proširenju pješačkih zona u samom srcu Zagreba. Gradske vlasti odlučile su nastaviti s trendom oslobađanja ulica od automobila i vraćanja prostora pješacima i biciklistima. Stanari unutar zona imat će osiguran pristup u posebnim terminima, dok će komunalni redari pojačano nadzirati provođenje ove odluke.', 'pexels-vladimirsrajber-28071880.jpg', 'vijesti', 0),
(2, '2026-06-21 11:46:54', 'Zagrebački plavi tramvaji slave rođendan: Pogledajte stare fotke kroz povijest', 'Simbol grada', 'Zagrebački električni tramvaj (ZET) obilježava još jednu važnu obljetnicu svojih prepoznatljivih plavih tramvaja koji već desetljećima čine kralježnicu gradskog prijevoza. Od starih modela s otvorenim platformama do modernih niskopodnih vozila, donosimo veliku fotogaleriju kroz povijest zagrebačkih ulica.', 'pexels-zekai-zhu-214984943-11827897.jpg', 'vijesti', 0),
(3, '2026-06-21 11:46:54', 'Nedjeljni lov na blago: Što smo sve pronašli na kultnom zagrebačkom sajmu', 'Hrelić reportaža', 'Posjetili smo legendarni sajam na Hreliću ove nedjelje kako bismo provjerili ponudu i osjetili jedinstvenu atmosferu. Od gramofonskih ploča i retro odjeće do starih stripova i unikatnih antikviteta, Hrelić i dalje ostaje nezaobilazno mjesto za sve ljubitelje nostalgije i dobre trgovine.', 'placeholder.jpg', 'vijesti', 0),
(4, '2026-06-21 11:46:54', 'Dinamo spreman za europski ispit: Trener najavio ofenzivnu postavu', 'Maksimirski lavovi', 'Uoči važne europske utakmice na Maksimiru, stručni stožer Dinama najavio je hrabru i napadačku igru od prve minute. Igrači su u punom pogonu, atmosfera u svlačionici je izvrsna, a navijači pripremaju veliku koreografiju kako bi pogurali momčad do nove važne pobjede u Europi.', 'kristina-kutlesa-YgBN2GKwkYs-unsplash.jpg', 'sport', 0),
(5, '2026-06-21 11:46:54', 'Cibona u dramatičnoj završnici pred domaćom publikom osigurala važnu pobjedu', 'Košarka pod tornjem', 'Košarkaši Cibone odigrali su napetu utakmicu punu preokreta u Draženovom domu. Zahvaljujući sjajnoj timskoj igri i smirenosti u ključnim slobodnim bacanjima u zadnjim sekundama susreta, bodovi ostaju pod tornjem na veliko oduševljenje domaćih navijača.', '37650847.jpg', 'sport', 0),
(6, '2026-06-21 11:46:54', 'Otvorene prijave za tradicionalnu trail utrku na Medvednici: Očekuje se rekordan broj trkača', 'Sljemenski đir', 'Ljubitelji trčanja i prirode dolaze na svoje jer su službeno otvorene prijave za ovogodišnje izdanje trail utrke na Sljemenu. Staze su prilagođene svim razinama spremnosti, od rekreativaca do profesionalaca, a trkače očekuju predivni šumski putevi i bogati startni paketi.', 'pexels-vladimirsrajber-33203357.jpg', 'sport', 0),
(7, '2026-06-21 11:46:54', 'Dvorišta se vraćaju ovog ljeta: Otkrivamo koje skrivene lokacije možete posjetiti', 'Gornji grad', 'Popularna manifestacija Dvorišta ponovno otvara vrata skrivenih gornjogradskih palača za sve posjetitelje. Uz vrhunsku živu glazbu, ambijentalnu rasvjetu i bogatu gastronomsku ponudu, ovo je idealna prilika da zavirite iza fasada i otkrijete povijesne tajne starog Zagreba.', 'pexels-vladimirsrajber-30263464.jpg', 'kultura', 0),
(8, '2026-06-21 11:46:54', 'Novi murali osvanuli u Novom Zagrebu i potpuno oživjeli sive fasade', 'Ulična umjetnost', 'U sklopu najnovijeg uličnog festivala, domaći i inozemni street art umjetnici oslikali su nekoliko velikih stambenih zgrada u Novom Zagrebu. Dosadne i sive betonske površine pretvorene su u impresivna umjetnička djela koja su unijela boju i novu energiju u kvart.', 'slika1.jpg', 'kultura', 0),
(9, '2026-06-21 11:46:54', 'Gdje pojesti najbolje štrukle u gradu? Testirali smo 5 kultnih mjesta', 'Gastro preporuka', 'Štrukle su nezaobilazni dio zagrebačke gastronomske tradicije, pa smo odlučili provjeriti gdje se pripremaju najbolje — zapečene ili kuhane, slatke ili slane. Testirali smo pet poznatih lokacija u gradu i donosimo vam detaljne ocjene okusa, teksture i ambijenta.', 'pexels-vidalbalielojrfotografia-2337842.jpg', 'kultura', 0),
(10, '2026-06-21 15:35:08', 'test', 'test', 'test', 'pexels-vladimirsrajber-30263464.jpg', 'vijesti', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
