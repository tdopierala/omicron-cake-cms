$(function(){
	$('#globalMap').vectorMap({
		map: 'world_mill',
		backgroundColor: "",
		series: {
			regions: [{
				values: covidData,
				scale: ['#FFCCCC', '#990000'],
				normalizeFunction: 'polynomial'
			}]
		},
		onRegionTipShow: function(e, el, code){
			el.html(el.html()+': '+covidData[code]+' cases');
		}
	});
});