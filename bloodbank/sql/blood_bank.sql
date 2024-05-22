-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 01:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_bank`
--

--
-- Procedures
--
DELIMITER //

CREATE OR REPLACE PROCEDURE GetDonationDetailsByDonor(
    IN donor_id INT
)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE hospital_name VARCHAR(255);
    DECLARE hospital_city VARCHAR(255);
    DECLARE blood_group VARCHAR(10);
    DECLARE units_donated INT; DECLARE donation_cursor CURSOR FOR
        SELECT hname, hcity, bg, units
        FROM donates
        WHERE did = donor_id;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    CREATE TEMPORARY TABLE IF NOT EXISTS temp_donation_history (
        hospital_name VARCHAR(255),
        hospital_city VARCHAR(255),
        blood_group VARCHAR(10),
        units_donated INT
    );
    OPEN donation_cursor;
    donation_loop: LOOP
        FETCH donation_cursor INTO hospital_name, hospital_city, blood_group, units_donated;
        IF done THEN
            LEAVE donation_loop;
        END IF;
        INSERT INTO temp_donation_history (hospital_name, hospital_city, blood_group, units_donated)
        VALUES (hospital_name, hospital_city, blood_group, units_donated);
    END LOOP;
    CLOSE donation_cursor;
    SELECT * FROM temp_donation_history;
    DROP TEMPORARY TABLE IF EXISTS temp_donation_history;
END //

DELIMITER ;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `check_stock_and_request_blood` (IN `p_hid` INT, IN `p_rid` INT, IN `p_bg` VARCHAR(2), IN `p_units` INT, OUT `p_message` VARCHAR(50))   BEGIN
    DECLARE available_units INT;
    SELECT stock_quantity INTO available_units
    FROM bloodstock
    WHERE hid=p_hid AND bg=p_bg;
    IF available_units IS NULL OR available_units=0 THEN
    SET p_message = 'No Stock';
    ELSEIF available_units<p_units THEN
    SET p_message='Insufficient Stock';
    ELSE
    INSERT INTO bloodrequest (hid,rid,bg,units,status)
    VALUES (p_hid,p_rid,p_bg,p_units,'Pending');
    SET p_message='Request Submitted';
    END IF ;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetDonorDetailsByHospital` (IN `hospitalId` INT)   BEGIN
    SELECT donors.dname, donors.demail, donors.dcity, donors.dphone, donors.dbg, donates.units 
    FROM donors
    INNER JOIN donates ON donors.did = donates.did
    WHERE donates.hid = hospitalId;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bloodrequest`
--

CREATE TABLE `bloodrequest` (
  `reqid` int(11) NOT NULL,
  `hid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `bg` varchar(3) NOT NULL,
  `units` int(1) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodrequest`
--

INSERT INTO `bloodrequest` (`reqid`, `hid`, `rid`, `bg`, `units`, `status`) VALUES
(1, 1, 2, 'A+', 3, 'Accepted'),
(2, 6, 2, 'A+', 3, 'Pending');

--
-- Triggers `bloodrequest`
--
DELIMITER $$
CREATE TRIGGER `trg_update_bloodstock` AFTER UPDATE ON `bloodrequest` FOR EACH ROW BEGIN
    IF NEW.status = 'Accepted' AND OLD.status <> 'Accepted' THEN
        UPDATE bloodstock
        SET stock_quantity = stock_quantity - NEW.units
        WHERE bg = NEW.bg AND hid=NEW.hid;
    END IF;
END
$$
DELIMITER ;
-- --------------------------------------------------------

--
-- Table structure for table `bloodstock`
--

CREATE TABLE `bloodstock` (
  `hid` int(11) NOT NULL,
  `bg` varchar(3) NOT NULL,
  `stock_quantity` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodstock`
--

INSERT INTO `bloodstock` (`hid`, `bg`, `stock_quantity`) VALUES
(1, 'A+', 14),
(1, 'B+', 0),
(2, 'A+', 4),
(2, 'AB', 1),
(6, 'A+', 3),
(6, 'B+', 5);

