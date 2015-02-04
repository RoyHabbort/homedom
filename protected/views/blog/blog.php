<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/blog/<?=$arguments['result']['category']?>">Блог</a>
                &rarr;
                <span><?=$arguments['result']['title']?></span>
            </div>
        </div>    
        <?php heretic::Widget('usersMenu', 'blog');?>
        <div class="white-block">
            <div class="padding-title title-big">
                <span><?=$arguments['result']['title']?></span>
            </div> 
            
            <div class="block-padding">
                
                <div class="img-blog-wrap">
                    <?php if((!empty($arguments['result']['image']))&&(file_exists(heretic::$_path['front_images'].$arguments['result']['image']))) :?>
                        <img src="/<?= heretic::$_path['front_images'].$arguments['result']['image'];?>">
                    <?php else :?>
                        <img src="/<?= heretic::$_path['template'];?>img/no_images.jpg">
                    <?php endif;?>
                </div> 
                
                <div class="content-text text-place">
                    <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '';?>
                </div>    
                
                <?php if(!empty($arguments['result']['files'])) : ?>
                <div class="download-file-div">
                    <span class="download-text">
                        Скачать прикреплённый фаил:
                    </span>
                    <span class="download-text">
                        <?php 
                            $filename = explode('/', $arguments['result']['files']);
                            $filename = $filename[count($filename)-1];
                            
                            $filename = explode('___', $filename);
                            $filename = $filename[count($filename)-1];
                            
                        ?>
                        <a alt="Скачать прикреплённый фаил" href="/<?=$arguments['result']['files']?>"><?=$filename;?></a>
                    </span> 
                    <div class="padding-top-20 file-wrap">
                        <a alt="Скачать прикреплённый фаил" href="/<?=$arguments['result']['files']?>">
                            <img alt="Скачать прикреплённый фаил" class="file-icon" src="/<?=  heretic::$_path['template']?>img/file.png">
                        </a>
                    </div> 
                       
                </div>
                <?php endif;?>
                <div class="clearfix"></div>
            </div>
            
        </div>    
    </div>    
</div>

