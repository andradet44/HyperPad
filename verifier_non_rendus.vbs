set cn = CreateObject("ADODB.Connection")
set rs_zero = CreateObject("ADODB.Recordset")




connectionString = "Driver={MySQL ODBC 5.3 ANSI Driver};Server=10.50.91.89; Data Source=prets; Database=new_hyp_mag_fic; User=radiopad; Password=radiopad;"
cn.Open connectionString


'Recuperation des parametres en base de donnees'
'---------------------------------------------------------------------------------------------------------------'
rs_zero.open "SELECT * FROM `parametres`" , cn , 3

Dim Id_magasin()
Dim Nom_societe()
Dim Departement()
Dim Alias_magasin()
Dim Mail_admin()

Dim i
i = 0

'Enregistrement des donnees dans des tableaux'
while rs_zero.EOF=false

  ReDim Preserve Id_magasin(i+1)
  Id_magasin(i) = rs_zero(1)

  ReDim Preserve Nom_societe(i+1)
  Nom_societe(i) = rs_zero(3)

  ReDim Preserve Departement(i+1)
  Departement(i) = rs_zero(4)

  ReDim Preserve Alias_magasin(i+1)
  Alias_magasin(i) = rs_zero(5)

  ReDim Preserve Mail_admin(i+1)
  Mail_admin(i) = rs_zero(6)

  i = i + 1

  rs_zero.MoveNext
Wend

'Fermeture du resultat de la requette'
rs_zero.close


'Lance la fonction de recuperation des donnees et envoi des mails'
i = 0
For Each id In Id_magasin
	if(Id_magasin(i) <> "") Then 
		result = send_mail (Id_magasin(i), Nom_societe(i), Departement(i), Alias_magasin(i), Mail_admin(i))
		i = i + 1
	End If
Next

Function send_mail(Id_magasin, Nom_societe, Departement , Alias_magasin , Mail_admin)
	set rs = CreateObject("ADODB.Recordset")
	set rs_un = CreateObject("ADODB.Recordset")
	d = Right(String(2, "0") & Day(date), 2)
	m = Right(String(2, "0") & Month(date), 2)
	y = Year(date)
	DateToday = d & "-" & m & "-" & y


	message = "" &_
			"<!DOCTYPE html>" &_
			"<html>" &_
			"<head>" &_
				"<title> HyperPad </title>" &_
				"<style media='screen'>" &_
				"table{" &_
					"display: block;" &_
					"width: 98%;" &_
					"margin: auto;" &_
					"margin-top: 60px;" &_
					"text-align: center;" &_
			"	}" &_
			"td, th{" &_
				"width: 14vw;" &_
				"padding: 8px;" &_
				"background-color: #f2f2f2;" &_
				"border-radius: 5px;" &_
		"	}" &_
			"th{" &_
				"cursor: pointer;" &_
			"}" &_
			"tr:hover > .color{" &_
				"background-color: #2098D1;" &_
				"color: white;" &_
			"}" &_
			".entete{" &_
				"background-color: #4CAF50;" &_
				"border-style: solid;" &_
				"border-width: 0px 0px 2px 0px;" &_
				"font-weight: bold;" &_
				"font-size: 20px;" &_
				"color: white;" &_
				"cursor: pointer;" &_
			"}" &_
			"</style>" &_
			"</head>" &_
			"<body>" &_
			"<h1> Liste radiopads non rendus" & DateToday & "</h1>" &_
			"<table class='tab_search avectri'>" &_
			"<thead>" &_
				"<tr class='th'>" &_
					"<th class='entete selection' data-tri='1' data-type='num'> Code utilisateur </th>" &_
					"<th class='entete'> Nom </th>" &_
					"<th class='entete'> Prenom </th>" &_
					"<th class='entete'> Code radiopad </th>" &_
					"<th class='entete'> Date pr?t </th>" &_
				"</tr>" &_
			"</thead>"


	'Recuperation de la liste des radiopads non rendus en base de donnees'
	'---------------------------------------------------------------------------------------------------------------'
	If Id_magasin <> "NULL" Then
		rs.open "SELECT * FROM `prets` WHERE `date_retour` = '0000-00-00 00:00:00' AND `id_magasin` = " & Id_magasin & " ORDER BY `date_pret` DESC" , cn , 3
		wscript.echo "SELECT * FROM `prets` WHERE `date_retour` = '0000-00-00 00:00:00' AND `id_magasin` = " & Id_magasin & " ORDER BY `date_pret` DESC"

		while rs.EOF=false
			message = message & "<tr>"

			Id_utilisateur = rs(1)
			Id_radiopad = rs(2)
			Date_pret = rs(3)

		  	rs_un.open "SELECT * FROM `utilisateurs` WHERE `id` =" & Id_utilisateur & " AND `id_magasin` = " & Id_magasin , cn , 3

		  	'Recuperation des informations de utilisateur'

		  	while rs_un.EOF=false
		  		Nom = rs_un(1)
		  		Prenom = rs_un(2)
		  		Non_rendu = rs_un(5)
		  		Non_rendu = Non_rendu + 1
		  		rs_un.MoveNext

		  	Wend

		  	rs_un.close

		  	'Met a jour son nombre de prets non rendus en fin de journee'
		  	rs_un.open "UPDATE `utilisateurs` SET  `non_rendu` = " & Non_rendu & " WHERE `id` = " & Id_utilisateur & " AND `id_magasin` = " & Id_magasin , cn , 3


	  		message = message & "<td class='color'>" & Id_utilisateur & "</td>"
			message = message & "<td class='color'>" & Nom & "</td>"
			message = message & "<td class='color'>" & Prenom & "</td>"
			message = message & "<td class='color'>" & Id_radiopad & "</td>"
			message = message &"<td class='color'>" & Date_pret & "</td>"
			message = message & "</tr>"


		  	rs.MoveNext
		Wend

		message = message & "</tr>"
		message = message & "</tbody>"
		message = message & "</table></body></html>"

		'Fermeture du resultat de la requette'
		rs.close


		'Preparation pour lenvoi du mail'
		'---------------------------------------------------------------------------------------------------------------'
		Sujet = "Liste radiopads non rendus" & DateToday
		From = "hyperpad" & Nom_societe & "@gbh.fr"

		Set mail = CreateObject("CDO.Message")
		mail.From = From
		mail.To = Mail_admin
		mail.Subject = Sujet
		mail.HTMLBody = message
		mail.Configuration.Fields.Item _
		("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
		mail.Configuration.Fields.Item _
		("http://schemas.microsoft.com/cdo/configuration/smtpserver") = "smtp.gbh.net"
		mail.Configuration.Fields.Item _
		("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25
		mail.Configuration.Fields.Update
		mail.Send

	End If

	'wscript.echo "Script Terminee"'

	send_mail = true
End Function


'---------------------------------------------------------------------------------------------------------------'
'Fermeture de la connexion'
cn.close