/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('billing-app', ['ngRoute'])
        .controller('billingCTRL', function($scope, $http){
             var templateStatus = $('.pp-templ-select-status'),
                 templateComment = $('.pp-templ-comment'),
                 allCities = '',
                 allUsers = {},
                 billing = (function(){
                 
                 var
                    TEXT_EXPLODE = '',
                    usersAll = [],
                    getUsers = function(){
                        $http.get('/ajax/getAllUsers')
                            .then(function(resp){
                                if(resp.data.errors){
                                    console.log(resp.data.errors);
                                return false;
                            }
                            $scope.users = resp.data.users;
                            usersAll = resp.data.users;
                            allUsers = $scope.users;
                        }, function(err){
                            console.log(err);
                        });
                    },
                    statusChange = function(user){
                        var row = $('.billing-table').find('tr[data-user="'+user.id_user+'"]'),
                            cell = $(row).find('.user-status'),
                            that = cell;
                        
                        if(!$(that).hasClass('active')){
                            $(that).addClass('active');  
                            $(cell).css('position', 'relative');

                            $(cell).append($(templateStatus).html());
                            $(cell).find('.btn-save-status').on('click', billing.addStatus);
                            
                            
                            setTimeout(function(){
                                $(document).on('click', function(e){
                                    if ($(e.target).closest(that).length) return false;

                                    $(cell).find('.select-change-menu').remove();
                                    $(that).removeClass('active');
                                    $(document).off('click');
                                    e.stopPropagation();
                                });
                            }, 100);
                        }
                        
                    },
                    commentChange = function(user){
                        var row = $('.billing-table').find('tr[data-user="'+user.id_user+'"]'),
                            cell = $(row).find('.comment-cell'),
                            that = cell;
                    
                        TEXT_EXPLODE = $.trim($(cell).find('.comment-val').text()); 
                        
                        if(!$(that).hasClass('active')){
                            $(that).addClass('active');    
                            $(cell).css('position', 'relative');
                            
                            
                            
                            console.log($(templateComment).html());

                            $(cell).append($(templateComment).html());
                            $(cell).find('.comment-text').text(TEXT_EXPLODE);
                            $(cell).find('.btn-add-comment').on('click', billing.addComment);
                            
                            $(cell).find('.comment-text').on('keyup', function(){
                                var that = this,
                                    thatText = $.trim($(this).val()),
                                    button = $(that).parents('.comment-cell-window').find('.btn-add-comment');
                                    
                                    if((thatText != TEXT_EXPLODE)&&($(button).css('display')!='block')){
                                        $(button).css({
                                            display:'block'
                                        });
                                    }
                                    
                            });
                            
                            
                            setTimeout(billing.closeComment, 100, {'that': that, 'cell':cell});
                        }
                        
                    
                    },
                    addStatus = function(e){
                        var that = this,
                            cell = $(that).parents('.user-status'),
                            userID = $(that).parents('tr').attr('data-user'),
                            status = $(cell).find('.statusSelect').val();
                            
                        status = $scope.selectStatus[status];    
                    
                        $.ajax({
                           url: '/ajax/addAdminStatus',
                           type: "POST",
                           dataType: 'JSON',
                           data: {id_user: userID, status:status},
                           success: function(e){
                                if(e.errors){
                                   alert(e.errors);
                                }else{
                                    if(e.success){
                                        $(cell).find('.status-val').text(status);
                                        $(cell).find('.select-change-menu').remove();
                                        $(that).removeClass('active')
                                        $(document).off('click');
                                    }
                                }
                           },
                           errors: function(e){
                               console.log(e);
                           }
                        });
                    
                    
                    },
                    closeComment = function(e){
                        var that = e.that,
                            cell = e.cell    
                        
                        $(document).on('click', function(e){
                            if ($(e.target).closest(that).length) return false;
                            $(cell).find('.comment-cell-window').remove();
                            $(that).removeClass('active');   
                            $(document).off('click');
                            e.stopPropagation();
                        });
                    },
                    addComment = function(e){
                        var that = this,
                            cell = $(that).parents('.comment-cell'),
                            userID = $(that).parents('tr').attr('data-user'),
                            comment = $(cell).find('.comment-text').val();
                    
                        $.ajax({
                           url: '/ajax/addAdminComment',
                           type: "POST",
                           dataType: 'JSON',
                           data: {id_user: userID, comment:comment},
                           success: function(e){
                                if(e.errors){
                                   alert(e.errors);
                                }else{
                                    if(e.success){
                                        $(cell).find('.comment-val').text(comment);
                                        $(cell).find('.comment-cell-window').remove();
                                        $(that).removeClass('active')
                                        $(document).off('click');
                                    }
                                }
                           },
                           errors: function(e){
                               console.log(e);
                           }
                        });
                        
                    },
                    getAllCities = function(){
                        $.ajax({
                            url: '/ajax/getAllCities',
                            type: "GET",
                            dataType: 'JSON',
                            success: function(e){
                                if(e.errors){
                                   alert(e.errors);
                                }else{
                                    if(e.success){
                                        var arrayResult = [''];
                                        allCities = e.cities;
                                        
                                        for(var key in allCities){
                                            arrayResult.push(allCities[key].city);
                                        }
                                        
                                        $scope.allCities = arrayResult;
                                    }
                                }
                           },
                           errors: function(e){
                               console.log(e);
                           }
                        });
                        
                        
                    },
                    editPass = function(user){
                        var pass = $('.billing-table tr[data-user="' + user.id_user + '"] .pass-cell input[name="newPass"]').val();
                        $.ajax({
                            url: '/ajax/editPass',
                            type: "POST",
                            dataType: 'JSON',
                            data: {id_user: user.id_user, password:pass},
                            success: function(e){
                                if(e.errors){
                                    if(e.errors.password){
                                        alert(e.errors.password);
                                    }else{
                                        alert(e.errors);
                                    }
                                    console.log(e.errors);
                                }else{
                                    if(e.success){
                                        alert(e.success);
                                        pass = '';
                                        $('.pass-cell input[name="newPass"]').val('');
                                    }
                                }
                            },
                            errors: function(e){
                                alert('ошибка соединения с сервером');
                               console.log(e);
                            }
                        })
                        
                    },
                    filterVisited = function(date){
                        
                        var min = date.min || '0001-01-01',
                            max = date.max || '9999-01-01',
                            result = [],
                            filter;
                            
                            console.log(min);
                            
                        
                        filter = $scope.users;
                        
                        for(var key in allUsers){
                            if((allUsers[key].date_visited >= min)&&(allUsers[key].date_visited <= max)){
                                console.log(allUsers[key].date_visited);
                                result.push(allUsers[key]);
                                
                                //console.log(max);
                                //console.log(filter[key].date_visited);
                            }
                        }
                        $scope.users = result;
                        
                    },
                    deleteUser = function(user){
                        
                        if(!confirm('Вы действительно хотите удалить')){
                            return false;
                        }
                        
                        var that = this,
                            row = $('.billing-table tr[data-user="' + user.id_user + '" ]'),
                            userID = user.id_user;
                            $.ajax({
                                url: '/ajax/deleteUserBilling',
                                type: "POST",
                                dataType: 'JSON',
                                data: {id_user: userID},
                                success: function(e){
                                    if(e.errors){
                                       alert(e.errors);
                                    }else{
                                        if(e.success){
                                            $(row).remove();
                                        }
                                    }
                               },
                               errors: function(e){
                                   console.log(e);
                               }
                            });
                            
                            
                            
                        
                    }
                 
                 return {
                     getUsers: getUsers,
                     statusChange: statusChange,
                     commentChange: commentChange,
                     addComment: addComment,
                     closeComment: closeComment,
                     addStatus: addStatus,
                     deleteUser: deleteUser,
                     getAllCities: getAllCities,
                     filterVisited: filterVisited,
                     editPass : editPass
                 }
             }());
             
             billing.getUsers();
             $scope.statusChange = billing.statusChange;
             $scope.commentChange = billing.commentChange;
             $scope.deleteUser = billing.deleteUser;
             $scope.filterVisited = billing.filterVisited;
             $scope.editPass = billing.editPass;
             
             $scope.selectStatus = ['', 'В поиске', 'уже купил', 'только продаёт', 'продаёт и ищет', 'уже продал', 'ищет аренду', 'сдаёт'];
             $scope.statusSelect = $scope.selectStatus[0];    
             
             billing.getAllCities();
             
             
});