<div class="conteiner text-page" ng-app="billing-app">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/moderation"><?=heretic::$_config['titlePage']?></a>
                &rarr;
                <a href="/moderation/banlist">Бан Лист</a>
                &rarr;
                <span>Биллинг</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'moder');?>
        <div class="white-block" ng-controller="billingCTRL">
            <div class="padding-title title-big">Биллинг</div>
            
            <div class="download-billing">
                <a href="/moderation/loadBillingTable">Загрузить таблицу файлом</a>
            </div>
            <?php if(!empty($arguments['result'])) : ?>
            <div class="billing-table-wrap">
                <div class="filter-search">
                    <div class="search-row">
                        <label>Город :</label> 
                        <select class="citySelect"  ng-model="searchText.city" ng-options="city for city in allCities">
                            <option>{{ city }}</option>
                        </select>
                    </div>
                    
                    <div class="search-row">
                        <label>Телефон :</label> <input class="search-phone mask-for-phone" ng-model="searchText.phone">
                    </div>
                    <div class="search-row">
                        <label>Дата последнего визита от :</label> <input class="search-date-min" ng-model="dateVisited.min" ng-change="filterVisited(dateVisited)">
                        <label> по :</label> <input class="search-date-max" ng-model="dateVisited.max" ng-change="filterVisited(dateVisited)">
                    </div>
                    <div class="search-row">
                        <label>Количество объявлений :</label> <input class="search-phone" ng-model="searchText.count">
                    </div>
                    <div class="search-row">
                        <label>Статус :</label> 
                        <select class="statusSelect"  ng-model="searchText.status" ng-options="selStatus for selStatus in selectStatus">
                            <option>{{ selStatus }}</option>
                        </select>
                    </div>
                </div>
                <table class="billing-table">
                    <thead>
                        <tr>
                            <th class="c1">Город</th>
                            <th class="c2">Контактное лицо</th>
                            <th class="c3">Телефон</th>
                            <th class="c4">Email</th>
                            <th class="c5">Дата регистрации</th>
                            <th class="c6">Дата последнего визита</th>
                            <th class="c7">Количество объявлений</th>
                            <th class="c8">Статус</th>
                            <th class="c9">Коментарий администратора</th>
                            <th class="c10">Сменить пароль</th>
                        </tr>
                    </thead>    
                    <tbody>
                        <tr data-ng-repeat="user in users | filter:searchText" data-user="{{user.id_user}}">
                            <td>
                                {{ user.city }} 
                                <div class="btn btn-red btn-del-user" ng-click="deleteUser(user)">Удалить</div>
                            </td>
                            <td> {{ user.fio }} </td>
                            <td> {{ user.phone }} </td>
                            <td> {{ user.email }} </td>
                            <td> {{ user.date_registration }} </td>
                            <td> {{ user.date_visited }} </td>
                            <td> {{ user.count }} </td>
                            <td class="user-status" ng-click="statusChange(user)"> 
                                <span class="status-val">{{ user.status }}</span>
                            </td>
                            <td class="comment-cell" ng-click="commentChange(user)">
                                <span class="comment-val">{{ user.comment }}</span>   
                            </td>
                            <td class="pass-cell">
                                <input name="newPass" type="text" ng-model="newPass">
                                <div class="btn btn-green btn-edit-pass" ng-click="editPass(user)">Сменить пароль</div>
                            </td>
                        </tr>
                        
                    <?php /* foreach ($arguments['result'] as $key => $value) : ?>
                        <tr data-user="<?=$value['id_user']?>">
                            <td><?=$value['city']?></td>
                            <td><?=$value['fio']?></td>
                            <td><?=$value['phone']?></td>
                            <td><?=$value['email']?></td>
                            <td><?=$value['date_registration']?></td>
                            <td><?=$value['date_visited']?></td>
                            <td <?=($value['count'] == 0) ? 'class="zero"' : '' ;?>><?=$value['count']?></td>
                            <td <?=($value['status'] == 'Забанен') ? 'class="red-cell"' : '' ;?>><?=$value['status']?></td>
                            <td class="comment-cell">
                                <span class="comment-val"><?=$value['comment']?></span>    
                                <div class="comment-cell-window">
                                    <textarea name="comment-text" class="comment-text"></textarea>
                                    <button type="button" class="btn btn-blue btn-add-comment">Добавить</button>
                                </div>    
                            </td>
                        </tr>
                    <?php endforeach; */ ?>
                    </tbody>
                </table>    
            </div>    
            <?php else : ?>
            <div class="billing-table-error">
                Пользователей не найдено.
            </div>    
            <?php endif;?>
          
            
            <div class="pp-templ-select-status">
                <div class="select-change-menu">
                    <select class="statusSelect"  ng-model="statusSelect" ng-options="selStatus for selStatus in selectStatus">
                        <option>{{ selStatus }}</option>
                    </select>  
                    
                    <button type="button" class="btn btn-blue btn-save-status">Сохранить</button>
                </div>
            </div>
            
            
            <div class="pp-templ-comment">
                <div class="comment-cell-window">
                    <textarea name="comment-text" class="comment-text"></textarea>
                    <button type="button" class="btn btn-blue btn-add-comment" >Добавить</button>
                </div>
            </div>
            
        </div>    
    </div>    
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>

<script type="text/javascript" src="/<?=  heretic::$_path['template']?>js/billing.js"></script>


    