<!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo('charset') ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<title><?php wp_title(''); if ( wp_title( '', false ) ) { echo ' − '; bloginfo('name'); } else { bloginfo('name'); echo ', '; bloginfo('description'); } ?></title>

		<?php wp_head(); ?>

	</head>

	<body <?php body_class( 'ui grid site' ) ?>>

		<div id="search-bg">
			<p>Click <a id="search-close" href="#">here</a> or hit escape to close this.</p>
		</div>
		<div id="nav-search">
			<?php get_search_form(); ?>
		</div>

		<header class="ui sixteen column wide site-header">

			<div id="nav-primary-menu" class="ui inverted menu grid">
				<a href="<?php echo home_url('/') ?>" class="ui one wide column active item item-home"><i class="home icon"></i> <span>Home</span></a>
				<a href="http://www.caercam.org/" class="ui one wide column item item-corp"><i class="lab icon"></i> <span>Corp.</span></a>
				<a href="http://charliemerland.me/" class="ui one wide column item item-me"><i class="coffee icon"></i> <span>.ME</span></a>
				<a href="#" id="toggle-search" class="right ui one wide column item item-toggle-search"><i class="search big icon"></i></a>
			</div>
		</header>
