mapboxgl.accessToken = 'pk.eyJ1IjoiZGFudGNhY2VuY28iLCJhIjoiY2szN3BobmpoMDE4YzNtb2ExMW9nYWNiaCJ9.rKKAdAQWePgXfmVUTvyM0w';
            const map = new mapboxgl.Map({
                container: 'map',
                center: [ -82.567324, 35.616288],
                zoom: 14,
                style: 'mapbox://styles/mapbox/streets-v10'
            });

/* Load Coordinates of Parking Lots */
map.on('load', () =>{
	map.addSource('pointsSource',{
		type: 'geojson',
		data: 
		//copy+paste block of code from geojson.io
		{
		"type": "FeatureCollection",
		"features": [
			{
			"lot": 1,
			"type": "Feature",
			"properties": {},
			"geometry": {
				"type": "Point",
				"coordinates": [
				-82.57142901420593,
				35.61456968976313
				]
			}
			},
			{
			"lot" : 2,
			"type": "Feature",
			"properties": {},
			"geometry": {
				"type": "Point",
				"coordinates": [
				-82.57152020931244,
				35.61523474226773
				]
			}
			}
		]
		}
	});
	//add Layer with "Points"
	map.addLayer({
		id: 'points',
		source: 'pointsSource',
		type: 'circle'
	});
});
console.log("not error");
/* Link Table Rows to Locations on Map */
const lots = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,24,25,26,27,28,29,30,31,33];
const coordinates = new Array(2);
coordinates [1] = [-82.57142901420593, 35.61456968976313];
coordinates [2] = [-82.57142901420593, 35.61456968976313];
coordinates [3] = [-82.57142901420593, 35.61456968976313];
coordinates [4] = [-82.57142901420593, 35.61456968976313];
coordinates [5] = [-82.57142901420593, 35.61456968976313];
coordinates [6] = [-82.57142901420593, 35.61456968976313];
coordinates [7] = [-82.57142901420593, 35.61456968976313];
coordinates [8] = [-82.57142901420593, 35.61456968976313];
coordinates [9] = [-82.57142901420593, 35.61456968976313];
coordinates [10] = [-82.57142901420593, 35.61456968976313];
coordinates [11] = [-82.57142901420593, 35.61456968976313];
coordinates [12] = [-82.57142901420593, 35.61456968976313];
coordinates [13] = [-82.57142901420593, 35.61456968976313];
coordinates [14] = [-82.57142901420593, 35.61456968976313];
coordinates [15] = [-82.57142901420593, 35.61456968976313];
coordinates [16] = [-82.57142901420593, 35.61456968976313];
coordinates [17] = [-82.57142901420593, 35.61456968976313];
coordinates [18] = [-82.57142901420593, 35.61456968976313];
coordinates [19] = [-82.57142901420593, 35.61456968976313];
coordinates [20] = [-82.57142901420593, 35.61456968976313];
coordinates [24] = [-82.57142901420593, 35.61456968976313];
coordinates [25] = [-82.57142901420593, 35.61456968976313];
coordinates [26] = [-82.57142901420593, 35.61456968976313];
coordinates [27] = [-82.57142901420593, 35.61456968976313];
coordinates [28] = [-82.57142901420593, 35.61456968976313];
coordinates [29] = [-82.57142901420593, 35.61456968976313];
coordinates [30] = [-82.57142901420593, 35.61456968976313];
coordinates [31] = [-82.57142901420593, 35.61456968976313];
coordinates [33] = [-82.57142901420593, 35.61456968976313];


for (i = 0; i < 35; i++) {
	document.getElementById(lots[i]).addEventListener('click', function () {
		console.log('coordinates: '+  coordinates[i,0] +", " + coordinates[i,1]);
		map.flyTo({
			center: [ coordinates[1][0], coordinates[1][1]],
			zoom: 17
		});
	});
};

