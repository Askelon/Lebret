<?php get_header(); ?>

<?php get_sidebar(); ?>

		<section id="main" class="main-content ui thirteen wide column">
			<div class="ui three column justified aligned stackable grid">
<?php
$i = 0; $featured = true;
if ( have_posts() ) : while ( have_posts() ) : the_post(); $i++;
?>
				<article <?php post_class( 'column' ) ?> role="article" itemscope itemtype="http://schema.org/Article">
					<header class="entry-header">
<?php if ( has_post_thumbnail() ) : ?>
						<div class="post-thumbnail"><?php the_post_thumbnail( 'medium' ) ?></div>
<?php endif; ?>
						<h5 class="entry-title" itemprop="headline">
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
							<?php edit_post_link( '&#9998;', '<span class="edit-link entypo">', '</span>' ); ?>
						</h5>
					</header>
<?php if ( $featured ) : ?>
					<div class="entry-content" itemprop="articleBody">
						<p><?php lebret_excerpt( 55 ); ?></p>
					</div>
<?php else : ?>
					<div class="entry-content" itemprop="articleBody">
						<p><?php lebret_excerpt(); ?></p>
					</div>
<?php
endif;
if ( 3 == $i ) :
	$featured = false;
endif; ?>
					<footer class="entry-footer">
						<div class="ui inverted menu">
							<a href="<?php the_permalink() ?>" class="item item-date" title="<?php the_time('j F Y') ?>"><i class="calendar icon"></i> <?php the_date('j-n-Y') ?></a>
							<?php comments_popup_link( '<i class="comment icon"></i> 0', '<i class="comment icon"></i> 1', '<i class="comment icon"></i> %', 'item item-comments' ); ?>
							<a href="<?php the_permalink() ?>" class="right active item item-readmore" title="<?php _e( 'Read More', 'lebret' ) ?>"> <i class="right large angle icon"></i></a>
						</div>
					</footer>
				</article>
<?php endwhile; endif; wp_reset_query(); ?>
			</div>

			<div class="pagination-container">
				<?php lebret_paging_nav() ?>
			</div>

		</section><!-- /#main-->

<?php get_footer() ?>