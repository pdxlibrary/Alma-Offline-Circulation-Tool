<?php
	// Including the configuration file from the variables file reduces include statements in the rest of the code because literally every page needs this at some point in time.
	
	include_once('include/configuration.php');
	
	// This array is used to fill in the first row of the spreadsheet, and can also be useful for keeping track of the order of items in the database.
	
	$FIRST_ROW = array(
		'Library',
		'Date/Time',
		'Return or Loan',
		'Item Barcode',
		'Item Call Number',
		'Patron Barcode',
		'Patron Name'
	);
	
	// This database connection is used extensively enough to warrant just putting it here for easy access.
	
	$DB = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
	
	// These are strings with which to prepare statements for the database tasks that we expect need to be performed during regular usage.
	
	$DB_INSERT_STRING = "INSERT INTO $DB_TABLE VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
	$DB_SELECT_STRING = "SELECT * FROM $DB_TABLE WHERE saved = 0 AND library LIKE ?";
	$DB_SELECT_DATE_STRING = "SELECT * FROM transactions WHERE timestamp LIKE ?";
	$DB_SAVED_STRING  = "UPDATE $DB_TABLE SET saved = 1 WHERE timestamp = ? AND item_barcode = ?";
	$DB_DELETE_STRING = "DELETE QUICK FROM $DB_TABLE WHERE saved = 1 AND timestamp LIKE ?";
?>
