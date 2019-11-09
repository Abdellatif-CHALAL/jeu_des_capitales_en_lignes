<?php 
	session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
		<title>Leaflet.js avec couche Stamen Watercolor</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../controller/style.css"/>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
	<body style="background-color:rgb(233, 150, 122);">
	<?php require("menu1.php");?>
	<div class="d-flex flex-row">
		<div id="div1" class="p-2">
			<h2 class="text-center">La question est la suivante:<h2>
			<h4 class="text-center" id="question"></h4>
				<img id ="flag" src =" " width="200px" height="150px" />
				<br>
				<br>
				<div class="text-center">
					<h3 id="bravo"></h3>
						<h1 id="score">0</h1>
				</div>
				<div>
					<img id="img" src=" " />
					<p id="description"></p>
				</div>
		</div>
		<div id="div2" class="p-2 qst2">
			<div id="maDiv"></div>
			<div class="d-flex justify-content-between mb-3" style="padding-top:10px;">
                <div class="p-2 "><span id="compteur" class="rounded-circle btn-primary btn-lg">0/7</span></div>
                <div class="p-2"><a style="broder-raduis: 20px;" href="StamenTileLayerQst2.php" class="btn btn-primary btn-lg" ><h5>Nouvelle partie</h5></a></div>
                <div class="p-2">
                    <button type="button" class="btn btn-primary btn-lg">Question suivante</button></div>
                </div>
		    </div>
		</div>
	</div>
		<script>
				  	   var northWest = L.latLng(90, -180);
						var southEast = L.latLng(-90, 180);
						var bornes = L.latLngBounds(northWest, southEast);
										// borne<!--<h1 class="text-center"style="background-color:DodgerBlue;"> Jeu Des Capitales Du Monde</h1>-->s pour empecher la carte StamenWatercolor de "dériver" trop loin...
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
						
						// Fonction de conversion au format GeoJSON
						function coordGeoJSON(latlng,precision) { 
							return '[' +
								L.Util.formatNum(latlng.lng, precision) + ',' +
								L.Util.formatNum(latlng.lat, precision) + ']';
						}
						//var popup = L.popup();
                        
            var countriesLayer;
			function highlightFeature(e){
				var layer = e.target;
				layer.setStyle(
					{   fillColor : 'blue',
						weight : 2,
						color : 'blue',
						dashArray :1
					}
				);
				if(!L.Browser.ie && !L.Browser.opera){
					layer.bringToFront();
				}
			}
			
			function resetHighlight(e){
				countriesLayer.resetStyle(e.target);
			}
			
			function zoomToFeature(e){
				map.fitBounds(e.target.getBounds());
			}
			
			function countriesOnEachFeature(feature, layer){
				layer.on(
					{
						mouseover : highlightFeature,
						mouseout : resetHighlight,
						dblclick : zoomToFeature
					}
				);
			}
			
			function countriesStyle(feature){
				return {
					fillColor : 'red',
					weight : 1,
					opacity : 1,
					color : 'white',
					dashArray : 1
				}
			}
			
				$.ajax({
					url:"../model/geojsonWorld/countries.geojson",
					dataType:"json",
						success: function (data) {
							countriesLayer = L.geoJson(data,
                  			      {style : countriesStyle,
                                        onEachFeature : countriesOnEachFeature
                        	}).addTo(map);
                                map.fitBounds(countriesLayer.getBounds());
						},
						error: function (err) {
							alert("j'ai echoué ");
						},		
				});
				$("a").hide();
				var nbrQuestionCorrect = 0;
				var dataJson;
				var p;
				var id_quest = 1;
				var num_quest = 1;
				$("#img").hide();
				$("#flag").hide();
				$(document).ready(function(){
					$.ajax({
						url: "../controller/selectInformation.php",
						method: "POST",
						data:{"num_quest":num_quest},
						success: function (data) {
							var v = JSON.parse(data);
							dataJson = v;
							traitement(v);
							console.log(v);
						},
						error: function (err) {
							alert("j'ai echoué ");
						},
					});
				});

