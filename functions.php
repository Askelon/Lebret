<?php

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Lebret supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since    1.0
 *
 * @return void
 */
function lebret_setup() {

	load_theme_textdomain( 'lebret', get_template_directory() . '/assets/lang' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	register_nav_menu( 'primary', __( 'Navigation Menu', 'lebret' ) );
	register_nav_menu( 'secondary', __( 'Secondary Menu', 'lebret' ) );

	if ( ! isset( $content_width ) ) $content_width = 960;
}
add_action( 'after_setup_theme', 'lebret_setup' );


/**
 * Registers two widget areas.
 *
 * @since    1.0
 *
 * @return void
 */
function lebret_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Home Widget Area', 'lebret' ),
		'id'            => 'sidebar',
		'description'   => __( 'Appears on left', 'lebret' ),
		'before_widget' => '<article id="%1$s" class="widget %2$s">',
		'after_widget'  => '</article>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Blog Right First Widget Area', 'lebret' ),
		'id'            => 'sidebar-second',
		'description'   => __( 'Appears in the right section of the Blog Posts View.', 'lebret' ),
		'before_widget' => '<article id="%1$s" class="ui inverted segment widget %2$s">',
		'after_widget'  => '</article>',
		'before_title'  => '<h4 class="ui header black inverted widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'lebret_widgets_init' );


/**
 * Enqueues scripts and styles for front end.
 *
 * @since    1.0
 */
function lebret_scripts() {

	wp_register_style( 'fonts', '//fonts.googleapis.com/css?family=Lato:100,200,300,400,900|Source+Sans+Pro:400,700', array(), false, 'all' );
	wp_register_style( 'semantic', get_template_directory_uri() . '/assets/css/semantic.css', array(), false, 'all' );
	wp_register_style( 'lebret', get_stylesheet_uri(), array(), false, 'all' );
	wp_register_style( 'lebret-color', get_template_directory_uri() . '/assets/css/lebret-spring.css', array(), false, 'all' );

	wp_enqueue_style( 'fonts' );
	wp_enqueue_style( 'semantic' );
	wp_enqueue_style( 'lebret' );
	wp_enqueue_style( 'lebret-color' );

	wp_register_script( 'lebret', get_template_directory_uri() . '/assets/js/public.js', array( 'jquery', 'jquery-masonry' ), false, true );
	wp_register_script( 'semantic', get_template_directory_uri() . '/assets/js/semantic.js', array( 'jquery' ), false, true );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'lebret' );
	wp_enqueue_script( 'comment-reply' );

	$wp_ajax = array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
	);

	wp_localize_script( 'lebret', 'wp_ajax', $wp_ajax );
}
add_action( 'wp_enqueue_scripts', 'lebret_scripts' );


/**
 * Load Posts using Ajax
 *
 * @since    1.0
 */
function lebret_load_posts_callback() {

	$offset = ( isset( $_POST['offset'] ) && '' != $_POST['offset'] ? (int) $_POST['offset'] : null );

	if ( is_null( $offset ) )
		die( __( 'Nothing left do show!', 'lebret' ) );

	$query = new WP_Query( 'offset=' . $offset );
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) :
			$query->the_post();
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

					<div class="entry-content" itemprop="articleBody">
						<p><?php lebret_excerpt(); ?></p>
					</div>

					<footer class="entry-footer">
						<div class="ui inverted menu">
							<a href="<?php the_permalink() ?>" class="item item-date" title="<?php the_time('j F Y') ?>"><i class="calendar icon"></i> <?php the_date('j-n-Y') ?></a>
							<?php comments_popup_link( '<i class="comment icon"></i> 0', '<i class="comment icon"></i> 1', '<i class="comment icon"></i> %', 'item item-comments' ); ?>
							<a href="<?php the_permalink() ?>" class="right active item item-readmore" title="<?php _e( 'Read More', 'lebret' ) ?>"> <i class="right large angle icon"></i></a>
						</div>
					</footer>
				</article>
<?php
			wp_reset_query();
		endwhile;
	endif;

	die();
}
add_action( 'wp_ajax_load_posts', 'lebret_load_posts_callback' );
add_action( 'wp_ajax_nopriv_load_posts', 'lebret_load_posts_callback' );


/**
 * Displays Lebret Menus.
 *
 * @since    1.0
 */
