<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php foreach($posts as $post): ?>

<?php $post_description = preg_replace('/^\s+|\n|\r|\s+$/m', '', strip_tags($post->body)); ?>

<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
	<article class="block">
		<a class="block-thumbnail" href="<?php echo ($settings->enable_https) ? secure_url('post') : URL::to('post') ?><?php echo '/' . $post->slug ?>">
			<div class="thumbnail-overlay"></div>
			<img src="<?php echo ImageHandler::getImage($post->image)  ?>">
			<div class="details">
				<h2><?php echo $post->title; ?></h2>
				<span><?php echo TimeHelper::convert_seconds_to_HMS($post->duration); ?></span>
			</div>
		</a>
		<div class="block-contents">
			<p class="date"><?php echo date("F jS, Y", strtotime($post->created_at)); ?></p>
			<p class="desc"><?php if(strlen($post_description) > 90){ echo mb_substr($post_description, 0, 90) . '...'; } else { echo $post->description; } ?></p>
		</div>
	</article>
</div>
<?php endforeach; ?>