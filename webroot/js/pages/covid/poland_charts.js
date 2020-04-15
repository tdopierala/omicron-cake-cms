$(function(){

	let charts = [
		{
			elementId:	"covid-chart1",
			type:		"line",
			labels:		_labels,
			name:		"Infected",
			color:		"rgb(255, 128, 0)",
			data:		_infected
		},{
			elementId:	"covid-chart2",
			type:		"line",
			labels:		_labels,
			name:		"Dead",
			color:		"rgb(204, 0, 0)",
			data:		_dead
		},{
			elementId:	"covid-chart3",
			type:		"bar",
			labels:		_labels,
			name:		"Infected increase",
			color:		"rgb(0, 76, 153)",
			data:		_infected_increase
		},{
			elementId:	"covid-chart4",
			type:		"bar",
			labels:		_labels,
			name:		"Dead increase",
			color:		"rgb(76, 0, 153)",
			data:		_dead_increase
		},{
			elementId:	"covid-chart5",
			type:		"pie",
			labels:		_current1_labels,
			name:		"Dead increase",
			color:		['rgb(255, 128, 0)', 'rgb(255, 0, 0)', 'rgb(0, 255, 0)'],
			data:		_current1_data
		},{
			elementId:	"covid-chart6",
			type:		"bar",
			labels:		_current2_labels,
			name:		"In quarantine",
			color:		['rgb(255, 128, 0)', 'rgb(255, 0, 0)', 'rgb(0, 255, 0)', 'rgb(0, 128, 255)'],
			data:		_current2_data
		},{
			elementId:	"covid-chart7",
			type:		"line",
			labels:		_labels,
			name:		"Hospitalized",
			color:		"rgb(204, 0, 102)",
			data:		_hospitalized
		},{
			elementId:	"covid-chart8",
			type:		"line",
			labels:		_labels,
			name:		"In quarantine",
			color:		"rgb(0, 102, 102)",
			data:		_quarantined
		},{
			elementId:	"covid-chart9",
			type:		"line",
			labels:		_labels,
			name:		"Under surveillance",
			color:		"rgb(0, 153, 0)",
			data:		_surveillance
		},{
			elementId:	"covid-chart10",
			type:		"line",
			labels:		_labels,
			name:		"Tests",
			color:		"rgb(0, 128, 255)",
			data:		_tests
		}
	];

	for(let i=0; i<charts.length; i++){
		let ctx = document.getElementById(charts[i].elementId).getContext('2d');

		new Chart(ctx, {
			type: charts[i].type,
			data: {
				labels: charts[i].labels,
				datasets: [{
					label: charts[i].name,
					backgroundColor: charts[i].color,
					data: charts[i].data,
				}]
			},
			options: {}
		});
	}
});
