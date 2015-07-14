<?php
	include_once('include/variables.php');
	include_once('include/functions.php');
	
	// These str_replace() commands are a weak prevention mechanism against SQL attacks, but also prevent bugs with names like "O'Hara".
	$textarea = str_replace('\'','',$_POST['textarea']);
	$textarea = str_replace('"','',$textarea);
	
	$csv = parse_csv($textarea);
	
	foreach ($csv as $line)
	{
		if ($line[0] != '')
		{
			$db_insert = $DB->prepare($DB_INSERT_STRING);
			$db_insert->bind_param('sssssss', $line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6]);
			$db_insert->execute();
		}
	}

	header('Location: index.php');
?>
