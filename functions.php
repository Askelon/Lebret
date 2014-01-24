<?php

/**
 * Sets up theme defaults and registers the various WordPress features that
 * De Guiche supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
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

	load_theme_textdomain( 'lebret', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	register_nav_menu( 'primary', __( 'Navigation Menu', 'lebret' ) );
	register_nav_menu( 'secondary', __( 'Secondary Menu', 'lebret' ) );

	if ( ! isset( $content_width ) ) $content_width = 896;
}
add_action( 'after_setup_theme', 'lebret_setup' );


/**
 * Load Open Sans Font
 *
 * @since    1.0
 */
function lebret_custom_header_fonts() {

	//wp_enqueue_style( 'lebret-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,700', array(), null );
}
add_action( 'admin_print_styles-appearance_page_custom-header', 'lebret_custom_header_fonts' );


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
		'before_title'  => '<h4 class="">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => __( 'Blog Right First Widget Area', 'lebret' ),
		'id'            => 'sidebar-second',
		'description'   => __( 'Appears in the right section of the Blog Posts View.', 'lebret' ),
		'before_widget' => '<article id="%1$s" class="ui inverted segment widget %2$s">',
		'after_widget'  => '</article>',
		'before_title'  => '<h4 class="ui block widget-title">',
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

	wp_enqueue_style( 'fonts' );
	wp_enqueue_style( 'semantic' );
	wp_enqueue_style( 'lebret' );

	wp_register_script( 'lebret', get_template_directory_uri() . '/assets/js/public.js', array( 'jquery', 'jquery-masonry' ), false, true );
	wp_register_script( 'semantic', get_template_directory_uri() . '/assets/js/semantic.js', array( 'jquery' ), false, true );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-masonry' );
	wp_enqueue_script( 'lebret' );
	wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'lebret_scripts' );


/**
* Get the site logo
* If no logo is set in the theme's options, use default WP-Badge as logo 
* 
* @since    De Guiche 1.0
*
* @return   string        The site logo URL.
*/
function lebret_site_logo() {
	$site_logo = get_theme_mod( 'lebret_logo', get_template_directory_uri() . '/assets/img/logo_128.png' );
	return $site_logo;
}


/**
 * Displays De Guiche Menus.
 *
 * @since    1.0
 */
function lebret_menu( $menu_name = 'primary', $args = array() ) {

	if ( ! in_array( $menu_name, array( 'primary', 'secondary' ) ) )
		return false;

	$defaults = array(
		'id'              => 'nav-' . $menu_name . '-menu',
		'container_class' => 'ui secondary vertical pointing menu',
		'item_class'      => 'item'
	);

	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {

		$menu  = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$items = wp_get_nav_menu_items( $menu->term_id );
		_wp_menu_item_classes_by_context( $items );
		$prev        = 0;
		$prev_parent = 0;

		if ( $items ) {
?>
						<nav id="<?php echo $id ?>" class="<?php echo $container_class ?>">
<?php
			foreach ( $items as $item ) {

				if ( ! $item->menu_item_parent ) {
					$parent_id = $item->ID;
?>
							<a id="menu-item-<?php echo $item->post_name ?>" href="<?php echo $item->url ?>" class="<?php echo $item_class . $class . implode( ' ', $item->classes ) ?>" title="<?php echo $item->attr_title ?>"><?php echo $item->title ?></a>
<?php
				}

				if ( $parent_id == $item->menu_item_parent ) {
					if ( ! $submenu )
						$submenu = true;
?>
								<a id="menu-item-<?php echo $item->post_name ?>" href="<?php echo $item->url ?>" class="sub-menu-item <?php echo $item_class . implode( ' ', $item->classes ) ?>" title="<?php echo $item->attr_title ?>"><?php echo $item->title ?></a>
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
	$excerpt_more   = '…';
	$text           = wp_trim_words( $text, $excerpt_length, $excerpt_more );

	return $text;
}


function lebret_excerpt( $length = 30, $content = null ) {
	echo lebret_get_excerpt( $length, $content );
}


/**
 * Prints HTML with date information for current post.
 *
 * Create your own lebret_entry_date() to override in a child theme.
 *
 * @since    1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 *
 * @return string The HTML-formatted post date.
 */
function lebret_entry_date( $echo = true ) {

	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'lebret' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'lebret' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		sprintf( '<span class="day">%s</span> <span class="monthyear"><span class="month">%s</span> <span class="year">%s</span></span>', get_the_date('j'), get_the_date('M'), get_the_date('Y') )
	);

	if ( $echo )
		echo $date;

	return $date;
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
?>

				<div class="pagination">
					<nav class="paging-navigation" role="pagination">
<?php if ( get_previous_posts_link() ) : ?>
						<div class="recent-posts"><?php previous_posts_link( __( '<span class="meta-nav">&larr;</span> Newer posts', 'lebret' ) ); ?></div>
<?php
endif;
if ( get_next_posts_link() ) : ?>
						<div class="older-posts"><?php next_posts_link( __( 'Older posts <span class="meta-nav">&rarr;</span>', 'lebret' ) ); ?></div>
<?php endif; ?>
						<div class="page-number">
							<ul id="paginate-links">
<?php
for ( $i = 1; $i <= $total; $i++ ) : 
	$selected = ( $i == $page );
?>
								<?php printf( '<li class="paginate-link%s" id="page_%d"><a href="%s">%s</a></li>', ( $selected ? ' selected' : '' ), $i, ( $selected ? '#' : get_pagenum_link( $i ) ), sprintf( __( 'Page %d of %d', 'lebret' ), $i, $total ) ) ?>

<?php endfor; ?>
							</ul>
						</div>
					</nav>
					<div style="clear:both"></div>
				</div>
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

	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
?>
				<div class="pagination">
					<nav class="post-navigation" role="navigation">
						<div class="recent-posts"><?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'lebret' ) ); ?></div>
						<div class="older-posts"><?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'lebret' ) ); ?></div>
					</nav>
					<div style="clear:both"></div>
				</div>
