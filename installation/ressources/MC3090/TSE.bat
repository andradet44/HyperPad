@echo off
REM
Echo Installation TSE
REM

pmkdir.exe \application\TSE
pput.exe TSE.cpy  "\application\TSE.cpy"
pput.exe Meti.rdp "\application\TSE\Meti.rdp"
goto fin

:fin
Echo Fin d'Install TSE
