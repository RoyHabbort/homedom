/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   
   var ii = 0;
   var TEXT_EXPLODE = "";
   
   /*
    * 5-11-2014
    * Сортировка таблиц
    * roy
    */
   
   //$(".billing-table").tablesorter(); 
   
   
   /*
    * 7-11-2014
    * Управление окном коментариев в биллинге
    * roy
    */
    
    //запрещаем всплытие событий клика на окне
    $('.comment-cell-window').on('click', function(e){
        e.stopPropagation();
    });
    //запрещаем всплытие событий клика на комменте
    $('.comment-text').on('click', function(e){
        e.stopPropagation();
    });
   
    //обрабатываем открытие окна при клике на ячейку комента
    $('.comment-cell').on('click', function(e){
        var that = this,
            comment = $.trim($(that).find('.comment-val').text()),
            button = $(that).find('.btn-add-comment');
        
        $(that).find('.comment-cell-window').css({
            display : 'block',
        });
        
        $('.comment-text').val(comment);

        $(that).find('.comment-text').animate({
            width: '170px',
            height: '50px'
        }, 400, function(){
            $(document).click(function(e){
                if ($(e.target).closest(that).length) return false;
                $(button).css('display', 'none');
                $(that).find('.comment-text').animate({
                    width: '0px',
                    height: '0px'
                }, 300, function(){
                    $(that).find('.comment-cell-window').css({
                        display : 'none'
                    });
                    $(document).off('click');
                    e.stopPropagation();
                });


            });
        });
      
    });
   
    //забиваем в глобальную переменную значение коммента по умолчанию
    $('.comment-text').on('focus', function(){
        TEXT_EXPLODE = $.trim($(this).val());
    });
   
    //кнопка добавить появляется только после изменения текста в поле коммента
    $('.comment-text').on('keyup', function(){
        var that = this,
            thatText = $.trim($(this).val()),
            button = $(that).parents('.comment-cell-window').find('.btn-add-comment');
        console.log(thatText + ' --- ' + TEXT_EXPLODE);    
        if((thatText != TEXT_EXPLODE)&&($(button).css('display')!='block')){
            $(button).css({
                display:'block'
            });
        }
    });
   
    //Сохранение коммента
    $('.btn-add-comment').on('click', function(e){
        var that = this,
            userID = $(that).parents('tr').attr('data-user'),
            thatText = $.trim($(this).parents('.comment-cell-window').find('.comment-text').val());
            
        $.ajax({
           url: '/ajax/addAdminComment',
           type: "POST",
           dataType: 'JSON',
           data: {id_user: userID, comment:thatText},
           success: function(e){
               console.log(e);
               
               if(e.errors){
                   alert(e.errors);
               }else{
                   if(e.success){
                        $(that).parents('.comment-cell').find('.comment-val').text(thatText);
                       
                        $(that).css('display', 'none');
                        $(that).parents('.comment-cell').find('.comment-text').animate({
                            width: '0px',
                            height: '0px'
                        }, 300, function(){
                            $(that).parents('.comment-cell').find('.comment-cell-window').css({
                                display : 'none'
                            });
                        });
                       
                   }
               }
               
           },
           error: function(err){
               console.log(err);
           }
        });    
            
        console.log(thatText);
        
        e.stopPropagation();
    });
   
   
   /*
    * 12-11-2014
    * 
    * roy
    */
   
   if ($('.search-date-min').length){
       $('.search-date-min').datepicker({
          dateFormat: "yy-mm-dd" 
       });
       $('.search-date-max').datepicker({
          dateFormat: "yy-mm-dd" 
       });
   }
   
   /* 5-08-2014
    * Создаём форму подать заявление
    * Олег Байгулов
    */
   
   $('.form-select').selectmenu();
   
   
   
    $.datepicker.setDefaults($.extend(
        $.datepicker.regional["ru"])
    );
   
   $('.schedule-date').datepicker({
       dateFormat:"yy-mm-dd",
   });
   $('.form-submit').on('click', function(){
      $(this).parents('form').find('input[type="submit"]').click(); 
   });
    
   $('#load-photo').change(function(){
       preview(this);
   });
   
   /* 14-08-2014
    * Обработка вводимых данных
    * Олег Байгулов
    */
    
    $('input[name="phone"]').mask("+7 (999) 999-99-99");
    $('.mask-for-phone').mask("+7 (999) 999-99-99");
    
    $('.addForm select[name="category"]').on( "selectmenuchange", function( event, ui ) {
        var category = ui.item.index;
        var cat = $('select[name="category"] option:eq(' + category + ')').val();
        if ((cat == 'rentals') || (cat == 'buy')){
            $('input[name="street"]').parents('.row-form').css('display', 'none');
            $('input[name="home"]').parents('.row-form').css('display', 'none');
            $('input[name="apartament"]').parents('.row-form').css('display', 'none');
        }else{
            $('input[name="street"]').parents('.row-form').css('display', 'block');
            $('input[name="home"]').parents('.row-form').css('display', 'block');
            $('input[name="apartament"]').parents('.row-form').css('display', 'block');
        }
        
    });
    
    
    
    $('select[name="city"]').on( "selectmenuchange", function( event, ui ) {
        var cityIndex = ui.item.index;
        var city = $('select[name="city"] option:eq(' + cityIndex + ')').val();
        if (city!=''){ 
            $.ajax({
                url: "/ajax/viewDistrict",
                type: "POST",
                dataType: "JSON",
                data: {'city':city},
                success: function(e, data){
                    $('select[name="district"]').html('');
                    $('select[name="district"]').append('<option value="">Выберите район</option>');
                    for(var i=0;i<e.length; i++){
                        $('select[name="district"]').append('<option value="'+e[i].id_district+'">'+e[i].district+'</option>');
                    }
                    $('select[name="district"]').selectmenu('refresh');
                 }
             });
        }else{
            $('select[name="district"]').html('');
            $('select[name="district"]').append('<option value="0">Выберите район</option>');
            $('select[name="district"]').selectmenu('refresh');
        }
    });
    
    
    
    $('.btn-add-schedule').on( "click", function(){
        var date = $('.schedule-date').val();
        var time = $('.time_schedule').val();
        if((date == '')||(time == '')){
            $('.object-schedule .errors-text').text('Записаться не удалось');
        }else{
            time = date + ' ' + time;
            var id = $('.time_schedule').attr('dataid');
            if(time!=''){
                $.ajax({
                    url: "/ajax/timeSchedule",
                    type: "POST",
                    dataType: "JSON",
                    data: {'time':time, 'id':id},
                    success: function(e, data){
                        //console.log(e);
                          if(e.dostup == 'no'){
                              
                              
                              $('.absolut-block').removeClass('hidden');
                             
                              
                          }else{
                              if(e){
                                  $('.object-schedule').html('');
                                  $('.object-schedule').append('<div class="success-text">Продавцу отправлено смс-уведомление с вашими контактными данными и временем вашего визита.</div>');
                              }else{
                                  $('.object-schedule .errors-text').text('Записаться не удалось');
                              }
                          }
                              
    //                    $('select[name="district"]').html('');
    //                    for(var i=0;i<e.length; i++){
    //                        $('select[name="district"]').append('<option value="'+e[i].id+'">'+e[i].district+'</option>');
    //                    }
    //                    $('select[name="district"]').selectmenu('refresh');
                     },
                     error: function(data){
                         $('.object-schedule .errors-text').text('Записаться не удалось');
                     }
                 });
            }
        }
        
    });
    
    
    /*
     * 12-09-2014
     * roy
     * Удаление пользователя
     */
    
    $('.btn-del-user').on('click', function(){
        
        var thisis = $(this).parents('.ban-row');
        var rules = $(thisis).find('.ban-result').attr('data-ban');
        var id = $(thisis).find('.id-user').text();

        $(thisis).find('.ban-error').text('');
        
        
        $.ajax({
            url: "/ajax/deleteUser",
            type: "POST",
            dataType: "JSON",
            data: {'id':id},
            success: function(e, data){
                if(e){
                    
                    $(thisis).remove();
                    
                }else{
                    $(thisis).find('.ban-error').text('Удалить пользователя не удалось');
                }

             },
             error: function(data){
                    $(thisis).find('.ban-error').text('Удалить пользователя не удалось');
             }
         });
        
    });
    
    
    /*
     * 08-09-2014
     * Roy
     * Код доступа "оплата"
     */
    
    $('.btn-code').on('click', function(){
       alert('Функция оплаты временно недоступна. Получите код доступа бесплатно.'); 
    });
    
    
    /*
     * 21-08-2014
     * Roy
     * Админка
     */
    $('.user-rules-save').on('click', saveRules);
    $('.ban-click').on('click', banfunc);
    
    /*
     * 26-08-2014
     * Выводи фотослайдер
     * Roy
     */
    
    $('.bxslider').bxSlider({
      pagerCustom: '#bx-pager'
    });
    
    $('.bxslider-pagination').bxSlider({
        pager: false,
        controls: true,
        slideWidth: 110,
        minSlides: 2,
        maxSlides: 6,
        
        slideMargin: 0,
    });
    
    $('.slide').on('click', function(){
       $('.slide').removeClass('active');
       $(this).addClass('active');
    });
    
    
    /*
     * 8-09-2014
     * Записаться на просмотр
     * Roy
     */
    
    $('#schedule-btn').on('click', function(){
       $('.schedule-object-wrap').removeClass('hidden');
       $('.background-wrap').removeClass('hidden');
    });
    
    $('.background-wrap').on('click', function(){
        $('.schedule-object-wrap').addClass('hidden');
       $('.background-wrap').addClass('hidden');
    });
    
    $('.btn-close-schedule').on('click', function(){
        $('.schedule-object-wrap').addClass('hidden');
       $('.background-wrap').addClass('hidden');
    });
    
    
    /*
     * 26-08-2014
     * Подключаем обработку дат при записи на просмотр 
     * Roy
     */
    
    $('.object-schedule .schedule-date').on('change', forschedule);
    
    /*
     * 29-08-2014
     * Добавляем и удаляем район
     * Roy
     */
    
    $('.district-unconfirm-delete').click(function(){
       $(this).addClass('hidden');
       $(this).parents('.district-row').find('.confirm-district').removeClass('hidden');
    });
    
    $('.add-district').on('click', addDistrict);
    
    $('.district-delete').on('click', removeDistrict);
    
    
    /*
     * 1-08-2014
     * Расписание просмотров, переключатель вкладок.
     * Roy
     */
    
    
    $('.tougle-btn .btn').click(function(){
        $('.tougle-btn .btn').removeClass('active');
        $(this).addClass('active');
        
        $('.section').removeClass('active-schedule');
        $('.section:eq(' + $(this).index() + ')').addClass('active-schedule');
    });
    
    
    /*
     * 9-09-2014
     * Загрузка файлов
     * Roy
     */
    
    
    $('#load-photo').uploadFile({
	url:"/ajax/uploadFile",
	fileName:"photogallery",
        showQueueDiv: 'upload-photo-block',
        showPreview:true,
        returnType:"json",
        multiple: false,
        showDone: false,
        showCancel:false,
        showAbort: false,
        showDelete:true,
        deletelStr: "<img class='img-close' src='/template/default/img/icons/icon-close.png'>",
        onSuccess: function (files, response, xhr, pd){
            
            $('.block-add-photo').removeClass('hidden-photo');
            
            var uniq = randomInt(1000000, 9999999);
            $(pd.statusbar).addClass('success-photo ');
            $(pd.statusbar).attr('uniq', uniq);
            $('.upload-hide').append('<input name="collection-'+ii+'" type="text" class="hidden collect-'+uniq+'" value="' + response[0] + '" >');
            
            ii++;
        },
    });
    
    $('#upload-photo-block').on('click', function(e){
       var el = e.target;
       if($(el).hasClass('upload-delete')){
           var uniq = $(el).parents('.file-upload-form').attr('uniq');
        
           $('.collect-'+uniq).remove();
       }
       
    });
    
    
    function randomInt(min, max) {
        return min + ((max-min+1)*Math.random()^0);
    }
    
    /*
     * 3-09-2014
     * Добавление фото
     * Roy
     */
    
    $('.photo-add-btn').on('click', addPhoto);
    
    
    /*
     * 3-09-2014
     * Выбор ответа для получения кода
     * Roy
     */
    
    $('.label-otvet').on('click', function(){
       $('.label-otvet').find('.krug').removeClass('active');
       $(this).find('.krug').addClass('active');
    });
    
    /*
    * 7-08-2014
    * Подключаем CKeditor
    * Олег Байгулов
    */
    
    if ($('#CKeditor').length){
        CKEDITOR.replace('CKeditor');
    }
    
});


