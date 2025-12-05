-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2025 at 10:15 PM
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
-- Database: `daryeel1_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_authorates` (IN `p_user_id` VARCHAR(40))   BEGIN
    SELECT ua.id, ua.user_id, ua.actions, 
           sa.m_id as category_id,sa.sub_id as link_id
    FROM user_authority ua
    JOIN system_authority sa 
         ON ua.actions = sa.sub_id
    WHERE ua.user_id = p_user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_menue_authorates` (IN `p_empid` VARCHAR(40))   BEGIN
    SELECT  m.m_id, m.text  AS 'category_name', m.icon AS 'category_icon',
           s.sub_id, s.text AS 'link_name', s.url AS 'link'
    FROM users u
    JOIN user_authority ua ON u.id = ua.user_id
    JOIN sub_menues s ON ua.actions = s.sub_id
    JOIN main_menues m ON m.m_id = s.m_id
    WHERE ua.user_id = p_empid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_main_menues` (IN `p_name` VARCHAR(100), IN `p_icon` VARCHAR(100), IN `p_url` VARCHAR(100))   BEGIN
    INSERT INTO main_menues (`text`, `icon`, `url`)
    VALUES (p_name, p_icon, p_url);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_sub_menues` (IN `p_menue_id` INT, IN `p_text` VARCHAR(100), IN `p_url` VARCHAR(100))   BEGIN
    INSERT INTO sub_menues (`m_id`, `text`, `url`)
    VALUES (p_menue_id, p_text, p_url);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `payment_procedure` (IN `p_customer_id` VARCHAR(40), IN `p_amount` DECIMAL(12,0), IN `p_amount_paid` DECIMAL(12,0), IN `p_balance` DECIMAL(12,0), IN `p_Account_id` VARCHAR(20), IN `p_method_id` VARCHAR(20))   BEGIN
    -- Haddii lacagta la bixiyay ka badan tahay amount-ka
    IF p_amount_paid > p_amount THEN
        SELECT 'Deny' AS msg;
    ELSE
        -- 1. Insert payment
        INSERT INTO payment (customer_id, amount, amount_paid, balance, Account_id, p_method_id, date)
        VALUES (p_customer_id, p_amount, p_amount_paid, p_balance, p_Account_id, p_method_id, NOW());

        -- 2. Update account balance
        

        -- 3. Update customer balance
        UPDATE customer
        SET balance = p_balance
        WHERE id = p_customer_id;

        -- 4. Success msg
        SELECT 'Registered' AS msg;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_amount` (IN `p_customer_id` VARCHAR(20))   BEGIN
    SELECT c.id AS cus_id,
           c.balance
    FROM customer c
    WHERE c.id = p_customer_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `read_bills_statement` (IN `p_tellphone` VARCHAR(30))   BEGIN
    IF p_tellphone IS NULL OR p_tellphone = '' THEN
        -- Soo celi dhammaan bills statement
        SELECT b.id, b.employe_id, b.Amount, b.user, b.date,
               e.fullName, e.tell
        FROM bills b
        LEFT JOIN employee e ON b.employe_id = e.emp_id;
    ELSE
        -- Soo celi qofka leh tellphone la soo diray
        SELECT b.id, b.employe_id, b.Amount, b.user, b.date,
               e.fullName, e.tell
        FROM bills b
        LEFT JOIN employee e ON b.employe_id = e.emp_id
        WHERE e.tell = p_tellphone;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `register_expense_sp` (IN `_id` INT, IN `_amount` FLOAT(11,2), IN `_type` VARCHAR(50), IN `_desc` TEXT, IN `_userId` VARCHAR(50), IN `_Account_id` INT)   BEGIN
 if(_type = 'Expense')THEN

if((SELECT read_acount_balance(_Account_id) < _amount))THEN

SELECT 'Deny' as Message;

ELSE

INSERT into expense(expense.amount,expense.type,expense.description,expense.user_id,expense.Account_id)
VALUES(_amount,_type,_desc,_userId,_Account_id);

SELECT 'Registered' as Message;

END if;
ELSE
if(_type = 'Expense')THEN

if((SELECT read_acount_balance(_Account_id) < _amount))THEN

SELECT 'Deny' as Message;
END IF;
ELSE
if EXISTS( SELECT * FROM expense WHERE expense.id = _id)THEN
UPDATE expense SET expense.amount = _amount, expense.type = _type, expense.description = _desc,expense.user_id=_userId,expense.Account_id=_Account_id
WHERE expense.id = _id;

