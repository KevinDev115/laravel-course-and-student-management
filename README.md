๐ Clonar repositorio:
```sh
git clone https://github.com/KevinDev115/laravel-course-and-student-management.git
cd laravel-course-and-student-management
```

๐ Instalar dependencias:
```sh
composer install
npm i
```

๐จ Configurar y crear base de datos
```sh
DB_CONNECTION=mysql
DB_HOST=your_host
DB_PORT=your_port
DB_DATABASE=your_name_database
DB_USERNAME=your_username_database
DB_PASSWORD=your_password_database
```
โ Generamos la key
```sh
php artisan key:generate
```

๐ ejecutamos migraciones
```sh
php artisan migration --seed
```

๐ iniciamos el proyecto
```sh
npm run watch
php artisan serve
```

ยกY listo! ๐
