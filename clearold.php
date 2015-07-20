<?php
	$page_title = 'Delete Files and Records';
	include_once('include/page_begin.php');
?>
	<form action="deleteold.php" id="mainform" method="POST" name="mainform">
		<p>
		<?php
			$DIR = './output';
			$DIR_CONTENTS = array_diff(scandir($DIR), array('..','.','.gitinclude'));
			rsort($DIR_CONTENTS);
			
			foreach($DIR_CONTENTS as $item)
			{
				$path = "output/$item";
				$filesize = filesize($path);
				$delete_time = explode('_', $item);
				echo "<input type=\"checkbox\" name=\"file[]\" value=\"$path\" /><a href=\"$path\">$delete_time[1]</a><br />\n";
			}
		?>
		</p>
		<input class="middlesubmit" type="submit" value="Delete" />
	</form>
<?php
	include_once('include/page_end.php');
?>
