# Тестовый проект
SPA-приложение с текстом рыбой, формой добавления комментариев, списком комментов с пагинацией

## Установка

1. Создайте файл .env путем копирования:
```sh
$ cp .example.env .env
```
2. Измените настройки в файле .env

```
DB_HOST=db.test.loc
DB_PORT=3306
DB_NAME=test
DB_USER=root
DB_PASSWORD=password

ITEMS_PER_PAGE=5

VIEWS_DIR=App/Views
```

3. Установка зависимостей
```sh
$ composer install
```
4. Бидл и запуск контейнера
```sh
docker-compose build && docker-compose up -d
```
5. Найдите запущенный контейнер с именем образа "test_db"
```sh   
docker container ls | grep "test_db"
```
6. Установите выбор БД в файле с дампом
```
use `<DB_NAME>`
```   
7. Запустите в контейнере sql скрипт для создания таблицы комментариев 
```sh
$  docker exec -i <CONTAINER_ID> mysql -u <DB_USER> -p<DB_PASSWORD> < ./docker/mysql/setup.sql
```

## Работа с приложением
Перейдите по адресу http://localhost:80. В верхней части страницы находится текст-рыба на 2 азбаца.
Под ним находится кнопка для отображения формы добавления комментария. Форма имеет валидацию на фронте(JS), 
а так же в стороне бекенда. 
Список комментариев отображается внизу станицы, имеет пагинацию(настраивается в .env - ITEMS_PER_PAGE)

# Зависимости
1. vlucas/phpdotenv - пакет для работы с .env файлом
2. illuminate/database - пакет для работы с БД
3. illuminate/pagination - пакет для работы с пагинацией


