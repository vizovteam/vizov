$(document).ready(function () {
    var address = $("#show_on_map .modal-header").html();
    var coords = [0,0];
    
    ymaps.ready(function () {
	    ymaps.geocode(address, {
	    	results: 1
	    }).then(function (res) {
	    	var firstGeoObject = res.geoObjects.get(0),
            coords = firstGeoObject.geometry.getCoordinates();
	    	init(coords);
	    });
    });

    function init(coords) {

        ymaps.geocode(address, {
                results: 1
            }).then(function (res) {
                    // Выбираем первый результат геокодирования.
                    var firstGeoObject = res.geoObjects.get(0),
                        // Координаты геообъекта.
                        coords = firstGeoObject.geometry.getCoordinates(),
                        // Область видимости геообъекта.
                        bounds = firstGeoObject.properties.get('boundedBy');

                    // Добавляем первый найденный геообъект на карту.
                    myMap.geoObjects.add(firstGeoObject);
                    myMap.setZoom(13);
                         
                });

        var myPlacemark,
            myMap = new ymaps.Map('map', {
                center: coords,
                zoom: 9
            }, {
                searchControlProvider: 'yandex#search'
            });

    }
});