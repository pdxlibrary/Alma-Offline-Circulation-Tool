<?php
	//ini_set('display_errors', 1);
	//error_reporting(E_ALL);
	$scripts = 'index.js';
	include_once('include/page_begin.php');
?>
	<form action="append.php" id="mainform" method="POST" name="mainform">
		<div id="users">
			<input type="hidden" id="library" name="library" value="MILLAR" />
			<div class="left">
				<h2>Check Out</h2>
				<label for="patronBarcode">Patron Barcode</label><input id="patronBarcode" name="patronBarcode" type="text" /><br />
				<label for="itemBarcode">Item Barcode</label><input id="itemBarcode" name="itemBarcode" type="text" /><br />
				<input class="button" id="checkoutbutton" name="checkoutbutton" type="button" value="Add Item" />
			</div>
			<div class="right">
				<h2>Check In</h2>
				<label for="itemBarcode2">Item Barcode</label><input id="itemBarcode2" name="itemBarcode2" type="text" /><br />
				<input class="button" id="checkinbutton" name="checkinbutton" type="button" value="Add Item" />
			</div>
			<div style="clear:both;"><input class="submit" type="submit" value="Submit Records" /></div>
		</div>
		<div class="debug">
			<h2>Transaction Log</h2>
			<p>
			This is a list of transactions awaiting submission. Until you click submit, these transactions are temporary and will vanish if the browser is closed or crashes.
			<br />
			<i>Remember to submit regularly while we are offline.</i>
			</p>
			<label for="textarea" style="visibility:hidden; width:0 !important;">Text Area</label><textarea id="textarea" name="textarea" readonly rows="8" cols="80"></textarea>
		</div>
	</form>
	<p>After the outage is over, one person must <a href="/listrecords.php">generate an offline transaction file</a> and upload it to Alma.</p>
<?php
	include_once('include/page_end.php');
?>