<?php
}

/**
 * Displays a Post thumbnail. If no Thumbnail was set, show a default one. If no
 * Post ID is submitted, use the current Post.
 *
 * @param    int        $post_id Post's ID. Default null.
 * @param    boolean    $echo Whether to echo the image. Default true.
 *
 * @since    1.0
 */
function lebret_post_cover( $post_id = null, $echo = true ) {

	$html = '';

	if ( is_null( $post_id ) ) {
		global $post;
		$post_id = $post->ID;
	}

	$t_id = get_post_thumbnail_id( $post_id );
	$thumbnail = wp_get_attachment_image_src( $t_id, 'large' );

	if ( ! $thumbnail ) {
		$html = sprintf( '<img class="landscape" src="%s" width="896" height="480" alt="%s" />'."\n", get_template_directory_uri() . '/assets/img/default_cover.jpg', get_bloginfo('name') );
	}
	else {
		$w = $thumbnail[1];
		$h = $thumbnail[2];

		$landscape = ( $w > $h );
		$wide      = ( $w > ( 2 * $h ) );

		if ( $wide ) {
			$class = 'class="wide"';
		}
		else if ( $landscape ) {
			$class = 'class="landscape"';
		}
		else {
			$class = '';
		}

		$html = sprintf( '<img %s src="%s" width="%d" height="%d" alt="%s" />'."\n", $class, $thumbnail[0], $w, $h, get_the_title( $post_id ) );
	}

	if ( $echo )
		echo $html;
	else
		return $html;
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
				<div class="comment-respond-avatar"><?php echo get_avatar( null, 74 ); ?></div>
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





/**
 * Categories widget class
 *
 * @since 2.8.0
 */
class Lebret_Widget_Categories extends WP_Widget {

        function __construct() {
                $widget_ops = array( 'classname' => 'lebret_widget_categories', 'description' => __( "A list or dropdown of categories. This is a copy of the Categories Widget, Lebret styled." ) );
                parent::__construct('lebret_categories', __('Lebret Categories'), $widget_ops);
        }

        function widget( $args, $instance ) {
                extract( $args );

                $title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories' ) : $instance['title'], $instance, $this->id_base);
                $c = ! empty( $instance['count'] ) ? '1' : '0';
                $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
                $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

                echo $before_widget;
                if ( $title )
                        echo "\n"."\t\t\t\t\t\t" . $before_title . $title . $after_title . "\n";

                $cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h);

                if ( $d ) {
                        $cat_args['show_option_none'] = __('Select Category');
                        wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
?>

<script type='text/javascript'>
/* <![CDATA[ */
        var dropdown = document.getElementById("cat");
        function onCatChange() {
                if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
                        location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
                }
        }
        dropdown.onchange = onCatChange;
/* ]]> */
</script>

<?php
                } else {

			$cat_args['title_li'] = '';
			$cat_args['echo'] = 0;

			$cats = get_categories(apply_filters('get_categories_taxonomy', 'category', $cat_args));

			if ( ! empty( $cats ) ) {

?>
						<div class="ui divided list">
<?php
				foreach ( $cats as $cat ) {
?>
							<div class="item">
								<i class="right small triangle icon"></i>
								<div class="content">
									<a href="<?php echo get_term_link( $cat, $cat->taxonomy ) ?>" class=""><?php echo $cat->cat_name ?></a>
									<div class="description"><?php echo $cat->description ?></div>
								</div>
							</div>
<?php
				}
?>
						</div>

<?php
			}

                }

                echo $after_widget;
        }

        function update( $new_instance, $old_instance ) {
                $instance = $old_instance;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
                $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
                $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

                return $instance;
        }

        function form( $instance ) {
                //Defaults
                $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
                $title = esc_attr( $instance['title'] );
                $count = isset($instance['count']) ? (bool) $instance['count'] :false;
                $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
                $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
?>
                <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

                <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
                <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
                <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

                <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
                <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
<?php
        }

}