SELECT 'Updated' as Message;
ELSE

INSERT into expense(expense.amount,expense.type,expense.description,expense.user_id,expense.Account_id)
VALUES(_amount,_type,_desc,_userId,_Account_id);

SELECT 'Registered' as Message;

END if;
END IF;

END if;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_main_menues` (IN `p_name` VARCHAR(100), IN `p_icon` VARCHAR(100), IN `p_url` VARCHAR(100), IN `p_id` INT)   BEGIN
    UPDATE main_menues
    SET `text` = p_name,
        `icon` = p_icon,
        `url`  = p_url
    WHERE m_id = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_sub_menues` (IN `p_menue_id` INT, IN `p_text` VARCHAR(100), IN `p_url` VARCHAR(100), IN `p_sub_id` INT)   BEGIN
    UPDATE sub_menues
    SET `m_id` = p_menue_id,
        `text` = p_text,
        `url`  = p_url
    WHERE sub_id = p_sub_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` varchar(30) NOT NULL,
  `bank_name` varchar(30) NOT NULL,
  `account_num` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `balance` float(11,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `bank_name`, `account_num`, `country`, `status`, `balance`, `date_created`) VALUES
('ACC001', 'Primary Bank', '0037277', 'Somalia', 'Active', 903.00, '2025-09-06 18:37:41'),
('ACC002', 'Salaam Bank', '3433223', 'Somalia', 'Active', 200.00, '2025-09-06 18:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `areaname` varchar(40) NOT NULL,
  `country` varchar(40) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `areaname`, `country`, `date`) VALUES
(1, 'Mogadisho', 'Somalia', '2025-09-06 18:37:41'),
(2, 'Hargeisa', 'Somaliland', '2025-09-06 18:37:41'),
(3, 'Garoowe', 'Somalia', '2025-09-06 18:37:41'),
(4, 'Boosaaso', 'Somalia', '2025-09-06 18:37:41'),
(5, 'Gaal Kacyo', 'Somalia', '2025-09-06 18:37:41'),
(6, 'Dhuusamareeb', 'Somalia', '2025-09-06 18:37:41'),
(7, 'Gedo', 'Somalia', '2025-09-06 18:37:41'),
(8, 'Kismaayo', 'Somalia', '2025-09-06 18:37:41'),
(9, 'Nairobi', 'kenya', '2025-09-06 18:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `employe_id` varchar(20) NOT NULL,
  `Amount` decimal(10,0) NOT NULL,
  `user` varchar(40) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `employe_id`, `Amount`, `user`, `date`) VALUES
(1, 'EMP001', 1000, 'USR001', '2023-06-16 07:32:07'),
(2, 'EMP002', 1000, 'USR001', '2023-06-16 07:50:58'),
(3, 'EMP003', 1000, 'USR001', '2023-06-16 07:51:32'),
(4, '', 0, '', '2023-06-18 06:34:07'),
(5, '', 0, '', '2023-06-18 06:35:30'),
(6, '', 0, '', '2023-06-18 06:37:13'),
(7, '', 0, '', '2023-06-18 06:37:27'),
(8, 'EMP004', 1000, 'USR001', '2023-06-19 10:49:11');

--
-- Triggers `bills`
--
DELIMITER $$
CREATE TRIGGER `update_charge` AFTER INSERT ON `bills` FOR EACH ROW BEGIN

update charge set active=1 WHERE
employe_id=new.employe_id;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `charge`
--

CREATE TABLE `charge` (
  `charge_id` int(11) NOT NULL,
  `employe_id` varchar(20) NOT NULL,
  `job_id` varchar(40) NOT NULL,
  `Amount` decimal(12,0) NOT NULL,
  `month_id` varchar(44) NOT NULL,
  `year` varchar(50) NOT NULL,
  `description` varchar(460) NOT NULL,
  `Account_id` varchar(20) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `charge`
--

INSERT INTO `charge` (`charge_id`, `employe_id`, `job_id`, `Amount`, `month_id`, `year`, `description`, `Account_id`, `user_id`, `active`, `date`) VALUES
(1, 'EMP001', 'JOB001', 500, 'January', '2023', 'Mushaar', 'ACC001', 'USR001', 1, '2023-06-16 07:32:07'),
(2, 'EMP002', 'JOB001', 500, 'January', '2023', 'Mushaar', 'ACC001', 'USR001', 1, '2023-06-16 07:50:58'),
(3, 'EMP003', 'JOB003', 500, 'January', '2023', 'Mushaar', 'ACC001', 'USR001', 1, '2023-06-16 07:51:32'),
(4, 'EMP004', 'JOB003', 500, 'January', '2023', 'Mushaar', 'ACC001', 'USR001', 1, '2023-06-19 10:49:11'),
(12, 'EMP001', 'JOB001', 500, 'February', '2023', 'Mushaar', 'ACC001', 'USR001', 1, '2023-06-16 07:32:07'),
(13, 'EMP002', 'JOB001', 500, 'February', '2023', 'Mushaar', 'ACC001', 'USR001', 1, '2023-06-16 07:50:58'),
(14, 'EMP003', 'JOB003', 500, 'February', '2023', 'Mushaar', 'ACC001', 'USR001', 1, '2023-06-16 07:51:32'),
(15, 'EMP004', 'JOB003', 500, 'February', '2023', 'Mushaar', 'ACC001', 'USR001', 1, '2023-06-19 10:49:11');

--
-- Triggers `charge`
--
DELIMITER $$
CREATE TRIGGER `update_account_balance` AFTER INSERT ON `charge` FOR EACH ROW BEGIN

update accounts set balance=balance-new.Amount
WHERE id=new.Account_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courior`
--

