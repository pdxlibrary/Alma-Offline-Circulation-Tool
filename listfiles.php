<?php
	ini_set('display_errors',1); 
	error_reporting(E_ALL);
	$page_title = 'List Generated Files';
	include_once('include/page_begin.php');
?>
			<p><a href="listrecords.php">Return to List Records</a></p>
			<p>Right-click, Save link as...</p>
			<ul>
				<?php
					$DIR = './output';
					$DIR_CONTENTS = array_diff(scandir($DIR), array('..','.','.gitinclude'));
					rsort($DIR_CONTENTS);
					
					foreach($DIR_CONTENTS as $item)
					{
						$path = "output/$item";
						$filesize = filesize($path);
						echo "<li><a href=\"$path\">$item</a> - $filesize Bytes</li>";
					}
				?>
			</ul>
<?php
	include_once('include/page_end.php');
?>
