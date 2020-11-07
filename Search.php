<!--
Guardian Analyser
Sub-Domain
Search-form & Results page

Copyright (C) 2013 Billy Lim Jun Ming
Licensed under GNU GPL
-->

<!DOCTYPE html>
<html>
<head>
    <title>Guardian Headline Analyser</title>
    <link rel="stylesheet" href="guardian_analyser.css">
</head>
<body><div id='container'>  
    <div id='header'>
    	<img src='img/Guardian_Analyser_Logo.jpg' alt='Guardian Analyser'></img>
	</div>
	<div class='line-seperator'></div>
	<ul id='navbar'>
		<li><a href='index.php'>Intro</a></li>
		<li class='current_page'>Search</li>
	</ul>
	<div class='line-seperator'></div>

	<div id='content'>
		<form id='search-form'>
			<div id='search-left'>
				<h4 class='search-field'>Search:</h4></br>
				<input type="text" name='query' placeholder='Search Query'></br></br>

				<h4 class='search-field'>Date:</h4></br>
				<input type="text" placeholder='From (YYYY-MM-DD)' name='from-date' class="auto-kal" data-kal="format:'YYYY-MM-DD'"></br>
				to</br>
				<input type="text" placeholder='To (YYYY-MM-DD)' name='to-date' class="auto-kal" data-kal="format:'YYYY-MM-DD'"></br></br>
	
				<h4 class='search-field'>Sort By:</h4></br>
				<input type="radio" name='order-by' value='newest' CHECKED/>Newest
				<input type="radio" name='order-by' value='oldest'>Oldest</br></br>
			</div>
			<div id='search-right'>
				<h4 class='search-field'>Section:</h4></br>
				<table id='sections-table'>
					<tr><td><input type="checkbox" name='section[]' value='business'>Business</td>
					<td><input type="checkbox" name='section[]' value='comment'>Comment</td>
					<td><input type="checkbox" name='section[]' value='culture'>Culture</td></tr>
					<tr><td><input type="checkbox" name='section[]' value='environment'>Environment</td>
					<td><input type="checkbox" name='section[]' value='lifeandstyle'>Life & Style</td>
					<td><input type="checkbox" name='section[]' value='money'>Money</td></tr>
					<tr><td><input type="checkbox" name='section[]' value='news'>News</td>
					<td><input type="checkbox" name='section[]' value='sport'>Sport</td>
					<td><input type="checkbox" name='section[]' value='tech'>Tech</td></tr>
					<tr><td><input type="checkbox" name='section[]' value='travel'>Travel</td>
					<td><input type="checkbox" name='section[]' value='tv'>TV</td></tr>
				</table></br>
				<div id='sections-note'>
					Note:</br> 
					This is not an exhaustive list of the sections.</br>
					Thus the unusual section name the results.</br>
					I apologise, but I cannot find a </br>
					complete list of all of Guardian's sections.
				</div>

				<h4 class='search-field'>Maximum No. of Articles:</h4></br>
				<input type="number" name='num' placeholder="Max Amount"></br></br>
			</div>
			<div id='search-submit'>
				<input type="submit" value='Submit'>
			</div>
		</form>
		<div id='results'></div>
	</div>
	
	<div id='buffer'></div>
	</div></body>
	<script src="includes/jquery.js"></script>
	<script src="includes/Moment.js"></script>
	<script src="includes/DatePicker/kalendae.js"></script> <link rel="stylesheet" href="includes/DatePicker/kalendae.css">
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="includes/FlotGraphs/excanvas.min.js"></script><![endif]-->
	<script src="includes/FlotGraphs/jquery.flot.js"></script>
	<script src="includes/FlotGraphs/jquery.flot.time.js"></script>
	<script src="includes/FlotGraphs/jquery.flot.pie.js"></script>
	<script src='js/Windows_Resize.js'></script>
	<script src="js/search.js"></script>
</html>