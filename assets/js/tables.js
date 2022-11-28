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
	
	if (rankings.length > 0){
		$.get('assets/php/rankings.php', function(data) {
			rankings.html(data);
			rankings.tablesorter({
				sortList: [[0,0]],
			});
		});
		table = rankings;
	}
	if (games.length>0) {
		$.get('assets/php/games.php', function(data) {
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
	