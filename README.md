# 🏅 INET 2025 API

API desarrollada para la gestión de las Olimpiadas INET 2025, construida con Laravel 12 y GraphQL utilizando Lighthouse. Esta API permite manejar usuarios, productos, órdenes, pagos y más, adaptada a un sistema para un ecommerce de paquetes turisticos.

---

## 🚀 Tecnologías utilizadas

-   [Laravel 12](https://laravel.com/)
-   [GraphQL](https://graphql.org/)
-   [Lighthouse PHP](https://lighthouse-php.com/)
-   MySQL / MariaDB
-   Composer / Artisan CLI

---

## 📦 Estructura del sistema

### Principales entidades:

-   **Usuarios** con autenticación y residencia
-   **Productos** (vuelos, autos, estadías) con capacidades y características
-   **Órdenes** con historial, detalles y pagos
-   **Relaciones Many-to-Many** (productos ↔ estadías/vuelos/autos, usuarios ↔ residencias)
-   **Consultas y mutaciones GraphQL**

---

## 📂 Instalación

```bash
git clone https://github.com/IgnaciogRuiz/Inet2025-Api.git
cd Inet2025-Api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```
