window.onload = init;

// This is a regular expression to pull the first set of numbers out of a patron barcode.
var PBCODE_REG_EXP = new RegExp(/\d+/);

// These are global so I can refer to the same thing across multiple functions, but are not meant to be constant. In the future, if I can figure out how to pass these along by reference, I will probably switch to doing that instead.
var form = null;
var formArray = null;
var formArray2 = null;



function init()
{
	form = document.mainform;
	
	/* These two arrays are just to let me do some for loops on the form elements. Since 
         * I was getting tired of adding a new if-else and looking at all of them, keeping 
         * these arrays here feels just a little bit easier.
         */
	formArray = {
		library: {
			value: "",
			error: "---",
			item: form.library,
			string: "Please select your Library\n"
		},
		itemBarcode: {
			value: "",
			item: form.itemBarcode,
			error: "",
			string: "Please provide a valid Item Barcode in Checkout\n"
		},
		patronBarcode: {
			value: "",
			item: form.patronBarcode,
			error: "",
			string: "Please provide a valid Patron Barcode or ID in Checkout\n"
		}
	};
	
	formArray2 = {
		library: {
			value: "",
			error: "---",
			item: form.library,
			string: "Please select your Library\n"
		},
		itemBarcode2: {
			value: "",
			item: form.itemBarcode2,
			error: "",
			string: "Please provide a valid Item Barcode in Checkin\n"
		}
	};
	
	/* Checkout and Checkin have similar functions, but are different because of 
         * the form elements they interact with.
         */
	form.checkoutbutton.addEventListener("click", checkout, false);
	form.checkinbutton.addEventListener("click", checkin, false);
	
	/* This prevents the [Enter] key from submitting, because 
         * barcode scanners end their input with an [Enter] key equivalent.
         */
	document.onkeypress = disableReturnKey;
}



function checkout()
{
	var now = rightNow();
	var string = "";
	var error = false;
	var errorText = "";
	
	for (var i in formArray)
	{
		formArray[i]["value"] = formArray[i]["item"].value.replace(",","");
	}
	
	if (PBCODE_REG_EXP.exec(formArray["patronBarcode"]["value"]))
		formArray["patronBarcode"]["value"] = PBCODE_REG_EXP.exec(formArray["patronBarcode"]["value"])[0];
	else
		formArray["patronBarcode"]["value"] = "";
	
	for (var i in formArray)
	{
		if (!validateField(formArray[i]["value"], formArray[i]["error"], formArray[i]["item"]))
		{
			errorText += formArray[i]["string"];
			error = true;
		}
	}
	
	if (error)
	{
		alert(errorText);
		return false;
	}
	
	string += formArray["library"]["value"] + "," + now + ',L,' + formArray["itemBarcode"]["value"] + "," + "," + formArray["patronBarcode"]["value"] + "," + "\n";
	form.textarea.value += string;
	form.itemBarcode.value = "";

	return false;
}



function checkin()
{
	var now = rightNow();
	var string = "";
	var error = false;
	var errorText = "";
	
	for (var i in formArray2)
	{
		formArray2[i]["value"] = formArray2[i]["item"].value.replace(",","");
	}
	
	for (var i in formArray2)
	{
		if (!validateField(formArray2[i]["value"], formArray2[i]["error"], formArray2[i]["item"]))
		{
			errorText += formArray2[i]["string"];
			error = true;
		}
	}
	
	if (error)
	{
		alert(errorText);
		return false;
	}
	
	string += formArray2["library"]["value"] + "," + now + ',R,' + formArray2["itemBarcode2"]["value"] + "," + ",,,\n";
	form.textarea.value += string;
	form.itemBarcode2.value = "";
	
	return false;
}



function disableReturnKey(evt, focus)
{
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	
	if ((evt.keyCode == 13) && (node.type=="text"))
	{
		return false;
	}
}



function rightNow()
{
	var current = new Date();
	var year = "" + current.getFullYear(),
		month = ((current.getMonth() + 1) < 10) ? "0" + (current.getMonth() + 1) : "" + (current.getMonth() + 1),
		day = (current.getDate() < 10) ? "0" + current.getDate() : "" + current.getDate(),
		hour = (current.getHours() < 10) ? "0" + current.getHours() : "" + current.getHours(),
		minute = (current.getMinutes() < 10) ? "0" + current.getMinutes() : "" + current.getMinutes(),
		second = (current.getSeconds() < 10) ? "0" + current.getSeconds() : "" + current.getSeconds();
	
	return year + month + day + hour + minute + second;
}



function validateField(text, wrong, item)
{
	if (text == wrong)
	{
		item.style.background = "#FFDFDF";
		item.style.border = "solid #BF0000";
		item.style.boxShadow = "0 0 .5em #FF8080";
		item.style.fontWeight = "bold";
		return false;
	}
	else
	{
		item.style.background = "";
		item.style.border = "";
		item.style.boxShadow = "";
		item.style.fontWeight = "";
		return true;
	}
}
