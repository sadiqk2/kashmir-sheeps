# 🐑 Kashmir Sheeps: Full-Stack Livestock, Manure & Wool Marketplace
### *Production-Grade Laravel 13, Domain-Driven Design (DDD), RESTful API v1 & Scientific Pastoral Platform*

> **Kashmir's Premier Direct Shepherd-to-Buyer Livestock, Organic Orchard Manure & Pure Merino Wool Marketplace.**  
> Zero middleman (*dalal*) commissions • Live Sheep Mandi • Tractor Loads & Screened Bags of Aged Manure • Pure Raw Fleece & Hand-Spun Yarn • 12-Digit INAPH Ear Tag Health Passports • Alpine Pasture Migration Tracking • SKUAST-K Clinical Diagnostic Assistant & 1962 Emergency Vet Helpline • Doorstep Delivery across all 10 Kashmir districts.

🌐 **Live GitHub Pages Frontend:** [https://sadiqk2.github.io/kashmir-sheeps/](https://sadiqk2.github.io/kashmir-sheeps/)  
⚙️ **Backend:** Full-Stack Laravel 13 (PHP 8.4) with SQLite, Domain-Driven Design & REST API v1 Architecture

---

## 🏗️ Domain-Driven Design (DDD) Architecture

The backend is structured into five bounded contexts under `app/Domain/`:

```
app/Domain/
├── Livestock/          # Stud rams, ewes, orchard manure, shearing equipment
│   ├── Actions/        # CreateListingAction, FilterLivestockAction...
│   ├── DTOs/           # ListingData
│   ├── Repositories/   # LivestockListingRepositoryInterface, EloquentLivestockListingRepository
│   └── ValueObjects/   # Money (with ₹ formatting & calculation)
├── Ordering/           # Orders, stock reservation, multi-stage delivery tracking
│   ├── Actions/        # PlaceOrderAction (with stock auto-sold locking), CancelOrderAction
│   ├── DTOs/           # OrderData, OrderItemData
│   ├── Repositories/   # OrderRepositoryInterface, EloquentOrderRepository
│   └── ValueObjects/   # OrderStatus
├── Identity/           # Accounts, authentication, verified buyer/breeder roles
│   ├── Actions/        # RegisterUserAction, AuthenticateUserAction
│   ├── DTOs/           # RegisterUserData
│   └── Repositories/   # UserRepositoryInterface, EloquentUserRepository
├── Veterinary/         # INAPH 12-digit RFID tags, e-health cards, SKUAST-K diagnostic engine
│   ├── Actions/        # RegisterInaphTagAction, SearchInaphTagAction, DiagnoseSymptomsAction...
│   ├── DTOs/           # InaphPassportData
│   └── Repositories/   # InaphPassportRepositoryInterface, EloquentInaphPassportRepository
└── Pastoral/           # Wool micron testing (SKUAST Lab), Bahak migratory passes
    ├── Actions/        # AnalyzeWoolAction, RegisterTransitPermitAction
    ├── DTOs/           # WoolLabData, BahakTransitData
    └── Repositories/   # WoolLabRepositoryInterface, BahakTransitRepositoryInterface
```

---

## 🌟 Marketplace Pillars

### 1. 🐑 Live Sheep Mandi (Breeding Studs & Qurbani Stock)
- **Kashmir Merino Stud Rams:** Verified 2 teeth (*Doda*) & 4 teeth with 19–21 micron superfine fleece pedigree.
- **Pir Panjal Bakarwali Mountain Breed:** Highland grazing-adapted, high-vitality rams.
- **Sharia-Compliant Qurbani Rams:** Pre-screened defect-free with doorstep delivery vehicle coordination.
- **Live Mandi Benchmark Chip:** Displays live ₹/Kg live weight benchmark (e.g. `~₹410/Kg`) on cards so buyers instantly verify fair pricing.

### 2. 🌱 Organic Apple Orchard Manure (کھاد)
- **Biological Winter Warmth:** Sheep manure has 3x higher nitrogen-potassium content than cattle dung, providing essential rootzone warmth during sub-zero *Chillai Kalan* (-8°C).
- **Multiple Batch Sizes:**
  - *Tractor Trolley Loads (500–600 Kg)* with hydraulic orchard bed unloading.
  - *50 Kg Heavy-Duty Screened Bags* of dry, odourless pellets for targeted trenching.
  - *Bulk Commercial Tipper Loads (2.5 Metric Tons)* directly from highland night folding camps.
- **Interactive Orchard Manure Calculator:** Calculates exact trolleys or bags needed based on orchard acreage (kanals) and tree density (Traditional Delicious vs High-Density M9).

### 3. 🧶 Pure Kashmir Merino Raw Wool & Hand-Spun Yarn (خام اون)
- **Raw Fleece Braids:** Hand-sheared and skirted pure Kashmir Merino fleece (19–21 micron).
- **Bulk Bales (25 Kg):** Clean white spring clip wool for local spinning mills and tweed weavers.
- **Traditional Charkha Hand-Spun Yarn (1 Kg Hank / Latti):** Spun by Kashmiri artisan women on traditional wooden charkhas, ready for warm hand-knitted Pherans and shawls.
- **Wool Quality & Market Payout Estimator:** Computes clean yield percentage and expected payout based on micron diameter.

### 4. 👤 User Accounts & Role-Based Verification
- **Verified Roles:**
  - 🛍️ *Verified Buyer / Consumer*
  - 🐑 *Registered Livestock Breeder & Seller*
  - 🏛️ *Pastoralist & Sheep Farmer*
  - 🩺 *Veterinary Assistant Surgeon (VAS)*
- **Laravel Sanctum Authentication:** Token-based API login and profile management (`/api/v1/auth/...`).
- **Auto-Fill Experience:** Automatically pre-fills checkout delivery and seller ad forms for signed-in users.

---

## 📡 RESTful API Reference (`/api/v1/...`)

| Method | Endpoint | Description |
|---|---|---|
| `GET / POST` | `/api/v1/livestock` | List filtered livestock, manure, wool, or create new listing |
| `GET / PUT / DELETE` | `/api/v1/livestock/{id}` | Retrieve, update, or soft-delete listing |
| `GET / POST` | `/api/v1/orders` | View order history or place order with stock reservation |
| `GET / POST` | `/api/v1/orders/{orderNo}/cancel` | Cancel order and release reserved stock |
| `POST` | `/api/v1/auth/register` | Register new account (Buyer, Breeder, Farmer, VAS) |
| `POST` | `/api/v1/auth/login` | Authenticate and obtain Sanctum bearer token |
| `GET` | `/api/v1/auth/me` | Fetch authenticated user profile |
| `GET` | `/api/v1/auth/roles` | List available marketplace roles and permissions |
| `GET` | `/api/v1/users/sellers` | Retrieve list of verified breeders and manure suppliers |
| `GET / POST` | `/api/v1/inaph` | Search or register 12-digit RFID e-Health passports |
| `POST` | `/api/v1/clinical/diagnose` | SKUAST-K multi-symptom differential diagnosis |
| `POST` | `/api/v1/clinical/dosage` | Weight-based veterinary drug dosage calculator |
| `GET / POST` | `/api/v1/wool-lab` | Submit fleece sample for micron & clean yield grading |
| `GET / POST` | `/api/v1/bahak-transit` | Issue digital migratory transit permit for seasonal pastures |

---

## 🧪 Automated Test Suite

Run the full PHPUnit test suite:

```bash
php artisan test
```

```
PASS  Tests\Feature\Api\V1\AuthApiTest
PASS  Tests\Feature\Api\V1\RestApiV1Test
PASS  Tests\Feature\LivestockApiTest
PASS  Tests\Feature\OrderApiTest
PASS  Tests\Feature\InaphPassportApiTest
PASS  Tests\Feature\ClinicalDiagnosisApiTest
PASS  Tests\Feature\WoolLabApiTest
PASS  Tests\Feature\BahakTransitApiTest

Tests:    36 passed (303 assertions)
Duration: ~2.4 seconds
```

---

## 🚀 Running Locally

```bash
# 1. Install Composer dependencies
composer install

# 2. Run database migrations & seed authentic Kashmir data
php artisan migrate:fresh --seed

# 3. Start local development server
php artisan serve --port=8000
```

Open your browser at **`http://127.0.0.1:8000`**.
