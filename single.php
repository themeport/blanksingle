<?php
/**
 * The template for displaying all blanksingle posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#blanksingle-post
 *
 * @package blanksingle
 */

get_header(); ?>

	<div class="wrap">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

				the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .wrap -->

<?php
get_footer();
