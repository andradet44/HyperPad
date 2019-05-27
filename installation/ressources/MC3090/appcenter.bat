@echo off
REM
Echo Installation AppCenter
REM

pmkdir.exe \application\AppCenter
pput.exe AppCenter.cpy  "\application\AppCenter.cpy"
pput.exe AppCenter.lnk  "\application\AppCenter\AppCenter.lnk"
pput.exe AppCenter.exe  "\application\AppCenter\AppCenter.exe"
pput.exe AppCenter.exe  "\application\StartUp\AppCenter.exe"
pput.exe AppCenter.reg  "\application\AppCenter.reg"
pput.exe PlatMC3000c50.reg "\application\PlatMC3000c50.reg"
pput.exe Icone_vidage.exe "\Application\Scripts\Icone_vidage.exe"
pput.exe SymScriptCE.exe "\Application\Scripts\SymScriptCE.exe"
pput.exe Vidage.spt "\Application\Scripts\Vidage.spt"


goto fin

:fin
Echo Fin d'Install AppCenter
