/**
 *     Continuous announcement scroller
 *     Copyright (C) 2011 - 2013 www.gopiplus.com
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

