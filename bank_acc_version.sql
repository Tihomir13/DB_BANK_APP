-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 08:16 AM
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
-- Database: `bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_status`
--

CREATE TABLE `account_status` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_status`
--

INSERT INTO `account_status` (`ID`, `Name`) VALUES
(1, 'Active'),
(2, 'Inactive'),
(3, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE `bank_account` (
  `IBAN` varchar(22) NOT NULL,
  `Interest` decimal(10,0) NOT NULL,
  `Account_Status_ID` int(11) NOT NULL,
  `Client_EGN` varchar(10) NOT NULL,
  `Currency_ID` int(11) NOT NULL,
  `Amount` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_account`
--

INSERT INTO `bank_account` (`IBAN`, `Interest`, `Account_Status_ID`, `Client_EGN`, `Currency_ID`, `Amount`) VALUES
('BG11417802903533446211', 0, 1, '1111111111', 1, 10633),
('BG61061747545953552915', 0, 1, '3333333333', 1, 4533),
('BG73083579028766828862', 0, 1, '2222222222', 1, 5066);

-- --------------------------------------------------------

--
-- Table structure for table `bank_card`
--

CREATE TABLE `bank_card` (
  `Card_number` varchar(16) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `Pin` varchar(4) NOT NULL,
  `CVV` varchar(3) NOT NULL,
  `Client_EGN` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `Name` varchar(50) NOT NULL,
  `EGN` varchar(10) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Phone_number` varchar(10) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`Name`, `EGN`, `Address`, `Phone_number`, `Email`, `username`, `password`) VALUES
('Tihomir Ivanov Susamov', '1111111111', 'Dubrovnik 18', '0889328488', 'Tihomir@abv.bg', 'Pichaga123', '$2y$10$wzFsKZiq0aClbZtYNQhfDOCU98j6wcJTGJTrro3GPZy7ByU.5qhxO'),
('Velizar Nedkov', '2222222222', 'Dubrovnik 18', '9349434333', 'Velizar@abv.bg', 'Brush', '$2y$10$rfIFyScM7VZPNe7q4R5KVO9nCgtaLc/BR7FfPPaIuso9vfc8clzba'),
('Denis Iliev', '3333333333', 'Dubrovnik 18', '3232423434', 'Denis@abv.bg', 'A3', '$2y$10$cHSUxam2lWLwamVczZF4puFbweQbPbpQZsdPxt6T6ZTFkqBJWh4VS');

-- --------------------------------------------------------

--
-- Table structure for table `credit`
--

CREATE TABLE `credit` (
  `ID` int(11) NOT NULL,
  `Total_amount` decimal(10,0) NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `Interest` decimal(10,0) NOT NULL,
  `Remaining_amount` decimal(10,0) NOT NULL,
  `Amount_installment` decimal(10,0) NOT NULL,
  `Remaining_installments` int(11) NOT NULL,
  `Repayment_Period` date NOT NULL,
  `Bank_Account_IBAN` varchar(22) NOT NULL,
  `Credit_Type_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credit`
--

INSERT INTO `credit` (`ID`, `Total_amount`, `Amount`, `Interest`, `Remaining_amount`, `Amount_installment`, `Remaining_installments`, `Repayment_Period`, `Bank_Account_IBAN`, `Credit_Type_ID`) VALUES
(28, 10300, 10000, 3, 10300, 858, 12, '2025-04-04', 'BG11417802903533446211', 1),
(29, 5250, 5000, 5, 5250, 219, 24, '2026-04-04', 'BG73083579028766828862', 3),
(30, 4200, 4000, 5, 4200, 175, 24, '2026-04-04', 'BG61061747545953552915', 2);

-- --------------------------------------------------------

--
-- Table structure for table `credit_type`
--

CREATE TABLE `credit_type` (
  `ID` int(11) NOT NULL,
  `Type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credit_type`
--

INSERT INTO `credit_type` (`ID`, `Type`) VALUES
(1, 'Personal'),
(2, 'Mortgage'),
(3, 'Student');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`ID`, `Name`) VALUES
(1, 'BGN'),
(2, 'EUR'),
(3, 'EUR');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `Name` varchar(50) NOT NULL,
  `EGN` varchar(10) NOT NULL,
  `Phone_number` varchar(10) NOT NULL,
  `Position_ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`Name`, `EGN`, `Phone_number`, `Position_ID`, `username`, `password`) VALUES