function lebret_menu( $menu_name = 'primary', $args = array() ) {

	if ( ! in_array( $menu_name, array( 'primary', 'secondary' ) ) )
		return false;

	$defaults = array(
		'id'              => 'nav-' . $menu_name . '-menu',
		'container_class' => 'ui secondary vertical pointing menu',
		'item_class'      => 'item',
		'add_icons'       => false
	);

	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {

		$menu  = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$items = wp_get_nav_menu_items( $menu->term_id );
		_wp_menu_item_classes_by_context( $items );
		$prev        = 0;
		$prev_parent = 0;
		$icon        = '';
		$attr_title  = '';

		if ( $items ) {
?>
						<nav id="<?php echo $id ?>" class="<?php echo $container_class ?>">
<?php
			foreach ( $items as $item ) {

				if ( $add_icons ) {
					$attr_title = $item->title;
					$item->title .= ' <i class="' . $item->attr_title . '"></i>';
				}
				else {
					$attr_title = $item->attr_title;
				}

				if ( ! $item->menu_item_parent ) {
					$parent_id = $item->ID;
?>
							<a id="menu-item-<?php echo $item->post_name ?>" href="<?php echo $item->url ?>" class="<?php echo $item_class . $class . implode( ' ', $item->classes ) ?>" title="<?php echo $attr_title ?>"><?php echo $item->title ?></a>
<?php
				}

				if ( $parent_id == $item->menu_item_parent ) {
					if ( ! $submenu )
						$submenu = true;
?>
								<a id="menu-item-<?php echo $item->post_name ?>" href="<?php echo $item->url ?>" class="sub-menu-item <?php echo $item_class . implode( ' ', $item->classes ) ?>" title="<?php echo $attr_title ?>"><?php echo $item->title ?></a>
<?php
					if ( $items[ $count + 1 ]->menu_item_parent != $parent_id && $submenu )
						$submenu = false;
				}

				if ( $items[ $count + 1 ]->menu_item_parent != $parent_id )
					$submenu = false;

				$count++;
			}
?>
						</nav>
<?php
		}
	}
}

/**
 * Display archive links. This is an edited copy of wp_get_archives in order
 * to get only monthly archives link with a custom date format.
 * 
 * @see wp_get_archives()
 *
 * @since 1.0.0
 */
function lebret_get_sidebar_archives() {

	global $wpdb, $wp_locale;

	$output = '';

	$last_changed = wp_cache_get( 'last_changed', 'posts' );
	if ( ! $last_changed ) {
		$last_changed = microtime();
		wp_cache_set( 'last_changed', $last_changed, 'posts' );
	}

	$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
	$key = md5( $query );
	$key = "wp_get_archives:$key:$last_changed";
	if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
		$results = $wpdb->get_results( $query );
		wp_cache_set( $key, $results, 'posts' );
	}
	if ( $results ) {
		foreach ( (array) $results as $result ) {
			$url = get_month_link( $result->year, $result->month );
			/* translators: 1: month name, 2: 4-digit year */
			$text = sprintf( __( '%1$s %2$d', 'lebret' ), $wp_locale->get_month_abbrev( $wp_locale->get_month( $result->month ) ), $result->year );
			$output .= get_archives_link( $url, $text, 'html', '', '' );
		}
	}

	$output = '<ul>' . $output . '</ul>';

	return $output;
}

function lebret_sidebar_archives() {
	echo lebret_get_sidebar_archives();
}

function lebret_excerpt_length( $length ) {
	return $length;
}

function lebret_get_excerpt( $length = 30, $content = null ) {

	if ( is_null( $content ) ) {
		global $post;
		$content = $post->post_content;

		if ( is_null( $content ) )
			return null;
	}

	$text = trim( $post->post_content );
	$text = strip_shortcodes( $text );
	$text = apply_filters( 'the_content', $text );
	
	$excerpt_length = (int) $length;
	$excerpt_more   = '&hellip;';
	$text           = wp_trim_words( $text, $excerpt_length, $excerpt_more );

	return $text;
}


function lebret_excerpt( $length = 30, $content = null ) {
	echo lebret_get_excerpt( $length, $content );
}


/**
 * Prints HTML with meta information for current post: categories, tags,
 * permalink, author, and date.
 *
 * @since    1.0
 */
