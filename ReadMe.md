Guardian-Analyser
=================
A web-page-based data analyser for the Guardian API.  
Parses headlines' words, articles dates & articles' sections.  
Written in HTML, PHP & JavaScript.  
Created as my final project for CS50x, Winter 2012.   

## How to Use:
1. Get Apache HTTP or any other similar programs.  
   If unfamiliar with installing Apache HTTP, google for tutorials on how to install it.  
	I used [this tutorial](http://lifeofageekadmin.com/how-install-apache-2-4-php-5-4-and-mysql-5-5-21-on-windows-7/) to install Apache HTTP on my windows computer.

2. Extract all the files in this repo to the directory which Apache HTTP reads from.  

3. Start Apache & go to "http://localhost" in your browser.  

4. Follow the instructions on the browser like you would with any other web app. 

5. Have Fun!  

Note: This website doesn't seem to display properly in Internet Explorer. Use Chrome or Firefox.  


## File descriptions:
`Index.php`  
Intro for the data anlyser, desciribes how to use & some credits to 3rd party codes.  

`Search.php`  
Page for the search form & also page where results will be rendered.  

`Render.php`  
PHP code to collect, analyse & render the data & results.  

`Guardian_Analyser.css`  
CSS for the entire web app.  

`includes`  
Contains all the relevant 3rd part codes used in the web app. 

`img`  
Contains the images used, namely the logo, the loading animation & my logo.  

`js`  
Contains the 2 .js files used. One is to create the search URL to be passed to Render.php.  
The other is to ensure the middle container stretches to fill the window height on large screens. 
  
## Screenshots:
![Intro screenshot] (http://i48.tinypic.com/2iql6o9.jpg) 

![Search screenshot] (http://i46.tinypic.com/2j5nd6t.jpg)

**  
Billy Lim Jun Ming  
15 Feburary 2013