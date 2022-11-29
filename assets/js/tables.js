/*
	Table content async loader
	*
	depence: jQuery
*/
var rankings = $('table.table-wrapper.rankings');
var games = $('table.table-wrapper.games');
var input = $('#myinput');
var loading = "LOADING...";

$(document).ready(function(){
	/*
		Paste Loading indicator, nothing fancy instead animated gif
	*/
	$('table.table-wrapper').html(loading);
	/*
		check IF github.io
		then load static HTML, which should be synced with PHP
		or load PHP on hosting which support it
	*/
	site = document.location;
	if ( site.toString().includes("github.io")) {
		file = 'html';
	}else{
		file = 'php';
	}
	/*
		Load content or dynamic PHP or static, need to be in main directory
		Linux/terminal
			curl -L "http://ws-leaderboard.h2g.pl/site/games.php" > ./site/games.html
			curl -L "http://ws-leaderboard.h2g.pl/site/rankings.php" > ./site/rankings.html
		or Powershell (terminal)
			wget "http://ws-leaderboard.h2g.pl/site/games.php"  -outfile "./site/games.html"
			wget "http://ws-leaderboard.h2g.pl/site/rankings.php" -outfile "./site/rankings.html"
	*/
	if (rankings.length > 0){
		$.get('site/rankings.'+file, function(data) {
			rankings.html(data);
			rankings.tablesorter({
				// Start sort by Rating DESC
				sortList: [[2,1]],
			});
		});
		table = rankings;
	}
	if (games.length>0) {
		$.get('site/games.'+file, function(data) {
			games.html(data);
			games.tablesorter({
				// Start sort by Date DESC
				sortList: [[5,1]],
				// sortInitialOrder: "desc",
				//headers: {5 : {sorter:true, sortInitialOrder: "desc"} }
			});
		});
		table = games;
	}
	/*
		Add event on search field (instead listener)
	*/
	input.on("keyup", function() {
		var value = $(this).val().toLowerCase();
		table.find('tbody tr').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	  });

});
	