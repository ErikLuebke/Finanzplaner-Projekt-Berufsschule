## Projekt aufsetzen
1. Im /backend Verzeichnis:
- composer install
2. Im root-verzeichnis /Finanzplaner-Projekt-Berufsschule:
- docker compose -f docker-compose.dev.yml up --build
- eventuell, falls nötig: docker compose -f docker-compose.dev.yml exec backend composer install
- docker compose -f docker-compose.dev.yml exec backend php artisan db:seed   `Zum Füllen der Datenbanktabellen`
3. Im Frontend (http://localhost:5173) nachdem alle Migrations und Seeder ausgeführt wurden:
  - Registrieren (http://localhost:5173/register) -> Konto anlegen
  - In der Datenbank in der Tabelle "Konto" bei dem Konto mit kontoid 1 die user_id auf 1 setzen, damit man bei dem registrierten User auch ein Konto mit geseedeten Daten verknüpft hat

## Entwicklung starten
- docker compose -f docker-compose.dev.yml up
- Öffne http://localhost:5173
- Stoppen: Strg+C, optional `docker compose -f docker-compose.dev.yml down`
- Für Datenbank öffne: http://localhost:8080/index.php?route=/database/structure&db=freibier

## Unit-Tests ausführen
1. Im Root-Verzeichnis Finanzplaner-Projekt-Berufsschule:
- docker compose -f docker-compose.dev.yml exec backend php artisan test
- docker compose -f docker-compose.dev.yml exec web npm run test:unit -- --run
