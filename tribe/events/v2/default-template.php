<?php
/**
 * Theme override for The Events Calendar default wrapper.
 */

use Illuminate\Support\Facades\Vite;
use Tribe\Events\Views\V2\Template_Bootstrap;

?><!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php do_action( 'get_header' ); ?>
    <?php wp_head(); ?>
    <?php echo Vite::withEntryPoints( [ 'resources/css/app.css', 'resources/js/app.js' ] )->toHtml(); ?>
  </head>

  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="app">
      <a class="sr-only focus:not-sr-only" href="#main">
        <?php echo esc_html__( 'Skip to content', 'sage' ); ?>
      </a>

      <?php echo view( 'sections.header' )->render(); ?>

      <main id="main" class="main">
        <?php echo tribe( Template_Bootstrap::class )->get_view_html(); ?>
      </main>

      <?php echo view( 'sections.footer' )->render(); ?>
    </div>

    <?php do_action( 'get_footer' ); ?>
    <?php wp_footer(); ?>
  </body>
</html>
