
/*
 * 26-08-2014
 * Модуль работы с карты
 * Работа с yandex.api
 * Разработчик Олег Байгулов
 */


$(document).ready(function(){
    
    
    $('form[name="search"] select[name="city"]').on('selectmenuchange', function(event, ui){
        var cityIndex = ui.item.index;
        var city = $('select[name="city"] option:eq(' + cityIndex + ')').val();
        
        if (city!=''){ 
            $.ajax({
                url: "/ajax/getCoordCity",
                type: "POST",
                dataType: "JSON",
                data: {'city':city},
                success: function(e, data){
                    console.log(e);
                    if(e){
                        myMap.setCenter([e.coord_y, e.coord_x], 11);
                    }
                 }
             });
        }
        
    });
    
    
    $('.search-map-button').on('click', function(){
            
        if($('.search-map-block').length){
            $('.search-map-block').toggleClass('search-hidden'); 
        }else{
            $('.absolut-block').removeClass('hidden');
        }

    });
    
    
    $('.show-map').on('click', function(){
       
        if($('.search-map-block').length){
            $('.search-map-block').toggleClass('search-hidden'); 
        }else{
            $('.absolut-block').removeClass('hidden');
        }
        
    });
    
    
    $('.btn-close-absolute').on('click', function(){
        $('.absolut-block').addClass('hidden');
    });
    
    
    if($('#map-search').length){
        ymaps.ready(map);

        $('.map-btn-add').on('click', drawRectangle);
        $('.map-btn-stop').on('click', stopDraw);
        $('.map-btn-clear').on('click', removeRectangle);
        $('.map-btn-search').on('click', ajaxSearchObject);
    }
    
    if($('#map-search-2').length){
        ymaps.ready(mapTwo);
    }
    
});


/*
 * 2-09-2014
 * Аякс поиск по карте
 * Roy
 */

function ajaxSearchObject(){
    var category = $('select[name="category"]').val();
    var type = $('select[name="type"]').val();
    var square_min = $('input[name="square_min"]').val();
    var square_max = $('input[name="square_max"]').val();
    var price_min = $('input[name="price_min"]').val();
    var price_max = $('input[name="price_max"]').val();
    
    $.ajax({
            url: "/ajax/postSearch",
            type: "POST",
            dataType: "JSON",
            data: {'category':category, 'type':type, 'square_min':square_min, 'square_max':square_max, 'price_min':price_min, 'price_max':price_max,},
            success: function(e, data){
                if(e){
                    //console.log('Поиск идёт испешно');
                    forResultMap()
                }else{
                    getError('В данный момент поиск невозможен!');
                }

             },
             error: function(data){
                    getError('В данный момент поиск невозможен');
             }
         });
         
    setTimeout(function(){
            
        
    }, 2000)     
    
}

/*
 * 3-09-2014
 * Вывод ошибок
 * roy
 */

function getError(text){
    $('.error-search').text(text);
}


/*
 * 3-09-2014
 * Возврат результатов поиска аяксом
 * roy
 */


function forResultMap(){
    countResult = 0;
    $.ajax({
        url: "/ajax/AjaxSearch",
        type: "POST",
        dataType: "JSON",

        success: function(e, data){

            if(e){
                myCollection.removeAll();
                myCollection = new ymaps.GeoObjectCollection({}, {
                    preset: 'twirl#redIcon', //все метки красные
                });
                
                $('.search-result').html('');
                
                for(var key in e){
                    
                    if(typeof polygon != "undefined"){
                        if(e[key].cordin ){
                            /*
                             * Если кординаты объекта присутствуют в БД
                             */
                            e[key].bool = getInsertPolygon(e[key])
                            if (e[key].bool){
                                countResult++;
                                getPointsToMap(e[key]);
                                getPointsToPlace(e[key]);
                            }


                        }else{
                            
                            /*
                             * Если кординаты объекта отсутствуют в БД
                             */
                            
                            e[key].address = e[key].city + " " + e[key].street + " " + e[key].home;
                            e[key].coord = new getCoordinate(e[key].address);
                            countResult++;
                            //console.log(e[key]);
                            timeOutPoints(e[key]);
                        }
                    }
                }
                
                if (countResult == 0) {$('.search-result').append('<div class="result-count">Объявлений не найдено</div>')}
                $('.search-result').append('<div class="clearfix"></div>');

                myMap.geoObjects
                    .add(myCollection)

                //console.log('Поиск идёт испешно 2');
            }else{
                getError('Объектов не найдено');
            }
         },
         error: function(data){
                getError('В данный момент поиск невозможен');
         }
    }); 
    
}


/*
 * 3-09-2014
 * Вспомагательная функция, для обработки объектов с отсутствующими координатами
 * roy
 */

