<?php	
	include_once('include/variables.php');
	$page_title = 'Download or Delete';
	include_once('include/page_begin.php');
	
	if(isset($_POST['action'])) {
		if($_POST['action'] == 'delete') {
			$filename = '';
			if(isset($_POST['file'])) {
				foreach($_POST['file'] as $filename) {
					$file_strings = preg_split('/_/', $filename);
					/* extracting from the filename in this way in case there is a '_' in the path to the 'output' folder */
					$delete_time = $file_strings[count($file_strings) - 2];
					echo "<p>Deleting data from $delete_time...</p>\n";

					if(!unlink($filename)) {
						echo "<h3>Failure deleting file " . $filename . ". Please contact <a href=\"mailto:" . $CONTACT_EMAIL . "\">" . $CONTACT_NAME . "</a>.</h3>\n";
					} else {
						echo "<p>Successfully deleted " . $filename . ".</p>\n";
					}

					if($db_select = $DB->prepare($DB_DELETE_STRING)) {
						$query_delete_time = $delete_time . " %";
						$db_select->bind_param('s', $query_delete_time);
						$db_select->execute();
						echo "<p>Successfully purged transaction records from " . $delete_time . ".</p>\n";
					} else {
						echo "<p>Error purging records from " . $delete_time . ".</p>\n";
					}
					$db_select->close();
				}
			}
		}
	}

	include_once('include/page_end.php');
?>
