/*
	Modified code derived from various internet sources
*/

/*https://betterprogramming.pub/sort-and-filter-dynamic-data-in-table-with-javascript-e7a1d2025e3c*/
var caretUpClassName = 'fa fa-caret-up';
var caretDownClassName = 'fa fa-caret-down';
var table = document.getElementById('full_list');
var input = document.getElementById('myinput');
var tableData = [
	{
	"rank": 1,
	"corporation": "Legion",
	"rating": "1,634",
	"delta": -39
	},
	{
	"rank": 2,
	"corporation": "Hinterm Mond",
	"rating": "1,627",
	"delta": "-"
	},
	{
	"rank": 3,
	"corporation": "StarControl",
	"rating": "1,617",
	"delta": "+9"
	},
	{
	"rank": 4,
	"corporation": "BlackStar Order",
	"rating": "1,546",
	"delta": -41
	},
	{
	"rank": 5,
	"corporation": "Kharon Shipping",
	"rating": "1,518",
	"delta": -33
	}
];

const sort_by = (field, reverse, primer) => {

	const key = primer ?
	function(x) {
	  return primer(x[field]);
	} :
	function(x) {
	  return x[field];
	};

	reverse = !reverse ? 1 : -1;

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
