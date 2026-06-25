# Manual de Instalación — Sistema Administrativo Escolar

> **Laravel 12 · PHP 8.2+ · MySQL · Node.js · Tailwind CSS**

---

## FORMA 1 — Instalación desde Unidad de Almacenamiento

Este método consiste en copiar los archivos del proyecto directamente desde una
unidad de almacenamiento externa (USB, disco duro portátil, etc.) a la máquina
destino.

---

## 1. Requisitos Previos

Asegúrese de tener instaladas las siguientes herramientas antes de continuar:

| Herramienta | Versión mínima | Descarga |
|---|---|---|
| **XAMPP** | 8.2.x o superior | https://www.apachefriends.org |
| **PHP** (incluido en XAMPP) | 8.2 | — |
| **Composer** | 2.x | https://getcomposer.org/download |
| **Node.js** | 18 LTS o superior | https://nodejs.org |
| **npm** | 9 o superior (incluido con Node.js) | — |

> **Nota:** Si ya tiene XAMPP instalado, verifique la versión de PHP abriendo el
> Panel de Control de XAMPP → Shell → escriba `php -v`.

---

## 2. Verificar Herramientas Instaladas

Abra una terminal (CMD o PowerShell) y ejecute los siguientes comandos:

```bash
php -v
composer -V
node -v
npm -v
```

Salida esperada (ejemplo):

```
PHP 8.2.x (cli)
Composer version 2.x.x
v20.x.x
10.x.x
```

Si algún comando no es reconocido, instale la herramienta correspondiente de la
tabla anterior antes de continuar.

---

## 3. Iniciar los Servicios de XAMPP

1. Abra el **Panel de Control de XAMPP**.
2. Inicie los módulos **Apache** y **MySQL**.
3. Verifique que ambos muestren el indicador en **verde**.

---

## 4. Copiar los Archivos del Proyecto

1. Conecte la unidad de almacenamiento a la computadora.
2. Localice la carpeta del proyecto. El nombre de la carpeta debe ser:

   ```
   System_Admin_Escolar
   ```

3. Copie la carpeta completa al directorio raíz de XAMPP:

   ```
   C:\xampp\htdocs\
   ```

   Resultado esperado:

   ```
   C:\xampp\htdocs\System_Admin_Escolar\
   ```

> **Importante:** No cambie el nombre de la carpeta. Asegúrese de que la
> estructura interna sea la correcta (debe contener `artisan`, `composer.json`,
> `package.json`, carpetas `app/`, `database/`, `resources/`, etc.).

### 4.1 Carpetas que NO deben incluirse en la copia

Las siguientes carpetas **no necesitan** ser copiadas desde la unidad porque se
generarán durante la instalación. Si la unidad las incluye, puede ignorarlas o
eliminarlas para ahorrar espacio:

| Carpeta | Motivo |
|---|---|
| `vendor/` | Se regenera con `composer install` |
| `node_modules/` | Se regenera con `npm install` |
| `storage/framework/cache/` | Se crea automáticamente |
| `storage/framework/sessions/` | Se crea automáticamente |
| `storage/framework/views/` | Se crea automáticamente |

---

## 5. Crear la Base de Datos en MySQL

1. Abra su navegador y vaya a:

   ```
   http://localhost/phpmyadmin
   ```

2. En el panel izquierdo haga clic en **Nueva** (New).
3. En el campo **Nombre de la base de datos** escriba:

   ```
   system_admin_escolar
   ```

4. En **Cotejamiento** seleccione: `utf8mb4_unicode_ci`
5. Haga clic en **Crear**.

---

## 6. Configurar el Archivo de Entorno (.env)

El archivo `.env` contiene las variables de configuración del sistema. Debe
crearse a partir de la plantilla incluida.

### 6.1 Crear el archivo .env

1. Navegue a la carpeta del proyecto:

   ```
   C:\xampp\htdocs\System_Admin_Escolar\
   ```

2. Localice el archivo `.env.example`.
3. Duplíquelo y renombre la copia a `.env` (sin extensión adicional).

   > **Consejo:** En Windows, si el Explorador de archivos no muestra la
   > extensión, abra CMD en esa carpeta y ejecute:
   > ```cmd
   > copy .env.example .env
   > ```

### 6.2 Editar el archivo .env

Abra el archivo `.env` con cualquier editor de texto (Notepad, VS Code, etc.) y
modifique las siguientes líneas:

```env
APP_NAME="Sistema Administrativo Escolar"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/System_Admin_Escolar/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=system_admin_escolar
DB_USERNAME=root
DB_PASSWORD=
```

> **Nota sobre `DB_PASSWORD`:** En XAMPP por defecto el usuario `root` no tiene
> contraseña. Si usted configuró una contraseña para MySQL, ingrésela aquí.

Guarde el archivo.

---

## 7. Instalar Dependencias PHP (Composer)

1. Abra una terminal (CMD o PowerShell).
2. Navegue a la carpeta del proyecto:

   ```bash
   cd C:\xampp\htdocs\System_Admin_Escolar
   ```

