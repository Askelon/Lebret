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
				<a class="ui one wide column active item item-home"><i class="home icon"></i> Home</a>
				<a class="ui one wide column item item-corp"><i class="mail icon"></i> Corp.</a>
				<a class="ui one wide column item item-me"><i class="user icon"></i> .ME</a>
				<div class="right menu">
					
				</div>
			</div>

			<div id="nav-secondary-menu" class="ui inverted secondary menu divided grid">
				<div class="left three wide column">
					
				</div>
				<div class="ui inverted right large menu">
					<div class="ui top right pointing mobile dropdown link item">
						Menu
						<i class="dropdown icon"></i>
						<div class="menu">
							<a class="item">Classes</a>
							<a class="item">Cocktail Hours</a>
							<a class="item">Community</a>
						</div>
					</div>
					<div class="ui dropdown link item">
						Courses
						<i class="dropdown icon"></i>
						<div class="menu">
							<a class="item">Petting</a>
							<a class="item">Feeding</a>
							<a class="item">Mind Reading</a>
						</div>
					</div>
					<a class="item">Library</a>
					<a class="item">Community</a>
				</div>
			</div>
		</header>