CREATE TABLE `courior` (
  `id` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `couriorType` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courior`
--

INSERT INTO `courior` (`id`, `name`, `couriorType`, `phone`, `date_created`) VALUES
('COU001', 'DHL', 'Air', '73828392', '2025-09-06 18:37:41'),
('COU002', 'Maersk', 'Sea', '88987899', '2025-09-06 18:37:41'),
('COU003', 'Daalo', 'Air', '+252617827637', '2025-09-06 18:37:41'),
('COU004', 'bajaa', 'Land', '443321', '2025-09-06 18:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `tell` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `balance` int(23) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `tell`, `address`, `user_id`, `balance`, `date_created`) VALUES
('CUS001', 'Ali ismail gaboow', '76178716', 'Hoolwadaag, Mog, Som', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS002', 'Xawo xasan cali', '252617882677', 'Km4, Mog, Som', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS003', 'Hanad abdi hassan', '937827287', 'london, uk', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS004', 'Hassan mohamed ali', '728127817', 'stanbul, turkiye', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS005', 'Axmed huzein hassan', '617889087', 'Daaru-salaam', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS006', 'Fartuun yuusuf ahmed', '9378333287', 'Istanbul, Turkiye', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS007', 'Mustaf abdulahi osman', '937483372', 'Istanbul, Turkiye', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS008', 'Mahad jaamac hasan', '6326162272', 'Istanbul, Turkiye', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS009', 'Khalid mohamed hasan', '723783278', 'Daaru-salaam', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS010', 'Sacdiyo ahmed huzein', '623726727', 'Istanbul, Turkiye', 'USR001', 0, '2025-09-06 18:37:41'),
('CUS011', 'Xaliimo jaamac axmed', '636712337', 'Istanbul, Turkiye', 'USR001', 80, '2025-09-06 18:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `emp_id` varchar(10) NOT NULL,
  `fullName` varchar(40) NOT NULL,
  `address` varchar(50) NOT NULL,
  `tell` varchar(30) NOT NULL,
  `job_id` varchar(30) NOT NULL,
  `office_id` varchar(30) NOT NULL,
  `image` varchar(15) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `fullName`, `address`, `tell`, `job_id`, `office_id`, `image`, `date_created`) VALUES
('EMP001', 'Abdiaziz omar mohamud', 'Daaru-salaam', '619054070', 'JOB001', 'OFF001', 'EMP001.png', '2025-09-06 18:37:41'),
('EMP002', 'Mohamed abdi hassan', 'Üsküdar/İstanbul', '88737826', 'JOB003', 'OFF004', 'EMP002.png', '2025-09-06 18:37:41'),
('EMP003', 'Abdullahi Xasan Jaamac', 'Km4', '619886721', 'JOB003', 'OFF002', 'EMP003.png', '2025-09-06 18:37:41'),
('EMP004', 'Xaawo axmed cabdi', 'Km4', '7289188', 'JOB003', 'OFF001', 'EMP004.png', '2025-09-06 18:37:41'),
('EMP005', 'abdala', 'yaqshid', '612377876', 'JOB005', 'OFF001', 'EMP005.png', '2025-09-06 18:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `Account_id` varchar(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `amount`, `type`, `description`, `user_id`, `Account_id`, `date`) VALUES
(1, 1280, 'Expense', 'Kiro', 'USR001', 'ACC002', '2025-09-06 18:37:41'),
(2, 10000, 'Income', 'Contract', 'USR001', 'ACC001', '2025-09-06 18:37:41'),
(3, 2000, 'Income', 'Miisaaniyad', 'USR001', 'ACC002', '2025-09-06 18:37:41'),
(4, 100, 'Income', 'Miisaaniyad', 'USR001', 'ACC002', '2025-09-06 18:37:41');

--
-- Triggers `expense`
--
DELIMITER $$
CREATE TRIGGER `update_account` AFTER INSERT ON `expense` FOR EACH ROW BEGIN
    IF NEW.type = 'Income' THEN
        UPDATE accounts
        SET balance = balance+new.amount
        WHERE id=new.Account_id;
        
        ELSE
                UPDATE accounts
        SET balance = balance-new.amount
        WHERE id=new.Account_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` varchar(20) NOT NULL,
  `ref_id` varchar(40) NOT NULL,
  `cus_id` varchar(40) NOT NULL,
  `issued_date` varchar(40) NOT NULL,
  `invoice_total` float(11,2) NOT NULL,
  `currency` varchar(40) NOT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` varchar(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `fee` float NOT NULL,
  `description` varchar(100) NOT NULL,
  `Date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `name`, `fee`, `description`, `Date_created`) VALUES
