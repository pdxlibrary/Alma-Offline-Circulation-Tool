<?php
	// These variables impact the text on various pages. Most notably, the footer text is here because that might be unique to a given organization (unlike body text, which is often instructions for the page).
	
	$MAIN_TITLE    = 'Offline Circulation Thingy';
	$CONTACT_NAME  = 'Technical Support';
	$CONTACT_EMAIL = 'human@example.edu';
	$FOOTER_TEXT   = "<p>This string should include tags, probably mention $CONTACT_NAME, and maybe have a link to some <a href=\"mailto:$CONTACT_EMAIL\">$CONTACT_EMAIL</a> for problem reporting.</p>";
	
	// This is an array of the possible locations one could be circulating at. The first entry is blank on purpose to force people to pick a location (helps with accuracy of records). We learned the hard way that uploading one big file to Alma causes a lot of "In Transit" items for items that go to not the desk that uploaded the file, so this is handy to generate separate files for each desk to avoid that issue.
	
	$LIBRARIES_ARRAY = array(
		'---' => 'Choose a Library',
		'aaa' => 'AAA Library',
		'gsh' => 'Global Scholars Hall',
		'kni' => 'Knight Library',
		'law' => 'Law Library',
		'mat' => 'Math Library',
		'oim' => 'OIMB Library',
		'pdx' => 'Portland Library',
		'sci' => 'Science Library'
	);
	
	// Below is the structure of the database table being used, and some variables for connecting to the database. It is admittedly simplistic, being just a single flat table that is mostly in database form instead of flat file form to handle multiple people submitting at once from different places in a stable fashion.
	
	/************************************************************************************
	* Database Structure                                                                *
	* char[3] | char[14] | char[1] | char[20] | char[48] | char[20] | char[48] | bit[1] *
	* library | datetime | retorlo | itmbarcd | itmcalnm | ptrbarcd | ptrname  | saved  *
	************************************************************************************/
	
	$DB_SERVER   = 'server';
	$DB_USERNAME = 'user';
	$DB_PASSWORD = 'password';
	$DB_NAME     = 'database';
	$DB_TABLE    = 'table';
?>