-- --------------------------------------------------------

--
-- Table structure for table `donates`
--

CREATE TABLE `donates` (
  `did` int(11) NOT NULL,
  `hid` int(11) NOT NULL,
  `dname` varchar(20) NOT NULL,
  `hname` varchar(20) NOT NULL,
  `hcity` varchar(20) NOT NULL,
  `bg` varchar(3) NOT NULL,
  `units` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donates`
--

INSERT INTO `donates` (`did`, `hid`, `dname`, `hname`, `hcity`, `bg`, `units`) VALUES
(1, 1, 'Roshini', 'Fortis Mallar Hospit', 'Chennai', 'A+', 4),
(1, 2, 'Roshini', 'SRM Hospital', 'Kancheepuram', 'A+', 4),
(1, 5, 'Roshini', 'CSI Kalyani Hospital', 'Chennai', 'A+', 1),
(1, 6, 'Roshini', 'Kauvery Hospital', 'Salem', 'A+', 2),
(2, 1, 'Shrey', 'Fortis Mallar Hospit', 'Chennai', 'A+', 3),
(2, 2, 'Shrey', 'SRM Hospital', 'Kancheepuram', 'B+', 1),
(2, 4, 'Shrey', 'MIOT Hospital', 'Chennai', 'B+', 4),
(2, 6, 'Shrey', 'Kauvery Hospital', 'Salem', 'A+', 3),
(3, 1, 'Pavi', 'Fortis Mallar Hospit', 'Chennai', 'A+', 4),
(3, 2, 'Pavi', 'SRM Hospital', 'Kancheepuram', 'O+', 2),
(4, 1, 'Sumi', 'Fortis Mallar Hospit', 'Chennai', 'A+', 2),
(4, 2, 'Sumi', 'SRM Hospital', 'Kancheepuram', 'A+', 3),
(4, 4, 'Sumi', 'MIOT Hospital', 'Chennai', 'A+', 2),
(5, 1, 'Ram', 'Fortis Mallar Hospit', 'Chennai', 'A+', 4),
(5, 2, 'Ram', 'SRM Hospital', 'Kancheepuram', 'A+', 3),
(6, 2, 'Lolesh', 'SRM Hospital', 'Kancheepuram', 'AB', 1);

--
-- Triggers `donates`
--
DELIMITER $$
CREATE TRIGGER `update_stock_quantity` AFTER INSERT ON `donates` FOR EACH ROW BEGIN
    UPDATE bloodstock b
    SET b.stock_quantity = b.stock_quantity + NEW.units
    WHERE b.bg = NEW.bg
    AND b.hid = NEW.hid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `did` int(11) NOT NULL,
  `dname` varchar(100) NOT NULL,
  `demail` varchar(100) NOT NULL,
  `dpassword` varchar(100) NOT NULL,
  `dphone` varchar(100) NOT NULL,
  `dbg` varchar(3) NOT NULL,
  `dcity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`did`, `dname`, `demail`, `dpassword`, `dphone`, `dbg`, `dcity`) VALUES
