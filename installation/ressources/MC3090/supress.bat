@echo off
REM
Echo suppression ancienne installation
REM
@echo off

pdel.exe  "\application\AppCenter.cpy"
pdel.exe  "\application\AppCenter.lnk"
pdel.exe  "\application\AppCenter.exe"
pdel.exe  "\application\AppCenter.reg"
pdel.exe  "\platform\conftcip.reg"
pdel.exe  "\platform\wlan*"
pdel.exe  "\Application\Scripts\SymScriptCE.exe"
pdel.exe  "\Application\Scripts\Icone_vidage.exe"
pdel.exe  "\Application\Scripts\Vidage.spt"
@echo off

goto fin

:fin

