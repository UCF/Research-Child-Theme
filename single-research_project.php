<?php

use UCFResearchPublication\Common;

$principal_investigator    = get_field( 'rp_principal_investigator', $post->ID );
$investigators = get_field( 'rp_coprincipal_investigators', $post->ID );

get_header(); the_post(); ?>

<article class="<?php echo $post->post_status; ?> post-list-item">

	<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
		<div class="row">
			<div class="col-lg-8 pr-lg-5">
				<?php the_content(); ?>
			</div>

			<?php if ( $principal_investigator || $investigators ) : ?>

			<div class="col-lg-4 mt-4 mt-lg-0">
				<?php if ( $principal_investigator ) : ?>
					<h2 class="h5 heading-underline">Principal Investigator</h2>
					<dl>
						<dt>
							<?php echo $principal_investigator->person_title_prefix; ?>
							<?php echo $principal_investigator->post_title; ?>
							<?php echo $principal_investigator->person_title_suffix; ?>
						</dt>

						<?php if ( $principal_investigator->person_jobtitle ) : ?>
							<dd class="mb-0"><?php echo $principal_investigator->person_jobtitle; ?></dd>
						<?php endif; ?>

						<?php if ( $principal_investigator->person_phone ) : ?>
							<dd class="mb-0">
								<a href="tel:<?php echo preg_replace("/[^0-9,.]/", "", $principal_investigator->person_phone ); ?>">
									<?php echo $principal_investigator->person_phone; ?>
								</a>
							</dd>
						<?php endif; ?>

						<?php if ( $principal_investigator->person_email ) : ?>
							<dd class="mb-0">
								<a href="mailto:<?php echo $principal_investigator->person_email; ?>">
									<?php echo $principal_investigator->person_email; ?>
								</a>
							</dd>
						<?php endif; ?>
					</dl>
				<?php endif; ?>

				<?php if( $investigators ) : ?>
					<h2 class="h5 heading-underline mt-4 pt-2 mb-0">Investigators</h2>

					<dl>

						<?php foreach( $investigators as $investigator ) : ?>

							<dt class="pt-3">
								<?php echo $investigator->person_title_prefix; ?>
								<?php echo $investigator->post_title; ?>
								<?php echo $investigator->person_title_suffix; ?>
							</dt>

							<?php if ( $investigator->person_jobtitle ) : ?>
								<dd class="mb-0"><?php echo $investigator->person_jobtitle; ?></dd>
							<?php endif; ?>

							<?php if ( $investigator->person_phone ) : ?>
								<dd class="mb-0">
									<a href="tel:<?php echo preg_replace("/[^0-9,.]/", "", $investigator->person_phone ); ?>">
										<?php echo $investigator->person_phone; ?>
									</a>
								</dd>
							<?php endif; ?>

							<?php if ( $investigator->person_email ) : ?>
								<dd class="mb-0">
									<a href="mailto:<?php echo $investigator->person_email; ?>">
										<?php echo $investigator->person_email; ?>
									</a>
								</dd>
							<?php endif; ?>

						<?php endforeach; ?>

					</dl>

				<?php endif; ?>
			</div>

			<?php endif; ?>
		</div>
	</div>

</article>

<?php get_footer(); ?>
