set currentpath=%~dp0
@echo %currentpath%

rmdir %currentpath%\temp /s /q
pause