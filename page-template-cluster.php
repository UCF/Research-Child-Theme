<?php
/**
 * Template Name: Research Cluster
 * Template Post Type: page
 */
use UCFResearchPublication\Common;

$cluster_leads     = get_field( 'cluster_leads' );
$cluster_colleges  = get_field( 'cluster_colleges' );
$cluster_events    = get_field( 'cluster_events_feed' );
$cluster_social    = get_field( 'cluster_related_tweets' );
$cluster_prg_copy  = get_field( 'cluster_program_lead_copy' );
$cluster_programs  = get_field( 'cluster_programs' );

$cluster_colleges_heading = get_field( 'cluster_colleges_heading' ) ?: "UCF Colleges Involved with {$post->post_title} Research";
$cluster_colleges_image   = get_field( 'cluster_colleges_image' );

$cluster_feed_type  = get_field( 'cluster_news_feed_type' );
$cluster_feed_topic = get_field( 'cluster_news_feed_topic' );
$cluster_stories    = get_field( 'cluster_news_stories' );

$news = research_get_news( $cluster_stories );

$cluster_faculty   = get_field( 'cluster_faculty' ) ?: null;
$cluster_post_docs = get_field( 'cluster_students' ) ?: null;


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
				<section id="cluster-content" aria-label="Main Content">
					<?php the_content(); ?>
				</section>
			</div>
			<div class="col-lg-4">
				<?php if ( $cluster_colleges && count( $cluster_colleges ) > 0 ) : ?>
				<section id="cluster-colleges-centers" aria-labelledby="cluster-colleges-centers-heading">
					<?php if ( $cluster_colleges_image ) : ?>
					<img src="<?php echo $cluster_colleges_image['url']; ?>" class="img-fluid mb-4" alt="<?php echo $cluster_colleges_image['alt']; ?>">
					<?php endif; ?>
					<h2 id="cluster-colleges-centers-heading" class="h5 mb-4"><?php echo $cluster_colleges_heading; ?>:</h2>
					<ul class="list-unstyled">
					<?php foreach( $cluster_colleges as $college ) : ?>
						<li class="mb-2">
							<a href="<?php echo $college['college_url']; ?>" target="_blank">
								<?php echo $college['college_name']; ?>
							</a>
						</li>
					<?php endforeach; ?>
					</ul>
				</section>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- Promo Section One -->
	<?php echo ! empty( $section_one ) ? do_shortcode( "[ucf-section id=\"$section_one->ID\" title=\"$section_one_lbl\"]" ) : ''; ?>
	<!-- End Promo Section One -->
	<!-- Start News -->
	<section id="cluster-news" aria-labelledby="cluster-news-heading">
		<div class="container py-4 py-md-5">
			<h2 id="cluster-news-heading" class="h1 mb-0">In The News</h2>
			<hr class="mt-2">
			<div class="row">
				<div class="col-lg-8">
					<?php if ( $cluster_feed_type === 'feed' ) : ?>
					<?php echo do_shortcode( "[ucf-news-feed layout='modern' topics='$cluster_feed_topic' title='']" ); ?>
					<?php else : ?>
					<div class="ucf-news modern">
					<?php foreach( $news as $item ) echo $item; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $cluster_social ) ) : ?>
				<div class="col-lg-4">
					<?php foreach( $cluster_social as $embed ) : ?>
						<?php echo $embed['social_embed']; ?>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<!-- End News -->
	<?php if ( ! empty( $research_projects ) ) : ?>
	<!-- Research Projects -->
	<section id="research-projects" aria-labelledby="research-projects-heading">
		<div class="container">
			<h2 id="research-projects-heading" class="h3 mb-4"><?php echo $post->post_title; ?> Projects</h2>
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
	<!-- End Research Projects -->
	<?php endif; ?>
	<?php if ( ! empty( $research_publications ) ) : ?>
	<!-- Research Publications -->
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
	<!-- End Research Publications -->
	<?php endif; ?>
	<!-- End Research -->
	<?php if ( is_array( $cluster_programs ) && ! empty( $cluster_programs ) ) : ?>
	<!-- Start Academics -->
	<section class="jumbotron bg-inverse text-inverse mb-0" aria-labelledby="research-programs">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<h2 id="research-programs" class="h1 mb-4 text-primary font-weight-black section-heading"><?php echo $post->post_title; ?> Degree Programs</h2>
					<?php if ( $cluster_prg_copy ) : ?>
					<div class="mb-5">
						<p><?php echo $cluster_prg_copy; ?></p>
					</div>
					<?php endif; ?>
					<div class="mb-5">
						<?php echo do_shortcode( '[ucf-degree-search placeholder="Search programs..."]' ); ?>
					</div>
				</div>
				<div class="col-lg-1 hidden-md-down">
					<hr class="hidden-xs hidden-sm hr-vertical hr-white center-block">
				</div>
				<div class="col-lg-3">
					<h3 class="h5 mb-3"><span class="badge badge-inverse">Programs</span></h3>
					<ul class="pl-3">
					<?php foreach( $cluster_programs as $program ) : ?>
						<li><a class="text-inverse" href="<?php echo $program['program_url']; ?>"><?php echo $program['program_name']; ?></a></li>
					<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- End Academics -->
	<?php endif; ?>
	<?php echo ! empty( $section_two ) ? do_shortcode( "[ucf-section id=\"$section_two->ID\" title=\"$section_two_lbl\"]" ) : ''; ?>
	<?php  if ( $cluster_faculty && count( $cluster_faculty ) > 0 ) : ?>
	<!-- Faculty -->
	<section aria-labelledby="faculty-listing" class="jumbotron jumbotron-light mb-0">
		<div class="container">
			<?php if ( $cluster_faculty && count( $cluster_faculty ) > 0 ) : ?>
			<h2 id="faculty-listing" class="h3"><?php echo $post->post_title; ?> Faculty</h2>
			<div class="pt-4 pb-2">
				<?php echo research_get_faculty_list( $cluster_faculty ); ?>
			</div>
			<?php endif; ?>
			<?php if ( $cluster_post_docs && count( $cluster_post_docs ) > 0 ) : ?>
				<h2 id="post-doc-listing" class="h3"><?php echo $post->post_title; ?> Post Doctoral Researchers</h2>
				<div class="pt-4 pb-2">
					<?php echo research_get_postdoc_list( $cluster_post_docs ); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<!-- End Faculty -->
	<?php endif; ?>
	<?php if ( ! empty( $cluster_events ) ) : ?>
	<!-- Events -->
	<section id="cluster-events" aria-label="Events">
		<div class="jumbotron bg-inverse mb-0">
			<div class="container">
			<?php echo do_shortcode( "[ucf-events feed_url='$cluster_events' layout='modern']" ); ?>
			</div>
		</div>
	</section>
	<!-- End Events -->
	<?php endif; ?>
	<?php echo ! empty( $section_footer ) ? do_shortcode( "[ucf-section id=\"$section_footer->ID\" title=\"$section_footer_lbl\"]" ) : ''; ?>
</article>

<?php get_footer(); ?>
