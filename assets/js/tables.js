/*
	Modified code derived from various internet sources, primarily:
	https://betterprogramming.pub/sort-and-filter-dynamic-data-in-table-with-javascript-e7a1d2025e3c
	Convert csv to json:
	https://www.convertcsv.com/csv-to-json.htm
*/

function filterTable() {
	let filter = input.value.toUpperCase();
	rows = table.getElementsByTagName("TR");
	let flag = false;

	for (let row of rows) {
	let cells = row.getElementsByTagName("TD");
	for (let cell of cells) {
		if (cell.textContent.toUpperCase().indexOf(filter) > -1) {
			flag = true;
			break;
		}
	}

	if (flag) {
		row.style.display = "";
	} else {
		row.style.display = "none";
	}

	flag = false;
	}
}

/* filterTable();
input.addEventListener('keyup', function(event) {
	filterTable();
});
 */

var rankings = $('table.table-wrapper.rankings');
var games = $('table.table-wrapper.games');
var input = $('#myinput');

$(document).ready(function(){
	$('table.table-wrapper').html("LOADING...");
	/*
		check IF github.io
	*/
	site = document.location;
	if ( site.toString().includes("github.io")) {
		file = 'html';
	}else{
		file = 'php';
	}
	/*
		Load content or dynamic PHP or static
		create static (linux console)
		curl -L "http://ws-leaderboard.h2g.pl/site/games.php" > ./site/games.html
		curl -L "http://ws-leaderboard.h2g.pl/site/rankings.php" > ./site/rankings.html

	*/
	if (rankings.length > 0){
		$.get('site/rankings.'+file, function(data) {
			rankings.html(data);
			rankings.tablesorter({
				sortList: [[0,0]],
			});
		});
		table = rankings;
	}
	if (games.length>0) {
		$.get('site/games.'+file, function(data) {
			games.html(data);
			games.tablesorter({
				sortList: [[5,1]],
				// sortInitialOrder: "desc",
				//headers: {5 : {sorter:true, sortInitialOrder: "desc"} }
			});
		});
		table = games;
	}
	input.on("keyup", function() {
		var value = $(this).val().toLowerCase();
		table.find('tbody tr').filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	  });

});
	