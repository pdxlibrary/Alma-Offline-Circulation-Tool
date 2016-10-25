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
                        <p>After downloading:
                                <ol>
                                        <li>Switch to Alma</li>
                                        <li>Alma Menu &gt; Fulfillment &gt; Advanced Tools &gt; Offline Circulation</li>
                                        <li>Click the file folder and select the file you just downloaded. <br />
                                            <img src="images/instructions-1.jpg"></li>
                                        <li>Click the Upload and Validate File Content button.</li>
					<li>When the status displays as completed, it will show how many "entities" finished and failed. For "entities failed" select the view button.</li>
                                </ol>
                        </p>
<?php
	include_once('include/page_end.php');
?>
