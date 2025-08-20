# 🌱 NPK Monitoring System with ESP32 & Web Dashboard

This project is an **IoT-based NPK monitoring system** that uses an **ESP32 microcontroller** to read soil nutrient data (Nitrogen, Phosphorus, Potassium, and Moisture) from a sensor, then sends the data to a **PHP-MySQL backend API**.
Users can view, update, and manage the stored data through a simple **Bootstrap + PHP web dashboard**.

---

## 🚀 Features

- 📡 **ESP32 Integration**: Reads NPK + moisture data from sensors.
- 🌐 **API Communication**: Sends readings to a PHP REST-like API for storage.
- 🗄️ **Database Storage**: Data is stored in a MySQL database with timestamp.
- 📊 **Web Dashboard**: Displays sensor readings in a table (sortable, searchable).
- ✏️ **CRUD Support**: View details, edit data, delete entries (with soft-delete).
- 🔔 **Toast Notifications**: Success/error feedback on user actions.

---

## 🛠️ Tech Stack

### Hardware

- **ESP32** microcontroller
- **NPK Sensor** (for Nitrogen, Phosphorus, Potassium)
- **Soil Moisture Sensor**

### Software

- **Firmware**: Arduino/ESP-IDF code running on ESP32
- **Backend**: PHP 8 + MySQL
- **Frontend**: Bootstrap 5 + Vanilla JS + DataTables
- **Database**: MySQL (`sensor_data` table)

---

## ⚙️ Installation & Setup

### 1. Clone the Project

```bash
git clone https://github.com/yourusername/npk-monitoring-system.git
cd npk-monitoring-system
```

### 2. Setup Database

Create MySQL database and table:

```sql
CREATE DATABASE npk_monitoring;
USE npk_monitoring;

-- Table for storing sensor readings
CREATE TABLE sensor_data (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50) NOT NULL,
    pin VARCHAR(20) NOT NULL,
    plot_id VARCHAR(20) NOT NULL,
    nitrogen VARCHAR(10) NOT NULL,
    phosphorus VARCHAR(10) NOT NULL,
    potassium VARCHAR(10) NOT NULL,
    moisture VARCHAR(10) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_deleted TINYINT(1) DEFAULT 0 NOT NULL
);

-- Table for storing user accounts
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(100) NOT NULL,
    gender VARCHAR(100) NOT NULL,
    is_deleted TINYINT(1) DEFAULT 0 NOT NULL,
    INDEX (email)
);
```

### 3. Configure Backend

Edit `connection.php` with your database credentials:

```php
$mysqli = new mysqli("localhost", "username", "password", "npk_monitoring");
```

### 4. Deploy Web Dashboard

- Place `api/` and `web/` folders inside your PHP server root (`htdocs/` if using XAMPP).
- Open `http://localhost/web/index.php` in your browser.

### 5. Setup ESP32

- Update API URL in ESP32 firmware:

  ```cpp
  const char* apiUrl = "http://your-server-ip/api/npk-data-insert.php";
  ```

- Flash firmware to ESP32 via Arduino IDE or PlatformIO.

---

## 🔗 API Endpoints

| Method | Endpoint                         | Description                      |
| ------ | -------------------------------- | -------------------------------- |
| POST   | `/api/npk-data-insert.php`       | Insert new reading from ESP32    |
| GET    | `/api/npk-data-read.php`         | Fetch all stored readings        |
| GET    | `/api/npk-data-details.php?id=1` | Fetch details of a single record |
| POST   | `/api/npk-data-update.php`       | Update a record (by `id`)        |
| POST   | `/api/npk-data-delete.php`       | Soft delete a record             |

---

## 📸 Screenshots (Optional)

- ESP32 device setup
- Web dashboard table view
- Edit modal / delete confirmation

---

## 👨‍💻 Author

**Ralph Maron Eda**
📍 Cagayan State University – College of Engineering and Architecture
