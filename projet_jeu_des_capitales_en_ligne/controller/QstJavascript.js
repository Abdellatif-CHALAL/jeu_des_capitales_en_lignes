
			// bornes pour empecher la carte StamenWatercolor de "dériver" trop loin...
			var northWest = L.latLng(90, -180);
			var southEast = L.latLng(-90, 180);
			var bornes = L.latLngBounds(northWest, southEast);
			// Initialisation de la couche StamenWatercolor
			var coucheStamenWatercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
				attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
				subdomains: 'abcd',
				ext: 'jpg'
			});
			// Initialisation de la carte et association avec la div
			var map = new L.Map('maDiv', {
				center: [48.858376, 2.294442],
				minZoom: 2,
				maxZoom: 18,
				zoom: 5,
				maxBounds: bornes
			});
			//var map = L.map('maDiv').setView([48.858376, 2.294442],5);


			// Affichage de la carte
			map.addLayer(coucheStamenWatercolor);

			// Juste pour changer la forme du curseur par défaut de la souris
			document.getElementById('maDiv').style.cursor = 'crosshair'
			//map.fitBounds(bornes);
			// Initilisation d'un popup
			var popup = L.popup();
			// Fonction de conversion au format GeoJSON
			function coordGeoJSON(latlng,precision) { 
				return '[' +
					L.Util.formatNum(latlng.lng, precision) + ',' +
					L.Util.formatNum(latlng.lat, precision) + ']';
			}
			// Fonction qui réagit au clic sur la carte (e contiendra les données liées au clic)
			function onMapClick(e) {
				popup.setLatLng(e.latlng)
					.setContent("Hello click détecté sur la carte !<br/> " + e.latlng.toString()+ "<br/>en GeoJSON: " + coordGeoJSON(e.latlng,7) + "<br/>Niveau de  Zoom: " + map.getZoom().toString())
					.openOn(map);
			}

			//circle.bindPopup("I am a circle.");

			function circle(){
				var circle = L.circle([51.508, -0.11], {
				color: 'red',
				fillColor: '#f03',
				fillOpacity: 0.5,
				radius: 100000
				}).addTo(map);
			}
				

			// Association Evenement/Fonction handler
			map.on('click', onMapClick);
			map.on('click', circle);