('JOB001', 'Manager', 500, 'Access all functions', '2025-09-06 18:37:41'),
('JOB002', 'Assistance Manager', 400, 'Access some functions', '2025-09-06 18:37:41'),
('JOB003', 'User', 500, 'Access some functions', '2025-09-06 18:37:41'),
('JOB004', 'abdiqani', 150, 'all', '2025-09-06 18:37:41'),
('JOB005', 'abdala', 500, 'shaqooyinka dhan uu qabanaa', '2025-09-06 18:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `main_menues`
--

CREATE TABLE `main_menues` (
  `m_id` int(11) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `text` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_menues`
--

INSERT INTO `main_menues` (`m_id`, `icon`, `text`, `url`) VALUES
(1, 'fas fa-user-alt', 'Administrator', '#'),
(2, 'fas fa-boxes', 'Shipment Module', '#'),
(3, 'fas fa-money-check-alt', 'Finance Module', '#'),
(4, 'fas fa-business-time', 'HRM Module', '#'),
(5, 'fas fa-shipping-fast ', 'Courier Module', '#'),
(6, 'fas fa-calendar-alt', 'Price Module', '#'),
(7, 'fas fa-file-alt', 'Reporting Module', '#');

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE `office` (
  `office_id` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`office_id`, `address`, `city`, `country`, `phone`, `date_created`) VALUES
('OFF001', 'Km4', 'Mogadishu', 'Somalia', '55654459', '2025-09-06 18:37:41'),
('OFF002', 'Southwark', 'London', 'United Kingdom', '88767787', '2025-09-06 18:37:41'),
('OFF004', 'Adalar', 'Stanbul', 'Turkiye', '6534425', '2025-09-06 18:37:41'),
('OFF005', 'islii', 'nairobi', 'kenya', '0799925348', '2025-09-06 18:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `customer_id` varchar(40) NOT NULL,
  `amount` decimal(12,0) NOT NULL,
  `amount_paid` decimal(12,0) NOT NULL DEFAULT 0,
  `balance` decimal(12,0) NOT NULL DEFAULT 0,
  `Account_id` varchar(11) NOT NULL,
  `p_method_id` varchar(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `amount`, `amount_paid`, `balance`, `Account_id`, `p_method_id`, `date`) VALUES
(1, 'CUS011', 280, 200, 80, 'ACC002', 'METH001', '2025-09-07 18:57:14');

--
-- Triggers `payment`
--
DELIMITER $$
CREATE TRIGGER `update_account_balances` AFTER INSERT ON `payment` FOR EACH ROW BEGIN
UPDATE accounts SET balance= balance+new.amount_paid
WHERE id=new.Account_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_price` AFTER INSERT ON `payment` FOR EACH ROW BEGIN

update customer s set s.balance=new.balance 
WHERE s.id=new.customer_id;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_status` AFTER INSERT ON `payment` FOR EACH ROW BEGIN
    IF NEW.balance = 0 THEN
        UPDATE pracel
        SET status_price = 'Paid'
        WHERE cust_id=new.customer_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `date`) VALUES
('METH001', 'EVC', '2025-09-06 21:37:41'),
('METH002', 'BANK', '2025-09-06 21:37:41'),
('METH003', 'E-DAHAB', '2025-09-06 21:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `pracel`
--

CREATE TABLE `pracel` (
  `id` int(22) NOT NULL,
  `TrackingID` int(200) NOT NULL,
  `cust_id` varchar(19) NOT NULL,
  `re_name` varchar(30) NOT NULL,
  `re_address` varchar(30) NOT NULL,
  `re_tell` varchar(30) NOT NULL,
  `departure` varchar(30) NOT NULL,
  `distination` varchar(30) NOT NULL,
  `courior` varchar(33) NOT NULL,
  `weight_Kg` varchar(30) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `status` varchar(40) NOT NULL,
  `price` float(11,2) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `date_created` varchar(30) NOT NULL,
  `status_price` varchar(40) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pracel`
--

INSERT INTO `pracel` (`id`, `TrackingID`, `cust_id`, `re_name`, `re_address`, `re_tell`, `departure`, `distination`, `courior`, `weight_Kg`, `item_name`, `status`, `price`, `user_id`, `date_created`, `status_price`) VALUES
(1, 821085058, 'CUS011', 'Mohamud abdi hassan', 'Hargeysa', '615332635', 'OFF001', '2', 'COU003', '20', 'Electronics', '1', 280.00, 'USR001', '2025-09-07', 'Pending');

--
-- Triggers `pracel`
--
DELIMITER $$
CREATE TRIGGER `Update_balance_customer` AFTER INSERT ON `pracel` FOR EACH ROW BEGIN

UPDATE customer SET balance=		balance+NEW.price WHERE id = new.cust_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_menues`
--

CREATE TABLE `sub_menues` (
  `sub_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `text` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_menues`
--

INSERT INTO `sub_menues` (`sub_id`, `m_id`, `text`, `url`) VALUES
(1, 1, 'User', 'user.php'),
(2, 1, 'User Permission', 'userAuthority.php'),
(3, 1, 'Main menues', 'main_menues.php'),
(4, 1, 'Sub menues', 'sub_menues.php'),
(5, 2, 'Customer', 'customer.php'),
(6, 2, 'Parcel', 'pracel.php'),
(7, 2, 'Track Order Status', 'track.php'),
(9, 3, 'Make Payment', 'payment.php'),
(12, 3, 'Expense', 'expense.php'),
(13, 4, 'Employee', 'employee.php'),
(14, 4, 'Branches', 'office.php'),
(15, 4, 'Job Title', 'jobs.php'),
(16, 5, 'Courier list', 'courior.php'),
(17, 7, 'Parcel Report', 'pracel_rpt.php'),
(18, 7, 'Employee Report', 'employee_rpt.php'),
(19, 3, 'Acounts', 'accounts.php'),
(33, 7, 'Customer Report', 'customer_rpt.php'),
(34, 7, 'Bills Report', 'bills_rpt.php'),
(35, 6, 'Price', 'price1.php'),
(36, 6, 'Area', 'area.php'),
(38, 7, 'Payment Report', 'payment_rpt.php');

-- --------------------------------------------------------

--
-- Stand-in structure for view `system_authority`
-- (See below for the actual view)
--
CREATE TABLE `system_authority` (
`m_id` int(11)
,`category` varchar(100)
,`icon` varchar(100)
,`category_link` varchar(100)
,`sub_id` int(11)
,`link_name` varchar(100)
,`link` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `tblprice`
--

CREATE TABLE `tblprice` (
  `id` varchar(30) NOT NULL,
  `from` varchar(50) NOT NULL,
  `to` varchar(50) NOT NULL,
  `shiptype` varchar(30) NOT NULL,
  `price` float(11,2) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblprice`
--

INSERT INTO `tblprice` (`id`, `from`, `to`, `shiptype`, `price`, `date_created`) VALUES
('PRI001', 'OFF001', '2', 'COU003', 14.00, '2025-09-06 18:37:41'),
('PRI002', 'OFF001', '3', 'COU003', 10.00, '2025-09-06 18:37:41'),
('PRI003', 'OFF001', '4', 'COU003', 13.00, '2025-09-06 18:37:41'),
('PRI004', 'OFF002', '1', 'COU001', 20.00, '2025-09-06 18:37:41'),
('PRI005', 'OFF001', '1', 'COU004', 3.00, '2025-09-06 18:37:41'),
('PRI006', 'OFF005', '1', 'COU001', 3.00, '2025-09-06 18:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `emp_id` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(30) NOT NULL,
  `image` varchar(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `emp_id`, `username`, `password`, `status`, `image`, `date_created`) VALUES
('USR001', 'EMP001', 'admim', '900150983cd24fb0d6963f7d28e17f72', 'Active', 'USR001.png', '2025-05-31 18:52:12'),
('USR002', 'EMP003', 'saadaq', '900150983cd24fb0d6963f7d28e17f72', 'Active', 'USR002.png', '2023-06-18 08:35:44'),
('USR003', 'EMP002', 'mohamed', 'a01610228fe998f515a72dd730294d87', 'Active', 'USR003.png', '2025-08-31 02:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_authority`
--

CREATE TABLE `user_authority` (
  `id` int(11) NOT NULL,
  `user_id` varchar(40) NOT NULL,
  `actions` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_authority`
--

INSERT INTO `user_authority` (`id`, `user_id`, `actions`) VALUES
(152, 'USR001', '3'),
(153, 'USR001', '1'),
(154, 'USR001', '4'),
(155, 'USR001', '2'),
(156, 'USR001', '16'),
(157, 'USR001', '19'),
(158, 'USR001', '11'),
(159, 'USR001', '9'),
(160, 'USR001', '12'),
(161, 'USR001', '10'),
(162, 'USR001', '15'),
(163, 'USR001', '13'),
(164, 'USR001', '14'),
(165, 'USR001', '35'),
(166, 'USR001', '36'),
(167, 'USR001', '34'),
(168, 'USR001', '17'),
(169, 'USR001', '38'),
(170, 'USR001', '33'),
(171, 'USR001', '18'),
(172, 'USR001', '6'),
(173, 'USR001', '7'),
(174, 'USR001', '5'),
(177, 'USR003', '6'),
(178, 'USR003', '7'),
(179, 'USR003', '5');

-- --------------------------------------------------------

--
-- Structure for view `system_authority`
--
DROP TABLE IF EXISTS `system_authority`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `system_authority`  AS SELECT `m`.`m_id` AS `m_id`, `m`.`text` AS `category`, `m`.`icon` AS `icon`, `m`.`url` AS `category_link`, `s`.`sub_id` AS `sub_id`, `s`.`text` AS `link_name`, `s`.`url` AS `link` FROM (`main_menues` `m` left join `sub_menues` `s` on(`m`.`m_id` = `s`.`m_id`)) ORDER BY `m`.`text` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employe_id` (`employe_id`);

--
-- Indexes for table `charge`
--
ALTER TABLE `charge`
  ADD PRIMARY KEY (`charge_id`),
  ADD UNIQUE KEY `employe_id` (`employe_id`,`month_id`,`year`);

--
-- Indexes for table `courior`
--
ALTER TABLE `courior`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Account_id` (`Account_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `main_menues`
--
ALTER TABLE `main_menues`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `Account_id` (`Account_id`),
  ADD KEY `payment_method_id` (`p_method_id`),
  ADD KEY `payment_ibfk_2` (`customer_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pracel`
--
ALTER TABLE `pracel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `TrackingID` (`TrackingID`);

--
-- Indexes for table `sub_menues`
--
ALTER TABLE `sub_menues`
  ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `tblprice`
--
ALTER TABLE `tblprice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_id` (`emp_id`,`username`);

--
-- Indexes for table `user_authority`
--
ALTER TABLE `user_authority`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `charge`
--
ALTER TABLE `charge`
  MODIFY `charge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `main_menues`
--
ALTER TABLE `main_menues`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pracel`
--
ALTER TABLE `pracel`
  MODIFY `id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sub_menues`
--
ALTER TABLE `sub_menues`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_authority`
--
ALTER TABLE `user_authority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