function lebret_entry_meta() {

	$author = $tags = $categories = $more = '';

	// Post author
	if ( 'post' == get_post_type() ) {
		$author = sprintf( '<li class="post-author"><span class="author vcard"><span class="entypo">&#128100;</span> &nbsp;<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></li>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'lebret' ), get_the_author() ) ),
			get_the_author()
		);
	}

	$categories = get_the_category_list( __( ', ', 'lebret' ) );
	if ( $categories ) {
		$c = explode( __( ', ', 'lebret' ), $categories );
		if ( count( $c ) > 3 )
			$categories = implode( __( ', ', 'lebret' ), array_slice( $c, 0, 3 ) ) . '&hellip; (' . ( count( $c ) - 3 ) . ' more)';

		$categories = sprintf( '<li class="post-categories"><span class="entypo">&#128193;</span> &nbsp;%s</li>', $categories );
	}

	$tags = get_the_tag_list( '', __( ', ', 'lebret' ) );
	if ( $tags ) {
		$t = explode( __( ', ', 'lebret' ), $tags );
		if ( count( $t ) > 3 )
			$tags = implode( __( ', ', 'lebret' ), array_slice( $t, 0, 3 ) ) . '&hellip; (' . ( count( $t ) - 3 ) . ' more)';

		$tags = sprintf( '<li class="post-tags"><span class="entypo">&#59148;</span> &nbsp;%s</li>', $tags );
	}

	if ( ! is_single() )
		$more = sprintf( '<li class="post-more more"><a href="%s" class="more">%s</a></li>', get_permalink(), __( 'Read More', 'lebret' ) );
	else if ( is_single() && comments_open() )
		$more = '<li class="post-more more-comment"><a href="' . get_comments_link() . '">' . __( 'Leave a comment', 'lebret' ) . '</a></li>';
	else
		$more = '<li class="post-more void"><a>' . __( 'Comments closed.', 'lebret' ) . '</a></li>';
?>
						<ul>
							<?php echo $author ?>
							<?php echo $categories ?>
							<?php echo $tags ?>
							<?php echo $more ?>
						</ul>
<?php

}

/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since    1.0
 */
function lebret_paging_nav() {

	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;

	$page  = ( $wp_query->get('paged') ? $wp_query->get('paged') : 1 );
	$total = $wp_query->max_num_pages;

	$paginate = paginate_links(
		array(
			'type'      => 'array',
			'total'     => $total,
			'current'   => $page,
			'prev_text' => '<i class="left angle icon"></i>',
			'next_text' => '<i class="right angle icon"></i>',
		)
	);
?>

					<nav class="ui inverted pagination menu" role="pagination">
<?php foreach ( $paginate as  $page ) :
	echo str_replace(
		array(
			'page-numbers',
			'next',
			'prev',
		),
		array(
			'item page-numbers',
			'icon next',
			'icon prev',
		),
		$page
	);
endforeach;  ?>
					</nav>
					<div id="loadmore" class="ui hover tiny button"><i class="refresh icon"></i><?php _e( 'Load More', 'lebret' ) ?></div>
<?php
}

/**
 * Displays navigation to next/previous post when applicable.
*
* @since    1.0
*
* @return void
*/
function lebret_post_nav() {

	/*global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
?>
				<div class="ui eleven wide column pagination">
					<nav class="ui grid post-navigation" role="navigation">
						<div class="ui four wide column recent-posts"><?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'lebret' ) ); ?></div>
						<div class="ui four wide column older-posts"><?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'lebret' ) ); ?></div>
					</nav>
					<div style="clear:both"></div>
				</div>
<?php
	*/
}


function lebret_tags( $limit = 4 ) {

	global $post;

	$html = '';

	$tags = get_the_tags();

	if ( ! empty( $tags ) ) {

		$html .= '<div class="post-tags"><ul>';

		if ( 0 < $limit )
			$tags = array_slice( $tags, 0, $limit );

		foreach ( $tags as $tag ) {
			$url = get_term_link( $tag );
			if ( ! is_wp_error( $url ) )
				$html .= sprintf( '<li class="post-tag"><span><a href="%s" title="%s">%s</a></span></li>', $url, $tag->description, $tag->name );
		}

		if ( 0 < $limit )
			$html .= '<li class="post-tag"><span><a href="#post-tags">&hellip;</a></span></li>';

		$html .= '</ul></div>';
	}

	echo $html;
}


/**
 * Displays a custom Comments List.
 *
 * @param    object     $comment The Comment Object.
 * @param    array      $args Display arguments.
 * @param    int        $depth Comment Depth.
 *
 * @since    1.0
 */
