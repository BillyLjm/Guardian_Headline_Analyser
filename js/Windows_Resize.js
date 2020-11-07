/*
 * Guardian Analyser
 * Windows Resizer
 *
 * Adjust content height to fill page
 *
 * Copyright (C) 2013 Billy Lim Jun Ming
 * Licensed under GNU GPL
 */

// resize when first loading & when resizing window
$(document).ready(resize);
$(window).resize(resize);

function resize(){	
	$('#buffer').height(($(window).height() - $('#content').height() - 165) + "px"); 
};
