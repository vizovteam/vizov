$(document).ready(function() {
    var isShowed = false;
    var city_name = $("#city option:selected").html();
    var address = $("#address").val();
    var coords = [0,0];

    ymaps.ready(function () {
        ymaps.geocode(city_name + ", " + address, {
            results: 1
        }).then(function (res) {
            var firstGeoObject = res.geoObjects.get(0),
            coords = firstGeoObject.geometry.getCoordinates();
            init(coords);
        });
    });

    $('#city').change(function(){
        city_name = $("#city option:selected").html();
        $('#address').val('');
    });


    function init(coords) {


        ymaps.geocode(city_name + ", " + address, {
                results: 1
            }).then(function (res) {
                    // Выбираем первый результат геокодирования.
                    var firstGeoObject = res.geoObjects.get(0),
                        // Координаты геообъекта.
                        default_coodrs = coords = firstGeoObject.geometry.getCoordinates(),
                        // Область видимости геообъекта.
                        bounds = firstGeoObject.properties.get('boundedBy');

                    // Добавляем первый найденный геообъект на карту.
                    myMap.geoObjects.add(firstGeoObject);
                    myMap.setZoom(13);



                    /**
                     * Если нужно добавить по найденным геокодером координатам метку со своими стилями и контентом балуна, создаем новую метку по координатам найденной и добавляем ее на карту вместо найденной.
                     */
                        
                     var myPlacemark = new ymaps.Placemark(coords, {
                     iconContent: address,
                     balloonContent: city_name + ", " + address
                     }, {
                     preset: 'islands#violetStretchyIcon'
                     });

                     myMap.geoObjects.add(myPlacemark);
                     init.prototype.myPlacemark = myPlacemark;
                         
                });

        var myPlacemark,
            myMap = new ymaps.Map('map', {
                center: coords,
                zoom: 13
            }, {
                searchControlProvider: 'yandex#search'
            });

        // Слушаем клик на карте
        myMap.events.add('click', function (e) {
            var coords = e.get('coords');

            // Если метка уже создана – просто передвигаем ее
            if (myPlacemark) {
                myPlacemark.geometry.setCoordinates(coords);
            }
            else if (init.prototype.myPlacemark){
                myPlacemark = init.prototype.myPlacemark;
                myPlacemark.geometry.setCoordinates(coords);
            } else {
            // Если нет – создаем.
                myPlacemark = createPlacemark(coords);
                myMap.geoObjects.add(myPlacemark);
                // Слушаем событие окончания перетаскивания на метке.
                myPlacemark.events.add('dragend', function () {
                    getAddress(myPlacemark.geometry.getCoordinates());
                });
                init.prototype.myPlacemark = myPlacemark;
            }
            getAddress(coords);
        });

        // Создание метки
        function createPlacemark(coords) {
            return new ymaps.Placemark(coords, {
                iconContent: 'поиск...'
            }, {
                preset: 'islands#violetStretchyIcon',
                draggable: true
            });
        }

        // Определяем адрес по координатам (обратное геокодирование)
        function getAddress(coords) {
            myPlacemark.properties.set('iconContent', 'поиск...');
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);

                myPlacemark.properties
                    .set({
                        iconContent: firstGeoObject.properties.get('name'),
                        balloonContent: firstGeoObject.properties.get('text')
                    });
            });
        }

        $('#city, #address').change(function(){
            myMap.destroy();
            city_name = $("#city option:selected").html();
            address = $("#address").val();
            isShowed = false;
        });

    }

    $('#save_map_modal').click(function () {
        if( myPlacemark = init.prototype.myPlacemark ) {
            var address = myPlacemark.properties._data.iconContent;
            $('#address').val(address);
        } 
        return true;
    });
});