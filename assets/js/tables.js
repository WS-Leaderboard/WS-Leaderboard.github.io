/*
	Modified code derived from various internet sources, primarily:
	https://betterprogramming.pub/sort-and-filter-dynamic-data-in-table-with-javascript-e7a1d2025e3c
	Convert csv to json:
	https://www.convertcsv.com/csv-to-json.htm
*/

var table = document.getElementById('full_list');
var input = document.getElementById('myinput');


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

filterTable();

input.addEventListener('keyup', function(event) {
	filterTable();
});


var sortable = $('table.table-wrapper');

$(document).ready(function(){
	sortable.tablesorter({
		sortList: [[0,0]],
		headers: {4:{sorter:false}}
	});
});

	