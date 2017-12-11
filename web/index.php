<html>
	<head>
		<title>Ricerca ristorante</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script>
			function controllo()
			{
				var numero=document.getElementById("limite").value;
				var ok=false;
				if(document.getElementById("limite").value!=""&&document.getElementById("citta").value!=""&&document.getElementById("query").value!="")
					if(parseInt(numero)<51)
						ok=true;
				return ok; 
			}
		</script>
	</head>
	<font size="6">Pagina per la ricerca di un ristorante:</font><br />
	<body>
		<?php
		    //Imposto i campi di ricerca di default
			if(isset($_POST["limite"]))
				$limite=$_POST["limite"];
			else
				$limite=15;
			if(isset($_POST["citta"]))
				$citta=$_POST["citta"];
			else
				$citta="Bergamo";
			if(isset($_POST["query"]))
				$query=$_POST["query"];
			else
				$query="Pizzeria";
			
			//Form ddei dati di ricerca
			echo "<form id='forma' method='post' onsubmit='return controllo();'>";
			echo " Numero elementi (da 1 a massimo 50):<input type='text' value='$limite' name='limite'id='limite' /><br/>";
			echo " Citta: <input type='text' value='$citta' name='citta' id='citta' /><br/>";
			echo " Tipologia del locale: <input type='text' value='$query' name='query' id='query' /><br/>";
			echo " <input type='submit' value='Aggiorna tabella' class='btn'/>";
			echo "</form>";
			//Salvo il link di richiestain una variabile
		  	//$indirizzo="https://api.foursquare.com/v2/venues/search?v=20161016&query=$query&limit=$limite&intent=checkin&client_id=3AGUTWIPEQWCBRFCAHIN104WCY0IAPETGLTQIJUDP0JMIC5W&W&client_secret=NH1JI30DQ4YSF5PBSWMCTGPWLHBR1Z11VHYI5ELMV2MNAXNV&near=$citta";
		    	$indirizzo="https://api.foursquare.com/v2/venues/search?v=20161016&query=$query&limit=$limite&intent=checkin&client_id=4DLLUZVXJEQIL0DFCN3B3YFG4EN4W4DMICUVPSNMRD24XKVU&W&client_secret=ZWWMV4LSNXGTZIRIUWHGE5PQDESQ0AHBACUPXVDPTESUTLRX&near=$citta";
			//curl_init inizializza una nuova sessione che gestirò con la funzione curl_setopt
			$ch = curl_init() or die(curl_error());
			//CURLOPT_URL setta l'indirizzo
			curl_setopt($ch, CURLOPT_URL,$indirizzo); 
			//CURLOPT_RETURNTRANSFER per restituire il trasferimento come una stringa
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//curl_exec restituisce true in caso di successo, altrimenti false
			$json=curl_exec($ch) or die(curl_error());
		        //json_decode converte da json in una variabile PHP
			$dati = json_decode($json);

			//Creo la tabella dove venrrano visualizzate le informazioni
			echo('<table id="customers" align="center">
			  <tr>
				<th>Nome</th>
				<th>Latitudine</th>
				<th>Longitudine</th>
			  </tr>');
			for($i=0; $i<$limite; $i++)
			{	
				echo "<tr><td>";
				echo $dati->response->venues[$i]->name;
				echo "</td><td>";
				echo $dati->response->venues[$i]->location->lat;
				echo "</td><td>";
				echo $dati->response->venues[$i]->location->lng;
				echo "</td></tr>";
			}
			echo "</table>";
			echo curl_error($ch);
			curl_close($ch);	
		?>
	</body>
</html>
