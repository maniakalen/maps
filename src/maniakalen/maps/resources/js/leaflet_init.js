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
        }
    };
    window.initMap = function(mapId, key, coords, zoom) {
        var map = window.leaflet.map = L.map(mapId).setView(coords, zoom);

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: '',
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