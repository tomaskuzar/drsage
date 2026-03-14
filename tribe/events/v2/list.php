<?php
/**
 * Theme override for The Events Calendar list view.
 *
 * @var array    $events
 * @var string   $rest_url
 * @var string   $rest_method
 * @var int      $should_manage_url
 * @var bool     $disable_event_search
 * @var string[] $container_classes
 * @var array    $container_data
 * @var string   $breakpoint_pointer
 * @var string   $prev_url
 * @var string   $next_url
 * @var string   $today_url
 */

$events_count      = is_array( $events ) ? count( $events ) : 0;
$header_title      = function_exists( 'tribe_get_events_title' ) ? tribe_get_events_title() : __( 'Podujatia', 'sage' );
$archive_permalink = function_exists( 'tribe_get_events_link' ) ? tribe_get_events_link() : home_url( '/podujatia/' );
?>
<div
	<?php tec_classes( $container_classes ); ?>
	data-js="tribe-events-view"
	data-view-rest-url="<?php echo esc_url( $rest_url ); ?>"
	data-view-rest-method="<?php echo esc_attr( $rest_method ); ?>"
	data-view-manage-url="<?php echo esc_attr( $should_manage_url ); ?>"
	<?php foreach ( $container_data as $key => $value ) : ?>
		data-view-<?php echo esc_attr( $key ); ?>="<?php echo esc_attr( $value ); ?>"
	<?php endforeach; ?>
	<?php if ( ! empty( $breakpoint_pointer ) ) : ?>
		data-view-breakpoint-pointer="<?php echo esc_attr( $breakpoint_pointer ); ?>"
	<?php endif; ?>
