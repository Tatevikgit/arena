<?php

require THIM_DIR . 'inc/admin/trigger-update-thim-core-1.0.4.php';

function thim_get_core_require() {
	$thim_core = array(
		'name'    => 'Thim Core',
		'slug'    => 'thim-core',
		'version' => '1.0.6',
		'source'  => 'https://foobla.bitbucket.io/thim-core/dist/thim-core.zip',
	);

	return $thim_core;
}

add_action( 'admin_init', 'thim_auto_compile_sass_to_css' );
function thim_auto_compile_sass_to_css() {
	$request = isset( $_GET['thim-auto-compile-sass-to-css'] );
	if ( ! $request ) {
		return;
	}

	delete_site_transient( '_thim_eduma_need_upgrade' );

	thim_auto_updated_theme_mods_30();
}

add_action( 'admin_init', 'thim_redirect_to_theme_dashboard' );
function thim_redirect_to_theme_dashboard() {
	$request = isset( $_GET['thim-redirect-to-theme-dashboard'] );

	if ( ! $request ) {
		return;
	}

	if ( is_callable( array( 'Thim_Core_Admin', 'go_to_theme_dashboard' ) ) ) {
		call_user_func( array( 'Thim_Core_Admin', 'go_to_theme_dashboard' ) );
	}

	wp_redirect( admin_url() );
	exit();
}

add_action( 'admin_notices', 'thim_notify_install_plugins' );

function thim_notify_install_plugins() {
	if ( class_exists( 'Thim_Core' ) ) {
		return;
	}

	?>
    <div class="notice notice-success">
        <h3>Eduma Theme notice!</h3>
        <p>
            Installed the theme successfully. <a
                    href="<?php echo esc_url( admin_url( '?thim-install-plugin-require=1' ) ); ?>">
				<?php _e( 'Enable Thim Core to start now!', 'eduma' ); ?>
            </a>
        </p>
    </div>
	<?php
}

add_action( 'admin_init', 'thim_install_plugin_require' );

function thim_install_plugin_require() {
	$request = isset( $_GET['thim-install-plugin-require'] );

	if ( ! $request ) {
		return;
	}

	require_once THIM_DIR . 'inc/libs/class-thim-plugin.php';

	$plugin_require = thim_get_core_require();

	$plugin = new Thim_Plugin();
	$plugin->set_args( $plugin_require );
	$plugin->install();

	wp_redirect( admin_url( '?thim-active-plugin-require' ) );
	exit();
}

add_action( 'admin_init', 'thim_active_plugin_require' );

function thim_active_plugin_require() {
	$request = isset( $_GET['thim-active-plugin-require'] );

	if ( ! $request ) {
		return;
	}

	require_once THIM_DIR . 'inc/libs/class-thim-plugin.php';

	$plugin_require = thim_get_core_require();

	$plugin = new Thim_Plugin();
	$plugin->set_args( $plugin_require );
	$plugin->activate( false );

	thim_activation_thim_core();
	//wp_redirect( admin_url( '?thim-redirect-to-theme-dashboard' ) );
	exit();
}