function addPhoto(){
    
    var i = 0;
    if ($('.input-photogallery').length){
        i = $('.input-photogallery').last().attr('data-i');
    }
    i++;
    var inputForm = '<div class="input-row block-padding"><input class="input-photogallery" data-i="' + i + '" type="file" name="photogallery-'+i+'"></div>';
    
    $('.for-input-photo').append(inputForm);
}


function removeDistrict(){
    
    
    var id = $(this).attr('data-id-district');
    var to_id = $(this).parents('.confirm-district').find('select[name="stnd-select"]').val();

    var thisis = $(this);

    $.ajax({
        url: "/ajax/deleteDistrict",
        type: "POST",
        dataType: "JSON",
        data: {'id':id, 'to_id': to_id},
        success: function(e, data){
            if(e){
                $(thisis).parents('.district-row').remove();
            }else{
                getError('Удаление района невозможно');
            }

         },
         error: function(data){
                getError('Удаление района невозможно');
         }
     });
        
    
    
    
}

function addDistrict(){
    var district = $('input[name="district"]').val();
    var id = $('.add-district').attr('data-id-city');
  
    
    $.ajax({
        url: "/ajax/addDistrict",
        type: "POST",
        dataType: "JSON",
        data: {'district':district, 'id':id},
        success: function(e, data){
            if(e){
                var app = '<div class="block-padding bottom-line district-row">\n\
                            <div class="city-title">' + district + '</div>\n\
                            <div data-id-district = "' + e + '" class="btn btn-red district-delete" onClick=\' removeDistrict() \'>Удалить</div>\n\
                           </div>';
                $('.all-district').append(app);
                $('input[name="district"]').val('');
            }else{
                getError('Добавить район не удалось');
            }
 
         },
         error: function(data){
                getError('Добавить район не удалось');
         }
     });
     
     
     function getError(text){
         $('.error-district').text(text);
     }
    
}

