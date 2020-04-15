$(function(){

	let charts = [
		{
			elementId:	"covid-chart1",
			type:		"horizontalBar",
			labels:		_regions,
			name:		"World Case by region",
			color:		"rgb(64, 64, 64)",
			data:		_infected,
			options:	{}
		},{
			elementId:	"covid-chart2",
			type:		"pie",
			labels:		_labels,
			name:		"Global statistics",
			color:		['rgb(204, 204, 0)', 'rgb(204, 0, 0)', 'rgb(0, 204, 0)'],
			data:		_global,
			options:	{
				title: { display: true, text: "Global statistics", position: 'top' }
			}
		},{
			elementId:	"covid-chart3",
			type:		"pie",
			labels:		_labels,
			name:		_labels_byregion[0],
			color:		['rgb(204, 204, 0)', 'rgb(204, 0, 0)', 'rgb(0, 204, 0)'],
			data:		_global_byregion[0],
			options:	{
				title: { display: true, text: _labels_byregion[0], position: 'top' }
			}
		},{
			elementId:	"covid-chart4",
			type:		"pie",
			labels:		_labels,
			name:		_labels_byregion[1],
			color:		['rgb(204, 204, 0)', 'rgb(204, 0, 0)', 'rgb(0, 204, 0)'],
			data:		_global_byregion[1],
			options:	{
				title: { display: true, text: _labels_byregion[1], position: 'top' }
			}
		},{
			elementId:	"covid-chart5",
			type:		"pie",
			labels:		_labels,
			name:		_labels_byregion[2],
			color:		['rgb(204, 204, 0)', 'rgb(204, 0, 0)', 'rgb(0, 204, 0)'],
			data:		_global_byregion[2],
			options:	{
				title: { display: true, text: _labels_byregion[2], position: 'top' }
			}
		},{
			elementId:	"covid-chart6",
			type:		"pie",
			labels:		_labels,
			name:		_labels_byregion[3],
			color:		['rgb(204, 204, 0)', 'rgb(204, 0, 0)', 'rgb(0, 204, 0)'],
			data:		_global_byregion[3],
			options:	{
				title: { display: true, text: _labels_byregion[3], position: 'top' }
			}
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
			options: charts[i].options
		});
	}
});
