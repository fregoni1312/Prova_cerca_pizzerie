<html>
	<head>
		<title>Ricerca ristorante</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script>
			function controllo()
			{
				var numero=document.getElementById("limite").value;
				var ok=false;
				var verifica=/^\d{1,2}$/
				if(document.getElementById("limite").value!=""&&document.getElementById("citta").value!=""&&document.getElementById("query").value!="")
					if(numero.match(verifica)&&parseInt(numero)<51)
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
			///echo "<form id='forma' method='post' onsubmit='return controllo();'>";
			echo " Numero elementi (da 1 a massimo 50):<input type='text' value='$limite' name='limite'id='limite' />";
			echo " Citta: <input type='text' value='$citta' name='citta' id='citta' />";
			echo " Tipologia del locale: <input type='text' value='$query' name='query' id='query' /><br/>";
			echo " <input type='submit' value='Aggiorna tabella' class='btn' onclick='return controllo();'/>";
			////echo "</form>";
			//Salvo il link di richiestain una variabile
	       // $indirizzo="https://api.foursquare.com/v2/venues/search?v=20161016&query=$query&limit=$limite&intent=checkin&client_id=YVMN1NGHAW4DWINOY2BHBVQTGR0RG01D4EVZ3Z3TPRN5EBE2&W&client_secret=GYRAVQCTVV5DUYI3J3OH2GKLQN5S2LEA0QIGECJ1MUFBTX2X&near=$citta";
		  //$indirizzo="https://api.foursquare.com/v2/venues/search?v=20161016&query=$query&limit=$limite&intent=checkin&client_id=3AGUTWIPEQWCBRFCAHIN104WCY0IAPETGLTQIJUDP0JMIC5W&W&client_secret=NH1JI30DQ4YSF5PBSWMCTGPWLHBR1Z11VHYI5ELMV2MNAXNV&near=$citta";
		$indirizzo="https://api.foursquare.com/v2/venues/search?v=20161016&query=$query&limit=$limite&intent=checkin&client_id=4DLLUZVXJEQIL0DFCN3B3YFG4EN4W4DMICUVPSNMRD24XKVU&W&client_secret=ZWWMV4LSNXGTZIRIUWHGE5PQDESQ0AHBACUPXVDPTESUTLRX&near=$citta";
			$ch = curl_init() or die(curl_error());
			curl_setopt($ch, CURLOPT_URL,$indirizzo);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$json=curl_exec($ch) or die(curl_error());
			$dati = json_decode($json);

			echo('<table id="customers" align="center">
			  <tr>
				<th>Nome</th>
				<th>Latitudine</th>
				<th>Longitudine</th>
			  </tr>');
			for($i=0; $i<$limite; $i++)
			{	
				echo "<tr>";
					echo "<td>";
					echo $dati->response->venues[$i]->name;
					echo "</td>";
					echo "<td>";
					echo $dati->response->venues[$i]->location->lat;
					echo "</td>";
					echo "<td>";
					echo $dati->response->venues[$i]->location->lng;
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo curl_error($ch);
			curl_close($ch);	
		?>
	</body>
</html>