function banfunc(){
    var thisis = $(this).parents('.ban-row');
    var rules = $(thisis).find('.ban-result').attr('data-ban');
    var id = $(thisis).find('.id-user').text();
    
    $(thisis).find('.ban-error').text('');
    
    $.ajax({
        url: "/ajax/banfunc",
        type: "POST",
        dataType: "JSON",
        data: {'rules':rules, 'id':id},
        success: function(e, data){
            if(e){
                if(rules == 1){
                    $(thisis).find('.ban-result').attr('data-ban', 0);
                    $(thisis).find('.ban-result').html('<span class="ban-text">Забанен</span>');
                    $(thisis).find('.ban-button .ban-click').removeClass('btn-red');
                    $(thisis).find('.ban-button .ban-click').addClass('btn-blue');
                    $(thisis).find('.ban-button .ban-click').text('Разбанить')
                }else{
                    $(thisis).find('.ban-result').attr('data-ban', 1);
                    $(thisis).find('.ban-result').html('<span class="active-ban-text">Активный пользователь</span>');
                    $(thisis).find('.ban-button .ban-click').removeClass('btn-blue');
                    $(thisis).find('.ban-button .ban-click').addClass('btn-red');
                    $(thisis).find('.ban-button .ban-click').text('Забанить')
                }
            }else{
                $(thisis).find('.ban-error').text('Действие не удалось');
            }
 
         },
         error: function(data){
                $(thisis).find('.ban-error').text('Действие не удалось');
         }
     });
    
}

