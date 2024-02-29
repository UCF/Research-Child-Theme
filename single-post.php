<?php get_header(); the_post(); ?>

<div class="featured-image">
	<?php the_post_thumbnail() ?>
</div>
<article class="<?php echo $post->post_status; ?> post-list-item">
	<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
		<div class="row">
			<div class="col-lg-12">
				<?php the_content(); ?>
			</div>
			<div class="col-lg-0">
				<?php if ( is_active_sidebar( 'research-custom-widget' ) ) : ?>
					<div id="research-custom-widget" class="primary-sidebar widget-area" role="complementary">
						<?php dynamic_sidebar( 'research-custom-widget' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</article>

<?php get_footer(); ?>
