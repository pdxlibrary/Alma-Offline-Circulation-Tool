<?php
	if (isset($_POST['library']))
		if ($_POST['library'] != '---')
			$library = $_POST['library'];
		else
			$library = '%';
	else
		$library = null;

	include_once('include/variables.php');
	
	$db_select = $DB->prepare($DB_SELECT_STRING);
	$db_select->bind_param('s', $library);
	$db_select->execute();
	$db_select->store_result();
	
	$db_select->bind_result($row['library'], $row['timestamp'], $row['return_or_loan'], $row['item_barcode'], $row['item_callnumber'], $row['patron_barcode'], $row['patron_name'], $row['saved']);
	$db_select->fetch();
	
	if($row['timestamp'] != '')
	{
        // If the $library is null, we should not proceed to extract anything... 
        // The error for this check is broken though.
		if ($library)
		{
            // Either the library is '---' and we should grab everything, 
            // or it is set and we should use that information. The files 
            // should have branch information if applicable.
			$datetime = strftime('%F_%H%M%S');
			
			if ($library != '%')
			{
				$dat = fopen('output/' . $_POST['library'] . '_' . $datetime . '.dat', 'w');
			}
			else
			{
				$dat = fopen('output/' . $datetime . '.dat', 'w');
			}
			
			if ($dat)
			{
				do
				{
                    $timestamp = new DateTime($row['timestamp']);
                    $alma_string = $timestamp->format("YmdHi") . $row['return_or_loan'] . $row['item_barcode'];
                    /* YYYYMMDDHHmm is 12 characters, L/R is one more, then there are 80 characters for 
                     * the barcode as a fixed width. If the barcode is not that long, spaces are added 
                     * to the end of it until it is. 12 + 1 + 80 = 93.
                     */
					$alma_string = str_pad($alma_string,93);	
					
					if ($row['patron_barcode'] != '')
						$alma_string .= $row['patron_barcode'];
					
					$alma_string .= "\r\n";
					
					if ($row['timestamp'] != '')
					{
						fwrite($dat, $alma_string);
						
						$db_saved = $DB->prepare($DB_SAVED_STRING);
						$db_saved->bind_param('ss', $row['timestamp'], $row['item_barcode']);
						$db_saved->execute();
					}
				}
				while ($db_select->fetch());
				
				fclose($dat);
			}
			else
			{
                ?> <p>ERROR! Something failed to open.</p> <?php
                exit();
				$errors = 'We had an error with opening the files, so they have not been written.';
			}
		}
		else
		{
			// For some reason, this error is broken.
			$errors = 'The \'library\' variable was never set.';
		}
	}
	
	$page_title = 'Extract Records';
	include_once('include/page_begin.php');
?>
    <p>This page should have just extracted all current records (verifiable on 
    the <a href="listrecords.php">record-listing page</a>, which should now 
    be empty). You can get to your files, listed from newest to oldest, at the 
    page for <a href="listfiles.php">viewing previously generated files</a>.</p>
<?php
	if (isset($errors)) echo "<div class=\"errors\"><h2>Errors</h2><p>$errors</p></div>";

	include_once('include/page_end.php');
?>
