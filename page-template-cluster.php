<?php
/**
 * Template Name: Research Cluster
 * Template Post Type: page
 */
$cluster_leads      = get_field( 'cluster_leads' );

$cluster_colleges  = get_field( 'cluster_colleges' );
$cluster_proposal  = get_field( 'cluster_proposal' );
$cluster_news      = get_field( 'cluster_news' );
$cluster_stories   = get_field( 'cluster_news_stories' );

$news = research_get_news( $cluster_stories );

$cluster_gen_goals = get_field( 'cluster_general_goals' );
$cluster_lng_goals = get_field( 'cluster_long_term_goals' );

$goal_count = isset( $cluster_gen_goals ) ? 1 : 0;
$goal_count += isset( $cluster_lng_goals ) ? 1 : 0;

$cluster_values          = get_field( 'cluster_value_statements' );
$cluster_faculty_message = get_field( 'cluster_faculty_message' );
$cluster_faculty         = get_field( 'cluster_faculty_members' );

$section_one        = get_field( 'promotional_section_one' );
$section_one_lbl    = get_field( 'promotional_section_one_label' );
$section_two        = get_field( 'promotional_section_two' );
$section_two_lbl    = get_field( 'promotional_section_two_label' );
$section_footer     = get_field( 'promotional_section_footer' );
$section_footer_lbl = get_field( 'promotional_section_footer_label' );

get_header(); the_post(); ?>

<article class="<?php echo $post->post_status; ?> post-list-item">
	<div class="bg-faded">
		<div class="container py-4">
			<div class="row">
				<div class="col-lg-2 col-md-3">
					<h2 class="h5 text-muted font-italic">Cluster Lead<?php echo count( $cluster_leads ) > 1 ? 's' : ''; ?>:</h2>
				</div>
				<?php foreach( $cluster_leads as $cluster_lead_obj ) :
					$cluster_lead = $cluster_lead_obj['cluster_lead'];
					$cluster_lead_title = $cluster_lead_obj['cluster_lead_title'] ?: $cluster_lead->person_jobtitle;
				?>
				<div class="col">
					<p class="mb-1 font-bold"><?php echo $cluster_lead->person_title_prefix; ?> <?php echo $cluster_lead->post_title; ?></p>
					<span class="d-block"><?php echo $cluster_lead_title; ?></span>
					<span class="d-block"><a href="tel:<?php echo $cluster_lead->person_phone; ?>"><?php echo $cluster_lead->person_phone; ?></a></span>
					<span class="d-block"><a href="mailto:<?php echo $cluster_lead->person_email; ?>"><?php echo $cluster_lead->person_email; ?></a></span>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
		<div class="row">
			<div class="col-lg-8">
				<?php the_content(); ?>
				<?php if ( $cluster_colleges && count( $cluster_colleges ) > 0 ) : ?>
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
				<?php endif; ?>
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
			</div>
		</div>
	</div>
	<!-- Promo Section One -->
	<?php echo ! empty( $section_one ) ? do_shortcode( "[ucf-section id=\"$section_one->ID\" title=\"$section_one_lbl\"]" ) : ''; ?>
	<!-- End Promo Section One -->
	<!-- Start News -->
	<?php if ( ! empty( $news ) && count( $news ) > 0 ) : ?>
	<div class="container py-4 py-md-5">
		<h2 class="h1 mb-0">In The News</h2>
		<hr class="mt-2">
		<div class="row">
			<div class="col-md-8">
				<div class="ucf-news modern">
				<?php foreach( $news as $item ) echo $item; ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<!-- End News -->
	<!-- Start Goals! -->
	<?php if ( $goal_count > 0 ) : ?>
	<section class="bg-inverse jumbotron" aria-labelledby="goals">
		<div class="container">
			<h2 id="goals">Goals</h2>
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
	<section aria-labelledby="why-join">
		<h2 id="why-join" class="my-5">Why Join the <?php echo $post->post_title; ?> Cluster?</h2>
		<div class="row mb-5">
		<?php foreach( $cluster_values as $value_statement ) : ?>
			<div class="col-md-4">
				<h3 class="h4 mb-3"><?php echo $value_statement['value_title']; ?></h3>
				<?php echo $value_statement['value_content']; ?>
			</div>
		<?php endforeach; ?>
		</div>
	</section>
	<?php endif; // cluster value statements ?>
	</div>
	<?php echo ! empty( $section_two ) ? do_shortcode( "[ucf-section id=\"$section_two->ID\" title=\"$section_two_lbl\"]" ) : ''; ?>
	<div class="container">
	<?php  if ( $cluster_faculty && count( $cluster_faculty ) > 0 ) : ?>
	<section aria-labelledby="faculty-listing">
	<h2 id="faculty-listing" class="h3 mb-4"><?php echo $post->post_title; ?> Faculty</h2>
	<?php echo $cluster_faculty_message; ?>
	<div class="jumbotron jumbotron-light mt-4 pt-4 pb-2">
		<h3 class="heading-underline">Cluster Faculty</h3>
		<ul class="list-unstyled">
		<?php foreach( $cluster_faculty as $faculty ) : ?>
			<li><a href="mailto:<?php echo $faculty->person_email; ?>"><?php echo $faculty->post_title; ?></a>, <?php echo $faculty->person_jobtitle; ?></li>
		<?php endforeach; ?>
		</ul>
	</div>
	</section>
	<?php endif; ?>
	</div>
	<?php echo ! empty( $section_footer ) ? do_shortcode( "[ucf-section id=\"$section_footer->ID\" title=\"$section_footer_lbl\"]" ) : ''; ?>
</article>

<?php get_footer(); ?>
