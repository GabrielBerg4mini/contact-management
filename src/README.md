# Contact Management

A CRUD web application to manage contacts, built with **Laravel 10** and **PHP 8.1**.

## Features

- Public list of contacts (search + pagination)
- Create, edit, view details (standalone page) and delete contacts
- Delete is a **soft delete** (Laravel `SoftDeletes`)
- Validation: name longer than 5 characters, contact with exactly 9 digits, valid e-mail; contact and e-mail must be unique
- Authentication: only the contact list is public; every other action requires login
- Feature tests for CRUD, validation errors, uniqueness and access control

## Default credentials

| E-mail              | Password   |
| ------------------- | ---------- |
| `admin@admin.com` | `123456` |

## Why Docker?

- **Same environment everywhere:** the app targets PHP 8.1 and Laravel 10. Docker pins those versions, so it behaves the same on any machine, regardless of what is installed locally.
- **Nothing to install besides Docker:** PHP, Composer, extensions and MySQL run in containers, so there is no local setup to break.
- **Database included:** MySQL runs as its own service, with the app talking to it by service name instead of a locally installed server.
- **One command to start and one to reset:** a broken environment can be rebuilt without touching the host.

## Requirements

- [Docker](https://docs.docker.com/get-docker/) and Docker Compose

## Running the project

```bash
# 1. Clone the repository
git clone <repository-url>
cd <project-folder>

# 2. Create the environment file
cp .env.example .env
# In .env, DB_HOST must be the database service name (e.g. db), not 127.0.0.1

# 3. Start the containers
docker compose up -d --build

# 4. Install dependencies
docker compose exec app composer install

# 5. Generate the application key
docker compose exec app php artisan key:generate

# 6. Create the tables and seed the admin user and sample contacts
docker compose exec app php artisan migrate --seed
```

The application is available at **http://localhost:8000** (adjust the port to the one in `docker-compose.yml`).

> If you only need the admin user: `docker compose exec app php artisan db:seed --class=AdminUserSeeder`

## Running the tests

```bash
docker compose exec app php artisan test
```

## Routes

| Method | URL                          | Description      | Access        |
| ------ | ---------------------------- | ---------------- | ------------- |
| GET    | `/contacts`                | List contacts    | Public        |
| GET    | `/contacts/create`         | New contact form | Authenticated |
| POST   | `/contacts`                | Store contact    | Authenticated |
| GET    | `/contacts/{contact}`      | Contact details  | Authenticated |
| GET    | `/contacts/{contact}/edit` | Edit form        | Authenticated |
| PUT    | `/contacts/{contact}`      | Update contact   | Authenticated |
| DELETE | `/contacts/{contact}`      | Soft delete      | Authenticated |
| GET    | `/login`                   | Login page       | Guests        |
| POST   | `/logout`                  | Logout           | Authenticated |

## Project structure (main files)

- `app/Models/Contact.php`: model with `SoftDeletes`
- `app/Http/Requests/ContactRequest.php`: validation rules (create and update)
- `app/Http/Controllers/ContactController.php`: CRUD actions
- `app/Http/Controllers/Auth/SessionController.php`: login and logout
- `database/migrations/*_create_contacts_table.php`: contacts table
- `database/seeders/`: admin user and sample contacts
- `resources/views/`: Blade views (layout, contacts, login)
- `tests/Feature/`: contact and authentication tests

## Useful commands

```bash
docker compose logs -f app                    # follow application logs
docker compose exec app php artisan migrate:fresh --seed   # reset database
docker compose exec app php artisan config:clear           # clear config cache
docker compose down                           # stop containers
```

## Troubleshooting

- **Login fails with correct credentials:** the admin user may not exist in this database. Run `docker compose exec app php artisan db:seed --class=AdminUserSeeder`.
- **Database connection refused:** inside Docker, `DB_HOST` must be the database service name, not `127.0.0.1`. Then run `php artisan config:clear`.
