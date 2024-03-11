<?php get_header(); the_post(); ?>

<div>
	<?php the_post_thumbnail( 'large', array( 'class' => 'w-100 img-fluid text-center object-fit-cover' , 'style' => 'min-height: 500px; max-height: 700px') ) ?>
</div>
<article class="<?php echo $post->post_status; ?> post-list-item">
	<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
		<div class="row">
			<div class="col-lg-12">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</article>

<?php get_footer(); ?>