/**
 * Navigation Menu widget class
 *
 * @since 3.0.0
 */
 class Lebret_Nav_Menu_Widget extends WP_Widget {

        function __construct() {
                $widget_ops = array( 'description' => __('Add a custom menu to your sidebar.') );
                parent::__construct( 'lebret_nav_menu', __('Lebret Custom Menu'), $widget_ops );
        }

        function widget($args, $instance) {
                // Get menu
                $nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

                if ( !$nav_menu )
                        return;

                $instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

                echo $args['before_widget'];

                if ( !empty($instance['title']) )
                        echo $args['before_title'] . $instance['title'] . $args['after_title'];

                wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu ) );

?>
						<div class="ui secondary vertical pointing menu">
							<a class="active item"><i class="users icon"></i> Friends</a>
							<a class="item"><i class="mail icon"></i> Messages</a>
							<a class="item"><i class="user icon"></i> Friends</a>
							<div class="ui dropdown item">
							    More <i class="dropdown icon"></i>
							    <div class="menu">
								    <a class="item"><i class="edit icon"></i> Edit Profile</a>
								    <a class="item"><i class="globe icon"></i> Choose Language</a>
								    <a class="item"><i class="settings icon"></i> Account Settings</a>
							    </div>
							</div>
						</div>
<?php

                echo $args['after_widget'];
        }

        function update( $new_instance, $old_instance ) {
                $instance['title'] = strip_tags( stripslashes($new_instance['title']) );
                $instance['nav_menu'] = (int) $new_instance['nav_menu'];
                return $instance;
        }

        function form( $instance ) {
                $title = isset( $instance['title'] ) ? $instance['title'] : '';
                $nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

                // Get menus
                $menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );

                // If no menus exists, direct the user to go and create some.
                if ( !$menus ) {
                        echo '<p>'. sprintf( __('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php') ) .'</p>';
                        return;
                }
                ?>
                <p>
                        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
                        <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
                </p>
                <p>
                        <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
                        <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
                <?php
                        foreach ( $menus as $menu ) {
                                echo '<option value="' . $menu->term_id . '"'
                                        . selected( $nav_menu, $menu->term_id, false )
                                        . '>'. $menu->name . '</option>';
                        }
                ?>
                        </select>
                </p>
                <?php
        }
}


function lebret_widgets() {

	register_widget( 'Lebret_Widget_Categories' );
	register_widget( 'Lebret_Nav_Menu_Widget' );
}
add_action( 'widgets_init', 'lebret_widgets' );