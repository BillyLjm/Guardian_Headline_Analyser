<!--
Guradian Analyser
Back-End
Result processor & Graph renderer

Copyright (C) 2013 Billy Lim Jun Ming
Licensed under GNU GPL
-->
<?php
	// If user entered this page wrongly, redirect to homepage 
	if($_SERVER["REQUEST_METHOD"] !== "POST")
	{
		header("Location: index.php"); 
		exit();
	}

	set_time_limit(3600); // set web app to time-out after 1hr

	// saves variables from 'search.js'
	$url_orig = $_POST['url'];
	$num = $_POST['num'];
	$order = $_POST['order'];
		
	// load search results for 1st time
	$results = json_decode(file_get_contents("$url_orig"), true);

	// if no max num given or num given is too large, sets number to total number of articles
	$tot_num = $results['response']['total'];
	if(empty($num) || $num > $tot_num)
		$num = $tot_num;
	$num_print = $num; // for printing onto screen later

	$page_num = 1; // to count result page number
	$headlines = array(); // to save headlines, word by word
	$dates = array(); // to save article dates
	$sections = array(); // to save sections each article is in

	// while max number is yet to be reached
	while($num > 0)
	{
		// saves relevant parts of each headline
		foreach($results['response']['results'] as $result)
		{
			// saves headlines
			$punctuations = ["'s","'d",",",".","?",":",";","(",")"];
			$tmp = str_replace($punctuations, "", $result['webTitle']); // removes punctuations
			$tmp = str_replace("/", " ", $tmp); // change fron-slashes to spaces
			$tmps = explode(' ', $tmp); // split into words, according to spaces
			foreach($tmps as $tmp)
			{
				if(!ctype_upper($tmp)) // de-capitalise non-acronyms (acronyms = all capital letter)
					$tmp = strtolower($tmp);
				$headlines[] = $tmp; // save headline
			} // Note: stopwords removed later to save running time 

			// saves dates (up to its month)
			$dates[] = substr($result['webPublicationDate'], 0, 7); 

			// saves sections
			$sections[] = $result['sectionName']; 
				
			// updates num & stop if max number reached
			$num--;
			if($num === 0) break;
		}
		if($num === 0) break;

		// move to next page
		$page_num++;
		$url = $url_orig . "&page=$page_num";
		$results = json_decode(file_get_contents("$url"), true);
	}

	echo "<div class='line-seperator'></div>"; // create divider b/w search from & results

	// Analyse headlines
	$Hfrequency = array_count_values($headlines); // calculates & saves  frequency of each word
	$stopwords = file("includes/stopwords.txt"); // discount stopwords
	foreach($stopwords as $stopword) // discount stopwords
	{
		$stopword = trim($stopword);
		if(isset($Hfrequency["$stopword"]))
			unset($Hfrequency["$stopword"]);
	}
	arsort($Hfrequency, SORT_NUMERIC); // sort remaining words in descending order of frequency
	
	// Display headlines results
	echo" 
	<div class='results-title'>
	Most Common words
	</div>
	<table id='words-table'>";
	$i = 0;
	foreach($Hfrequency as $key => $value)
	{
		if($i % 5 === 0) echo "<tr>"; // new row every 5 words
		$number = $i + 1;
		echo "<td>$number. $key -- $value times</td>"; // actual output
		$i++;
		if($i % 5 === 0) echo "</tr>"; // new row every 5 words
		if($i >= 100) break;
	}
	echo
	"</table>";

	// create div for date's bar graph
	echo" 
	<div class='results-title'>
		Graph of Number of Articles</br>
		against Time
	</div>
	<div class='stats' id='date-graph'></div>"; 

	// Analyse dates & saves into appropriate format
	$Dfrequency = array_count_values($dates);
	date_default_timezone_set('Europe/London');
	$i = count($Dfrequency) - 1;
	foreach($Dfrequency as $key => $value)
	{
		$Dplot["$i"][] = strtotime("$key") * 1000;
		$Dplot["$i"][] = $value;
		$i--;
	}
		
	// Sort plot points from oldest to newest
	if($order === 'newest')
		$Dplot = array_reverse($Dplot);
		
	// to set start of x-axis to 15 days before earliest date
	$Dmin = $Dplot[0][0]; 
?>

<!-- Render bar graph for dates -->
<script type="text/javascript">
	// save plot points in appropraite format
	var points = <?php echo json_encode($Dplot) ?>; 

	// set options for bar graph
 	var options = {
 		series: { bars: {
            show: true,
            barWidth: 30 * 24 * 60 * 60 * 1000 + 50000000, // 30-day month in milliseconds + some buffer
             align: 'center'
        }},
     	yaxis: {},
    	xaxis: { mode: "time",
    			timeformat: "%b %Y",
           		min: <?php echo "$Dmin" ?>,
           		minTickSize: [1, "month"]
		}
 	};

 	// plot graph
	$(document).ready(function () {
    	$.plot($("#date-graph"), [points], options);
	});
	</script>

<?php
	// create div for sections's pie chart
	echo" 
	<div class='results-title'>
		Proportion of Sections</br>
		from which articles originated from
	</div>
	<div id='section-label'></div>
	<div class='stats' id='section-graph'></div>"; 

	// Analyse sections
	$Sfrequency = array_count_values($sections);  // calculates & saves  frequency of each section
	arsort($Sfrequency, SORT_NUMERIC); // sort in descending order of frequency
	$i = 0;
	
	if(count($Sfrequency) > 15)
	{
		$others_section = 0; // to count instances of "others" sections

		foreach($Sfrequency as $key => $value)
		{
			// save most significant 14 sections
			if($i < 15) 
			{
				$Splot["$i"]['label'] = $key;
				$Splot["$i"]['data'] = $value;
			}
			
			// count instances of "others" sections
			else
			$others_section = $others_section + $value;

			$i++; // move to next data pair
		}
		
		// save data for "others" section
		$Splot[] = ['label' => 'Others', 'data' => $others_section];
	}
	
	// if there are <= 15 sections
	else
	{
		foreach($Sfrequency as $key => $value)
		{
			$Splot["$i"]['label'] = $key;
			$Splot["$i"]['data'] = $value;
			$i++; // move to next data pair
		}
	}
?>

<!-- Render pie chart for sections -->
<script type="text/javascript">
	var points = <?php echo json_encode($Splot) ?>;
	var options = {
        	series: { pie: { 
        		show: true,
        		startAngle: 0
        	}},
        	grid: { hoverable: true },
        	legend: { labelBoxBorderColor: "none" }
    	}
 
	$(document).ready(function () {
    	$.plot($("#section-graph"), points, options);
    $("#section-graph").bind("plothover", pieHover);
	});
 
	function pieHover(event, pos, obj) {
    	if (!obj) return;
 
    	percent = parseFloat(obj.series.percent).toFixed(2);
    	$("#section-label").html('<span style="font-family: Arial; font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
	}
</script>