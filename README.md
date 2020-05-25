# Konfiguráció
A project jelenleg XAMPP virtual host-on keresztüli működésre van beállítva, de át lehet írni `.env` file `APP_URL` kulcsát is, hogy stimmeljen az elérési út, elvileg úgy is működik, de nem próbáltam ki. 
Bedobom ide a saját config fájljaim tartalmát, ha mégis így szeretné beállítani.

### *'/apache/conf/extra/httpd-vhosts.conf'* tartalma:
```apacheconfig
<VirtualHost *:80>
    ServerAdmin webmaster@webprog.com
    DocumentRoot "C:/xampp/htdocs/webprog/public"
    ServerName wp.test
    ErrorLog "logs/wp-error.log"
    CustomLog "logs/wp-access.log" common
</VirtualHost>
```

### Windows *hosts* fájl tartalma:
```
127.0.0.1 wp.test
```

# Adatbázis
1. Adatbázis és felhasználó:
    ```mysql
    GRANT ALL PRIVILEGES ON *.* TO 'wp3_hl5u4v'@'%' IDENTIFIED BY '6Y6VVAPl8E6P';

    CREATE DATABASE IF NOT EXISTS `wp3_hl5u4v`;

    GRANT ALL PRIVILEGES ON `wp3_hl5u4v`.* TO 'wp3_hl5u4v'@'%';
    ```
2. Táblák és adatok
    1. Ha van php telepítve, akkor a root mappából indított parancssorba:
        ```shell script
        php artisan migrate:fresh && php artisan db:seed
        ```
        Ez feldob minden táblát, feltölti őket véletlenszerű teszt adatokkal és csinál egy Admin illetve egy "sima" felhasználót.
    2. *Alternatíva: van egy `wp3_hl5u4v.sql` fájl a `FIRST_CONFIG` mappában.*

# Bejelentkezés
Az adatbázis összes felhasználója `password` jelszót kap alapból, beleértve az admin (`admin@example.com`) és a user (`user@example.com`) felhasználókat is.

# Funkciók

A munka egy **nagyon** alapvető project management felület.

Minden felhasználó tud:
- Projektet indítani (Trello-ból exportált JSON-ból is)
- Email-szerűen üzenetet küldeni egy másik felhasználónak
- Megnézni az elküldött üzeneteket
- Megtekinteni bármely felhasználó profilját és azok publikus projektjeit
- A hozzá rendelt feladatok státuszán módosítani
- Megtekinteni azon projekteket, melyekben részt vesz 
<br>(és azok összes feladatát, valamint ezen feladatokat exportálhatja CSV formátumba)

A Projektet készítő felhasználó tud:
- Módosítani, Törölni a projektet (Beleértve a résztvevők listáját is)
- Feladatokat felvenni, módosítani, törölni (Beleértve a résztvevők listáját is)

Admin tud:
- Megtekinteni, módosítani, törölni bármely projektet
- Megtekinteni, módosítani, törölni bármely feladatot

Továbbá támogatott a markdown formátum az üzenet, projekt ismertető és feladat leírás input dobozában.

---

#### Készítette: Dombi Tibor Dávid - HL5U4V
