<?php
$src = get_template_directory_uri();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php
			global $page, $paged;

			wp_title('|', true, 'right');

			bloginfo('name');

			$site_description = get_bloginfo('description', 'display');
			if ($site_description && ( is_home() || is_front_page() ))
				echo " | $site_description";
			?></title>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel="icon" href="<?php echo $src ?>/images/favicon.png" type="image/png" />
		<?php
		if (is_singular() && get_option('thread_comments'))
			wp_enqueue_script('comment-reply');


		wp_head();
		?>


		<meta name="viewport" content="width=device-width" />
		<script src='https://www.google.com/recaptcha/api.js?onload=kdpCallback&render=explicit'></script>
		<script>
			var recaptcha1;
			var recaptcha2;
			var kdpCallback = function () {
				recaptcha1 = grecaptcha.render('recaptcha1', {
					'sitekey': '6LdZuB8TAAAAAJ6u9zNLKCcf0iweJ5KEtjj6YCUd',
					'theme': 'light'
				});
				recaptcha2 = grecaptcha.render('recaptcha2', {
					'sitekey': '6LdZuB8TAAAAAJ6u9zNLKCcf0iweJ5KEtjj6YCUd',
					'theme': 'light'
				});
			};
		</script>
	</head>


	<body <?php body_class(); ?> >
<!-- Hotjar Tracking Code for http://kodujdlapolski.pl/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:345609,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>

		<header>
			<div class="ep-top">
				<div class="row">
					<div class="small-12 medium-6 large-6 columns text-center medium-text-left">
						<a href="https://epf.org.pl/" rel="noopener" target="_blank"><?php _e('ePaństwo Foundation program') ?><img src="<?php echo $src; ?>/images/eplogo.png" alt="<?php _e('ePaństwo Foundation program') ?>" /></a>
					</div>
					<div class="small-12 medium-6 large-6 columns text-center medium-text-right social-links">
						<a href="<?php the_field('irc_url', 'options'); ?>" rel="noopener" target="_blank"><i class="icon-irc"></i></a>
						<a href="<?php the_field('slack_url', 'options'); ?>" rel="noopener" target="_blank"><i class="icon-slack"></i></a>
						<a href="<?php the_field('youtube_url', 'options'); ?>" rel="noopener" target="_blank"><i class="icon-youtube-square"></i></a>
						<a href="<?php the_field('twitter_url', 'options'); ?>" rel="noopener" target="_blank"><i class="icon-twitter-square"></i></a>
						<a href="<?php the_field('facebook_url', 'options'); ?>" rel="noopener" target="_blank"><i class="icon-facebook-square"></i></a>
					</div>
					<div class="small-12 columns show-for-large"><hr /></div>
				</div>
			</div>
			<div class="row">
				<div class="small-5 columns show-for-large">
					<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'text-right main-menu')); ?>
				</div>
				<div class="small-6 large-2 columns large-text-center">
					<a href="<?php echo home_url(); ?>"><img src="<?php echo $src; ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a>
				</div>
				<div class="small-5 columns show-for-large relative">
					<?php wp_nav_menu(array('theme_location' => 'primary2', 'menu_class' => 'text-left main-menu')); ?>
					<div class="lang">
						<?php
						$langs = icl_get_languages('skip_missing=0');
						$j = 0;
						foreach ($langs as $lang):
							?>
							<a href="<?php echo $lang['url']; ?>"<?php if ($lang['active'] == 1): ?> class="lang-active"<?php endif; ?>><?php echo $lang['language_code']; ?></a> <?php if ($j == 0): ?>/<?php endif; ?>
							<?php $j = 1; ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="small-6 columns hide-for-large">
					<div class="hamburger">
						<div class="line line1"></div>
						<div class="line line2"></div>
						<div class="line line3"></div>
					</div>
				</div>
			</div>
		</header>
