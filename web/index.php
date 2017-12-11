<html>
	<head>
		<title>Ricerca ristorante</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script>
			function controllo_campi()
			{
				var valore=document.getElementById("lim").value;
				var esito=false;
				var verifica=/^\d{1,2}$/
				if(document.getElementById("lim").value!=""&&document.getElementById("cit").value!=""&&document.getElementById("que").value!="")
					if(valore.match(verifica)&&parseInt(valore)<51)
						esito=true;
				return esito;
			}
		</script>
	</head>
	<font size="6">Pagina per la ricerca di un ristorante</font><br />
	<body>
		<?php
			if(isset($_POST["lim"]))
			{
				$lim=$_POST["lim"];
			}
			else
			{
				$lim=15;
			}
			if(isset($_POST["cit"]))
			{
				$cit=$_POST["cit"];
			}
			else
			{
				$cit="Bergamo";
			}
			if(isset($_POST["que"]))
			{
				$que=$_POST["que"];
			}
			else
			{
				$que="Pizzeria";
			}
		/*
			echo "<form id='forma' method='post' onsubmit='return controllo_campi();'><br/>";
			echo "<table>";
			echo "<tr>";
			echo " <td>Numero elementi (1-50): </td><td><input type='text' value='$lim' name='lim'id='lim' /></td>";
			echo "</tr>";
			echo "<tr>";
			echo " <td>Citta: </td><td><input type='text' value='$cit' name='cit' id='cit' /></td>";
			echo "</tr>";
			echo "<tr>";
			echo " <td>Cosa stai cercando?: </td><td><input type='text' value='$que' name='que' id='que' /></td><br/>";
			echo "</tr>";
			echo "</table>";
			echo " <input type='submit' value='Aggiorna tabella' class='btn'/>";
			echo "</form>";*/
			
			echo('<form action="/action_page.php">
			    <label for="fname">Numero elementi (da 1 a massimo 50):</label>
			    <input type="text" id="lim" name="lim" value='$lim'>

			    <label for="lname">Citta</label>
			    <input type="text" id="cit" name="cit" value='$cit'>
			    
			    <label for="lname">Tipologia ristorante</label>
			    <input type="text" id="que" name="que" value='$que'>

			    <input type="submit" value="Submit">
			  </form>');
		/*
		echo('<form action="/action_page.php">
			    <label for="fname">Numero elementi (da 1 a massimo 50):</label>
			    <input type="text" id="lim" name="lim">

			    <label for="lname">Citta</label>
			    <input type="text" id="cit" name="cit" >
			    
			    <label for="lname">Tipologia ristorante</label>
			    <input type="text" id="que" name="que">

			    <input type="submit" value="Submit">
			  </form>');*/
	
			# Questo script chiama un'API e la inserisce in una tabella 
			# Indirizzo dell'API da richiedere
	                $indirizzo_pagina="https://api.foursquare.com/v2/venues/search?v=20161016&query=$que&limit=$lim&intent=checkin&client_id=YVMN1NGHAW4DWINOY2BHBVQTGR0RG01D4EVZ3Z3TPRN5EBE2&W&client_secret=GYRAVQCTVV5DUYI3J3OH2GKLQN5S2LEA0QIGECJ1MUFBTX2X&near=$cit";
		        //$indirizzo_pagina="https://api.foursquare.com/v2/venues/search?v=20161016&query=$que&limit=$lim&intent=checkin&client_id=3AGUTWIPEQWCBRFCAHIN104WCY0IAPETGLTQIJUDP0JMIC5W&W&client_secret=NH1JI30DQ4YSF5PBSWMCTGPWLHBR1Z11VHYI5ELMV2MNAXNV&near=$cit";
			# Codice di utilizzo di cURL
			# Chiama l'API e la immagazzina in $json
			$ch = curl_init() or die(curl_error());
			curl_setopt($ch, CURLOPT_URL,$indirizzo_pagina);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$json=curl_exec($ch) or die(curl_error());
			# Decodifico la stringa json e la salvo nella variabile $data
			$data = json_decode($json);
			# Stampa della tabella delle pizzerie.
			echo('<table id="customers" align="center">
			  <tr>
				<th>Nome/th>
				<th>Latitudine</th>
				<th>Longitudine</th>
			  </tr>');
			for($i=0; $i<$lim; $i++)
			{	
				echo "<tr>";
					echo "<td>";
					echo $data->response->venues[$i]->name;
					echo "</td>";
					echo "<td>";
					echo $data->response->venues[$i]->location->lat;
					echo "</td>";
					echo "<td>";
					echo $data->response->venues[$i]->location->lng;
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
			# Stampa di eventuali errori
			echo curl_error($ch);
			curl_close($ch);
			
			
		?>
	</body>
</html>
