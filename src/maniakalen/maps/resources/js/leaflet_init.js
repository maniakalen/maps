$(document).ready(function() {
    window.leaflet = window.leaflet || {
        "map": false,
        'addPopup': function(coords, content, options) {
            if (!window.leaflet.map) { return; }
            options = options || {closeButton:false};
            var popup = L.popup(options)
                .setLatLng(coords)
                .setContent(content);
            window.leaflet.map.addLayer(popup);
        },
        'addMarker': function(coords, popupContent) {
            if (!window.leaflet.map) { return; }
            popupContent = popupContent || false;
            var marker = L.marker(coords).addTo(window.leaflet.map);
            if (popupContent) {
                marker.bindPopup(popupContent).openPopup();
            }
        }
    };
    window.initMap = function(mapId, key, coords, zoom, options) {
        options = options || {};
        options.attribution = options.attribution || 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';

        var map = window.leaflet.map = L.map(mapId);
        map.on('load', function() {
            $('body').trigger('leaflet.map.loaded');
        });
        map.setView(coords, zoom);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: options.attribution,
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: key
        }).addTo(map);

        $('body').on('leaflet.points.loaded', function(e) {
            $.map(e.points, function(item) {
                window.leaflet.addPopup(item.coords, item.content);
            });
        });
    };
});