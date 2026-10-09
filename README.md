# ĶepuDraugs.lv — projekta palaišanas instrukcija

Šajā instrukcijā aprakstīts, kā lejupielādēt un palaist ĶepuDraugs.lv projektu Windows datorā.

## 1. Nepieciešamās programmas

Pirms projekta lejupielādes datorā jābūt instalētām šādām programmām:

- **Laragon** — PHP un MySQL servera darbināšanai.
- **Git** — projekta lejupielādei no GitHub.
- **Composer** — projekta PHP atkarību instalēšanai.

## 2. Projekta lejupielāde

1. Atveriet **Laragon**.
2. Nospiediet **Start All**, lai palaistu serverus.
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

## 4. Laravel konfigurēšana

Izveidojiet projekta konfigurācijas failu:

```cmd
copy .env.example .env
```

Ģenerējiet lietotnes atslēgu:

```cmd
php artisan key:generate
```

## 5. Datubāzes izveide

1. Pārliecinieties, ka Laragon ir palaists **MySQL**.
2. Atveriet **HeidiSQL** vai citu MySQL datubāzu pārvaldības programmu.
3. Izveidojiet jaunu tukšu datubāzi ar nosaukumu:

```text
kepudraugs
```

4. Projekta mapē atveriet `.env` failu.
5. Atrodiet datubāzes iestatījumus un norādiet:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kepudraugs
DB_USERNAME=root
DB_PASSWORD=
```

Šie iestatījumi paredzēti Laragon noklusējuma MySQL konfigurācijai. Ja datorā MySQL lietotājam ir parole vai tiek izmantots cits ports, iestatījumi jāpielāgo.

Saglabājiet `.env` failu.

Terminālī izpildiet:

```cmd
php artisan config:clear
```

## 6. Datubāzes tabulu izveide

Projekta mapē izpildiet:

```cmd
php artisan migrate
```

Šī komanda izveidos projektam nepieciešamās datubāzes tabulas.

## 7. Projekta palaišana

Terminālī izpildiet:

```cmd
php artisan serve
```

Atveriet interneta pārlūkprogrammu un ievadiet adresi:

**http://127.0.0.1:8000**

Ja Laravel terminālī norāda citu adresi vai portu, izmantojiet norādīto adresi.

Lai apturētu serveri, terminālī nospiediet **Ctrl + C**.

## 8. Iespējamās problēmas

**Neizdodas izveidot savienojumu ar datubāzi**

Pārbaudiet, vai Laragon ir palaists MySQL un `.env` failā norādīti pareizi datubāzes iestatījumi.

**Kļūda par trūkstošām PHP bibliotēkām**

Izpildiet:

```cmd
composer install
```

**Kļūda par lietotnes atslēgu**

Izpildiet:

```cmd
php artisan key:generate
```

**Portu 8000 jau izmanto cita programma**

Palaidiet projektu ar citu portu:

```cmd
php artisan serve --port=8001
```

Pēc tam atveriet:

**http://127.0.0.1:8001**

## 9. GitHub repozitorijs

Projekta pirmkods pieejams šeit:

https://github.com/rodzerz/project-kepudraugs.git