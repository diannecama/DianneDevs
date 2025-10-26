# Safe Evacuation & Shelter System

Isang "Windy-style" na evacuation at shelter management system na puwedeng gumana offline para makatulong sa mabilis na pagresponde sa sakuna.

## 🧭 Ano ang ginagawa ng system na ito

- **Nagpapakita ng mapa** na may mga lokasyon ng shelter, kasama ang status/capacity color coding
- **Kaya magtrabaho offline** gamit ang naka-cache na data (localStorage at cached map tiles)
- **Nakaka-sync** kapag may internet para sa pinakabagong shelter status at emergency alerts
- **May geolocation** para hanapin ang pinakamalapit na shelter mula sa kasalukuyang lokasyon ng user
- **May capacity tracking** para maiwasan ang over-capacity sa mga shelter

## 🏗️ High-level Architecture

- **Client (Browser)**: UI (Bootstrap), mapa (Leaflet), geolocation, offline cache (localStorage)
- **API (PHP sa `api/`)**: Nagbibigay at tumatanggap ng data mula/para sa MySQL
- **Database (MySQL/MariaDB)**: Nagsa-store ng shelters, routes, alerts, settings, at logs
- **Utility (`reset_db.php`)**: Pang-reset at pang-seed ng sample data para mabilis mag-setup

## 🚀 Pangunahing Features

- **Interactive Map**: Dark-themed map + capacity indicators (Green/Yellow/Red)
- **Offline-first**: Gagana kahit mawalan ng internet (gamit ang naka-cache na data at tiles)
- **Real-time-ish Sync**: Kapag online, kinukuha ang latest na data mula sa API
- **Geolocation**: Hanapin ang pinakamalapit na shelters batay sa iyong lokasyon
- **Emergency Alerts**: Makakakuha at makakakita ng mga alerto mula sa server

## 📋 Requirements

- PHP 7.4+
- MySQL 5.7+ o MariaDB 10.2+
- Web server (Apache/Nginx). Sa Windows, puwede ang XAMPP/WAMP
- Modern browser na may geolocation support

## 🛠️ Installation / Setup

1. I-clone o i-download ang project sa web server directory mo (hal. `C:\xampp\htdocs\PERSONALTemp`)
2. I-start ang web server (Apache + MySQL sa XAMPP/WAMP)
3. I-run ang database reset/seed script para awtomatikong gumawa ng DB at sample data:
   ```
   http://localhost/PERSONALTemp/reset_db.php
   ```
4. I-access ang system:
   ```
   http://localhost/PERSONALTemp/
   ```

Kung may error, tingnan ang "Troubleshooting" sa ibaba.

## 🗄️ Database Overview

Ginagamit ang database na `evacuation_system` at mga sumusunod na pangunahing tables:

- `shelters` — impormasyon ng shelter (pangalan, lokasyon, kapasidad, at kasalukuyang occupancy)
- `routes` — mga ligtas na ruta para sa evacuation
- `emergency_alerts` — mga alerto/abiso tungkol sa sakuna
- `user_sessions` — simpleng pag-track ng user interactions para sa analytics
- `ml_analysis_logs` — logs para sa analysis/insights
- `system_settings` — mga config tulad ng refresh intervals o feature flags

> Tandaan: Ang eksaktong schema ay awtomatikong nire-reset ng `reset_db.php` para magkaroon ng working sample data.

## 🔌 API Overview

- `api/shelters.php`
  - GET: Kunin ang listahan ng shelters at status/capacity
  - (Optional) POST/PUT: I-update ang capacity/occupancy kapag may pagbabago mula sa ops team
- Posibleng iba pang endpoints (depende sa build):
  - `api/alerts.php` — kunin ang active emergency alerts
  - `api/routes.php` — kunin ang mga ruta
  - `api/settings.php` — kunin ang system settings

> Note: Ang eksaktong endpoints ay maaaring mag-iba depende sa implementation. Ang core endpoint na kailangan ng UI ay `api/shelters.php`.

## ⚙️ Configuration

I-edit ang DB credentials sa `api/shelters.php` kung kinakailangan:
```php
$host = 'localhost';
$dbname = 'evacuation_system';
$username = 'root';
$password = '';
```

Siguraduhing tumatakbo ang MySQL at may user na may tamang permissions.

## 🎯 Paano Gamitin (User Flow)

1. Buksan ang app at payagan ang geolocation kapag ni-request
2. Tingnan sa mapa ang mga shelter at ang kulay ng indicator:
   - 🟢 Green = High capacity shelter
   - 🟡 Yellow = Low capacity shelter
3. I-click ang "Download Offline Data" para ma-cache ang data at map tiles
4. Kapag online ka ulit, automatic na mag-a-update (auto-sync) ang data

## 📱 Offline Capabilities

- **Local Storage**: Naka-store ang huling nakuha na shelter/alerts data para magamit offline
- **Offline Maps**: Gumagamit ng cached map tiles kung available
- **Auto-sync**: Kapag nag-online, tatawag sa API para sa pinakabagong data
- **Status Indicator**: May UI state kung online/offline

## 🎨 UI/Theme

- Dark theme base colors:
  - Primary: `#121212`
  - Secondary: `#DADADA`
  - Accent: `#FFFFFF`
- Frameworks/Libraries: Bootstrap (UI), Leaflet (map), vanilla JS

## 🔄 Pag-reset ng Database

Kung gusto mong bumalik sa fresh sample data:
```
http://localhost/PERSONALTemp/reset_db.php
```

## 📂 Folder Structure (high-level)

- `api/` — PHP endpoints (hal. `shelters.php`)
- `reset_db.php` — utility para gumawa ng DB at seed data
- `assets/` o `public/` — static files (images, css, js) kung meron
- Root HTML/PHP/JS files — UI at app logic

