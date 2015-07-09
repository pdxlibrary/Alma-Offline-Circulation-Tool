<?php
	$now = new DateTime('now');
	$oneMonthAgo = new DateTime('now');
	$oneMonthAgo->sub(new DateInterval('P1M'));
	
	$dt_string = 'N/A';
	$dt_string_formatted = 'N/A';
	if (isset($_POST['timestamp']))
	{
		$deletetime = date_create_from_format('Y-m-d', $_POST['timestamp']);
	}
	else
	{
		$deletetime = new DateTime('now');
		$deletetime->sub(new DateInterval('P3M'));
	}
	
	if ($deletetime !== False)
	{
		$dt_string = $deletetime->format('YmdHis');
		$dt_string_formatted = $deletetime->format('Y-m-d H:i:s');
		if ($deletetime < $oneMonthAgo)
		{
			include_once('include/variables.php');
			
			$db_delete = $DB->prepare($DB_DELETE_STRING);
			$db_delete->bind_param('s', $dt_string);
			$db_delete->execute();
			
                        // After removing all of those SQL entries, this next part should remove any 
                        // files whose filesystem timestamps are older than $deletetime. We are assuming 
                        // that files do not get "modified" when they are downloaded and stuff, so under 
                        // normal circumstances this value should be close to if not equal to the creation time.
			$DIR = substr(__FILE__, 0, strrpos(__FILE__, '/')) . '/output';
			$DIR_CONTENTS = array_diff(scandir($DIR), array('..','.','.gitinclude'));
			rsort($DIR_CONTENTS);
			
			foreach($DIR_CONTENTS as $item)
			{
				$filetime = date("YmdHis",filemtime($DIR . '/' . $item));
				
				if ($filetime < $deletetime->format('YmdHis'))
					unlink($DIR . '/' . $item);
			}
		}
		else
		{
			$errors = 'The time provided is too recent, please try again.';
		}
	}
	else
	{
		$errors = 'Something broke, possibly due to providing the time in an invalid format.';
	}
	
	
	
	$page_title = 'Delete Old Records';
	include_once('include/page_begin.php');
?>
                        <p>This page should have just deleted all records before 
                        <?php echo $dt_string_formatted; ?>. Your older files should 
                        also have been destroyed.</p>
<?php
	if (isset($errors)) echo "<div class=\"errors\"><h2>Errors</h2><p>$errors</p></div>";

	include_once('include/page_end.php');
?>