function lebret_comments( $comment, $args, $depth ) {

	extract( $args, EXTR_SKIP );

	if ( 1 == $depth ) :

?>

				<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
					<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
						<header class="comment-header">
							<div class="comment-author vcard">
								<?php
								printf(
									'%s<cite class="fn">%s</cite> <a class="comment-permalink" href="%s">%s</a>',
									( $depth > 1 ? '<i class="icon reply mail"></i> ' : '' ),
									get_comment_author_link(),
									esc_url( get_comment_link( $comment->comment_ID ) ),
									sprintf( __( '%1$s at %2$s', 'lebret' ), get_comment_date(), get_comment_time() )
								);
								?>
							</div>
						</header>
						<div class="comment-text">
<?php if ( '0' == $comment->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'lebret' ) ?></em><br />
<?php endif; ?>

							<?php echo get_avatar( $comment->comment_author_email, 128 ); ?>
							<?php comment_text(); ?>
						</div>
						<footer class="comment-footer">
							<?php
								comment_reply_link(
									array_merge(
										$args,
										array(
											'before'     => '',
											'reply_text' => '<i class="icon reply mail"></i>&nbsp;' . __( 'Reply', 'cyrano' ),
											'after'      => '',
											'depth'      => $depth,
											'max_depth'  => $args['max_depth']
										)
									)
								); ?>
						</footer>
					</article>
<?php
	elseif ( 1 < $depth ) :
?>

				<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
					<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
						<div class="comment-text">
<?php if ( '0' == $comment->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'lebret' ) ?></em><br />
<?php endif; ?>

							<?php echo get_avatar( $comment->comment_author_email, 128 ); ?>
							<?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>
							<?php comment_text(); ?>
						</div>
					</article>
<?php
	endif;
}


/**
 * Styling the Comment Form to look like Comments List.
 * 
 * @uses comment_form_logged_in Filter Hook to display a Header before the Author VCard
 * 
 * @param    string    $logged_in_as   The logged-in-as HTML-formatted message.
 *
 * @since    1.0
 */
function lebret_comment_logged_in( $logged_in_as ) {
?>
				<header class="comment-respond-header comment-respond-loggedin">
<?php
	return $logged_in_as;
}
add_filter( 'comment_form_logged_in', 'lebret_comment_logged_in' );


/**
 * Styling the Comment Form to look like Comments List.
 * 
 * @uses comment_form_field_comment Filter Hook to end the Header before the Comment Textarea
 * 
 * @param array  $commenter     An array containing the comment author's username, email, and URL.
 *
 * @since    1.0
 */
function lebret_comment_form_logged_in_after( $commenter ) {
?>
				</header>

<?php
}
add_action( 'comment_form_logged_in_after', 'lebret_comment_form_logged_in_after' );


/**
 * Styling the Comment Form to look like Comments List.
 * 
 * @uses comment_form_before_fields Action Hook to display a Header before the Author VCard
 *
 * @since    1.0
 */
function lebret_comment_before_fields() {
?>
				<header class="comment-respond-header comment-respond-fields">
<?php
}
add_action( 'comment_form_before_fields', 'lebret_comment_before_fields' );


/**
 * Styling the Comment Form to look like Comments List.
 * 
 * @uses comment_form_after_fields Action Hook to end the Header before the Comment Textarea
 *
 * @since    1.0
 */
function lebret_comment_form_after_fields() {
?>
				</header>
				<!--<div class="comment-respond-avatar"><?php echo get_avatar( null, 74 ); ?></div>-->
<?php
}
add_action( 'comment_form_after_fields', 'lebret_comment_form_after_fields' );


/**
 * Styling the Comment Form to look like Comments List.
 * 
 * @uses comment_form Action Hook to display 
 *
 * @since    1.0
 */
function lebret_comment_form( $post_id ) {
?>
				</div> <!-- /comment-respond-content -->
<?php
}
add_action( 'comment_form', 'lebret_comment_form' );





/**
 * Theme Customizer
 *
 * @since    1.0
 */
function lebret_theme_customizer( $wp_customize ) {

	$wp_customize->add_section(
		'lebret_logo_section',
		array(
			'title'       => __( 'Site Logo', 'lebret' ),
			'priority'    => 50,
			'description' => '',
		)
	);

	$wp_customize->add_setting(
		'lebret_logo',
		array(
			'default'   => get_template_directory_uri() . '/assets/img/logo_128.png',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'lebret_logo',
			array(
				'label'      => __( 'Custom Logo', 'lebret' ),
				'section'    => 'lebret_logo_section',
				'settings'   => 'lebret_logo',
			)
		)
	);

	$wp_customize->get_setting('lebret_logo')->transport='postMessage';

	// Enqueue scripts for real-time preview
	wp_enqueue_script( 'lebret-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'jquery' ) );
}
add_action( 'customize_register', 'lebret_theme_customizer' );

require_once get_template_directory() . '/widgets.php';

function lebret_widgets() {

	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Recent_Comments' );

	register_widget( 'Lebret_Widget_Categories' );
	register_widget( 'Lebret_Nav_Menu_Widget' );
	register_widget( 'Lebret_Widget_Archives' );
	register_widget( 'Lebret_Widget_Recent_Posts' );
	register_widget( 'Lebret_Widget_Recent_Comments' );
}
add_action( 'widgets_init', 'lebret_widgets' );