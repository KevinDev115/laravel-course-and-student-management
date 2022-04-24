Clonar repositorio:
```sh
git clone https://github.com/KevinDev115/laravel-course-and-student-management.git
cd laravel-course-and-student-management
```

Instalar dependencias:
```sh
composer install
npm i
```

Configurar y crear base de datos
```sh
DB_CONNECTION=mysql
DB_HOST=your_host
DB_PORT=your_port
DB_DATABASE=your_name_database
DB_USERNAME=your_username_database
DB_PASSWORD=your_password_database
```
Generamos la key
```sh
php artisan key:generate
```

Ejecutamos migraciones
```sh
php artisan migration --seed
```

Arrancamos el proyecto
```sh
npm run watch
php artisan serve
```

Y listo! 😋
