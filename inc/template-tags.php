<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package blanksingle
 */

if ( ! function_exists( 'blanksingle_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function blanksingle_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on blanksingle pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'blanksingle' ); ?></h1>

	<?php
		if ( is_single() && 'jetpack-testimonial' == get_post_type() ) :
			previous_post_link( '<div class="nav-previous">%link</div>', __( '<span class="meta-nav">Previous testimonial</span>', 'blanksingle' ) );
			next_post_link( '<div class="nav-next">%link</div>', __( 'Next testimonial', 'blanksingle' ) );

		elseif ( is_attachment() ) :
			previous_post_link( '<div class="nav-previous">%link</div>', __( '<span class="meta-nav">View the post</span>', 'blanksingle' ) );

		elseif ( is_single() ) :
			previous_post_link( '<div class="nav-previous">%link</div>', __( '<span class="meta-nav">Previous post</span>', 'blanksingle' ) );
			next_post_link( '<div class="nav-next">%link</div>', __( 'Next post', 'blanksingle' ) );

		elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages
			if ( get_next_posts_link() )
	?>
			<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'blanksingle' ) ); ?></div>

	<?php
			if ( get_previous_posts_link() )
	?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'blanksingle' ) ); ?></div>
	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // blanksingle_content_nav

if ( ! function_exists( 'blanksingle_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function blanksingle_posted_on() {
	// Get the author name; wrap it in a link.
	$byline = sprintf(
		/* translators: %s: post author */
		__( 'by %s', 'blanksingle' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
	);

	// Finally, let's write all of this to the page.
	echo '<span class="posted-on">' . blanksingle_time_link() . '</span><span class="byline"> ' . $byline . '</span>';
}
endif;

if ( ! function_exists( 'blanksingle_time_link' ) ) :
/**
 * Gets a nicely formatted string for the published date.
 */
function blanksingle_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);

	// Wrap the time string in a link, and preface it with 'Posted on'.
	return sprintf(
		/* translators: %s: post date */
		__( '<span class="screen-reader-text">Posted on</span> %s', 'blanksingle' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
}
endif;

if ( ! function_exists( 'blanksingle_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function blanksingle_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'blanksingle' ) );
		if ( $categories_list && blanksingle_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'blanksingle' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'blanksingle' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'blanksingle' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'blanksingle' ), esc_html__( '1 Comment', 'blanksingle' ), esc_html__( '% Comments', 'blanksingle' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'blanksingle' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function blanksingle_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'blanksingle_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'blanksingle_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so blanksingle_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so blanksingle_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in blanksingle_categorized_blog.
 */
function blanksingle_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'blanksingle_categories' );
}
add_action( 'edit_category', 'blanksingle_category_transient_flusher' );
add_action( 'save_post',     'blanksingle_category_transient_flusher' );