function timeOutPoints(object){
    
    setTimeout(function(){
        setCoord(object.coord, object.address, object.id);
        object.cordin = new Object();
        object.cordin.coord_x = object.coord.obj_x;
        object.cordin.coord_y = object.coord.obj_y;
        
        object.bool = getInsertPolygon(object)
        if (object.bool){
            getPointsToMap(object);
            getPointsToPlace(object);
        }else{
            countResult--;
        }
        
    },1000)
    
}


/*
 * 3-09-2014
 * Вывод объектов в основную область
 * roy
 */

function getPointsToPlace(object){
    var square = '';
    if (object.public_square != ''){
        square = object.public_square + ' м&#178;';
    }
    
    if(object.main_image == ''){
        object.main_image = "/template/default/img/no_images.jpg";
    }else{
        object.main_image = "/assets/images/thumb/" + object.main_image;
    }
    
    var resultWrap = $('.search-result');
    $(resultWrap).append('\
                            <div class="result-block bottom-line">\n\
                                <div class="result-img-wrap">\n\
                                    <div class="result-img">\n\
                                        <a href="/objects/object/'+object.id+'"><img src="' + object.main_image + '"></a>\n\
                                    </div>\n\
                                </div>\n\
                                <div class="result-text">\n\
                                    <div class="object-name"><a href="/objects/object/' + object.id + '">'+ object.type + ' ' + square + '</a></div>\n\
                                    <div class="object-price"> ' + object.price + ' </div>\n\
                                    <div class="object-place">' + object.street + '</div>\n\
                                </div>\n\
                            </div>');
  
}

/*
 * 3-09-2014
 * Вывод объектов на карту
 * roy
 */

function getPointsToMap(object){
    //console.log(object);
    
    var cr = [object.cordin.coord_x, object.cordin.coord_y];
    var square = '';
    if (object.public_square != ''){
        square = object.public_square + ' м&#178;';
    }

    myCollection.add(
            new ymaps.Placemark(cr, {
                balloonContentHeader: '<a target="object_'+object.id+'" href="/objects/object/' + object.id + '">' + object.type + " " + square + "</a>",
                balloonContent: '<div> ' + object.price + ' руб. </div>',
            }) 
    ); 
    
}


/*
 * 2-09-2014
 * Проверка на вхождение в область точки
 * roy
 */

function getInsertPolygon(object){
    if(typeof polygon != "undefined"){
        var cordin = [object.cordin.coord_x, object.cordin.coord_y];
        var result = polygon.geometry.contains(cordin); 
        return result;
    }else{
        return false;
    }
    
    
}



/*
 * 2-09-2014
 * Выделение области на карте
 * Roy
 */

function drawRectangle(){
    $('.map-btn-add').addClass('hidden');
    $('.map-btn-stop').removeClass('hidden');
    
    if(typeof polygon != "undefined") removeRectangle();
    
    polygon = new ymaps.Polygon([[]],{},{});

    myMap.geoObjects.add(polygon);
    polygon.editor.startDrawing();
    
}



/*
 * 2-09-2014
 * Остановить выделение по карте
 * Roy
 */

function stopDraw(){
    $('.map-btn-stop').addClass('hidden');
    $('.map-btn-add').removeClass('hidden');
    polygon.editor.stopEditing();
    printGeometry(polygon.geometry.getCoordinates());
}


/*
 * 2-09-2014
 * Очистка карты от выделения
 * Roy
 */

function removeRectangle(){
    myMap.geoObjects.remove(polygon);
}


/*
 * 2-09-2014
 * Получение координат выделенного объекта
 * Roy
 */

function printGeometry(coords){
    //console.log(coords);
    $('#geometry').val(stringify(coords));
 
    function stringify (coords) {
        var res = '';
        if ($.isArray(coords)) {
            res = '[ ';
            for (var i = 0, l = coords.length; i < l; i++) {
                if (i > 0) {
                    res += ', ';
                }
                res += stringify(coords[i]);
            }
            res += ' ]';
        } else if (typeof coords == 'number') {
            res = coords.toPrecision(6);
        } else if (coords.toString) {
            res = coords.toString();
        }

        return res;
    }
    
}

/*
 * 02-09-2014
 * Воссоздание полигона по координатам из поля
 * roy
 */
function restoreDraw(){
    var geocoord = $('#geometry').val();
    //console.log(geocoord);
    if(typeof polygon != "undefined") removeRectangle();
    
    polygon = new ymaps.Polygon(geocoord,{},{});

    myMap.geoObjects.add(polygon);
}


