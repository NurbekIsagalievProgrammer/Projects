# Название проекта

TransactionDocker.Тестовое задание

## Начало работы

1.Разархивировать проект
2.Войти через терминал в  папку проекта TransactionDocker
3.В терминале  запустить команду 'docker-compose up --build'(или с  командой  sudo)
4.Открыть новый терминал(снова войти в проект через терминал) не закрывая  старый  и запустить в  нем  команду 'docker-compose exec php sh'
5.В новом терминале запустить команды  'cd /var/www/html'  и 'composer install' и 'php artisan key:generate'
6.Запустить команду  миграции 'php artisan migrate'
7.Запустить команду сидера 'php artisan db:seed'
8.Запустить команду 'chown -R www-data:www-data *'
9.Открыть проект в браузере по адресу localhost:8080




