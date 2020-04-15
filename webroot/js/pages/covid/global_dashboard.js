$(function(){

	let charts = [
		{
			elementId:	"covid-chart1",
			type:		"line",
			labels:		_global_label,
			name:		"Infected",
			color:		"rgb(255, 128, 0)",
			data:		_global_infected,
			options:	{}
		},{
			elementId:	"covid-chart2",
			type:		"line",
			labels:		_global_label,
			name:		"Infected",
			color:		"rgb(255, 128, 0)",
			data:		_global_dead,
			options:	{}
		},{
			elementId:	"covid-chart3",
			type:		"horizontalBar",
			labels:		_global_regions,
			name:		"World Case by region",
			color:		"rgb(64, 64, 64)",
			data:		_global_byregions,
			options:	{}
		}/* ,{
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
		} */
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


	$('#globalMap').vectorMap({
		map: 'world_mill',
		backgroundColor: "",
		series: {
			regions: [{
				values: _global_map_data,
				scale: ['#FFCCCC', '#990000'],
				normalizeFunction: 'polynomial'
			}]
		},
		onRegionTipShow: function(e, el, code){
			el.html(el.html()+': '+_global_map_data[code]+' cases');
		}
	});
});