<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php include('includes/header.php'); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12 page">
				<h2><?php echo $page->title; ?></h2>
				<div class="heading-divider"></div>
				<div class="page-body">
					<?php echo $page->body ?>
				</div>
			</div>
		</div>
	</div>
<?php include('includes/footer.php'); ?>