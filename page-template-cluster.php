<?php
/**
 * Template Name: Research Cluster
 * Template Post Type: page
 */
$cluster_lead       = get_field( 'cluster_lead' );
$cluster_lead_title = get_field( 'cluster_lead_title' ) ?: $cluster_lead->person_jobtitle;


$cluster_colleges  = get_field( 'cluster_colleges' );
$cluster_proposal  = get_field( 'cluster_proposal' );
$cluster_news      = get_field( 'cluster_news' );

$cluster_gen_goals = get_field( 'cluster_general_goals' );
$cluster_lng_goals = get_field( 'cluster_long_term_goals' );

$goal_count = isset( $cluster_gen_goals ) ? 1 : 0;
$goal_count += isset( $cluster_lng_goals ) ? 1 : 0;

$cluster_values          = get_field( 'cluster_value_statements' );
$cluster_faculty_message = get_field( 'cluster_faculty_message' );
$cluster_faculty         = get_field( 'cluster_faculty_members' );

get_header(); the_post(); ?>

<article class="<?php echo $post->post_status; ?> post-list-item">
	<div class="bg-faded">
		<div class="container py-4">
			<div class="row">
				<div class="col-lg-2">
					<h2 class="h5 text-muted font-italic">Cluster Lead:</h2>
				</div>
				<div class="col-lg-10">
					<p class="mb-1 font-bold"><?php echo $cluster_lead->person_title_prefix; ?> <?php echo $cluster_lead->post_title; ?></p>
					<span class="d-block"><?php echo $cluster_lead_title; ?></span>
					<span class="d-block"><a href="tel:<?php echo $cluster_lead->person_phone; ?>"><?php echo $cluster_lead->person_phone; ?></a></span>
					<span class="d-block"><a href="mailto:<?php echo $cluster_lead->person_email; ?>"><?php echo $cluster_lead->person_email; ?></a></span>
				</div>
			</div>
		</div>
	</div>
	<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
		<div class="row">
			<div class="col-lg-8">
				<?php the_content(); ?>
				<h2 class="h4 text-default mt-5 mb-4">UCF Colleges Involved in <?php echo $post->post_title; ?>:</h2>
				<ul>
				<?php foreach( $cluster_colleges as $college ) : ?>
					<li>
						<a class="text-primary" href="<?php echo $college['college_url']; ?>" target="_blank">
							<?php echo $college['college_name']; ?>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
			<div class="col-lg-3 offset-lg-1">
				<?php if ( $cluster_proposal ) : ?>
				<div class="chevron-link mb-5">
					<span class="fa fa-chevron-right"></span>
					<a href="<?php echo get_permalink( $cluster_proposal->ID ); ?>">
						View the <?php echo $post->post_title; ?> Cluster Proposal
					</a>
				</div>
				<?php endif; // End if $cluster_proposal ?>

				<?php if ( $cluster_news ) : ?>
				<h3 class="text-default h4 mb-4">Learn More About <?php echo $post->post_title; ?>:</h3>
				<?php foreach( $cluster_news as $news ) : ?>
				<div class="cluster-news-item mt-1 mb-2">
					<a class="text-secondary font-weight-bold" href="<?php echo $news['news_url']; ?>" target="_blank">
						<?php echo $news['news_title']; ?>
					</a>
					<p class="text-muted text-small font-italic"><?php echo $news['news_source']; ?>
				</div>
				<?php endforeach; ?>
				<?php endif; // End if $cluster_news ?>
			</div>
		</div>
	</div>
	<!-- Start Goals! -->
	<?php if ( $goal_count > 0 ) : ?>
	<section class="bg-inverse jumbotron">
		<div class="container">
			<h2>Goals</h2>
			<div class="row">
				<?php if ( $cluster_gen_goals ) : ?>
				<div class="col-lg-6<?php echo $goal_count < 2 ? ' offset-lg-3' : ''; ?>">
					<?php echo $cluster_gen_goals; ?>
				</div>
				<?php endif; ?>
				<?php if ( $cluster_lng_goals ) : ?>
				<div class="col-lg-6<?php echo $goal_count < 2 ? ' offset-lg-3' : ''; ?>">
					<?php echo $cluster_lng_goals; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
	<div class="container">
	<?php if ( $cluster_values && count( $cluster_values ) > 0 ) : ?>
		<h2 class="my-5">Why Join the <?php echo $post->post_title; ?> Cluster?</h2>
		<div class="row mb-5">
		<?php foreach( $cluster_values as $value_statement ) : ?>
			<div class="col-md-4">
				<p class="h4 mb-3"><?php echo $value_statement['value_title']; ?></p>
				<p class="font-condensed"><?php echo $value_statement['value_content']; ?></p>
			</div>
		<?php endforeach; ?>
		</div>
	<?php endif; // cluster value statements ?>
	<?php  if ( $cluster_faculty && count( $cluster_faculty ) > 0 ) : ?>
	<h2 class="h3 mb-4"><?php echo $post->post_title; ?> Faculty</h2>
	<p><?php echo $cluster_faculty_message; ?>
	<div class="jumbotron jumbotron-light">
		<h3 class="heading-underline">Cluster Faculty</h3>
		<ul class="list-unstyled">
		<?php foreach( $cluster_faculty as $faculty ) : ?>
			<li><a href="mailto:<?php echo $faculty->person_email; ?>"><?php echo $faculty->post_title; ?></a>, <?php echo $faculty->person_jobtitle; ?>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
	</div>
</article>

<?php get_footer(); ?>
