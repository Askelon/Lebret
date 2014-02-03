
			<aside id="sidebar-second" class="ui five wide column justified sidebar-second">

				<article id="archives-timeline" class="ui inverted segment widget widget_archive">
					<?php lebret_sidebar_archives() ?>
				</article>

				<div id="sidebar-second-widgets">

<?php
global $post;
if ( isset( $post->post_author ) && ! is_null( $post->post_author ) ) :
	$author_id = $post->post_author;
?>
					<div id="about-author" class="about-author clear">
						<h4 class="ui header black inverted author-name"><?php _e( 'About the Author', 'lebret' ); ?></h4>
						<?php echo get_avatar( $author_id ); ?>
						<p class="author-description"><?php echo get_the_author_meta( 'description', $author_id ); ?></p>
					</div>
<?php endif; ?>

					<?php dynamic_sidebar( 'sidebar-second' ); ?>

				</div>

			</aside>
