<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usersMenuWidget
 *
 * @author Рой
 */
class usersMenuWidget extends widgetClass{
    
    public function index($type){
        
        switch ($type) {
            case 'blog':
                $menu = array(
                    1 => array(
                        'link' => '/blog',
                    ),
                    2 => array(
                        'link' => '/blog/buyer',
                        'text' => 'Покупателю',
                    ),
                    3 => array(
                        'link' => '/blog/seller',
                        'text' => 'Продавцу',
                    ),
                    4 => array(
                        'link' => '/blog/tenant',
                        'text' => 'Арендатору',
                    ),
                    5 => array(
                        'link' => '/blog/landlord',
                        'text' => 'Арендо - дателю',
                    )
                );
                break;
            
            case 'users':
                $menu = array(
                    1 => array(
                        'link' => '/users',
                    ),
                    2 => array(
                        'link' => '/users/favorites',
                        'text' => 'Избранное',
                    ),
                    3 => array(
                        'link' => '/users/schedule',
                        'text' => 'Расписание просмотров',
                    ),
                    4 => array(
                        'link' => '/users/personal',
                        'text' => 'Личные данные',
                    ),
                    5 => array(
                        'link' => '/users/code',
                        'text' => 'Код доступа',
                    )
                );
                break;
            
            case 'admin':
                $menu = array(
                    1 => array(
                        'link' => '/admin',
                    ),
                    2 => array(
                        'link' => '/admin/blog',
                        'text' => 'Блог',
                    ),
                    3 => array(
                        'link' => '/admin/rulesUsers',
                        'text' => 'Права доступа',
                    ),
                    4 => array(
                        'link' => '/admin/key',
                        'text' => 'Генерация ключей',
                    ),
                    5 => array(
                        'link' => '/admin/city',
                        'text' => 'Города',
                    )
                );
                break;
            
            case 'moder':
                $menu = array(
                    1 => array(
                        'link' => '/moderation/listObject',
                    ),
                    2 => array(
                        'link' => '/moderation/listObject',
                        'text' => 'Список на модерацию',
                    ),
                    3 => array(
                        'link' => '/moderation/banlist',
                        'text' => 'Бан лист',
                    ),
                    4 => array(
                        'link' => '/moderation/editnews',
                        'text' => 'Новости',
                    ),
                    5 => array(
                        'link' => '/moderation/otvetPage',
                        'text' => 'Рейтинг ответов',
                    )
                );
                break;
            
            default:
                $menu = array(
                    1 => array(
                        'link' => '/users',
                    ),
                    2 => array(
                        'link' => '/users/favorites',
                        'text' => 'Избранное',
                    ),
                    3 => array(
                        'link' => '/users/schedule',
                        'text' => 'Расписание просмотров',
                    ),
                    4 => array(
                        'link' => '/users/personal',
                        'text' => 'Личные данные',
                    ),
                    5 => array(
                        'link' => '/users/code',
                        'text' => 'Код доступа',
                    )
                );
                break;
        };
        
        $this->render('index', array ('menu' => $menu));
    }
    
}
