# ĶepuDraugs.lv — projekta palaišanas instrukcija

Šajā instrukcijā aprakstīts, kā lejupielādēt, konfigurēt un palaist ĶepuDraugs.lv projektu Windows datorā, izmantojot Laragon.

## 1. Nepieciešamās programmas

Pirms projekta lejupielādes datorā jābūt instalētām šādām programmām:

- **Laragon** — PHP un MySQL servera darbināšanai.
- **Git** — projekta lejupielādei no GitHub.
- **Composer** — projekta PHP atkarību instalēšanai.

Laragon vidē jābūt pieejamai ar Laravel 13 saderīgai PHP versijai (PHP 8.3 vai jaunākai).

## 2. Projekta lejupielāde

1. Atveriet **Laragon**.
2. Nospiediet **Start All**, lai palaistu nepieciešamos servisus.
3. Atveriet **Laragon Terminal**.
4. Izpildiet tālāk norādītās komandas.

Pārejiet uz Laragon projektu mapi:

```cmd
cd C:\laragon\www
```

Lejupielādējiet projektu no GitHub:

```cmd
git clone https://github.com/rodzerz/project-kepudraugs.git
```

Pārejiet uz projekta mapi:

```cmd
cd project-kepudraugs
```

## 3. Projekta atkarību instalēšana

Terminālī izpildiet:

```cmd
composer install
```

Sagaidiet, līdz instalēšana ir pabeigta.

## 4. Laravel konfigurācijas faila izveide

Izveidojiet `.env` failu:

```cmd
copy .env.example .env
```

Atveriet projekta mapē izveidoto `.env` failu ar teksta redaktoru.

Atrodiet un iestatiet šādus parametrus:

```env
APP_NAME="ĶepuDraugs.lv"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

**APP_KEY vērtību nekopējiet no cita datora.** Katram instalētajam projektam jāģenerē sava lietotnes atslēga.

Saglabājiet `.env` failu un terminālī izpildiet:

```cmd
php artisan key:generate
```

Laravel automātiski izveidos `APP_KEY` vērtību.

## 5. MySQL datubāzes izveide

1. Pārliecinieties, ka Laragon ir palaists **MySQL** serviss.
2. Atveriet **HeidiSQL** vai citu MySQL datubāzu pārvaldības programmu.
3. Pieslēdzieties lokālajam MySQL serverim.
4. Izveidojiet jaunu, tukšu datubāzi ar nosaukumu:

```text
kepudraugs
```

5. Projekta `.env` failā atrodiet datubāzes iestatījumus un norādiet:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kepudraugs
DB_USERNAME=root
DB_PASSWORD=
```

Šie iestatījumi paredzēti Laragon MySQL konfigurācijai ar lietotāju `root` bez paroles.

Ja datorā MySQL izmanto citu portu, lietotājvārdu vai paroli, šīs vērtības jāpielāgo.

## 6. Administratora konta konfigurēšana

Lai varētu pārbaudīt arī administratora sadaļu, nepieciešams izveidot administratora kontu.

Projekta `.env` faila beigās pievienojiet:

```env
ADMIN_NAME="Administrators"
ADMIN_EMAIL="admin@kepudraugs.lv"
ADMIN_PASSWORD="Komisija1234"
```

Šie ir piemēra dati lokālai projekta pārbaudei. Administratora paroli var izvēlēties arī citu.

**Paroles prasības:**
- Vismaz 8 simboli.
- Vismaz viens lielais burts.
- Vismaz viens cipars.

Saglabājiet `.env` failu.

## 7. Datubāzes tabulu un administratora konta izveide

Pēc `.env` faila konfigurēšanas Laragon terminālī, atrodoties projekta mapē, izpildiet:

```cmd
php artisan config:clear
```

Izveidojiet datubāzes tabulas:

```cmd
php artisan migrate
```

Izveidojiet administratora kontu:

```cmd
php artisan db:seed
```

Komanda `php artisan db:seed` izmanto `.env` failā norādītos `ADMIN_NAME`, `ADMIN_EMAIL` un `ADMIN_PASSWORD` parametrus.

Ja viss izpildīts veiksmīgi, terminālī tiks parādīts paziņojums:

```text
Administratora konts veiksmīgi izveidots!
```

**Piezīme:** ja administrators ar norādīto e-pasta adresi jau eksistē, atkārtota `db:seed` izpilde tā paroli nemainīs.

## 8. Projekta palaišana

Laragon terminālī, atrodoties projekta mapē, izpildiet:

```cmd
php artisan serve
```

Atveriet interneta pārlūkprogrammu un ievadiet adresi:

**http://127.0.0.1:8000**

Ja Laravel terminālī norāda citu adresi vai portu, izmantojiet norādīto adresi.

Lai apturētu serveri, terminālī nospiediet **Ctrl + C**.

## 9. Pieteikšanās administratora kontā

Kad projekts ir palaists, atveriet mājaslapu pārlūkprogrammā un pārejiet uz pieteikšanās sadaļu.

Piesakieties ar `.env` failā norādītajiem administratora datiem.

Ja izmantoti šīs instrukcijas piemēra dati:

- **E-pasts:** `admin@kepudraugs.lv`
- **Parole:** `Komisija1234`

Pēc pieteikšanās administratora panelis ir pieejams adresē:

**http://127.0.0.1:8000/admin**

## 10. Iespējamās problēmas

**Neizdodas izveidot savienojumu ar datubāzi**

Pārbaudiet, vai Laragon ir palaists MySQL un `.env` failā norādīti pareizi datubāzes iestatījumi.

**Trūkst PHP bibliotēku vai `vendor` mapes**

Izpildiet:

```cmd
composer install
```

**Nav izveidota Laravel lietotnes atslēga**

Izpildiet:

```cmd
php artisan key:generate
```

**Administratora konts nav izveidots**

Pārbaudiet, vai `.env` failā ir norādīti visi trīs parametri:

```env
ADMIN_NAME="Administrators"
ADMIN_EMAIL="admin@kepudraugs.lv"
ADMIN_PASSWORD="Komisija1234"
```

Pēc tam izpildiet:

```cmd
php artisan config:clear
php artisan db:seed
```

**Portu 8000 jau izmanto cita programma**

Palaidiet projektu ar citu portu:

```cmd
php artisan serve --port=8001
```

Pēc tam atveriet:

**http://127.0.0.1:8001**

Šādā gadījumā `.env` failā ieteicams arī nomainīt:

```env
APP_URL=http://localhost:8001
```

**Pēc `.env` faila izmaiņām konfigurācija neatjaunojas**

Izpildiet:

```cmd
php artisan config:clear
```

## 11. GitHub repozitorijs

Projekta pirmkods pieejams GitHub:

https://github.com/rodzerz/project-kepudraugs.git

---

**Piezīme:** `.env` fails ir lokāls konfigurācijas fails. Tajā var atrasties paroles un citas sensitīvas vērtības, tāpēc to nevajag augšupielādēt publiskā GitHub repozitorijā.