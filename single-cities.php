<?php
if ( isset( $_GET['csv'] ) && $_GET['csv'] == 'show'):
	header("Content-type: text/csv; charset=utf-8");
	header("Content-Disposition: attachment; filename=output.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	$args = array(
			'post_type' => 'projects',
			'posts_per_page' => -1,
			'meta_query' => array(
					array(
							'key' => 'city',
							'value' => '"' . get_the_ID() . '"',
							'compare' => 'LIKE'
					)
			)
	);

	$outstream = fopen("php://output", "w");
	fwrite($outstream, 'name,description,link_url,code_url' . "\r\n");
	$query = new WP_Query($args);
	if ($query->have_posts()):
		while ($query->have_posts()): $query->the_post();
			$links = get_field('links');
			if ($links) {
				foreach ($links as $link) {
					if (strstr($link['url'], 'github.com')) {
						$ar = explode('/', $link['url']);
						fwrite($outstream, get_the_title() . ' (' . $ar[4] . '),"' . trim(str_replace('&nbsp;', '', get_the_content(''))) . '",' . get_permalink(icl_object_id(get_the_ID()), '', true, 'en') . ',' . $link['url'] . "\r\n");
					}
				}
			}
		endwhile;
	endif;
	fclose($outstream);
	exit;
else:
	?>
	<?php get_header() ?>
	<?php $src = get_template_directory_uri(); ?>

	<?php get_template_part('breadcrumbs'); ?>

	<div class="row city-single">

		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
				<?php
				$img = get_field('baner');
				?>
				<div class="small-12 medium-9 columns city-content">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<img src="<?php echo $img['sizes']['large']; ?>" class="mb40" />
					<?php
					$fb_cities = get_field('fb_cities');
					if ($fb_cities) {
						$cities = [];
						foreach ($fb_cities as $fb_city) {
							$cities[] = $fb_city['city'];
						}
					}
					?>

					<?php $content = apply_filters( 'the_content', get_the_content() ); ?>

					<?php if(!empty(trim($content))): ?>

					<h3 class="section-title"><?php _e('About us'); ?></h3>
					<p class="meetings-description"> 
					<?php the_content(); ?>
					</p>
					<?php endif; ?>

					<?php
					$members = get_field('coordinators');
					if(!$members) { $members = []; } 
					$args = array(
							'post_type' => 'projects',
							'posts_per_page' => -1,
							'meta_query' => array(
									array(
											'key' => 'city',
											'value' => '"' . get_the_ID() . '"',
											'compare' => 'LIKE'
									)
							)
					);

					$query = new WP_Query($args);
					?>

					<?php if ($query->have_posts()): ?>
						<h3 class="section-title mt30"><?php _e('Projects'); ?></h3>
						<div class="row project-list">

							<?php while ($query->have_posts()): $query->the_post(); ?>
								<?php get_template_part('project-on-list'); ?>
								<?php
							endwhile;
							wp_reset_query();
							?>
						</div>
					<?php endif; ?>

					<h3 class="section-title show-for-medium"><?php _e('Organizers'); ?></h3>
					<div class="row mt10 show-for-medium">

						<?php
						$i = 1;
						?>
						<?php foreach ($members as $member): ?>
							<div class="small-12 medium-4 columns team-list fleft">
								<table>
									<tr>
										<td class="photo">
											<?php
											$photo = get_field('photo', 'user_' . $member['ID']);
											$user_photo = $photo['sizes']['thumbnail'];
											if (!$user_photo) {
												$user_photo = get_avatar_url($member['ID'], array('size' => 105));
											}
											if (!$user_photo) {
												$user_photo = $src . '/images/blank-person.png';
											}
											$phone = get_field('phone_contact', 'user_' . $member['ID']);
											$mail = get_field('mail_contact', 'user_' . $member['ID']);
											$function = get_field('function', 'user_' . $member['ID']);
											?>
											<a href="<?php echo get_author_posts_url($member['ID']); ?>"><img src="<?php echo $user_photo; ?>" alt="<?php echo $member['display_name'] ?>" /></a>
										</td>
										<td class="desc">
											<h4><a href="<?php echo get_author_posts_url($member['ID']); ?>"><?php echo $member['display_name'] ?></a></h4>
										</td>
									</tr>
								</table>
							</div>
							<?php
							$i++;
						endforeach;
						?>
					</div>



					<?php
					if ($query->have_posts()):
						$exists = [];
						?>

						<h3 class="section-title mt30 show-for-medium"><?php _e('Members'); ?></h3>
						<div class="row show-for-medium">
							<?php while ($query->have_posts()): $query->the_post(); ?>
								<?php
								$team = get_field('osoby');
								if ($team):
									?>
									<?php foreach ($team as $member): ?>
										<?php if ($member['person']['ID'] && !in_array($member['person']['ID'], $exists)): ?>
											<div class="small-12 medium-4 columns team-list fleft">
												<table>
													<tr>
														<td class="photo">
															<?php
															$photo = get_field('photo', 'user_' . $member['person']['ID']);
															$user_photo = $photo['sizes']['thumbnail'];
															if (!$user_photo) {
																$user_photo = get_avatar_url($member['person']['ID'], array('size' => 105));
															}
															if (!$user_photo) {
																$user_photo = $src . '/images/blank-person.png';
															}
															?>
															<a href="<?php echo get_author_posts_url($member['person']['ID']); ?>"><img src="<?php echo $user_photo; ?>" alt="<?php echo $member['person']['display_name'] ?>" /></a>
														</td>
														<td class="desc">
															<h4><a href="<?php echo get_author_posts_url($member['person']['ID']); ?>"><?php echo $member['person']['display_name'] ?></a></h4>
														</td>
													</tr>
												</table>
											</div>
											<?php $exists[] = $member['person']['ID']; ?>
										<?php else: ?>
										<?php endif; ?>
									<?php endforeach; ?>

								<?php endif; ?>
								<?php
							endwhile;
							wp_reset_query();
							?>
						</div>
					<?php endif; ?>




					<?php if (get_field('partners_template') == 'lista'): ?>
						<?php
						$posts = get_field('partners');
						if ($posts):
							?>
							<h3 class="section-title mt30"><?php _e('Partners'); ?></h3>
							<?php
							foreach ($posts as $post):
								setup_postdata($post);
								$logo = get_field('logo');
								$url = get_field('url');
								?>
								<div class="partner-box">
									<?php if ($url): ?>
										<a href="<?php echo $url; ?>"><img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php the_title(); ?>" /></a>
										<h3><a href="<?php echo $url; ?>"><?php the_title(); ?></a></h3>
									<?php else: ?>
										<img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php the_title(); ?>" />
										<h3><?php the_title(); ?></h3>
									<?php endif; ?>
									<div class="content">
										<?php the_content(); ?>
									</div>
								</div>
								<?php
							endforeach;
							wp_reset_postdata();
							?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="small-12 medium-3 columns post-author">
					<?php get_template_part('sidebar-city'); ?>
				</div>
				<?php
				$blog_posts = get_field('blog_posts');
				if ($blog_posts):
					?>
					<div class="row pt40">
						<div class="small-12 columns pt30">
							<h3 class="section-title"><span><?php _e('Blog'); ?></span></h3>
						</div>
					</div>
					<div class="row post-list mb40">
						<?php
						$args = array(
								'post_type' => 'post',
								'posts_per_page' => 3,
								'cat' => $blog_posts
						);

						$query = new WP_Query($args);
						?>
						<?php if ($query->have_posts()): ?>
							<?php while ($query->have_posts()): $query->the_post(); ?>
								<?php get_template_part('post-on-list'); ?>
								<?php
							endwhile;
							wp_reset_postdata();
							?>
						<?php endif; ?>
						<div class="small-12 columns text-center">
							<a href="<?php echo get_permalink(icl_object_id(17, 'page')); ?>" class="btn red"><?php _e('Read all posts'); ?></a>
						</div>
					</div>
				<?php endif; ?>
				<?php if (get_field('partners_template') == 'logo'): ?>
					<div class="small-12 columns mb50">
						<?php
						$posts = get_field('partners');
						if ($posts):
							?>
							<h3 class="section-title"><?php _e('Partners'); ?></h3>
							<div class="row small-up-2 medium-up-4 large-up-6 mt25">
								<?php
								foreach ($posts as $post):
									setup_postdata($post);
									$logo = get_field('logo');
									$url = get_field('url');
									?>
									<div class="column">
										<div class="partner-wrapper">
											<?php if ($url): ?>
												<a href="<?php echo $url; ?>"><img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php the_title(); ?>" /></a>
											<?php else: ?>
												<img src="<?php echo $logo['sizes']['medium']; ?>" alt="<?php the_title(); ?>" />
											<?php endif; ?>
										</div>
									</div>
									<?php
								endforeach;
								wp_reset_postdata();
								?>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
	<?php get_footer() ?>
<?php endif; ?>
