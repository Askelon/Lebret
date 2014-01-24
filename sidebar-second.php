
			<aside id="sidebar-second" class="ui five wide column justified sidebar-second">

				<article id="archives-timeline" class="ui inverted segment widget widget_archive">
					<ul>
						<li><a href="http://blog.caercam.dev/2014/01/">Jan. 2014</a></li>
						<li><a href="http://blog.caercam.dev/2013/03/">Mar. 2013</a></li>
						<li><a href="http://blog.caercam.dev/2013/01/">Jan. 2013</a></li>
						<li><a href="http://blog.caercam.dev/2012/09/">Sep. 2012</a></li>
						<li><a href="http://blog.caercam.dev/2012/07/">Jui. 2012</a></li>
						<li><a href="http://blog.caercam.dev/2012/04/">Avr. 2012</a></li>
						<li><a href="http://blog.caercam.dev/2011/12/">Déc. 2011</a></li>
						<li><a href="http://blog.caercam.dev/2011/11/">Nov. 2011</a></li>
						<li><a href="http://blog.caercam.dev/2011/07/">Jul. 2011</a></li>
						<li><a href="http://blog.caercam.dev/2010/06/">Jun. 2010</a></li>
						<li><a href="http://blog.caercam.dev/2010/05/">Mai. 2010</a></li>
						<li><a href="http://blog.caercam.dev/2010/04/">Avr. 2010</a></li>
					</ul>
				</article>

				<div id="sidebar-second-widgets">

					<div id="about-author" class="about-author clear">
						<h4 class="author-name"><?php _e( 'About the Author', 'lebret' ); ?></h4>
						<?php echo get_avatar( get_the_author_meta( 'ID' ) ); ?>
						<p class="author-description"><?php echo get_the_author_meta( 'description' ); ?></p>
					</div>

					<?php dynamic_sidebar( 'sidebar-second' ); ?>

				</div>

			</aside>
