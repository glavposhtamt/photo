ymaps.ready(init);


function init() {
     navigator.geolocation.getCurrentPosition(showinfo, showerror);
}

function showinfo(position){

    var myMap = new ymaps.Map('map', {
        center: [position.coords.latitude, position.coords.longitude],
        zoom: 1
    });

    var myPoint = new ymaps.Placemark([position.coords.latitude, position.coords.longitude], { hintContent: 'Ну давай уже тащи' }, {
        preset: 'islands#circleDotIcon',
        iconColor: 'red'
    });
    myPoint.events.add('click', function () {
        alert('О, событие!');
    });
    myMap.geoObjects.add(myPoint);
    
    ymaps.geocode([position.coords.latitude, position.coords.longitude]).then(function (res) {
            var myGeoObject = res.geoObjects.get(0), 
                bounds = myGeoObject.properties.get('boundedBy');

                myMap.setBounds(bounds, {
                    checkZoomRange: true
                });
            console.log('Текущий город: ',myGeoObject.properties.get(
                'metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName'));
    });
    function set_point(address){
        for(var i = 0; i < address.length; ++i){
            ymaps.geocode(address[i], { results: 1 }).then(function (res) {
                // Выбираем первый результат геокодирования.
                var firstGeoObject = res.geoObjects.get(0),
                    // Координаты геообъекта.
                    coords = firstGeoObject.geometry.getCoordinates(),
                    // Область видимости геообъекта.
                    bounds = firstGeoObject.properties.get('boundedBy');
                
				    // Добавляем первый найденный геообъект на карту.	
                    myMap.geoObjects.add(new ymaps.Placemark(coords, { hintContent: 'Ну давай уже тащи' }, 
                    {
                        preset: 'islands#dotIcon',
                        iconColor: '#1faee9'
                    }));
                
                // Масштабируем карту на область видимости геообъекта.
                myMap.setBounds(bounds, {
                    // Проверяем наличие тайлов на данном масштабе.
                    checkZoomRange: true
                });
            });
        }
    }

   set_point(['Джанкой, Проезжая 60', 'Джанкой, Маяковского, 72', 'Джанкой, Ярмарочная, 9']);
}

function showerror(error){
    alert('Ошибка: '+error.code+' '+error.message);
}