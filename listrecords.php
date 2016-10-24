<?php
	ini_set('display_errors',1); 
	error_reporting(E_ALL);
	$page_title = 'List Current Records';
	include_once('include/page_begin.php');
?>
	<h2>Generate New Files</h2>

	<p>This button will extract the records from this page into *.dat files, then 
	flag them in the database. Please <strong>do not generate a new file</strong> if all 
	you want to do is view <a href="listfiles.php" target="_blank">previously generated 
	files</a> from an older date. After the file is generated, follow the instructions
        on the <a href="/listfiles.php">List Generated Files</a> page.</p>

	<form action="extract.php" id="mainform" method="POST" name="mainform">
		<input type="hidden" id="library" name="library" value="MILLAR" />
		<input class="middlesubmit" type="submit" value="Generate Files" />
	</form>

	<h2>Current Unsaved Data</h2>

	<table>
		<thead>
	        <tr>
                <th>Date</th>
                <th>Return/Loan</th>
                <th>Item Barcode</th>
                <th>Patron Barcode</th>
	        </tr>
		</thead>
		
		<tbody>
			<?php
				include_once('include/variables.php');
				
				$library = '%';
				$db_select = $DB->prepare($DB_SELECT_STRING);
				$db_select->bind_param('s', $library);
				$db_select->execute();
				$db_select->store_result();
				$db_select->bind_result(
					$row['library'], $row['timestamp'], 
					$row['return_or_loan'], $row['item_barcode'], 
					$row['item_callnumber'], $row['patron_barcode'], 
					$row['patron_name'], $row['saved']
				);
				
				while ($db_select->fetch())
				{
					echo '<tr>';
					
					foreach ($row as $key => $item)
					{
						if ($key != 'saved')
						{
							if ($key == 'item_barcode' || $key == 'patron_barcode' || $key == 'timestamp' || $key == 'return_or_loan')
							{
								if ($item != '')
									echo '<td>' . $item . '</td>';
								else
									echo '<td></td>';
							}
						}
					}
					
					echo "</tr>\n\t\t\t\t";
				}
			?>
		</tbody>
	</table>
<?php
	include_once('include/page_end.php');
?>
