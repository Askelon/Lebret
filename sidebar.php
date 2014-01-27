
			<aside id="sidebar" class="ui three wide column sidebar">

				<div class="site-cover"></div>

				<div id="sidebar-social-menu" class="ui inverted menu">
					<a href="" class="item item-facebook" title=""><i class="facebook icon"></i></a>
					<a href="" class="item item-twitter" title=""><i class="twitter icon"></i></a>
					<a href="" class="item item-google" title=""><i class="google plus icon"></i></a>
					<a href="" class="item item-github" title=""><i class="github icon"></i></a>
					<a href="" class="right item item-more" title=""><i class="ellipsis horizontal icon"></i></a>
				</div>

				<?php lebret_menu( 'secondary', array( 'id' => 'sidebar-secondary-menu', 'add_icons' => true, 'container_class' => 'ui secondary inverted vertical pointing menu' ) ) ?>

				<?php dynamic_sidebar( 'sidebar' ); ?>

			</aside>