3. Ejecute el siguiente comando:

   ```bash
   composer install
   ```

   Esto descargará e instalará todos los paquetes PHP definidos en
   `composer.json`. El proceso puede tardar varios minutos dependiendo de la
   velocidad de internet.

   > **Sin conexión a internet:** Si la unidad de almacenamiento incluye la
   > carpeta `vendor/`, omita este paso; las dependencias ya están incluidas.

Salida esperada al finalizar:

```
Generating optimized autoload files
> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi
...
Package manifest generated successfully.
```

---

## 8. Generar la Clave de la Aplicación

Laravel requiere una clave de cifrado única para cada instalación. Ejecute:

```bash
php artisan key:generate
```

Salida esperada:

```
INFO  Application key set successfully.
```

Este comando escribe automáticamente el valor de `APP_KEY` en el archivo `.env`.

---

## 9. Instalar Dependencias de Node.js (npm)

1. En la misma terminal, asegúrese de estar en la carpeta del proyecto.
2. Ejecute:

   ```bash
   npm install
   ```

   Esto instalará Vite, Tailwind CSS y las demás dependencias del frontend
   definidas en `package.json`.

   > **Sin conexión a internet:** Si la unidad de almacenamiento incluye la
   > carpeta `node_modules/`, omita este paso.

---

## 10. Compilar los Assets del Frontend

Una vez instaladas las dependencias de Node.js, compile los archivos CSS y JS:

```bash
npm run build
```

Salida esperada al finalizar:

```
vite v7.x.x building for production...
✓ built in x.xxs
```

Esto generará la carpeta `public/build/` con los assets optimizados.

---

## 11. Crear los Permisos de Almacenamiento

Laravel necesita permisos de escritura en la carpeta `storage`. En Windows con
XAMPP esto generalmente no es necesario, pero si aparece un error de permisos
ejecute:

```bash
php artisan storage:link
```

---

## 12. Ejecutar las Migraciones de Base de Datos

Este paso crea todas las tablas necesarias en la base de datos:

```bash
php artisan migrate
```

Confirme con `yes` si el sistema pregunta si desea ejecutar las migraciones.

Salida esperada:

```
INFO  Running migrations.

  0001_01_01_000000_create_users_table ............. DONE
  0001_01_01_000001_create_cache_table ............. DONE
  0001_01_01_000002_create_jobs_table .............. DONE
  ...
```

---

## 13. Ejecutar los Seeders (Datos Iniciales)

Para poblar la base de datos con los datos iniciales del sistema ejecute:

```bash
php artisan db:seed
```

> Si desea ejecutar únicamente el seeder de datos iniciales:
> ```bash
> php artisan db:seed --class=DatosInicialesSeeder
> ```

---

## 14. Limpiar la Caché de Configuración

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 15. Verificar la Instalación

### Opción A — Usando el servidor de Laravel (recomendado para pruebas)

Ejecute en la terminal:

```bash
php artisan serve
```

Abra el navegador en:

```
http://127.0.0.1:8000
```

### Opción B — Usando Apache de XAMPP

Con Apache activo en XAMPP, abra el navegador en:

```
http://localhost/System_Admin_Escolar/public
```

Si la página de inicio del sistema aparece correctamente, la instalación fue
exitosa.

---

## Resumen de Comandos (Orden de Ejecución)

```bash
# 1. Ir a la carpeta del proyecto
cd C:\xampp\htdocs\System_Admin_Escolar

# 2. Crear el .env
copy .env.example .env

# 3. Editar .env con los datos de la BD (ver Paso 6.2)

# 4. Instalar dependencias PHP
composer install

# 5. Generar clave de aplicación
php artisan key:generate

# 6. Instalar dependencias Node.js
npm install

# 7. Compilar assets del frontend
npm run build

# 8. Enlace de almacenamiento
php artisan storage:link

# 9. Ejecutar migraciones
php artisan migrate

# 10. Ejecutar seeders
php artisan db:seed

# 11. Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 12. Iniciar servidor (opcional)
php artisan serve
```

---

## Solución de Problemas Comunes

| Error | Causa probable | Solución |
|---|---|---|
| `php: command not found` | PHP no está en el PATH | Agregar `C:\xampp\php` al PATH del sistema |
| `composer: command not found` | Composer no está instalado | Descargar e instalar desde getcomposer.org |
| `SQLSTATE[HY000] [1045] Access denied` | Credenciales de BD incorrectas | Verificar `DB_USERNAME` y `DB_PASSWORD` en `.env` |
| `SQLSTATE[HY000] [1049] Unknown database` | La BD no existe | Crear la BD en phpMyAdmin (ver Paso 5) |
| `No application encryption key has been specified` | Falta `APP_KEY` | Ejecutar `php artisan key:generate` |
| `Vite manifest not found` | Assets no compilados | Ejecutar `npm run build` |
| `Class not found` | Autoload desactualizado | Ejecutar `composer dump-autoload` |
| Puerto 80 ocupado en Apache | Otro servicio usa el puerto | Cambiar el puerto de Apache en XAMPP o usar `php artisan serve` |

---

*— Fin de la Forma 1 — Instalación desde Unidad de Almacenamiento*
