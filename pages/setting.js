/**
 *     Continuous announcement scroller
 *     Copyright (C) 2011 - 2014 www.gopiplus.com
 *     http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function _cas_submit()
{
	if(document.cas_form.cas_text.value=="")
	{
		alert("Please enter the announcement.")
		document.cas_form.cas_text.focus();
		return false;
	}
	else if(document.cas_form.cas_link.value=="")
	{
		alert("Please enter the link.")
		document.cas_form.cas_link.focus();
		return false;
	}
	else if(document.cas_form.cas_status.value=="")
	{
		alert("Please select the display status.")
		document.cas_form.cas_status.focus();
		return false;
	}
	else if(document.cas_form.cas_order.value=="")
	{
		alert("Please enter the display order, only number.")
		document.cas_form.cas_order.focus();
		return false;
	}
	else if(isNaN(document.cas_form.cas_order.value))
	{
		alert("Please enter the display order, only number.")
		document.cas_form.cas_order.focus();
		return false;
	}
	_cas_escapeVal(document.cas_form.cas_text,'<br>');
}

function _cas_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.frm_cas_display.action="options-general.php?page=continuous-announcement-scroller&ac=del&did="+id;
		document.frm_cas_display.submit();
	}
}	

function _cas_redirect()
{
	window.location = "options-general.php?page=continuous-announcement-scroller";
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

function _cas_help()
{
	window.open("http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/");
}

function _casNoEnterKey(e)
{
    var pK = e ? e.which : window.event.keyCode;
    return pK != 13;
}
document.onkeypress = _casNoEnterKey;
if (document.layers) document.captureEvents(Event.KEYPRESS);