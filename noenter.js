/*
##########################################################################################################
###### Project   : Continuous announcement scroller  												######
###### File Name : noenter.js                   													######
###### Purpose   : This javascript is to hide enter key press from the page text box & text area.  	######
###### Created   : Aug 30th 2010                  													######
###### Modified  : Aug 30th 2010                  													######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                       					######
###### Link      : http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/        ######
##########################################################################################################
*/

function gopiNoEnterKey(e)
{
    var pK = e ? e.which : window.event.keyCode;
    return pK != 13;
}
document.onkeypress = gopiNoEnterKey;
if (document.layers) document.captureEvents(Event.KEYPRESS);
