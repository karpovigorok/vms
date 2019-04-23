<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php

if (isset($videos)):
    $media = $videos;
elseif (isset($posts)):
    $media = $posts;
endif;


?>

<div class="pagination">
    <?php if ($current_page != 1) : ?>
        <a class="previous_page"
           href="<?php echo $pagination_url . '/?page=' . intval($current_page - 1); ?>"><?php echo _i('Prev Page'); ?></a>
    <?php endif; ?>
    <?php if ($media->hasMorePages()) : ?>
        <a class="next_page"
           href="<?php echo $pagination_url . '/?page=' . intval($current_page + 1); ?>"><?php echo _i('Next Page'); ?></a>
    <?php endif; ?>
</div>