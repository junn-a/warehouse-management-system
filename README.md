<!-- ===================== -->
<!--       BADGES         -->
<!-- ===================== -->
![PHP](https://img.shields.io/badge/PHP-7.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Database-336791?style=for-the-badge&logo=postgresql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-3-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-JavaScript-0769AD?style=for-the-badge&logo=jquery&logoColor=white)
![Barcode](https://img.shields.io/badge/Feature-Barcode%20Scanning-green?style=for-the-badge)
![Printer](https://img.shields.io/badge/Thermal_Printer-ECO_POS-black?style=for-the-badge)
![License](https://img.shields.io/badge/License-Open_Source-success?style=for-the-badge)

---

# 📦 Warehouse Management System (WMS)

A **web-based Warehouse Management System (WMS)** designed for **pallet-based storage**, **barcode tracking**, **smart location assignment**, and **warehouse transfer operations**.  
Built with **PHP 7, PostgreSQL, Bootstrap 3, jQuery**, and integrated with **thermal printers** for real-time label printing.

---

## 📌 Overview

This application helps warehouses manage **finished goods stored on pallets** with high accuracy and traceability.  
It covers the complete warehouse flow from **inbound storage**, **location assignment**, **barcode validation**, **transfer planning**, to **logistics handover**.

The system is suitable for **small to medium-scale warehouses** and can be extended to support **FIFO, FEFO, and multi-warehouse strategies**.

---

## 🚀 Key Features

### ✅ Master Data Management (CRUD)
- Product Master (SKU, name, category)
- Location Master (Zone, Rack, Level, Bin)
- Pallet Master
- Destination / Logistics Master
- User & Role Management

---

### 📥 Inbound & Storage
- Finished goods stored **by pallet**
- Automatic **storage location assignment** (special feature)
- Unique **barcode per pallet**
- Barcode label printed via **thermal printer (ECO POS)**
- Labels attached to pallet carton stacks
- Loader stores pallets based on assigned locations

---

### 🔁 Transfer & Outbound
- Automatic **transfer document number**
- Transfer created based on selected SKUs
- System generates **picking plan**
- Barcode validation during picking
- Pallets transferred to logistics / outbound area
- Full transfer history tracking

---

### 📊 Reporting
- Stock by SKU
- Stock by Location
- Pallet movement history
- Transfer transaction reports
- Export to CSV / Excel

---

## 🖨️ Thermal Printer Integration
- Integrated with **ECO POS Thermal Printer**
- Print pallet labels and barcode information
- Customizable label format
- Direct printing from web application

---

## 🛠️ Technology Stack

| Layer | Technology |
|-----|-----------|
| Frontend | HTML5, Bootstrap 3 |
| Scripting | JavaScript, jQuery |
| Backend | PHP 7 |
| Database | PostgreSQL |
| Hardware | Barcode Scanner, Thermal Printer (ECO POS) |

---

## 🗂️ Project Structure

```text
warehouse-management-system/
├── assets/
│   ├── css/
│   ├── js/
│   ├── bootstrap/
│   └── images/
├── config/
│   └── database.php
├── modules/
│   ├── master/
│   ├── transaction/
│   └── report/
├── barcode/
│   └── scanner.js
├── print/
│   └── label_template.php
├── auth/
│   ├── login.php
│   └── logout.php
├── api/
│   └── v1/
├── database.sql
├── index.php
└── README.md
