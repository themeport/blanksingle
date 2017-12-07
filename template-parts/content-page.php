<?php
/**
 * Template part for displaying pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package blanksingle
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php blanksingle_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
			endif;

			the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
		?>

		<?php if ( '' != get_the_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="blog-thumbnail">
				<?php the_post_thumbnail( 'blanksingle-page-thumbnail' ); ?>
			</a>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'blanksingle' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'blanksingle' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php blanksingle_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
