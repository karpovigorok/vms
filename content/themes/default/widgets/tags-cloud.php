<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<!-- tags -->
<?php if(sizeof($tags)):?>
    <div class="widgetBox">
        <div class="widgetTitle">
            <h5><?php echo _i('Tags');?></h5>
        </div>
        <div class="tagcloud">
        <?php
            foreach($tags as $tag):
                if($tag->name != ''):
        ?>
                    <a href="/videos/tag/<?php echo $tag->name;?>"><?php echo $tag->name;?></a>
        <?php
                endif;
            endforeach;
        ?>
        </div>
    </div>
<!-- End tags -->
<?php endif;?>