('Tihomir', '1111111111', '0889328488', 1, 'BOSS', 'admin'),
('Azra Mehmed', '2222222222', '7777777777', 2, 'Zi888', 'Zi88Zi88'),
('Стефан Тютюнков', '3333333333', '0887245114', 2, 'TheRedFlashBG', 'Money'),
('Пламена Николаева', '5555555555', '5555555555', 2, 'moneylover', '365mL11B'),
('Тома Томов', '9999999999', '8888888888', 2, 'Tomkata', 'C++FTWN');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`ID`, `Name`) VALUES
(1, 'CEO'),
(2, 'Bank Operator');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `ID` int(11) NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Trans_Type_ID` int(11) NOT NULL,
  `S_Bank_Account_IBAN` varchar(22) NOT NULL,
  `R_Bank_Account_IBAN` varchar(22) NOT NULL,
  `Employee_EGN` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`ID`, `Amount`, `Date`, `Trans_Type_ID`, `S_Bank_Account_IBAN`, `R_Bank_Account_IBAN`, `Employee_EGN`) VALUES
(143, 333, '2024-04-04 20:34:26', 3, 'BG11417802903533446211', 'BG73083579028766828862', '5555555555'),
(144, 200, '2024-04-04 20:34:49', 3, 'BG11417802903533446211', 'BG61061747545953552915', '5555555555'),
(148, 500, '2024-04-04 20:38:19', 3, 'BG11417802903533446211', 'BG73083579028766828862', '5555555555'),
(149, 222, '2024-04-04 20:38:31', 3, 'BG11417802903533446211', 'BG73083579028766828862', '9999999999'),
(150, 344, '2024-04-04 20:38:41', 3, 'BG11417802903533446211', 'BG73083579028766828862', '5555555555'),
(151, 1000, '2024-04-04 20:39:06', 3, 'BG73083579028766828862', 'BG61061747545953552915', '5555555555'),
(152, 233, '2024-04-04 20:39:13', 3, 'BG73083579028766828862', 'BG61061747545953552915', '9999999999'),
(153, 500, '2024-04-04 20:39:20', 3, 'BG73083579028766828862', 'BG11417802903533446211', '3333333333'),
(154, 500, '2024-04-04 20:39:46', 3, 'BG61061747545953552915', 'BG11417802903533446211', '2222222222'),
(155, 400, '2024-04-04 20:39:56', 3, 'BG61061747545953552915', 'BG73083579028766828862', '2222222222');

-- --------------------------------------------------------

--
-- Table structure for table `trans_type`
--

CREATE TABLE `trans_type` (
  `ID` int(11) NOT NULL,
  `Type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_type`
--

INSERT INTO `trans_type` (`ID`, `Type`) VALUES
(1, 'Deposit'),
(2, 'Withdraw'),
(3, 'Transfer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_status`
--
ALTER TABLE `account_status`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`IBAN`),
  ADD KEY `Client_EGN` (`Client_EGN`),
  ADD KEY `Account_Status_ID` (`Account_Status_ID`),
  ADD KEY `Currency_ID` (`Currency_ID`);

--
-- Indexes for table `bank_card`
--
ALTER TABLE `bank_card`
  ADD PRIMARY KEY (`Card_number`),
  ADD KEY `Client_EGN` (`Client_EGN`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`EGN`);

--
-- Indexes for table `credit`
--
ALTER TABLE `credit`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Bank_Account_IBAN` (`Bank_Account_IBAN`,`Credit_Type_ID`),
  ADD KEY `Credit_Type_ID` (`Credit_Type_ID`);

--
-- Indexes for table `credit_type`
--
ALTER TABLE `credit_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`EGN`),
  ADD KEY `Position_ID` (`Position_ID`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Trans_Type_ID` (`Trans_Type_ID`,`S_Bank_Account_IBAN`,`Employee_EGN`),
  ADD KEY `Bank_Account_IBAN` (`S_Bank_Account_IBAN`),
  ADD KEY `Employee_EGN` (`Employee_EGN`),
  ADD KEY `R_Bank_Account_IBAN` (`R_Bank_Account_IBAN`);

--
-- Indexes for table `trans_type`
--
ALTER TABLE `trans_type`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_status`
--
ALTER TABLE `account_status`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `credit`
--
ALTER TABLE `credit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `credit_type`
--
ALTER TABLE `credit_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `trans_type`
--
ALTER TABLE `trans_type`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD CONSTRAINT `bank_account_ibfk_1` FOREIGN KEY (`Client_EGN`) REFERENCES `client` (`EGN`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bank_account_ibfk_2` FOREIGN KEY (`Account_Status_ID`) REFERENCES `account_status` (`ID`),
  ADD CONSTRAINT `bank_account_ibfk_3` FOREIGN KEY (`Currency_ID`) REFERENCES `currency` (`ID`);

--
-- Constraints for table `bank_card`
--
ALTER TABLE `bank_card`
  ADD CONSTRAINT `bank_card_ibfk_1` FOREIGN KEY (`Client_EGN`) REFERENCES `client` (`EGN`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `credit`
--
ALTER TABLE `credit`
  ADD CONSTRAINT `credit_ibfk_1` FOREIGN KEY (`Credit_Type_ID`) REFERENCES `credit_type` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `credit_ibfk_2` FOREIGN KEY (`Bank_Account_IBAN`) REFERENCES `bank_account` (`IBAN`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`Position_ID`) REFERENCES `position` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`S_Bank_Account_IBAN`) REFERENCES `bank_account` (`IBAN`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`Trans_Type_ID`) REFERENCES `trans_type` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`Employee_EGN`) REFERENCES `employee` (`EGN`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`R_Bank_Account_IBAN`) REFERENCES `bank_account` (`IBAN`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
