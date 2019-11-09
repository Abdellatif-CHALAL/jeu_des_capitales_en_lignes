<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Leaflet.js avec couche Stamen Watercolor</title>
		<meta charset="utf-8" />
        <link rel="stylesheet" href="../model/style/accueil.css">
		<link rel="stylesheet" href="../model/style/style.css"/>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
	<body id="body1">
    <?php require("menu.php");?>    
	<div class="d-flex flex-row">
		<div id="div1" class="p-2">
			<h2 class="text-center">La question est la suivante:<h2>
			<h4 class="text-center" id="question"></h4>
				<img id ="flag" src =" " width="200px" height="150px"/>
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
                <div class="p-2"><a style="broder-raduis: 20px;" href="StamenTileLayer.php" class="btn btn-primary btn-lg" >Rejoueur</a></div>
                <div class="p-2">
                    <button type="button" class="btn btn-primary btn-lg">Question suivante</button></div>
                </div>
		    </div>
	</div>
	<script>
	
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

// Fonction de conversion au format GeoJSON
function coordGeoJSON(latlng, precision) {
    return '[' +
        L.Util.formatNum(latlng.lng, precision) + ',' +
        L.Util.formatNum(latlng.lat, precision) + ']';
}

$("a").hide();
var nbrQuestionCorrect = 0;
var index = 0;
var popup = L.popup();
var circle;
var correct;
var tab = new Array();
var p;
var compteur = Boolean(1);
$("#img").hide();
$.ajax({
    url: "../model/jeu.json",
    dataType: "json",

    success: function (data) {
        traitement(data, index);
    },
    error: function (err) {
        alert("j'ai echoué ");
    },
});

$("button").click(function () {
    index = index + 1;
    if (index == 7) {
        $("button").hide();
        $("a").show();
    }
    compteur = Boolean(1);
    $("#img").hide();
    $("#description").html(" ");
    $("#bravo").html(" ");
    deleteTab();
    if (p != null) {
        map.removeLayer(p);
    }
    $.ajax({
        url: "../model/jeu.json",
        dataType: "json",

        success: function (data) {
            traitement(data, index);
        },
        error: function (err) {
            alert("j'ai echoué ");
        },
    });
});

function traitement(data, index) {
    $("#question").html(data[0].features[index].question);
    polygone(data[0].features[index].properties.pays.polygone);
    flag(data[0].features[index].properties.pays.flag);
}

function polygone(lien) {
    $.getJSON(lien, function (data) {
        p = L.geoJSON(data, {
            style: function (feature) {
                return { color: 'blue',
                    fillColor : 'blue' };
            }
        }).addTo(map);
        map.fitBounds(p.getBounds());
    });
}

function flag(lien) {
    $("#flag").attr("src", lien);
}

function deleteTab() {
    var i = 0;
    while (i < tab.length) {
        tab.pop().remove();
        i++;
    }
}
// Fonction qui réagit au clic sur la carte (e contiendra les données liées au clic)
function onMapClick(e) {

    $.getJSON("../model/jeu.json", function (data) {
        var marker1 = L.marker(data[0].features[index].geometry.coordinates).addTo(map);
        marker1.remove();
        circle = L.circle(e.latlng, {
            color: 'green',
            fillColor: 'green',
            fillOpacity: 0.5,
            radius: 100000
        }).addTo(map);
        tab.push(circle);

        var start = marker1.getLatLng();
        var end = e.latlng;
        distance = Math.round(start.distanceTo(end) / 1000.0);
        if (distance < 200){
            if ((tab.indexOf(correct) == -1) && (compteur)) {
                compteur = Boolean(0);
                nbrQuestionCorrect++;
                $("#compteur").html(nbrQuestionCorrect+'/7');
                var sc = $("#score").text();
                var n = Number(sc);
                if(data[0].features[index].properties.pays.surface >= 800000){
						$("#score").html(n + 1000);	
				}else{
						$("#score").html(n + 500);
				}
                $("#img").attr("src", data[0].features[index].properties.ville.image);
                $("#img").show();
                $("#description").html(data[0].features[index].properties.ville.description);
                $("#bravo").html("Bravo! Bonne réponse.");
                $("#bravo").css("background-color", "rgb(0,255,0)");
            }
        } else {
            $("#score").text(sc);
            $("#img").attr("src", data[0].features[index].properties.ville.image);
            $("#img").show();
            $("#description").html(data[0].features[index].properties.ville.description);
            $("#bravo").html("Désolé! Mauvaise réponse.");
            $("#bravo").css("background-color", "rgb(255,0,0)");
            tab.pop().remove();
            correct = L.circle(marker1.getLatLng(), {
                color: 'green',
                fillColor: 'green',
                fillOpacity: 0.5,
                radius: 100000
            }).addTo(map).bindPopup("<h5>" + data[0].features[index].properties.ville.name + "</h5>").openPopup();
            tab.push(correct);
        }
    });
    if (index == 6) {
        $("button").hide();
        $("a").show();
    }
}

map.on('click', onMapClick);
	</script>
	</body>
</html>