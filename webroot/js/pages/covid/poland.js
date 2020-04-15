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
			type:		"pie",
			labels:		_current1_labels,
			name:		"Dead increase",
			color:		['rgb(255, 128, 0)', 'rgb(255, 0, 0)', 'rgb(0, 204, 0)'],
			data:		_current1_data
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
