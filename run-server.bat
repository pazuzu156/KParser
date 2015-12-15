@echo off

rem Run server on localhost port 8080

if not exist vendor goto install

goto run

:install
composer install

:run
php -S 127.0.0.1:8080 -t test