## 🔐 Security at Data Integrity (basics)

- Gumamit ng prepared statements sa PHP para iwas SQL injection
- I-validate ang lahat ng input sa server bago i-process
- Limitahan ang write endpoints (POST/PUT) sa authenticated/authorized users lamang kung i-e-expose sa internet
- Huwag maglagay ng secrets sa client; panatilihin sa server-side config

## 🧪 Testing / Verification Quick Checks

- Buksan ang `reset_db.php` at tingnan kung walang error sa browser
- I-load ang home page at i-check ang console kung may API/network errors
- I-toggle ang internet (offline mode) at i-reload para i-verify ang cached data
- Gumamit ng ibang browser tab para makita kung nagre-refresh ang data kapag online

## 🛠️ Troubleshooting

- Walang laman ang mapa o listahan:
  - I-verify kung tumatakbo ang MySQL at tama ang DB credentials sa `api/shelters.php`
  - I-run muli ang `reset_db.php`
- Geolocation hindi gumagana:
  - Siguraduhing naka-allow ang location sa browser at device
- Offline ay hindi nagwo-work:
  - I-check kung na-trigger ang caching (clear cache, re-download offline data)
- 500/404 errors sa API:
  - Buksan ang browser devtools Network tab at i-check ang response
  - Tingnan ang Apache/PHP error logs

## 🤖 Random Forest: Paano ito nagta-train sa system

- **Saan makikita ang algorithm**:
  - `js/random-forest.js` — implementasyon ng Random Forest (pagtayo ng maraming decision trees, feature importance, at evaluation)
  - `js/ml-training-system.js` — data prep, split (train/test), pagtawag sa `RandomForest.train`, pag-save at pag-load ng model

- **Core training flow**:
  1. Ihanda ang `trainingData` at `featureNames` sa `MLTrainingSystem`
  2. Gumawa ng modelo: `new RandomForest(nTrees, maxDepth, minSamplesSplit, minSamplesLeaf)`
  3. `randomForest.train(trainingData, featureNames)`
  4. `randomForest.evaluate(testData)` at i-save ang results
  5. `randomForest.saveModel()` para ma-reuse

- **Paano patakbuhin**:
  - Demo UI: buksan ang `ml-dashboard.html` nang direkta para mag-train at tingnan ang metrics
  - Programmatic: i-include ang `js/random-forest.js` at `js/ml-training-system.js`, ihanda ang data, at tawagin ang `trainModel()`

## 📥 Dataset Import: Paano mag-import at bakit minsan ‘di nase-save

- **Importer**: `import_dataset.php` (tumatanggap ng `.xlsx`, `.xls`, `.csv`)
- Kailangan ang PhpSpreadsheet para sa Excel: `composer require phpoffice/phpspreadsheet`
- Required columns (ayon sa importer): Barangay, Owner Name, Capacity, Typhoon Zone, Flood Zone, Landslide Zone, Storm Surge Zone, Elevation, Latitude, Longitude, Building Material Type, Building Condition, Water Supply, Electricity, Road Condition, Estimated Travel Time, Near Main Road, Is Safe Shelter

- Steps:
  1. I-prepare ang file (tamang columns at order)
  2. Buksan: `http://localhost/PERSONALTemp/import_dataset.php`
  3. I-upload at i-submit, tingnan ang summary

- Common issues at fixes:
  - Missing PhpSpreadsheet → install via Composer
  - Mali ang columns/order → ayusin ayon sa README/importer
  - DB credentials/schema → i-check `app/Db.php` at i-run `reset_db.php` kung kailangan
  - PHP upload limits → itaas `upload_max_filesize` at `post_max_size`
  - CSV delimiter/encoding → standard CSV (comma, UTF-8, may header)

## ☎️ Emergency Hotline

- May button sa control panel papunta sa `hotline.html` para sa national at sample LGU contacts

## 🧩 Modules at Paano Gumagana ang Bawat Isa

1) Map & Layers — `index.php`, `js/evacuation-system.js`
   - Naglo-load ng markers mula API/cache at nagdi-display ng routes at popups

2) Control Panel — `index.php`
   - Get/Load location, Refresh multi-device, Download Offline Data, Sync, Clear Routes, Flood toggle, Emergency Hotline

3) Geolocation & Saved Location — `js/evacuation-system.js`
   - Kumuha at mag-save ng kasalukuyang lokasyon (localStorage), may UI indicators

4) Offline & Sync — `js/evacuation-system.js`
   - I-cache ang data at mag-auto-sync kapag online

5) Shelters API & Data — `api/shelters.php`, DB `shelters`
   - GET shelters; UI renders markers at “Nearest Shelters” list

6) Search to Barangay (Direct Zoom)
   - Kapag nag-search, automatic na mag-zoom/pan sa unang match o exact match at bubuksan ang info popup

7) Routing — `js/evacuation-system.js`
   - Show/clear/reverse route, distance/duration details

8) Flood Mode — `js/evacuation-system.js`
   - Toggle para sa flood-related visualization/logic

9) Dataset Import / Reset DB — `import_dataset.php`, `reset_db.php`
   - Bulk load ng data at mabilis na pag-setup ng sample data

10) Settings / Logs — `system_settings`, `user_sessions`, `ml_analysis_logs`
   - Config at analytics/audit tables

11) ML Components (Reference) — `js/random-forest.js`, `js/ml-training-system.js`, `ml-dashboard.html`
   - Algorithm at training flow para sa demonstration/reference

## 📞 Support

Kung may issues, tingnan ang browser console at siguraduhing:
- Tumatakbo ang MySQL server
- Tama ang database credentials
- May permissions ang web server