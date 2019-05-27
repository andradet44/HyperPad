@echo off
REM
REM Installation sur PocketPC
REM

if not '%1'=='' goto param

echo.
echo Installation sur PocketPC ...
echo.
echo Verifiez que le PocketPC est connecté … ActiveSync.
echo Puis appuyez sur une touche.
echo.
echo.
call supress.bat
call appcenter.bat
call TSE.bat
call DataWedge.bat
call run.bat
goto fin

:param
echo.
echo Usage: INSTALL
echo.
goto fin

:erreur
echo.
echo Erreur: Problème d'installation !
echo.
goto fin

:fin
echo INSTALLATION TERMINEE
echo Appuyer sur 1 9 Power
pause
