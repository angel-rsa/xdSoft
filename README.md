# xdSoft
Тестовое задание для веб-разработчика от компании Икс Ди Софт, Программный продукт

Необходимо написать скрипт, собирающий данные с рейтинга Кинопоиска (http://www.kinopoisk.ru/top/),
и сохраняющего позицию, рейтинг, оригинальное название, год и кол-во проголосовавших людей в БД (любой на выбор).
Также нужно добавить соответствующие поля в БД для выборки рейтинга на определенную дату.
Скрипт должен быть написан с учетом возможности постановки в cron.

Создать базовую веб-страницу, выводящую топ-10 фильмов на указанную дату. 
На ней должно присутствовать поле, где пользователь может указать дату выборки.
При выгрузке данных из СУБД должен быть использован кэширующий слой, чтобы избежать запросов к базе каждый раз, 
когда рейтинг должен быть показан.

Критерии оценки:
- чистый, читаемый, структурируемый php код, объектно ориентированный дизайн
- схема базы данных
- чистота верстки

# Решение

Создан проект на Symfony 2.8 с использованием БД MySql и кеширующей прослойки в виде memcache.

При установке проекта необходимо настроить доступ к БД и memcache в файле app/config/parameters.yml

БД создается по стандартным симфониевским канонам:
php app/console doctrine:database:create
php app/console doctrine:schema:update --force

Консольная команда парсинга:
php app/console parse:kinopoisk
или
php app/console parse:kinopoisk YYYY-MM-DD
(для парсинга конкретной даты)

Экран отображения ТОП-10 на дату является стартовым экраном
При использовании веб-сервера из пакета симфони (php app/console server:run) открывается запросом http://127.0.0.1:8000/
