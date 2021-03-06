DROP database IF EXISTS carrental;
CREATE database carrental CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE carrental;

CREATE TABLE customers(
  personnumber BIGINT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  address VARCHAR(255) NOT NULL,
  postaladdress VARCHAR(255) NOT NULL,
  phonenumber VARCHAR(10) NOT NULL
) ENGINE=InnoDb;

CREATE TABLE cars(
  registration CHAR(6) PRIMARY KEY,
  make VARCHAR(100) NOT NULL,
  color VARCHAR(20) NOT NULL,
  year INT NOT NULL,
  price INT NOT NULL
) ENGINE=InnoDb;

CREATE TABLE rentals(
  id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  registration CHAR(6),
  personnumber BIGINT,
  checkouttime DATETIME NOT NULL,
  checkintime DATETIME,
  days INT,
  cost FLOAT,
  FOREIGN KEY (registration) REFERENCES cars(registration),
  FOREIGN KEY (personnumber) REFERENCES customers(personnumber)
) ENGINE=InnoDb;

CREATE TABLE makes(
  make VARCHAR(100) NOT NULL
) ENGINE=InnoDb;

CREATE TABLE colors(
  color VARCHAR(100) NOT NULL
) ENGINE=InnoDb;

INSERT INTO customers (personnumber, name, address, postaladdress, phonenumber) VALUES
  (199309230465, "Lisa Andersson", "Storgatan 2", "45656 Småstad", "0775343455"),
  (197002101207, "Mohammad Rezai", "Stackvägen 12", "75646 Uppsala", "0708118825"),
  (197804282338, "Ali Boraoui", "Hässjevägen 3", "75647 Uppsala", "0722345678"),
  (198807280030, "Petri Lejerdahl", "August Södermans väg 9", "75645 Uppsala", "0725999988"),
  (194604279796, "Mona Karlsson", "Stenbrohultsvägen 107", "75754 Uppsala", "0737882211"),
  (195704143295, "Mario Garcia", "Valhallavägen 52", "11414 Stockholm", "0722994450"),
  (197405314563, "Lovisa Larsson", "Glimmerstigen 11", "45776 Granitbyn", "0711959545"),
  (196302254344, "Helena Janols", "Drottninggatan 20", "86040 Sundsvall", "0703454545"),
  (197302271452, "Stefan Åhlander", "Lapplandsresan 25 B", "75755 Uppsala", "0704979766"),
  (198007271482, "Maria Erlandsson", "Lapplandsresan 25 B", "75755 Uppsala", "0725100580");

INSERT INTO cars (registration, make, color, year, price) VALUES
  ("LST364", "Volvo", "Blue", 2019, 700),
  ("PDG675", "Audi", "Blue", 2016, 500),
  ("LMS009", "Volvo", "White", 2012, 300),
  ("KUL456", "Mercedes", "Green", 2018, 700),
  ("ABC123", "Hyundai", "White", 2015, 350),
  ("SAS022", "BMW", "Blue", 2019, 800),
  ("NKM342", "Volvo", "Black", 2015, 400),
  ("PDF110", "Hyundai", "Yellow", 2017, 450),
  ("LSW364", "Toyota", "Gray", 2012, 300),
  ("DOL990", "Toyota", "Red", 2011, 200);

INSERT INTO makes (make) VALUES
  ("Peugeot"),
  ("Suzuki"),
  ("Fiat"),
  ("Honda"),
  ("Ford"),
  ("Hyundai"),
  ("Renault"),
  ("Toyota"),
  ("Volkswagen"),
  ("Chrystler"),
  ("Volvo"),
  ("Audi"),
  ("BMW"),
  ("Mercedes");

  INSERT INTO colors (color) VALUES
    ("Blue"),
    ("Red"),
    ("Green"),
    ("Yellow"),
    ("Black"),
    ("White"),
    ("Magenta"),
    ("Gray"),
    ("Brown");