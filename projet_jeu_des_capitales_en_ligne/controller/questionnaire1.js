
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
                return { color: 'blue' };
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

    // popup.setLatLng(e.latlng)
    // .setContent("Hello click détecté sur la carte !<br/> " + e.latlng.toString()+ "<br/>en GeoJSON: " + coordGeoJSON(e.latlng,7) +"<br/>Niveau de  Zoom: " + map.getZoom().toString())
    // .openOn(map);

    $.getJSON("../model/jeu.json", function (data) {
        var marker1 = L.marker(data[0].features[index].geometry.coordinates).addTo(map);
        marker1.remove();
        circle = L.circle(e.latlng, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 100000
        }).addTo(map);
        tab.push(circle);

        var start = marker1.getLatLng();
        var end = e.latlng;
        distance = Math.round(start.distanceTo(end) / 1000.0);
        //circle.bindPopup('Distance = '+distance+' km');
        if (distance < 200) {
            if ((tab.indexOf(correct) == -1) && (compteur)) {
                compteur = Boolean(0);
                var sc = $("#score").text();
                var n = Number(sc);
                $("#score").html(n + 100);
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
    if (index == 7) {
        $("button").hide();
    }
}

map.on('click', onMapClick);