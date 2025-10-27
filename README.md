# 🌐 Translation Management Service (Laravel 10)

A **high-performance, PSR-12 compliant, token-secured Translation Management Service** built with **Laravel 10**.  
It stores, searches, and exports multilingual translations with support for tagging and scalable data handling (100 k+ records).

---

## ⚙️ Features

✅ Token-based authentication (custom middleware)  
✅ Manage translations for unlimited locales (e.g. `en`, `fr`, `es`)  
✅ Tag support (`mobile`, `desktop`, `web`)  
✅ JSON export endpoint for frontend frameworks (Vue, React, etc.)  
✅ Optimized queries (< 200 ms API responses)  
✅ Command to generate 100 k + test records  
✅ Full Unit + Feature + Performance tests  
✅ Docker + CI/CD ( GitHub Actions )

---

## 🧩 Architecture Overview

| Layer | Components |
|--------|-------------|
| Models | `User`, `Language`, `Tag`, `Translation` |
| Controllers | `AuthController`, `LanguageController`, `TagController`, `TranslationController` |
| Middleware | `AuthenticateWithToken` |
| Console | `GenerateTranslations` command |
| Database | MySQL 8 + optimized indexes |
| Tests | Unit, Feature, Performance (Pest/PHPUnit) |
| Deployment | Docker + GitHub Actions CI |

---

## 🚀 Quick Setup

```bash
git clone https://github.com/<your-repo>/translation-service.git
cd translation-service
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan translations:generate 100000
php artisan serve
