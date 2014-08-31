<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8" />
	
	<title><?=$meta['title']?><?=isset($meta['title'])?" | ":""?><?=$site_title?></title>
	<meta name="description" content="<?=$site_description?>"> 
        <?php if (isset($meta['robots'])) { ?>
        <meta name="robots" content="<?=$meta['robots']?>">
        <?php } ?>
	<link rel="stylesheet" href="<?=$theme?>/style.css" type="text/css" />
    <link rel="icon" type="image/png" href="<?=$theme?>/images/favicon.png" />
    <link rel="apple-touch-icon" href="<?=$theme?>/images/touchicon.png"/>
    <link rel="shortcut icon" href="<?=$theme?>/images/touchicon.png" />
    <meta name="viewport" content="width=320">
</head>
<body>

	<header id="header">
		<div class="inner clearfix">
			<h1><a href="<?=$base_url?>"><?=$site_title?></a></h1>
			<ul class="nav">
				<?php foreach ($pages as $title=>$page) { ?>
				<li><a href="<?=$base_url.$page ?>"><?=$title ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</header>
    
    <?php if ($is_front_page) {?> <!-- Front page lists all blog posts -->
		
	<div id="posts">
        <?php foreach($posts as $post ){ ?>
		<div class="post">
			<h3><a href="<?=$base_url.$post['file'] ?>"><?=$post['meta']['title'] ?></a></h3>
			<p class="meta"><?=$post['meta']['formatted_date'] ?></p>
			<p class="excerpt"><?=$post['excerpt']?></p>
		</div>
        <?php } ?>
	</div>

    <?php } else { ?> <!-- Single page shows individual blog post -->

	<div class="post">
		<h2><?= $meta['title']?> </h2>
		<p class="meta"><?= $meta['formatted_date'] ?></p>
		<?= $post_html ?>
	</div>

    <?php } ?>

	
	<footer id="footer">
                <a href="http://www.outofbounds.gr">outofbounds</a> software
	</footer>
    
</body>
</html>