(1, 'Roshini', 'roshini@gmail.com', 'roshini@123', '9043588681', 'A+', 'Chennai'),
(2, 'Shrey', 'shrey@gmail.com', 'shrey@123', '6394738232', 'B+', 'Chennai'),
(3, 'Pavi', 'pavithraniyer@gmail.com', 'pavi@123', '9087654365', 'O+', 'Chennai'),
(4, 'Sumi', 'sumi@gmail.com', 'sumi@123', '6234567891', 'A+', 'Chennai'),
(5, 'Ram', 'ram@gmail.com', 'ram@123', '6547382963', 'A+', 'Chennai'),
(6, 'Lolesh', 'lolesh@gmail.com', 'lolesh@123', '65498702678', 'AB-', 'Chennai');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `hid` int(11) NOT NULL,
  `hname` varchar(100) NOT NULL,
  `hemail` varchar(100) NOT NULL,
  `hpassword` varchar(100) NOT NULL,
  `hphone` varchar(100) NOT NULL,
  `hcity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`hid`, `hname`, `hemail`, `hpassword`, `hphone`, `hcity`) VALUES
(1, 'Fortis Mallar Hospital', 'healthcare@fortismalarhospital.com', 'Fortismalar@123', '914442892222', 'Chennai'),
(2, 'SRM Hospital', 'healthmatters@srmhospital.com', 'Srm@123', '914427452270', 'Kancheepuram'),
(3, 'Apollo Multi Speciality Hospital', 'Apollocares@apollohospitals.com', 'Apollo@123', '914428290200', 'Chennai'),
(4, 'MIOT Hospital', 'miotcares@miothospital.com', 'Miot@123', '9122492288', 'Chennai'),
(5, 'CSI Kalyani Hospital', 'healthpioneer@csikalyanihospital.com', 'Csikalyani@123', '914428476433', 'Chennai'),
(6, 'Kauvery Hospital', 'lifecare@kauveryhospital.com', 'Kauvery@123', '914462855324', 'Salem');

-- --------------------------------------------------------

--
-- Table structure for table `receivers`
--

CREATE TABLE `receivers` (
  `rid` int(11) NOT NULL,
  `rname` varchar(100) NOT NULL,
  `remail` varchar(100) NOT NULL,
  `rpassword` varchar(100) NOT NULL,
  `rphone` varchar(100) NOT NULL,
  `rbg` varchar(3) NOT NULL,
  `rcity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receivers`
--

INSERT INTO `receivers` (`rid`, `rname`, `remail`, `rpassword`, `rphone`, `rbg`, `rcity`) VALUES
(1, 'Sarala', 'sarala@gmail.com', 'sarala@123', '87654298023', 'AB+', 'Chennai'),
(2, 'Ananthi', 'ananthi@gmail.com', 'ananthi@123', '908765438973', 'O+', 'Chennai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloodrequest`
--
ALTER TABLE `bloodrequest`
  ADD PRIMARY KEY (`reqid`),
  ADD KEY `fk_hidreq` (`hid`),
  ADD KEY `fk_ridreq` (`rid`);

--
-- Indexes for table `bloodstock`
--
ALTER TABLE `bloodstock`
  ADD PRIMARY KEY (`hid`,`bg`);

--
-- Indexes for table `donates`
--
ALTER TABLE `donates`
  ADD PRIMARY KEY (`did`,`hid`),
  ADD KEY `fk_hid` (`hid`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`did`),
  ADD UNIQUE KEY `demail` (`demail`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`hid`),
  ADD UNIQUE KEY `hemail` (`hemail`);

--
-- Indexes for table `receivers`
--
ALTER TABLE `receivers`
  ADD PRIMARY KEY (`rid`),
  ADD UNIQUE KEY `remail` (`remail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloodrequest`
--
ALTER TABLE `bloodrequest`
  MODIFY `reqid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `hid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `receivers`
--
ALTER TABLE `receivers`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bloodrequest`
--
ALTER TABLE `bloodrequest`
  ADD CONSTRAINT `fk_hidreq` FOREIGN KEY (`hid`) REFERENCES `hospitals` (`hid`),
  ADD CONSTRAINT `fk_ridreq` FOREIGN KEY (`rid`) REFERENCES `receivers` (`rid`);

--
-- Constraints for table `bloodstock`
--
ALTER TABLE `bloodstock`
  ADD CONSTRAINT `fk_stockhid` FOREIGN KEY (`hid`) REFERENCES `hospitals` (`hid`);

--
-- Constraints for table `donates`
--
ALTER TABLE `donates`
  ADD CONSTRAINT `fk_did` FOREIGN KEY (`did`) REFERENCES `donors` (`did`),
  ADD CONSTRAINT `fk_hid` FOREIGN KEY (`hid`) REFERENCES `hospitals` (`hid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
