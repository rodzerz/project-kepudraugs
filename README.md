# ĶepuDraugs.lv

ĶepuDraugs.lv ir Laravel tīmekļa lietotne, kas paredzēta mājdzīvnieku īpašnieku un pieskatītāju savstarpējai saziņai un rezervāciju veikšanai.

## Projekta palaišanas instrukcija

### 1. Nepieciešamās programmas

Datorā jābūt instalētām:

- [Laragon](https://laragon.org/)
- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/)

Nepieciešama PHP 8.3 vai jaunāka versija un MySQL.

### 2. Projekta lejupielāde

Atvērt **Laragon**, nospiest **Start All** un atvērt **Terminal**.

Laragon terminālī izpildīt:

```cmd
cd C:\laragon\www
git clone https://github.com/rodzerz/project-kepudraugs.git kepudraugs
cd kepudraugs
```

### 3. Projekta uzstādīšana

Instalēt nepieciešamās bibliotēkas:

```cmd
composer install
```

Izveidot konfigurācijas failu:

```cmd
copy .env.example .env
```

Ģenerēt Laravel lietotnes atslēgu:

```cmd
php artisan key:generate
```

### 4. Datubāzes izveidošana

Laragon terminālī izpildīt:

```cmd
mysql -u root -e "CREATE DATABASE IF NOT EXISTS kepudraugs;"
```

Atvērt konfigurācijas failu:

```cmd
notepad .env
```

Pārbaudīt, vai datubāzes iestatījumi ir šādi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kepudraugs
DB_USERNAME=root
DB_PASSWORD=
```

Saglabāt failu un izpildīt:

```cmd
php artisan config:clear
php artisan migrate
```

### 5. Attēlu konfigurācija

Izpildīt:

```cmd
php artisan storage:link
```

### 6. Projekta palaišana

Laragon terminālī izpildīt:

```cmd
php artisan serve
```

Pārlūkprogrammā atvērt:

**http://127.0.0.1:8000**

Projekts ir gatavs lietošanai!

### 7. Atkārtota palaišana

Nākamajās reizēs pietiek ar Laragon palaišanu (**Start All**) un šīm komandām:

```cmd
cd C:\laragon\www\kepudraugs
php artisan serve
```

Pēc tam atvērt **http://127.0.0.1:8000**.

---

**GitHub:** https://github.com/rodzerz/project-kepudraugs

**Izstrādes vide:** Laravel 13, PHP 8.3+, MySQL, Blade, CSS, JavaScript.