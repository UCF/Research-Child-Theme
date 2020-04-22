<?php
/**
 * Template Name: Research Cluster
 * Template Post Type: page
 */
use UCFResearchPublication\Common;

$cluster_leads     = get_field( 'cluster_leads' );
$cluster_colleges  = get_field( 'cluster_colleges' );
$cluster_stories   = get_field( 'cluster_news_stories' );
$cluster_events    = get_field( 'cluster_events_feed' );
$cluster_social    = get_field( 'cluster_related_tweets' );

$news = research_get_news( $cluster_stories );

$cluster_faculty = get_field( 'cluster_faculty' );


$section_one        = get_field( 'promotional_section_one' );
$section_one_lbl    = get_field( 'promotional_section_one_label' );
$section_two        = get_field( 'promotional_section_two' );
$section_two_lbl    = get_field( 'promotional_section_two_label' );
$section_footer     = get_field( 'promotional_section_footer' );
$section_footer_lbl = get_field( 'promotional_section_footer_label' );

$research_projects     = get_field( 'cluster_projects' );
$research_publications = get_field( 'cluster_publications' );

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
			</div>
			<div class="col-lg-4">
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
	<?php echo ! empty( $section_two ) ? do_shortcode( "[ucf-section id=\"$section_two->ID\" title=\"$section_two_lbl\"]" ) : ''; ?>
	<?php  if ( $cluster_faculty && count( $cluster_faculty ) > 0 ) : ?>
	<!-- Faculty -->
	<section aria-labelledby="faculty-listing" class="jumbotron jumbotron-light">
		<div class="container">
			<h2 id="faculty-listing" class="h3"><?php echo $post->post_title; ?> Faculty</h2>
			<div class="pt-4 pb-2">
				<?php echo research_get_faculty_list( $cluster_faculty ); ?>
			</div>
		</div>
	</section>
	<!-- End Faculty -->
	<!-- Research -->
	<?php if ( ! empty( $research_projects ) ) : ?>
	<section aria-labelledby="research-projects">
		<div class="container">
			<h2 id="research-projects" class="h3 mb-4"><?php echo $post->post_title; ?> Projects</h2>
			<div class="row">
			<?php
				foreach( $research_projects as $project ) :
					$principle_investigator = get_field( 'rp_principle_investigator', $project->ID );
					$co_investigators = get_field( 'rp_co_investigators', $project->ID );
			?>
				<div class="card col-lg-4 mb-4">
					<div class="card-block">
						<div class="card-title">
							<h3 class="h5"><?php echo $project->post_title; ?></h3>
							<dl>
								<dd>Principle Investigator:</dd>
								<dt><?php echo $principle_investigator->post_title; ?></dt>
							</dl>
							<p class="card-text"><?php echo $project->post_excerpt; ?></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
	<?php if ( ! empty( $research_publications ) ) : ?>
	<section area-labelledby="research-publications">
		<div class="container">
			<h2 id="research-publications" class="h3 mb-4"><?php echo $post->post_title; ?> Publications</h2>
			<div class="card-deck">
			<?php
				foreach( $research_publications as $publication ) :
			?>
				<div class="card mb-4">
					<div class="card-block">
						<?php echo Common\get_publication_markup( $publication ); ?>
					</div>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
	<!-- End Research -->
	<?php endif; ?>
	</div>
	<?php if ( ! empty( $cluster_events ) ) : ?>
	</div><!-- End .container -->
	<div class="jumbotron bg-inverse">
		<div class="container">
		<?php echo do_shortcode( "[ucf-events feed_url='$cluster_events' layout='modern']" ); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php echo ! empty( $section_footer ) ? do_shortcode( "[ucf-section id=\"$section_footer->ID\" title=\"$section_footer_lbl\"]" ) : ''; ?>
	<?php if ( ! empty( $cluster_social ) ) : ?>
	<div class="container">
		<h2><?php echo $post->post_title; ?> Social</h2>
		<div class="row">
		<?php foreach( $cluster_social as $embed ) : ?>
			<div class="col-md-6 col-lg-4">
			<?php echo $embed['social_embed']; ?>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>
</article>

<?php get_footer(); ?>
