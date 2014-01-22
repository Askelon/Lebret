<?php get_header(); ?>

		<div id="main" class="ui grid segment">

			<aside id="blog-menu" class="ui three wide column justified">
<?php deguiche_menu( 'secondary' ); ?>
			</aside>

			<section id="content" class="ui eight wide column justified">
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
				<article <?php post_class( 'ui piled segment' ) ?> role="article" itemscope itemtype="http://schema.org/Article">
					<header class="post-header">
						<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ) ?></div>
					</header>
					<div class="post-meta">
						<div class="ui basic left floated segment"><?php the_date() ?></div>
						<div class="ui basic right floated segment"><a href="<?php echo get_comments_link() ?>"><?php _e( 'Leave a comment', 'deguiche' ) ?></a></div>
					</div>
					<div class="post-content" itemprop="articleBody">
						<?php the_content(); ?>
					</div>
					<footer class="post-footer">
						
					</footer>
				</article>
<?php endwhile; endif; ?>
			</section><!-- /#content-->

<?php get_sidebar(); ?>

<?php get_sidebar('second'); ?>

		</div>

<?php get_footer(); ?>