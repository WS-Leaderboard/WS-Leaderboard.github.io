/*
	Modified code derived from various internet sources, primarily:
	https://betterprogramming.pub/sort-and-filter-dynamic-data-in-table-with-javascript-e7a1d2025e3c
*/
var caretUpClassName = 'fa fa-caret-up';
var caretDownClassName = 'fa fa-caret-down';
var table = document.getElementById('full_list');
var input = document.getElementById('myinput');

var tableData = gameData;

const sort_by = (field, reverse, primer) => {

	const key = primer ?
	function(x) {
	  return primer(x[field]);
	} :
	function(x) {
	  return x[field];
	};

	if (typeof val === 'string') {
		reverse = !reverse ? -1 : 1;
	}
	else {
		reverse = !reverse ? 1 : -1;
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
	if (iconClassName.includes(caretUpClassName)) {
		caret.className = `caret ${caretDownClassName}`;
		reverse = false;
	} else {
		reverse = true;
		caret.className = `caret ${caretUpClassName}`;
	}

	tableData.sort(sort_by(field, reverse));
	populateTable();
}
function populateTable() {
	table.innerHTML = '';
	for (let data of tableData) {
		let row = table.insertRow(-1);
		let date = row.insertCell(0);
		date.innerHTML = data.date;

		let players = row.insertCell(1);
		players.innerHTML = data.players;

		let team1 = row.insertCell(2);
		team1.innerHTML = data.team1;

		let score1 = row.insertCell(3);
		score1.innerHTML = data.score1;

		let score2 = row.insertCell(4);
		score2.innerHTML = data.score2;

		let team2 = row.insertCell(5);
		team2.innerHTML = data.team2;
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

/*for (let column of tableColumns) {
	column.addEventListener('click', function(event) {
		toggleArrow(event);
	});
}*/

input.addEventListener('keyup', function(event) {
	filterTable();
});
