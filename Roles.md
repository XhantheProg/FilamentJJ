<!-- ![alt text](image.png) -->
# Roles y Permisos FILAMENT

## Pasos para implementar Roles y Permisos con Shield en Filament 4 + Laravel (Windows)

1. Instalar Shield
```bash
composer require bezhansalleh/filament-shield
```

2. Publicar configuración de Shield

```bash
php artisan vendor:publish --tag=filament-shield-config
```

3. Instalar Spatie Permission (dependencia)

```bash
composer require spatie/laravel-permission
```

4.  Publicar migraciones de Spatie Permission

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

5.  Ejecutar las migraciones

```bash
php artisan migrate
```

Esto crea las tablas: permissions, roles, model_has_permissions, model_has_roles, role_has_permissions

6. Instalar Shield en el panel

```bash
php artisan shield:install
```
Seleccionar: admin (0)

7. Generar permisos y políticas

```bash
php artisan shield:generate --all
```

Seleccionar:

- Panel: admin (0)
- ¿Seleccionar qué generar?: yes
- Qué generar: policies_and_permissions
- Seleccionar todos los recursos con espaciador y Enter

8. Asignar rol super_admin a tu usuario
e
```bash
php artisan shield:super-admin
```