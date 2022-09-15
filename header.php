<?php
/**
 * The header for the theme
 *
 * This is the template that displays all of the <head> section
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage _gc
 * @since 1.0.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="<?php bloginfo( 'desciption' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="format-detection" content="telephone=no" />
		<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
		<link rel="profile" href="https://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<link rel="icon" href="<?php bloginfo( 'template_directory' ); ?>/favicon.png" type="image/x-icon" />
		
		<?php if( wp_get_environment_type() == 'production' ) : ?>
		<meta name="facebook-domain-verification" content="q8fikcmqc9vc0g1q6z8ng7lqfcxnma" />
		<?php endif; ?>
		<script type='text/javascript'>
			piAId = '946903';
			piCId = '';
			piHostname = 'go.genutraining.org.au';
			
			(function() {
			function async_load(){
			var s = document.createElement('script'); s.type = 'text/javascript';
			s.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + piHostname + '/pd.js';
			var c = document.getElementsByTagName('script')[0]; c.parentNode.insertBefore(s, c);
			}
			if(window.attachEvent) { window.attachEvent('onload', async_load); }
			else { window.addEventListener('load', async_load, false); }
			})();
		</script>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<style type='text/css'>
			.embeddedServiceHelpButton .helpButton .uiButton {
				background-color: #001f6f;
				font-family: "Arial", sans-serif;
			}
			.embeddedServiceHelpButton .helpButton .uiButton:focus {
				outline: 1px solid #001f6f;
			}
		</style>

		<script type='text/javascript' src='https://service.force.com/embeddedservice/5.0/esw.min.js'></script>
		<script type='text/javascript'>
			var initESW = function(gslbBaseURL) {
				embedded_svc.settings.displayHelpButton = true; //Or false
				embedded_svc.settings.language = ''; //For example, enter 'en' or 'en-US'

				//embedded_svc.settings.defaultMinimizedText = '...'; //(Defaults to Chat with an Expert)
				//embedded_svc.settings.disabledMinimizedText = '...'; //(Defaults to Agent Offline)

				//embedded_svc.settings.loadingText = ''; //(Defaults to Loading)
				//embedded_svc.settings.storageDomain = 'yourdomain.com'; //(Sets the domain for your deployment so that visitors can navigate subdomains during a chat session)

				// Settings for Chat
				//embedded_svc.settings.directToButtonRouting = function(prechatFormData) {
					// Dynamically changes the button ID based on what the visitor enters in the pre-chat form.
					// Returns a valid button ID.
				//};
				//embedded_svc.settings.prepopulatedPrechatFields = {}; //Sets the auto-population of pre-chat form fields
				//embedded_svc.settings.fallbackRouting = []; //An array of button IDs, user IDs, or userId_buttonId
				//embedded_svc.settings.offlineSupportMinimizedText = '...'; //(Defaults to Contact Us)

				embedded_svc.settings.enabledFeatures = ['LiveAgent'];
				embedded_svc.settings.entryFeature = 'LiveAgent';

				embedded_svc.init(
					'https://genutraining.my.salesforce.com',
					'https://genutraining-webchat.secure.force.com/liveAgentSetupFlow',
					gslbBaseURL,
					'00D5g000004xWFs',
					'Web_Chat_Agent',
					{
						baseLiveAgentContentURL: 'https://c.la1-core1.sfdc-vwfla6.salesforceliveagent.com/content',
						deploymentId: '57296000000001D',
						buttonId: '57396000000001c',
						baseLiveAgentURL: 'https://d.la1-core1.sfdc-vwfla6.salesforceliveagent.com/chat',
						eswLiveAgentDevName: 'EmbeddedServiceLiveAgent_Parent04I96000000000BEAQ_17d02446945',
						isOfflineSupportEnabled: true
					}
				);
			};

			if (!window.embedded_svc) {
				var s = document.createElement('script');
				s.setAttribute('src', 'https://genutraining.my.salesforce.com/embeddedservice/5.0/esw.min.js');
				s.onload = function() {
					initESW(null);
				};
				document.body.appendChild(s);
			} else {
				initESW('https://service.force.com');
			}
		</script>

		<?php wp_body_open(); ?>

		<nav id="mobile-nav" class="position-fixed bg-white p-3 h-100">
			<button class="toggle-nav  d-block d-lg-none  btn btn-white  text-secondary  px-2 py-0 ml-2"
				data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
				<span class="fas fa-times  font-weight-bold"></span>
			</button>
			<div class="d-flex justify-content-start d-block d-md-none mobile-account">
				<?php if ( ! WC()->cart->is_empty() ) : ?>
					<a href="/cart" class="cart btn btn-outline-lighter-grey text-primary px-2 py-2 col-3 col-sm-2"><span class="fa fa-shopping-cart text-secondary mr-1"></span></a>
				<?php endif; ?>

				<a href="https://www.genutrainingonline.org.au/login/index.php" class="account btn btn-outline-lighter-grey text-primary px-2 py-2 ml-3 col-8 col-sm-4">
					Student Login<span class="fa fa-bullseye-pointer text-secondary ml-2"></span>
				</a>
			</div>
			<?php
				wp_nav_menu(
					array(
						'container'  => false,
						'menu'       => 'Mobile Menu',
						'menu_class' => 'main-navigation m-0',
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					)
				);
			?>
		</nav>

		<header id="universal-header" class="bg-white  py-2 py-lg-0">
			<div class="container">
				<div class="row">

					<div class="col-4 col-md-2 d-flex align-items-center">
						<a id="logo" href="<?php echo esc_url( home_url() ); ?>">
							<img src="<?php echo esc_url( get_bloginfo( 'template_directory' ) ); ?>/assets/images/GenU-Training.svg" alt="<?php echo esc_attr( bloginfo( 'name' ) ); ?> Logo">
						</a>
					</div><!-- .col -->

					<div class="col-8 col-md-10 d-flex flex-column justify-content-center">

						<div class="py-2 d-flex align-items-center justify-content-end">

							<?php if ( ! WC()->cart->is_empty() ) : ?>
							<div class="mini-cart woocommerce">
								<a href="/cart" class="mini-cart__icon d-none d-md-block btn btn-outline-lighter-grey text-primary px-2 py-1"><span class="fa fa-shopping-cart text-secondary mr-1"></span></a>
								<div class="mini-cart__card">
									<div class="card h-100 shadow-lg ">
										<div class="card-body d-flex flex-column">
											<?php woocommerce_mini_cart(); ?>
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>

							<a href="https://www.genutrainingonline.org.au/login/index.php" class="d-none d-md-block  btn btn-outline-lighter-grey text-primary  px-2 py-1  ml-3">
								Student Login<span class="fa fa-bullseye-pointer text-secondary ml-2"></span>
							</a>

							<a href="tel:1300582687" class="phone-link btn btn-white text-primary pr-2 pl-4 py-1 ml-3 position-relative">
								<span class="phone-icon text-secondary mr-2 position-absolute">
									<img src="<?php echo esc_url( get_bloginfo( 'template_directory' ) ); ?>/assets/images/icons/phone.svg" />
								</span>
								1300 582 687
							</a>

							<div class="d-none d-md-block pl-3 ml-3 border-left border-lighter-grey social-links">
								<?php if (get_field( 'facebook_link', 'options' )) : ?>
								<a class="btn btn-white btn-sm  font-weight-normal" href="<?php the_field( 'facebook_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
									<span class="fab fa-facebook-f"></span>
								</a>
								<?php endif; ?>
								<?php if (get_field( 'twitter_link', 'options' )) : ?>
								<a class="btn btn-white btn-sm  font-weight-normal" href="<?php the_field( 'twitter_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
									<span class="fab fa-twitter"></span>
								</a>
								<?php endif; ?>
								<?php if (get_field( 'youtube_link', 'options' )) : ?>
								<a class="btn btn-white btn-sm  font-weight-normal" href="<?php the_field( 'youtube_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
									<span class="fab fa-youtube"></span>
								</a>
								<?php endif; ?>
								<?php if (get_field( 'linkedin_link', 'options' )) : ?>
								<a class="btn btn-white btn-sm  font-weight-normal" href="<?php the_field( 'linkedin_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
									<span class="fab fa-linkedin-in"></span>
								</a>
								<?php endif; ?>
								<?php if (get_field( 'instagram_link', 'options' )) : ?>
								<a class="btn btn-white btn-sm  font-weight-normal" href="<?php the_field( 'instagram_link', 'options' ); ?>" target="_blank" rel="noopener noreferrer">
									<span class="fab fa-instagram"></span>
								</a>
								<?php endif; ?>
							</div>

							<button class="toggle-nav  d-block d-lg-none  btn btn-white  text-secondary  px-2 py-0 ml-2"
								data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
								<span class="fas fa-bars  font-weight-bold"></span>
							</button>
						</div>

						<?php
						wp_nav_menu(
							array(
								'container'       => 'nav',
								'container_id'    => 'desktop-nav',
								'container_class' => 'menu-wrapper pb-3  d-none d-lg-flex justify-content-end  border-top border-lighter-grey',
								'menu'            => 'Primary Menu',
								'menu_class'      => 'main-navigation list-unstyled text-nowrap d-flex align-items-center m-0',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							)
						);
						?>

					</div><!-- .col -->
				</div><!-- .row -->

			</div><!-- .container -->
		</header>
