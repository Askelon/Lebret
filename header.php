<!DOCTYPE html>

<html>

	<head>
		<!-- Standard Meta -->
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<!-- Site Properities -->
		<title><?php wp_title('') ?></title>

		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/semantic.css">
		<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri() ?>">

		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
		<script src="<?php echo get_template_directory_uri() ?>/js/semantic.js"></script>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class( 'ui grid site' ) ?>>

		<header class="ui sixteen column wide site-header">

			<div id="nav-search">
				<?php get_search_form(); ?>
			</div>

			<div id="nav-primary-menu" class="ui inverted menu grid">
				<a href="http://blog.caercam.org/" class="ui one wide column active item item-home"><i class="home icon"></i> <span>Home</span></a>
				<a href="http://www.caercam.org/" class="ui one wide column item item-corp"><i class="mail icon"></i> <span>Corp.</span></a>
				<a href="http://charliemerland.me/" class="ui one wide column item item-me"><i class="user icon"></i> <span>.ME</span></a>
				<a href="#" id="toggle-search" class="right ui one wide column item item-toggle-search"><i class="search big icon"></i></a>
			</div>

			<div id="nav-secondary-menu" class="ui inverted secondary menu divided grid">
				<div class="left three wide column site-information">
					<h1 class="site-title"><a href="<?php echo home_url('/') ?>"><?php bloginfo('name') ?></a></h1>
				</div>
				<div class="ui inverted right large menu">
					<a href="" class="item"><i class="block layout icon"></i></a>
					<a href="" class="item"><i class="grid layout icon"></i></a>
					<a href="" class="item"><i class="list layout icon"></i></a>
				</div>
			</div>
		</header>