function map(){
    
    
    var city = $('select[name="city"]').val();
    var mapingObject = new Object;
    mapingObject.center = new Object;
    mapingObject.center.x = 39.7041;
    mapingObject.center.y = 47.244;
    
    if (city!=""){
        mapingObject.center.x = $('select[name="city"] option:selected').attr('data_x');
        mapingObject.center.y = $('select[name="city"] option:selected').attr('data_y');
    }
    
    
    
    myMap = new ymaps.Map("map-search", {
            center: [mapingObject.center.y, mapingObject.center.x],
            zoom: 11,
        });
        
    
    mapingObject.obj = new allObject();
    
    myCollection = new ymaps.GeoObjectCollection({}, {
        preset: 'twirl#redIcon', //все метки красные
    });
    
    
    
    setTimeout(function(){
        for(var key in mapingObject.obj) {
            if (mapingObject.obj[key].coord.status =="error"){
                mapingObject.obj[key].coord = new getCoordinate(mapingObject.obj[key].address);
                
            }
        }
        
        setTimeout(function(){
            for(var key in mapingObject.obj) {
                if (mapingObject.obj[key].coord.status =='forset') {
                    setCoord(mapingObject.obj[key].coord, mapingObject.obj[key].address, mapingObject.obj[key].id);
                    mapingObject.obj[key].coord.status='success';
                }
                
                var cr = [mapingObject.obj[key].coord.obj_x, mapingObject.obj[key].coord.obj_y];
                var square = '';
                if (mapingObject.obj[key].square != ''){
                    square = mapingObject.obj[key].square + ' м&#178;';
                }
                
                myCollection.add(
                        new ymaps.Placemark(cr, {
                            balloonContentHeader: '<a href="/objects/object/' + mapingObject.obj[key].id + '">' + mapingObject.obj[key].type + " " + square + "</a>",
                            balloonContent: '<div> ' + mapingObject.obj[key].price + ' руб. </div>',
                        }) 
                );
            }
            myMap.geoObjects
                    .add(myCollection)
                    
        }, 3000);
        
    },3000);
    
}



function mapTwo(){
    
    var map_adress = $('.adress-for-map').text();
    
    var object = new getCoord(map_adress);
    
    setTimeout(function(){
        
        
        myMap = new ymaps.Map("map-search-2", {
            center: [object.obj_x, object.obj_y],
            zoom: 11,
        });
        
        myCollection = new ymaps.GeoObjectCollection({}, {
            preset: 'twirl#redIcon', //все метки красные
        });
        
        
        myCollection.add(
            new ymaps.Placemark([object.obj_x,object.obj_y], {
                
            }) 
        );

        myMap.geoObjects
                    .add(myCollection)

        
        
    }, 3000);
    console.log(object);
    
}


function allObject(){
    var thisis = this;
    $('.for-yandex-map .ya-object').each(function(i){
       var object = new Object();
       object.id = $(this).attr('data-id');
       object.category = $(this).attr('data-category');
       object.type = $(this).attr('data-type');
       object.city = $(this).attr('data-city');
       object.street = $(this).attr('data-street');
       object.home = $(this).attr('data-home');
       object.apartament = $(this).attr('data-apartament');
       object.square = $(this).attr('data-square');
       object.price = $(this).attr('data-price');
       object.address =  object.city + " " + object.street + " " + object.home;
       object.coord = new getCoord(object.address);
       thisis[i] = object;
    });
    
}


function getCoordinate(address){
    var myGeocoder = ymaps.geocode(address);
    var thisis = this;
    myGeocoder.then(
        function (res) {
            thisis.obj_x = res.geoObjects.get(0).geometry.getCoordinates()[0];
            thisis.obj_y = res.geoObjects.get(0).geometry.getCoordinates()[1];
            thisis.status = 'forset';
        },
        function (err) {
            thisis.status = 'error';
        }
    );
    
}


function getCoord(address){
    var thisis = this;
    $.ajax({
        url: "/ajax/getCoord",
        type: "POST",
        dataType: "JSON",
        data: {'address':address},
        success: function(e, data){
            if(e){
                thisis.obj_x = e.coord_x;
                thisis.obj_y = e.coord_y;
                thisis.status = "success";
            }else{
                thisis.status = "error";
            }
        },
        error: function(data){
            thisis.coord.status = 'error';
        }
    });
}

function setCoord(coord, address, id){
    $.ajax({
        url: "/ajax/setCoord",
        type: "POST",
        dataType: "JSON",
        data: {'cx' : coord.obj_x, 'cy' : coord.obj_y, 'address':address, 'id':id},
        success: function(e, data){
            //if(e) //console.log('Запись координат в БД успешна');
                //else //console.log('Произошла ошибка записи координат в бд');
        },
        error: function(data){
            //console.log('Произошла ошибка записи координат в бд');
        }
    });
}
