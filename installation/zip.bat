set currentpath=%~dp0
@echo %currentpath%

%currentpath%7z.exe a -tzip -mx=9 %currentpath%temp\ressource.zip %currentpath%temp\*
pause