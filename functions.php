<?php
	function inDatabase($queryEncoding, $queryDescription) {
		$query = sprintf("SELECT encoding, description FROM acronyms 
			WHERE encoding='%s';",
			mysql_real_escape_string($queryEncoding));
		$result = mysql_query($query);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$null = 0;
		while ($row = mysql_fetch_assoc($result)) {
			if ($row['description'] == $queryDescription) {
				$null++;
			}
		}
		if ($null == 0) {
			return FALSE;
		} else {
			return TRUE;
		}

		mysql_free_result($result);
	}
?>

<?php
	function populate($filename) {
		if ($handle = fopen($filename, "r")) {
			while ($data = fgetcsv($handle, ",")) {
				if (!inDatabase(strtolower($data[0]), strtolower($data[1]))) {
					$newElt = sprintf("INSERT INTO acronyms (encoding, description) 
						VALUES ('%s', '%s');",
						mysql_real_escape_string(strtolower($data[0])),
						mysql_real_escape_string(strtolower($data[1])));
					mysql_query($newElt);
				}
			}
			fclose($handle);
		} else { echo $handle; }
	}
?>