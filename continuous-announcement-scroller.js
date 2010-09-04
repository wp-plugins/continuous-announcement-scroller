/*
##########################################################################################################
###### Project   : Continuous announcement scroller  												######
###### File Name : continuous-announcement-scroller.js                   							######
###### Purpose   : This javascript is to scroll the announcement.  									######
###### Created   : Aug 30th 2010                  													######
###### Modified  : Aug 30th 2010                  													######
###### Author    : Gopi.R (http://www.gopiplus.com/work/)                       					######
###### Link      : http://www.gopiplus.com/work/2010/09/04/continuous-announcement-scroller/        ######
##########################################################################################################
*/
	

function cas_scroll() {
	cas_obj.scrollTop = cas_obj.scrollTop + 1;
	cas_scrollPos++;
	if ((cas_scrollPos%cas_heightOfElm) == 0) {
		cas_numScrolls--;
		if (cas_numScrolls == 0) {
			cas_obj.scrollTop = '0';
			cas_content();
		} else {
			if (cas_scrollOn == 'true') {
				cas_content();
			}
		}
	} else {
		setTimeout("cas_scroll();", 10);
	}
}

var cas_Num = 0;
/*
Creates amount to show + 1 for the scrolling ability to work
scrollTop is set to top position after each creation
Otherwise the scrolling cannot happen
*/
function cas_content() {
	var tmp_vsrp = '';

	w_vsrp = cas_Num - parseInt(cas_numberOfElm);
	if (w_vsrp < 0) {
		w_vsrp = 0;
	} else {
		w_vsrp = w_vsrp%cas_array.length;
	}
	
	// Show amount of vsrru
	var elementsTmp_vsrp = parseInt(cas_numberOfElm) + 1;
	for (i_vsrp = 0; i_vsrp < elementsTmp_vsrp; i_vsrp++) {
		
		tmp_vsrp += cas_array[w_vsrp%cas_array.length];
		w_vsrp++;
	}

	cas_obj.innerHTML 	= tmp_vsrp;
	
	cas_Num 			= w_vsrp;
	cas_numScrolls 	= cas_array.length;
	cas_obj.scrollTop 	= '0';
	// start scrolling
	setTimeout("cas_scroll();", 2000);
}

