/*
 * Guardian Analyser
 * Search Javascript Trigger
 *
 * Triggers when search-from is submitted 
 * Produces search url & triggers data processing
 * 
 * Copyright (C) 2013 Billy Lim Jun Ming
 * Licensed under GNU GPL
 */

$(document).ready(function() 
{
    $('#search-form').on('submit', function() 
    {
        // message to display if input is valid
        var ERROR_MESSAGE = '<font color="#FF0000">One or more search inputs are invalid.</br> Please check your search inputs.</br> Especially the dates.</font>';
        
        // loading animation
        $('#results').html("<img src='img/Loading.gif' alt='Loading Animation'></img>");
        resize();

        // base url to build upon. sets results to json & page-size to be 50 
        var url = 'http://content.guardianapis.com/search?format=json&page-size=50';

        // validate & add from-date filter
        tmp = $("#search-form input[name='from-date']").val();
        if(tmp !== '')
        {
            if(moment(tmp, "YYYY-MM-DD").isValid())
                url = url.concat('&from-date=',tmp);
            else
            {
                $('#results').html(ERROR_MESSAGE);
                return false;
            }
        }
        
        // validate & add to-date filter
        tmp = $("#search-form input[name='to-date']").val();
        if(tmp !== '')
        {
            if(moment(tmp, "YYYY-MM-DD").isValid())
                url = url.concat('&to-date=',tmp);
            else
            {
                $('#results').html(ERRORMESSAGE);
                return false;
            }
        }
        
        // validate & add max number of articles
        var num = $("#search-form input[name='num']").val();
        if(num !== '')
        {
            if(!($.isNumeric(num)) || num <= 0)
            {
                $('#results').html(ERROR_MESSAGE);
                return false;
            }
        }

        // add search query filter
        var tmp = $("#search-form input[name='query']").val();
        if(tmp !== '')
        {
            tmp = tmp.replace(/ /g,'+');
            url = url.concat('&q=',tmp);
        }
        
        // add section filter
        tmps = $("#search-form input[name='section[]']:checked");
        if(tmps.length > 0)
        {
            url = url.concat('&section=');
            for(var i = 0; i < tmps.length; i++)
                url = url.concat(tmps[i].value, '|');
            url = url.substring(0, url.length - 1);
        }

        // add newest/oldest priority
        order = $("#search-form input[name='order-by']").val();
        url = url.concat('&order-by=',order);

        // send ajax request
        $.ajax(
        {
            url: 'Render.php',
            type: 'POST',
            data: {url:url, num:num, order:order},
            success: function(response) 
            {
                $('#results').html(response);
                resize();
            }
        });
         
        // overwrite form submission
        return false;
    });
});