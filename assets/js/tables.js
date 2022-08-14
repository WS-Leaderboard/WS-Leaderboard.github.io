/*
	Modified code derived from various internet sources, primarily:
	https://betterprogramming.pub/sort-and-filter-dynamic-data-in-table-with-javascript-e7a1d2025e3c
	Convert csv to json:
	https://www.convertcsv.com/csv-to-json.htm
*/
var caretUpClassName = 'fa fa-caret-up';
var caretDownClassName = 'fa fa-caret-down';
var table = document.getElementById('full_list');
var input = document.getElementById('myinput');

var tableData = rankingsData;

const sort_by = (field, reverse, primer) => {

	const sort_reverse = ["rank", "corporation"];
	
	const key = primer ?
	function(x) {
	  return primer(x[field]);
	} :
	function(x) {
	  return x[field];
	};

	if (sort_reverse.includes(field)) {
		reverse = !reverse ? 1 : -1;
	}
	else {
		reverse = !reverse ? -1 : 1;
	}
	
	return function(a, b) {
	return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
	};
};

function clearArrow() {
	let carets = document.getElementsByClassName('caret');
	for (let caret of carets) {
		caret.className = "caret";
	}
}

function toggleArrow(event) {
	let element = event.target;
	let caret, field, reverse;
	if (element.tagName === 'SPAN') {
		caret = element.getElementsByClassName('caret')[0];
		field = element.id
	}
	else {
		caret = element;
		field = element.parentElement.id
	}

	let iconClassName = caret.className;
	clearArrow();
	if (iconClassName.includes(caretDownClassName)) {
		caret.className = `caret ${caretUpClassName}`;
		reverse = true;
	} else {
		reverse = false;
		caret.className = `caret ${caretDownClassName}`;
	}

	tableData.sort(sort_by(field, reverse));
	populateTable();
}
function populateTable() {
	table.innerHTML = '';
	for (let data of tableData) {
		let row = table.insertRow(-1);
		let rank = row.insertCell(0);
		rank.innerHTML = data.rank;

		let corporation = row.insertCell(1);
		corporation.innerHTML = data.corporation;

		let rating = row.insertCell(2);
		rating.innerHTML = data.rating;

		let delta = row.insertCell(3);
		delta.innerHTML = data.delta;
	}

	filterTable();
}

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

populateTable();

let tableColumns = document.getElementsByClassName('table-column');

for (let column of tableColumns) {
	column.addEventListener('click', function(event) {
		toggleArrow(event);
	});
}

input.addEventListener('keyup', function(event) {
	filterTable();
});
