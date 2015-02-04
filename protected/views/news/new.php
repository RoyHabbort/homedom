
<div class="conteiner text-page">
    <div class="content-width">
        <div class="breadcrums-div">
            <div class="breadcrums">
                <a href="/">Главная страница</a>
                &rarr;
                <a href="/news/lists">Новости</a>
                &rarr;
                <span><?=$arguments['title']?></span>
            </div>
        </div>    
        <div class="left-place green-cube">
            <p><?= heretic::$_config['titlePage'];?></p>
        </div>
        <div class="right-place">
            <div class="white-block">
                <div class="block-padding bottom-line">
                    <h2 class="title-h2"><?=$arguments['title']?></h2>
                    <span class="date-pole"><?=$this->converteDate($arguments['date'])?></span>
                    <div class="text-place">
                        <?=$arguments['text']?>
                    </div>
                    <div class="btn-back" onclick="history.back()">
                        Назад
                    </div>      
                </div>
            </div>    
        </div>    
        <div class="clearfix"></div>    
    </div>    
</div>

