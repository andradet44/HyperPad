@echo off
REM
Echo Installation Startup
REM


:inst_nt
pmkdir.exe Scripts "\Application\Scripts"
pput.exe SymScriptCE.exe "\Application\Scripts\SymScriptCE.exe"
pput.exe Icone_vidage.exe "\Application\Scripts\Icone_vidage.exe"
pput.exe VidageRCC.spt "\Application\Scripts\Vidage.spt"
pput.exe DataWedge.run "\Application\StartUp\DataWedge.run"
pput.exe Idxx.Reg      "\Platform\Idxx.Reg"
pput.exe WCS_OPTIONS.REG "\Platform\WCS_OPTIONS.REG"
pput.exe WCS_PROFILES.REG "\Platform\WCS_PROFILE.REG"

:fin
Echo Fin d'Install StartUp

