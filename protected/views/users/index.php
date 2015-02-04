<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <span>Личный кабинет</span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'users');?>
        <div class="white-block">
            <div class="padding-title title-big"><?= (count($arguments)>1) ? 'Ваши объявдения' : 'Ваше объявление' ;?></div>
            <div class='padding-title success-flash'>
                <?= heretic::getFlash('success');?>
            </div>    
            
            <div class='padding-title errors-text'>
                <?= heretic::getFlash('errors');?>
            </div>   
            <?php  if(!empty($arguments)) : ?>
                <?php foreach ($arguments as $key => $value) : ?>
                    <div class="block-padding bottom-line">
                        <div class="user-object-left">
                            <div class="result-img-wrap">
                                <div class="result-img">
                                    <?php if((!empty($value['main_image']))&&(file_exists(heretic::$_path['images_thumb'].$value['main_image']))) :?>
                                        <img src="/<?= heretic::$_path['images_thumb'].$value['main_image'];?>">
                                    <?php else :?>
                                        <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                                    <?php endif;?>
                                </div>    
                            </div>    
                            <div class="result-text">
                                <div class="object-name"><a href="/users/object/<?=$value['id']?>">Квартира <?=$value['public_square']?> м&#178;</a></div>
                                <div class="object-price"><?=$this->smarty_modifier_sum_convert($value['price'],'summa')?></div>
                                <div class="object-place"><?=$value['street']?></div>
                                <div class="object-status"><span class="<?= ($value['color'] == 'red') ? 'red-text' : 'success-text' ; ?>"> <?=$value['moderation']?></span></div>
                            </div>
                        </div>
                        <div class="user-object-center">
                            <div class="rating-line">
                                <span class="rating-label">Добавлено в избранное</span>
                                <span class="rating-result"><?= (!empty($value['count'])) ? $value['count'] : '0';?></span>
                            </div>
                            <div class="rating-line">
                                <span class="rating-label">Просмотров всего</span>
                                <span class="rating-result"><?= (!empty($value['browsing'])) ? $value['browsing'] : '0';?></span>
                            </div>
                            <div class="rating-line">
                                <span class="rating-label">Просмотров за сегодня</span>
                                <span class="rating-result"><?= (!empty($value['browsing_day'])) ? $value['browsing_day'] : '0';?></span>
                            </div>
                        </div>   
                        
                        <div class="user-object-right">
                            <div class="rating-line">
                                <form method="post" action="/users/deleteObject" class=''>
                                    <input name='id' type="hidden" value='<?=$value['id']?>'>
                                    <button type='submit' class='btn btn-red'>Удалить</button>
                                </form>
                            </div>
                            <div class="rating-line">
                                <?php if($value['stat'] == -2) : ?>
                                    <form method="post" action="/users/moveObject" class=''>
                                        <input name='id' type="hidden" value='<?=$value['id']?>'>
                                        <button type='submit'class='btn btn-green'>Разместить объявление</button>
                                    </form>
                                <?php else :?>
                                <form method="post" action="/users/removeObject" class=''>
                                    <input name='id' type="hidden" value='<?=$value['id']?>'>
                                    <button type='submit'class='btn btn-blue'>Временно снять с продажи</button>
                                </form>
                                <?php endif;?>
                            </div>
                            
                        </div> 
                        
                        <div class="clearfix"></div>
                    </div>    
                <?php endforeach;?>
            <?php else : ?>
                <div class="block-padding">
                    <p>У вас пока нет объявлений</p>
                </div>    
            <?php endif;?>
        </div>    
    </div>    
</div>

