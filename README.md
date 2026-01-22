# CRM SaaS Multi-Tenant

CRM multi-tenant orientado a negocios, desarrollado con Laravel, que permite a cada empresa gestionar sus clientes, servicios y horarios de forma independiente y segura.

El sistema está diseñado para centralizar la gestión operativa de los negocios, optimizando procesos internos y mejorando la organización de la información.

---

## 🚀 Funcionalidades

- Autenticación de usuarios
- Gestión de negocios (tenants)
- Separación de datos por negocio (multi-tenant)
- Gestión de usuarios con roles
- Gestión de servicios
- Gestión de horarios
- Operaciones CRUD completas
- Interfaz responsive

---

## 🏢 Arquitectura Multi-Tenant

El sistema implementa un modelo **multi-tenant basado en negocio**, donde:

- Cada usuario pertenece a uno o más negocios.
- Los datos están asociados a un negocio específico.
- Un usuario solo puede acceder a la información del negocio al que pertenece.
- La separación de datos se realiza a nivel lógico mediante relaciones en base de datos.

📌 **Ejemplo conceptual:**

Usuario → Negocio → Servicios / Horarios / Datos

Esto garantiza:

- Seguridad de la información
- Escalabilidad
- Aislamiento entre negocios

---

## 🔐 Roles y Permisos

El sistema incluye distintos niveles de acceso, por ejemplo:

- **Administrador**
    - Gestión completa del negocio
    - Gestión de usuarios y roles
- **Empleado**
    - Acceso limitado a servicios y horarios

Los roles permiten un uso ordenado y seguro del sistema dentro de cada negocio.

---

## 🧱 Arquitectura del Proyecto

El proyecto sigue buenas prácticas de Laravel:

app/
├── Http/
│ ├── Controllers/
│ ├── Requests/
├── Models/
├── Services/
├── Policies/
└── ...

- **Controllers**: lógica de control
- **Requests**: validaciones
- **Models**: relaciones y reglas de negocio
- **Services**: lógica reutilizable
- **Policies**: control de acceso

---

## 🛠️ Tecnologías Utilizadas

- PHP
- Laravel
- MySQL
- HTML
- TailwindCSS
- Git / GitHub

---

## ⚙️ Instalación

```bash
git clone https://github.com/tu-usuario/crm-saas.git
cd crm-saas
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```
