@echo off
REM
echo Installation DataWedge
REM

pput.exe DataWedge.cpy "\Application\DataWedge.cpy"
pput.exe DataWedge.exe "\Application\DataWedge.exe"
pput.exe DataWedge.reg "\Application\DataWedge.reg"
goto fin

:fin
Echo Fin d'Install DataWedge

