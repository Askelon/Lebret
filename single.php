<?php get_header(); ?>

<?php get_sidebar(); ?>

		<section id="main" class="content ui thirteen wide column">
			<div class="ui column justified aligned stackable grid">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID() ?>" <?php post_class( 'ui eleven wide column' ) ?> role="article" itemscope itemtype="http://schema.org/Article">
					<div class="entry-terms">
						<?php lebret_tags( 2 ) ?>
					</div>
<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-thumbnail"><?php the_post_thumbnail( 'large' ) ?></div>
<?php endif; ?>
					<header class="entry-header">
						<div class="entry-meta"><span class="entry-categories"><?php the_category( ', ' ) ?></span></div>
						<h5 class="entry-title" itemprop="headline">
							<?php the_title() ?>
						</h5>
						<div class="entry-meta">
							<span class="meta entry-date"><a href="<?php the_permalink() ?>" class="item item-date" title="<?php the_time('j F Y') ?>"><i class="calendar icon"></i> <?php the_date('j F Y') ?></a></span>
							<span class="meta entry-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="item item-author" title="<?php the_author_meta( 'display_name' ); ?>"><i class="user icon"></i> <?php the_author_meta( 'display_name' ); ?></a></span>
							<span class="meta entry-comments"><?php comments_popup_link( '<i class="comment icon"></i> 0 commentaire', '<i class="comment icon"></i> 1 commentaire', '<i class="comment icon"></i> % commentaires', 'item item-comments' ); ?></span>
							<span class="meta entry-edit"><?php edit_post_link( '<i class="edit-link entypo">&#9998;</i> ' . __( 'Edit' ) ); ?></span>
						</div>
					</header>
					<div class="entry-content" itemprop="articleBody">
						<?php the_content(); ?>
					</div>
				</article>

				<article id="post-comments" class="ui eleven wide column" role="comment" itemscope itemtype="http://schema.org/Article">
					<?php comments_template() ?>
				</article>

<?php endwhile; endif; ?>

<?php get_sidebar('second'); ?>

			</div>

		</section><!-- /#main-->

<?php get_footer() ?>