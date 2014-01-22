<?php get_header(); ?>

<?php get_sidebar('home'); ?>

		<div id="main" class="main-content ui thirteen wide column">

			<section id="featured" class="ui fourteen wide column">
				<!--<div class="ui two wide column"></div>-->
				<div class="sixteen wide column">
					<div class="ui three column justified aligned stackable grid">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<article <?php post_class( 'column' ) ?> role="article" itemscope itemtype="http://schema.org/Article">
							<header class="entry-header">
								<div class="post-thumbnail"><?php the_post_thumbnail( 'medium' ) ?></div>
								<h5 class="entry-title" itemprop="headline">
									<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a>
									<?php edit_post_link( '&#9998;', '<span class="edit-link entypo">', '</span>' ); ?>
								</h5>
							</header>
							<div class="entry-content" itemprop="articleBody">
								<?php the_excerpt(); ?>
							</div>
							<footer class="entry-footer">
								<div class="ui inverted menu">
									<a href="<?php the_permalink() ?>" class="item item-date" title="<?php the_time('j F Y') ?>"><i class="calendar icon"></i> <?php the_date('j-n-Y') ?></a>
									<?php comments_popup_link( '<i class="comment icon"></i> 0', '<i class="comment icon"></i> 1', '<i class="comment icon"></i> %', 'item item-comments' ); ?>
									<a href="<?php the_permalink() ?>" class="right active item item-readmore" title="<?php _e( 'Read More', 'lebret' ) ?>"></i> <i class="right large angle icon"></i></a>
								</div>
							</footer>
						</article>
<?php endwhile; endif; ?>
					</div>
				</div>
			</section><!-- /#posts-->

		</div><!-- /#main-->

		<div class="ui horizontal icon divider"><i class="coffee icon"></i></div>

		<div class="ui page grid overview segment">
			<div class="ui two wide column"></div>
			<div class="twelve wide column">
				<div class="ui four column center aligned stackable divided grid">
					<div class="column">
						<a href="http://www.facebook.com/#!/pages/Charlie-Merland-photographe/135392246511319">
							<div class="ui facebook circular button"><i class="facebook link big icon"></i> Facebook</div>
						</a>
					</div>
					<div class="column">
						<a href="https://twitter.com/CaerCam">
							<div class="ui twitter circular button"><i class="twitter link big icon"></i> Twitter</div>
						</a>
					</div>
					<div class="column">
						<a href="https://plus.google.com/u/0/+CharlieMerland">
							<div class="ui google plus circular button"><i class="google plus link big icon"></i> Google+</div>
						</a>
					</div>
					<div class="column">
						<a href="https://github.com/Askelon/">
							<div class="ui github circular button"><i class="github link big icon"></i> GitHub</div>
						</a>
					</div>
				</div>
			</div>
		</div>

<?php get_footer() ?>