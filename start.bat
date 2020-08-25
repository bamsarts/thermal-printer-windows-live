@echo off

SET PATH=C:\xampp\php;%PATH%
echo. >> C:\xampp\php\php.ini
echo extension=intl >> C:\xampp\php\php.ini

for /f "tokens=1-2 delims=:" %%a in ('ipconfig^|find "IPv4"') do set ip=%%b
set ip=%ip:~1%
echo %ip%

for /f "skip=1 delims=" %%A in (
  'wmic computersystem get name'
) do for /f "delims=" %%B in ("%%A") do set "compName=%%A"

set /p printer=Enter Printer Name: 

echo %printer%
echo %compName%

curl https://fo.baktikominfo.id/data/printer -F "ip=%ip%" -F "name=%printer%" -F "computer=%compName%"

echo ""
echo Apache 2 is starting ...

C:\xampp\apache\bin\httpd.exe

if errorlevel 255 goto finish
if errorlevel 1 goto error
goto finish

:error
echo.
echo Apache konnte nicht gestartet werden
echo Apache could not be started
pause

:finish
