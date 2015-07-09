/*if (document.addEventListener) {
	document.addEventListener("DOMContentLoaded", init, false);
}*/

window.onload = init;

// These are global so I can refer to the same thing across multiple functions, but are not meant to be constant. In the future, if I can figure out how to pass these along by reference, I will probably switch to doing that instead.
var form = null;



function init()
{
	// Keeps track of the form on the page.
	form = document.mainform;
	
	// Checkout and Checkin have similar functions, but are different because of the form elements they interact with.
	form.onsubmit = checkdate;
}



function checkdate()
{
	var monthAgo = oneMonthAgo();
	var error = false;
	var errorText = "";
	var timestamp = form.timestamp.value.replace("-","","g") + "000000";
	
	if (timestamp < monthAgo)
		return true;
	
	errorText += "You need to keep at least the last month's worth of records.";
	checkValidity(true,form.timestamp);
	alert(errorText)
	return false;
}



function oneMonthAgo()
{
	var current = new Date();
	var year = "" + current.getFullYear(),
		month = ((current.getMonth() + 1) < 10) ? "0" + (current.getMonth() + 1) : "" + (current.getMonth() + 1),
		day = (current.getDate() < 10) ? "0" + current.getDate() : "" + current.getDate(),
		hour = (current.getHours() < 10) ? "0" + current.getHours() : "" + current.getHours(),
		minute = (current.getMinutes() < 10) ? "0" + current.getMinutes() : "" + current.getMinutes(),
		second = (current.getSeconds() < 10) ? "0" + current.getSeconds() : "" + current.getSeconds();
	
	if (month > 1)
		month = "" + (month - 1);
	else
	{
		month = "" + 12;
		year = "" + (year - 1);
	}
	
	month = (month < 10) ? "0" + month : month;
	
	return year + month + day + hour + minute + second;
}



function checkValidity(error, item)
{
	if (error)
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
