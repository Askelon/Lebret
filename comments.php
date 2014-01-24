<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Lebret
 * @since Lebret 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;

if ( comments_open() ) : ?>

				<div id="comments" class="comments-area">

<?php if ( have_comments() ) : ?>
					<h2 class="comments-title">
						<?php printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'lebret' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ); ?>
					</h2>

					<ol class="comment-list">
						<?php
							wp_list_comments( array(
								'callback'    => 'lebret_comments',
								'style'       => 'ul',
								'short_ping'  => true,
								'avatar_size' => 74,
							) );
						?>
					</ol><!-- .comment-list -->

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
					<nav class="navigation comment-navigation" role="navigation">
						<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'lebret' ); ?></h1>
						<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'lebret' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'lebret' ) ); ?></div>
					</nav><!-- .comment-navigation -->
<?php
		endif; // Check for comment navigation
	else : ?>
					<p><em><?php _e( 'No comment yet. Want to be the first?', 'lebret' ); ?></em></p>
<?php endif; // have_comments() ?>

					<?php
					$user = wp_get_current_user();
					comment_form(
						array(
							'comment_notes_before' => '',
							'fields' => array(
								'author'               => '<div class="comment-form-author"><div class="comment-form-label">' . '<label for="author">' . __( 'Name', 'lebret' ) . ' <span class="required">*</span></label></div><div class="comment-form-input">' . '<input id="author" name="author" type="text" value="" size="30" aria-required="true" placeholder="' . __( 'John Doe', 'lebret' ) . '" /></div></div>',
								'email'                => '<div class="comment-form-email"><div class="comment-form-label"><label for="email">' . __( 'Email', 'lebret' ) . ' <span class="required">*</span></label></div><div class="comment-form-input">' . '<input id="email" name="email" type="email" value="" size="30" aria-required="true" placeholder="' . __( 'john@johndoe.me', 'lebret' ) . '" /></div></div>',
								'url'                  => '<div class="comment-form-url"><div class="comment-form-label"><label for="url">' . __( 'Website', 'lebret' ) . '</label></div><div class="comment-form-input">' . '<input id="url" name="url" type="url" value="" size="30" placeholder="' . __( 'http://johndoe.me', 'lebret' ) . '" /></div></div><div style="clear:both"></div>'
							),
							'comment_field'        => '<div class="comment-respond-content"><div class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . __( 'Want to say something? Please, help yourself!', 'lebret' ) . '"></textarea></div>',
							'logged_in_as'         => '<div class="logged-in-as">' . get_avatar( $user->user_email, 74 ) . '<div class="comment-author-vcard">' . sprintf( '<a href="%1$s">%2$s</a> <a href="%3$s" title="%3$s"><span class="entypo">&#59201;</span></a></div>', get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ), __( 'Log out of this account', 'lebret' ) ) . '</div>'
						)
					); ?>

				</div><!-- #comments -->

<?php endif; // comments_open() ?>