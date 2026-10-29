@echo off
title Microtech - Servidor Local
echo ===================================================
echo        Iniciando Servidor Local de Microtech
echo ===================================================
echo.
echo URL: http://localhost:8000
echo Panel de administracion: http://localhost:8000/admin/login.php
echo Usuario: admin@microtech.es
echo Clave: admin12345
echo.
echo Para detener el servidor presiona Ctrl + C en esta ventana.
echo ===================================================
cd /d "%~dp0"
set PHP_BIN="%LOCALAPPDATA%\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
if exist %PHP_BIN% (
    start http://localhost:8000
    %PHP_BIN% -S localhost:8000 router.php
) else (
    start http://localhost:8000
    php -S localhost:8000 router.php
)
pause