>
	<div class="page-shell page-shell--wide page-shell--events">
		<section class="events-archive">
			<div class="events-archive__blob events-archive__blob--left" aria-hidden="true"></div>
			<div class="events-archive__blob events-archive__blob--right" aria-hidden="true"></div>

			<?php $this->template( 'components/loader', [ 'text' => __( 'Loading...', 'the-events-calendar' ) ] ); ?>
			<?php $this->template( 'components/json-ld-data' ); ?>
			<?php $this->template( 'components/data' ); ?>
			<?php $this->template( 'components/before' ); ?>

			<header class="events-archive__hero">
				<div class="events-archive__hero-copy">
					<p class="page-header__eyebrow"><?php esc_html_e( 'Kalendár podujatí', 'sage' ); ?></p>
					<h1 class="page-header__title"><?php echo esc_html( $header_title ); ?></h1>
					<p class="page-header__excerpt">
						<?php esc_html_e( 'Prehľad všetkých naplánovaných podujatí. Môžeš filtrovať, vyhľadávať a otvoriť detail každého termínu.', 'sage' ); ?>
					</p>

					<div class="events-archive__chips" aria-label="<?php esc_attr_e( 'Typy obsahu v kalendári', 'sage' ); ?>">
						<span><?php esc_html_e( 'Rodinné stretnutia', 'sage' ); ?></span>
						<span><?php esc_html_e( 'Program pre deti', 'sage' ); ?></span>
						<span><?php esc_html_e( 'Prehľad termínov', 'sage' ); ?></span>
					</div>
				</div>

				<aside class="events-archive__hero-card">
					<p class="events-archive__hero-label"><?php esc_html_e( 'Kalendár', 'sage' ); ?></p>
					<strong class="events-archive__hero-number"><?php echo esc_html( (string) $events_count ); ?></strong>
					<p class="events-archive__hero-text">
						<?php echo esc_html( 1 === $events_count ? __( 'podujatie na tejto stránke', 'sage' ) : __( 'podujatia na tejto stránke', 'sage' ) ); ?>
					</p>
					<a class="events-archive__hero-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php esc_html_e( 'Späť na hlavnú stránku', 'sage' ); ?>
					</a>
				</aside>
			</header>

			<div class="events-archive__controls">
				<?php $this->template( 'components/messages' ); ?>
				<?php $this->template( 'components/filter-bar' ); ?>
				<?php $this->template( 'components/events-bar' ); ?>
				<?php $this->template( 'list/top-bar' ); ?>
			</div>

			<?php if ( ! empty( $events ) ) : ?>
				<div class="events-archive__grid" aria-label="<?php esc_attr_e( 'Zoznam podujatí', 'sage' ); ?>">
					<?php foreach ( $events as $event ) : ?>
						<?php $this->setup_postdata( $event ); ?>
						<article <?php post_class( 'event-card', $event->ID ); ?>>
							<a class="event-card__link" href="<?php echo esc_url( get_permalink( $event ) ); ?>">
								<div class="event-card__date">
									<span class="event-card__month">
										<?php echo esc_html( tribe_get_start_date( $event, false, 'M' ) ); ?>
									</span>
									<strong class="event-card__day">
										<?php echo esc_html( tribe_get_start_date( $event, false, 'd' ) ); ?>
									</strong>
								</div>

								<div class="event-card__body">
									<h2 class="event-card__title"><?php echo esc_html( get_the_title( $event ) ); ?></h2>

									<div class="event-card__meta">
										<p>
											<strong><?php esc_html_e( 'Kedy:', 'sage' ); ?></strong>
											<?php echo esc_html( tribe_get_start_date( $event, false, 'j. n. Y H:i' ) ); ?>
										</p>

										<?php if ( tribe_get_venue( $event ) ) : ?>
											<p>
												<strong><?php esc_html_e( 'Kde:', 'sage' ); ?></strong>
												<?php echo esc_html( tribe_get_venue( $event ) ); ?>
											</p>
										<?php endif; ?>

										<?php if ( tribe_get_cost( $event, true ) ) : ?>
											<p>
												<strong><?php esc_html_e( 'Vstup:', 'sage' ); ?></strong>
												<?php echo wp_kses_post( tribe_get_cost( $event, true ) ); ?>
											</p>
										<?php endif; ?>
									</div>

									<div class="event-card__excerpt">
										<?php echo esc_html( wp_trim_words( wp_strip_all_tags( tribe_events_get_the_excerpt( $event ) ), 22 ) ); ?>
									</div>

									<span class="event-card__cta"><?php esc_html_e( 'Pozrieť detail', 'sage' ); ?></span>
								</div>
							</a>
						</article>
					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>
				</div>

				<nav class="events-archive__pagination" aria-label="<?php esc_attr_e( 'Navigácia medzi podujatiami', 'sage' ); ?>">
					<div class="nav-links">
						<?php if ( ! empty( $prev_url ) ) : ?>
							<a class="page-numbers" href="<?php echo esc_url( $prev_url ); ?>"><?php esc_html_e( 'Predchádzajúce', 'sage' ); ?></a>
						<?php endif; ?>

						<?php if ( ! empty( $today_url ) && untrailingslashit( $today_url ) !== untrailingslashit( $archive_permalink ) ) : ?>
							<a class="page-numbers" href="<?php echo esc_url( $today_url ); ?>"><?php esc_html_e( 'Dnes', 'sage' ); ?></a>
						<?php endif; ?>

						<?php if ( ! empty( $next_url ) ) : ?>
							<a class="page-numbers" href="<?php echo esc_url( $next_url ); ?>"><?php esc_html_e( 'Ďalšie', 'sage' ); ?></a>
						<?php endif; ?>
					</div>
				</nav>
			<?php else : ?>
				<div class="events-archive__empty">
					<h2><?php esc_html_e( 'Momentálne nie sú naplánované žiadne podujatia.', 'sage' ); ?></h2>
					<p><?php esc_html_e( 'Keď pridáš eventy v The Events Calendar, zobrazia sa tu automaticky.', 'sage' ); ?></p>
				</div>
			<?php endif; ?>

			<?php $this->template( 'components/ical-link' ); ?>
			<?php $this->template( 'components/after' ); ?>
		</section>
	</div>
</div>

<?php $this->template( 'components/breakpoints' ); ?>
