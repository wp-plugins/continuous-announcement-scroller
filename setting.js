/*
##########################################################################################################
###### Project   : Continuous announcement scroller  												######
###### File Name : setting.js                   													######
###### Purpose   : This javascript is to authenticate the form.  									######
###### Created   : Aug 30th 2010                  													######
###### Modified  : Aug 30th 2010                  													######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                        					######
###### Link      : http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/        ######
##########################################################################################################
*/


function cas_submit()
{
	if(document.form_mt.cas_text.value=="")
	{
		alert("Please enter the message.")
		document.form_mt.cas_text.focus();
		return false;
	}
	else if(document.form_mt.cas_link.value=="")
	{
		alert("Please enter the link.")
		document.form_mt.cas_link.focus();
		return false;
	}
	else if(document.form_mt.cas_status.value=="")
	{
		alert("Please select the display status.")
		document.form_mt.cas_status.focus();
		return false;
	}
	else if(document.form_mt.cas_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.form_mt.cas_order.focus();
		return false;
	}
	else if(isNaN(document.form_mt.cas_order.value))
	{
		alert("Please enter the display order, only number.")
		document.form_mt.cas_order.focus();
		return false;
	}
	_cas_escapeVal(document.form_mt.cas_text,'<br>');
}

function _cas_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_hsa.action="options-general.php?page=continuous-announcement-scroller/content-management.php&AC=DEL&DID="+id;
		document.frm_hsa.submit();
	}
}	

function _cas_redirect()
{
	window.location = "options-general.php?page=continuous-announcement-scroller/content-management.php";
}

function _cas_escapeVal(textarea,replaceWith)
{
textarea.value = escape(textarea.value) //encode textarea strings carriage returns
for(i=0; i<textarea.value.length; i++)
{
	//loop through string, replacing carriage return encoding with HTML break tag
	if(textarea.value.indexOf("%0D%0A") > -1)
	{
		//Windows encodes returns as \r\n hex
		textarea.value=textarea.value.replace("%0D%0A",replaceWith)
	}
	else if(textarea.value.indexOf("%0A") > -1)
	{
		//Unix encodes returns as \n hex
		textarea.value=textarea.value.replace("%0A",replaceWith)
	}
	else if(textarea.value.indexOf("%0D") > -1)
	{
		//Macintosh encodes returns as \r hex
		textarea.value=textarea.value.replace("%0D",replaceWith)
	}
}
textarea.value=unescape(textarea.value) //unescape all other encoded characters
}