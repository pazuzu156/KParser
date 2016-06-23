@echo off

rem Run server on localhost port 8080

rem This will get the PHP location from php_loc.txt
for /f "delims=" %%i in (php_loc.txt) do set PHP=%%i

if not exist vendor goto install

goto run

:install
composer install

:run
"%PHP%" -S 127.0.0.1:8080 -t tests/views
