ymaps.ready(init);

function init() {
     navigator.geolocation.getCurrentPosition(showinfo, showerror);
}

function showinfo(position){
    
    var myAddress = [], myHint = [], myId = [];

    var myMap = new ymaps.Map('map', {
        center: [position.coords.latitude, position.coords.longitude],
        zoom: 1
    });

    var myPoint = new ymaps.Placemark([position.coords.latitude, position.coords.longitude], { hintContent: 'Местонахождение' }, {
        preset: 'islands#circleDotIcon',
        iconColor: 'red'
    });
    myPoint.events.add('click', function () {
        alert('Тут будет переход по ссылке!');
    });
    myMap.geoObjects.add(myPoint);
    
    ymaps.geocode([position.coords.latitude, position.coords.longitude]).then(function (res) {
            var myGeoObject = res.geoObjects.get(0), 
                bounds = myGeoObject.properties.get('boundedBy');

                myMap.setBounds(bounds, {
                    checkZoomRange: true
                });
            var city = myGeoObject.properties.get(
                'metaDataProperty.GeocoderMetaData.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName');
            $.post('/geography/', { city: city }, function(data){
                var arr = jQuery.parseJSON(data);
                for(var i = 0; i < arr.length; i++) {
                    myAddress.push(arr[i].address);
                    myHint.push(arr[i].hint);
                    myId.push(arr[i].id);
                }
                set_point(myAddress, myHint, myId);
                
                
            });
    });
    function set_point(address, hint){
        var c = 0, j = 0;
        for(var i = 0; i < address.length; ++i){
            ymaps.geocode(address[i], { results: 1 }).then(function (res) {
                // Выбираем первый результат геокодирования.
                var firstGeoObject = res.geoObjects.get(0),
                    // Координаты геообъекта.
                    coords = firstGeoObject.geometry.getCoordinates(),
                    // Область видимости геообъекта.
                    bounds = firstGeoObject.properties.get('boundedBy');
                    
				    // Добавляем первый найденный геообъект на карту.
                    var schoolPoint = new ymaps.Placemark(coords, { hintContent: hint[c++] }, 
                    {
                        preset: 'islands#dotIcon',
                        iconColor: '#1faee9'
                    });
                
                    schoolPoint.events.add('click', function () {
                        location.href = 'http://' + location.host + '/ourworks/' + myId[j++];
                    });
                
                    myMap.geoObjects.add(schoolPoint);
                
                // Масштабируем карту на область видимости геообъекта.
                myMap.setBounds(bounds, {
                    // Проверяем наличие тайлов на данном масштабе.
                    checkZoomRange: true
                });
            });
        }
    }
}

function showerror(error){
    alert('Ошибка: '+error.code+' '+error.message);
}