set cn = CreateObject("ADODB.Connection")
set rs = CreateObject("ADODB.Recordset")
set rs1 = CreateObject("ADODB.Recordset")
set rs2 = CreateObject("ADODB.Recordset")



connectionString = "Driver={MySQL ODBC 5.3 ANSI Driver};Server=10.50.91.89; Data Source=prets; Database=new_hyp_mag_fic; User=radiopad; Password=radiopad;"
cn.Open connectionString

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
				"<th class='entete'> Date prêt </th>" &_
			"</tr>" &_
		"</thead>"


'Récupération des paramètres en base de données'
'---------------------------------------------------------------------------------------------------------------'
rs.open "SELECT * FROM `parametres`" , cn , 3

Id_magasin = "NULL"
Nom_societe = "NULL"
Departement = "NULL"
Alias_magasin = "NULL"
Mail_admin = "NULL"


while rs.EOF=false

  Id_magasin = rs(1)
  Nom_societe = rs(2)
  Departement = rs(3)
  Alias_magasin = rs(4)
  Mail_admin = rs(5)

  rs.MoveNext
Wend

'Fermeture du résultat de la requette'
rs.close


'Récupération de la liste des radiopads non rendus en base de données'
'---------------------------------------------------------------------------------------------------------------'
If Id_magasin <> "NULL" Then
	rs.open "SELECT * FROM `prets` WHERE `date_retour` = '0000-00-00 00:00:00' AND `id_magasin` = " & Id_magasin & " ORDER BY `date_pret` DESC" , cn , 3


	while rs.EOF=false
		message = message & "<tr>"

		Id_utilisateur = rs(1)
		Id_radiopad = rs(2)
		Date_pret = rs(3)

	  	rs1.open "SELECT * FROM `utilisateurs` WHERE `id` =" & Id_utilisateur & " AND `id_magasin` = " & Id_magasin , cn , 3

	  	'Récupération des informations de utilisateur'

	  	while rs1.EOF=false
	  		Nom = rs1(1)
	  		Prenom = rs1(2)
	  		Non_rendu = rs1(5)
	  		Non_rendu = Non_rendu + 1 
	  		rs1.MoveNext

	  	Wend

	  	rs1.close

	  	'Met à jour son nombre de prets non rendus en fin de journée'
	  	rs1.open "UPDATE `utilisateurs` SET  `non_rendu` = " & Non_rendu & " WHERE `id` = " & Id_utilisateur & " AND `id_magasin` = " & Id_magasin , cn , 3


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

	'Fermeture du résultat de la requette'
	rs.close


	'Préparation pour lenvoi du mail'
	'---------------------------------------------------------------------------------------------------------------'
	Sujet = "Liste radiopads non rendus" & DateToday
	From = "HyperPad" & Nom_societe & "@gbh.fr"

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



'---------------------------------------------------------------------------------------------------------------'
'Fermeture de la connexion'
cn.close

'wscript.echo "Script Terminee"'