$("button").click(function () {
	map.fitBounds(countriesLayer.getBounds());
	num_quest++;
	$("#img").hide();
	$("#flag").hide();
    $("#description").html(" ");
    $("#bravo").html(" ");
    if (p != null) {
        map.removeLayer(p);
    }
	$.ajax({
        url: "../controller/selectInformation.php",
		method: "POST",
		data:{"num_quest":num_quest },
        success: function (data) {
            var v = JSON.parse(data);
				dataJson = v;
				traitement(v);
				console.log(v);
        },
        error: function (err) {
            alert("j'ai echoué ");
        },
    });
});


function traitement(data) {
    $("#question").html(data[0].quest);
}

// function polygone(lien) {
//     $.getJSON(lien, function (data) {
//         p = L.geoJSON(data, {
//             style: function (feature) {
//                 return { color: 'blue' };
//             }
//         }).addTo(map);
//         map.fitBounds(p.getBounds());
//     });
// }

// function flag(lien) {
//     $("#flag").attr("src", lien);
// }



	map.on('click', onClick);
	
	function onClick(e) {

		// On recherche ici le pays sur lequel on a clické
		// e contient automatiquement la lat/lon (e.latlng)
		// Requete AJAX de type GET pour récupérer les infos du pays sur le point où on a cliqué (lati, longi) 
		$.ajax({
		    type: 'GET',
		    url: "http://nominatim.openstreetmap.org/reverse",
		    dataType: 'jsonp',
		    jsonpCallback: 'data',
		    data: { format: "json", limit: 1,lat: e.latlng.lat,lon: e.latlng.lng,json_callback: 'data' },
		    error: function(xhr, status, error) {
				alert("ERREUR "+error);
			},
		    success: function(data){
				if (data.address.country == dataJson[0].nom_pays){
					$.getJSON(dataJson[0].url_pays, function (data) {
						p = L.geoJSON(data, {
						style: function (feature) {
							return { color: 'green',
								fillColor : 'green' };
						}
						}).addTo(map);
						map.fitBounds(p.getBounds());
    				});
					nbrQuestionCorrect++;
                	$("#compteur").html(nbrQuestionCorrect+'/7');
					var sc = $("#score").text();
					var n = Number(sc);
					if(dataJson[0].surface_pays < 800000){
						$("#score").html(n + 1000);	
					}else{
						$("#score").html(n + 500);
					}
					$("#img").attr("src", dataJson[0].url_img);
					$("#flag").attr("src", dataJson[0].url_flag);
					$("#img").show();
					$("#flag").show();
					$("#description").html(dataJson[0].desciption_pays);
					$("#bravo").html("Bravo! Bonne réponse.");
					$("#bravo").css("background-color", "rgb(0,255,0)");
				}else{
					$.getJSON(dataJson[0].url_pays, function (data) {
						p = L.geoJSON(data, {
						style: function (feature) {
							return { color: 'green',
								fillColor : 'green' };
						}
						}).addTo(map);
						map.fitBounds(p.getBounds());
    				});
					$("#score").text(sc);
					$("#img").attr("src", dataJson[0].url_img);
					$("#flag").attr("src", dataJson[0].url_flag);
					$("#img").show();
					$("#flag").show();
					$("#description").html(dataJson[0].desciption_pays);
					$("#bravo").html("Désolé! Mauvaise réponse.");
					$("#bravo").css("background-color", "rgb(255,0,0)");
				}
				if(num_quest == 7){
					$("button").hide();
        			$("a").show();
					var score = Number($("#score").text());
					$.ajax({
						url: "../controller/score.php",
						method: "POST",
						data:{"score":score,"id_ut":<?php echo $_SESSION['sessionInfos']['id_ut']; ?>,"num_quest":num_quest,"id_quest":id_quest},
						success: function (data){
							var v = JSON.parse(data);
								dataJson = v;
								traitement(v);
								console.log(v);
						},
						error: function (err) {
							alert("j'ai echoué ");
						},
					});
				}
			console.log(data);
			}	
		});
	}
		</script>
	</body>
</html>