function saveRules(){
    var thisis = $(this).parents('.users-block');
    var rules = $(thisis).find('.select-rules').val();
    var id = $(thisis).find('.id-user').text();
    
    $.ajax({
        url: "/ajax/rulesSave",
        type: "POST",
        dataType: "JSON",
        data: {'rules':rules, 'id':id},
        success: function(e, data){

            if(e){
                $(thisis).find('.rules-result-text').removeClass('errors-text');
                $(thisis).find('.rules-result-text').addClass('success-text');
                $(thisis).find('.rules-result-text').text('Сохранение успешно');
            }else{
                $(thisis).find('.rules-result-text').removeClass('success-text');
                $(thisis).find('.rules-result-text').addClass('errors-text');
                $(thisis).find('.rules-result-text').text('Сохранить не удалось');
            }
 
         },
         error: function(data){
                $(thisis).find('.rules-result-text').removeClass('success-text');
                $(thisis).find('.rules-result-text').addClass('errors-text');
                $(thisis).find('.rules-result-text').text('Сохранить не удалось');
         }
     });
    
}

function preview(input){
    if (input.files && input.files[0]) {
        
       $('label[for="load-photo"]').find('.inner-label-load').addClass('hidden');
       $('label[for="load-photo"]').find('#image-on-load').remove();
       $('label[for="load-photo"]').append('<img class="image-load" src="" id="image-on-load">');
        
       var reader = new FileReader();

        reader.onload = function (e) {
            $('#image-on-load').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
        
    }
    
    $(input).removeAttr('hidden');
}


function forschedule(){
    
    var text = $('.object-schedule .schedule-date').val();
    var id = $('.object-schedule .time_schedule').attr('data-id');
    var date = new Date(text.replace(/(\d+)-(\d+)-(\d+)/, '$2/$3/$1'));
    var curr_date = new Date();
    
    if (curr_date.valueOf()<(date.valueOf()+1000*60*60*24)){
        $('.object-schedule .errors-text').text('');
        $.ajax({
            url: "/ajax/ifSchedule",
            type: "POST",
            dataType: "JSON",
            data: {'date' : text, 'id' : id},
            success: function(e, data){
                
                
                
                
                
                $('.object-schedule .time_schedule').html('');
                $('.object-schedule .time_schedule').append('<option value="">Выберете время</option>');
                var start_time = $('.object-schedule .time_schedule').attr('date-start');
                var end_time =$('.object-schedule .time_schedule').attr('date-end');
                
                start_time = parseTime(start_time);
                end_time = parseTime(end_time);
                var curr_time = start_time;
                var out_time;
                do {
                    out_time = parseToTime(curr_time);
                    $('.object-schedule .time_schedule').append("<option value='"+out_time+"'>"+out_time+"</option>");
                    curr_time = curr_time + 15 * 60 * 1000;
                } while(curr_time < end_time);
                
                for(var key in e) {
                    e[key].needTime = e[key].time.split(' ')[1];
                    $('.object-schedule .time_schedule option[value="' + e[key].needTime + '"]').remove();
                }
                
                
                $('.object-schedule .time_schedule').selectmenu('refresh');
                //console.log(e);
                
             },
             error: function(data){
                    //console.log('аякс не выполнен');
             }
         });
    }else{
        $('.object-schedule .errors-text').text('Выбранная дата меньше текущей');
        $('.object-schedule .time_schedule').html('');
        $('.object-schedule .time_schedule').append('<option value="">Выберете сначала дату</option>');
        $('.object-schedule .time_schedule').selectmenu('refresh');
        //console.log('дата меньше текущей');
    }
    
}


function parseTime(time){
    
    var time_array = time.split(':');
    
    time = time_array[0] * 60 * 60 * 1000 + time_array[1] * 1000 * 60 + time_array[2] * 1000; 
    return time;
}


function parseToTime(time){
    var hour = Math.floor(time/(60*60*1000));
    time = time % (60*60*1000);
    var minute = Math.floor(time/(60*1000));
    time = time % (60*1000);
    var second = Math.floor(time/1000);
    
    if (hour<10) hour = '0' + hour;
    if (minute<10) minute = '0' + minute;
    if (second<10) second = '0' + second;
    
    var result = hour + ':' + minute + ':' + second;
    return result;
}


function confirmDelete(type) {
    var text = '';
    switch (type) {
        case 'city' : text = 'Вместе с городом будут удалены все объявления данного города. Вы подтверждаете удаление?'; break
        case 'district' : text = 'Вместе с районом будут удалены все объявления данного района. Вы подтверждаете удаление?'; break
        default : text = 'Вместе с городом будут удалены все объявления данного города. Вы подтверждаете удаление?'; break
    }
    if (confirm(text)) {
        return true;
    } else {
        return false;
    }
}
