<div class="pagination">
    <ul>
        <li>
            <a href="<?=$arguments['href']?>1"> В начало</a>
        </li>
        
        <?php for ($i=$arguments['pag_to']['start']; $i<=$arguments['pag_to']['end']; $i++) : ?>
        <li class='<?= ($arguments['page'] == $i) ? 'active' : '';?>'>
            <a  href="<?=$arguments['href']?><?=$i?>"> <?=$i?></a>
        </li>
        <?php endfor;?>
        
        <li>
            <a href="<?=$arguments['href']?><?=$arguments['count_page']?>"> В конец</a>
        </li>
        
    </ul>
</div>    