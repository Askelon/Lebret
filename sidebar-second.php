
			<aside id="sidebar-second" class="ui five wide column justified sidebar-second">

				<article id="archives-timeline" class="ui inverted segment widget widget_archive">
					<?php lebret_sidebar_archives() ?>
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
