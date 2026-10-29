# 🐑 Kashmir Sheeps: Full-Stack Livestock & HADP Digital Ecosystem
### *Integrated Laravel 13 Backend, SQLite Database, HADP Schemes Hub & SKUAST-K Scientific Platform*

> **Kashmir's Premier Direct Farmer-to-Buyer Livestock Marketplace, HADP J&K Subsidies Hub & Scientific Sheep Management Platform.**  
> Zero middleman (*dalal*) commissions • 50% HADP Capital Subsidies • 12-Digit INAPH Ear Tag Passports • Alpine Pasture Migration Tracking • SKUAST-K Clinical Diagnostic Assistant & 1962 Helpline • Doorstep Delivery across all J&K districts.

🌐 **Live GitHub Pages Frontend:** [https://sadiqk2.github.io/kashmir-sheeps/](https://sadiqk2.github.io/kashmir-sheeps/)  
⚙️ **Backend:** Full-Stack Laravel 13 (PHP 8.4) with SQLite & REST API architecture

---

## 🏗️ Full-Stack Laravel Architecture

The application has been upgraded into a production-ready, full-stack Laravel platform featuring:
- **Framework:** Laravel 13 with PHP 8.4
- **Database Engine:** SQLite (`database/database.sqlite`) with automated migrations & seeders
- **API Architecture:** RESTful JSON APIs (`/api/livestock`, `/api/orders`, `/api/hadp`, `/api/inaph`, `/api/clinical`, `/api/wool-lab`, `/api/bahak-transit`)
- **Frontend Layer:** Dual-mode interactive client (`resources/views/app.blade.php` and `public/index.html`) supporting both live Laravel API calls and offline/static fallback to `StorageService` (`localStorage`)
- **Automated Test Suite:** 26 automated Feature tests with 183 assertions passing via PHPUnit (`php artisan test`)

---

## 🏛️ Flagship HADP & Scientific Modules

Aligned with the Government of Jammu & Kashmir's flagship **HADP initiative** (Agriculture Production Department & Sheep Husbandry Department) and **SKUAST-Kashmir**:

### 1. 🐑 Project 24: Self-Sufficiency in Mutton Production in J&K
* **Commercial Sheep/Goat Farms (50-Ewe Units):** 50% DBT Capital Subsidy (₹2,50,000 government grant) for educated rural youth, women SHGs, and progressive pastoralists.
* **5-Stage Workflow Pipeline:** Applications track from KKG Intake ➔ Tehsil VAS Scrutiny ➔ DSHO Physical Inspection ➔ District Committee Sanction ➔ 50% DBT PFMS Bank Disbursement.
* **Printable Pre-Sanction Certificate:** Official certificate complete with Govt of J&K seal, reference numbers, and DSHO digital authorization.

### 2. 🔬 Project 27: Promotion of Wool/Pelt Processing & Marketing
* **Mechanical Shearing Modernization:** 50% subsidy on professional 6-speed electric shearing clipper kits.
* **Wool Quality Laboratory Analyzer:** Interactive laboratory tool testing fiber micron (µ), staple length (cm), Clean Fleece Yield (CFY%), and Greasy Fleece Weight (GFW) to determine official HADP Minimum Support Price (MSP) + clean yield quality bonus.

### 3. 📋 INAPH 12-Digit Ear-Tag Digital Passport Registry
* **RFID Biometric Passports:** 12-digit ear tag tracking (134.2 kHz FDX-B ISO 11784/11785) with genotype, sire/dam pedigree, age/teeth status, and full vaccination records (Enterotoxaemia, Sheep Pox, PPR, FMD).
* **Field Registration:** Enables field officers and progressive breeders to register newly tagged stock into the central database.

### 4. 🩺 SKUAST-K Clinical Diagnostic Symptom Checker & Emergency 1962 Helpline
* **Multi-Symptom Triage Engine:** Diagnoses Enterotoxaemia (ETV), Sheep Pox (*Kari*), Fascioliasis (*Liver Fluke / Rok*), *Chillai Kalan* Lamb Hypothermia/Pneumonia, and Contagious Foot Rot.
* **Weight-Based Drug Dosage Calculator:** Enter live animal weight in kg to calculate exact ml/mg dosages for Fenbendazole 10%, Oxyclozanide 3.4%, Oxytetracycline 200mg/ml L.A., and Meloxicam with withdrawal warnings.
* **One-Touch Ambulance Call:** Direct link to `tel:1962` for J&K Mobile Veterinary Clinic Ambulances.

### 5. 🏔️ Alpine Pasture (*Bahak*) Transhumance Migration Tracker
* **Corridor Tracking:** Live statuses for Peer Ki Gali / Mughal Road, Sonamarg - Minamarg, Tosamaidan Highland, Gurez - Tulail Pass, and Sinthan Top.
* **Pastoral Transit Logger:** Logs Chopan IDs, migrating flock counts (ewes, rams, lambs), dipping certificates, and checkpost clearances.

### 6. 📦 Orders & Official Tax Invoices
* **Flexible Payments:** Cash on Delivery (COD), Instant UPI (with simulated dynamic QR), and Kisan Credit Card (KCC) Livestock Vouchers.
* **Printable Tax Invoices:** J&K Sheep Husbandry e-Mandi formatted invoices with item breakdown, INAPH tag numbers, 0% agricultural GST exemption, transport carrier vehicle details, and digital seal.

---

## 🔌 API Endpoints Reference

| Method | Endpoint | Description |
|---|---|---|
| `GET` | `/api/livestock` | List all catalog sheep & farm products (supports filters by category, district, search, qurbani, sort) |
| `POST` | `/api/livestock` | Post new livestock / farm product listing |
| `GET` | `/api/livestock/{id}` | Get single listing with INAPH passport |
| `PUT` | `/api/livestock/{id}` | Update listing price, weight, sold status |
| `DELETE` | `/api/livestock/{id}` | Delete listing |
| `GET` | `/api/orders` | List user orders with line items |
| `POST` | `/api/orders` | Place new order, deduct live stock, setup delivery tracking |
| `GET` | `/api/orders/{orderNo}` | Get order details & invoice data |
| `POST` | `/api/orders/{orderNo}/cancel` | Cancel order & restore live animal stock |
| `POST` | `/api/orders/{orderNo}/advance-tracking` | Advance tracking milestone (Confirmed ➔ Cleared ➔ In Transit ➔ Delivered) |
| `GET` | `/api/hadp` | List submitted HADP DBT subsidy applications |
| `POST` | `/api/hadp` | Submit new Kisan Khidmat Ghar (KKG) application |
| `GET` | `/api/hadp/{refNo}` | Get HADP application details & status |
| `POST` | `/api/hadp/{refNo}/advance-stage` | Advance 5-stage workflow pipeline |
| `GET` | `/api/inaph` | List all registered 12-digit RFID livestock passports |
| `POST` | `/api/inaph` | Register new INAPH 12-digit ear tag |
| `GET` | `/api/inaph/{tagNo}` | Lookup animal biometric passport by 12-digit tag |
| `POST` | `/api/clinical/diagnose` | Run SKUAST-K symptom assessment & triage protocol |
| `POST` | `/api/clinical/dosage` | Calculate live weight-based veterinary drug dosages |
| `GET` | `/api/wool-lab` | List past wool testing certificates |
| `POST` | `/api/wool-lab/analyze` | Run HADP Project 27 wool grading, MSP & bonus calculation |
| `GET` | `/api/bahak-transit` | List pastoral transhumance migration permits |
| `POST` | `/api/bahak-transit` | Log new flock migration permit crossing |

---

## 🚀 Local Development Setup

### 1. Requirements
* PHP 8.2 or higher (PHP 8.4 recommended) with `pdo_sqlite`, `curl`, `mbstring`, `fileinfo` extensions
* Composer 2.x
* Node.js & npm (optional for Vite)

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/sadiqk2/kashmir-sheeps.git
cd kashmir-sheeps

# Install Composer dependencies
composer install

# Setup environment & application key
cp .env.example .env
php artisan key:generate

# Run database migrations and seed authentic Kashmir livestock & HADP data
php artisan migrate --seed

# Start the Laravel development server
php artisan serve
```
Open [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser.

---

## 🧪 Automated Testing Suite

Run the full automated test suite containing 26 Feature tests across all modules:
```bash
php artisan test --testdox
```

### Test Coverage Highlights:
* `LivestockApiTest`: Catalog filtering, farmer ad posting, stock mutation, deletion.
* `OrderApiTest`: Checkout order generation, free delivery calculation threshold (₹1,499), live animal stock marking, order cancellation and inventory restoration, delivery tracking milestones.
* `HadpApplicationApiTest`: Project 24 & 27 50% DBT subsidy cap logic, 5-stage workflow pipeline progression.
* `InaphPassportApiTest`: 12-digit RFID ear tag registry lookup, new tag registration, 404 validation.
* `ClinicalDiagnosisApiTest`: SKUAST-K triage matching for ETV, Sheep Pox, Liver Fluke, Pneumonia, and weight-based dosage formulas.
* `WoolLabApiTest`: HADP Project 27 wool micron grading classification, clean fleece yield payout formulas.
* `BahakTransitApiTest`: Pastoral transhumance transit permits and checkpost dipping certification.

---

## 📄 License & Attribution
* Developed under the technical guidance of **SKUAST-Kashmir** and the **Department of Sheep Husbandry, Government of Jammu & Kashmir**.
* Open source under the MIT License.
