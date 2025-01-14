<?php

class WP_Auth0_Admin_Basic extends WP_Auth0_Admin_Generic {

	/**
	 *
	 * @deprecated 3.6.0 - Use $this->_description instead
	 */
	const BASIC_DESCRIPTION = '';

	protected $_description;

	protected $actions_middlewares = array(
		'basic_validation',
	);

	/**
	 * WP_Auth0_Admin_Basic constructor.
	 *
	 * @param WP_Auth0_Options_Generic $options
	 */
	public function __construct( WP_Auth0_Options_Generic $options ) {
		parent::__construct( $options );
		$this->_description = __( 'Basic settings related to the Auth0 integration.', 'wp-auth0' );
	}

	/**
	 * All settings in the Basic tab
	 *
	 * @see \WP_Auth0_Admin::init_admin
	 * @see \WP_Auth0_Admin_Generic::init_option_section
	 */
	public function init() {
		add_action( 'wp_ajax_auth0_delete_cache_transient', array( $this, 'auth0_delete_cache_transient' ) );

		$options = array(
			array(
				'name'     => __( 'Domain', 'wp-auth0' ),
				'opt'      => 'domain',
				'id'       => 'wpa0_domain',
				'function' => 'render_domain',
			),
			array(
				'name'     => __( 'Custom Domain', 'wp-auth0' ),
				'opt'      => 'custom_domain',
				'id'       => 'wpa0_custom_domain',
				'function' => 'render_custom_domain',
			),
			array(
				'name'     => __( 'Client ID', 'wp-auth0' ),
				'opt'      => 'client_id',
				'id'       => 'wpa0_client_id',
				'function' => 'render_client_id',
			),
			array(
				'name'     => __( 'Client Secret', 'wp-auth0' ),
				'opt'      => 'client_secret',
				'id'       => 'wpa0_client_secret',
				'function' => 'render_client_secret',
			),
			array(
				'name'     => __( 'Client Secret Base64 Encoded', 'wp-auth0' ),
				'opt'      => 'client_secret_b64_encoded',
				'id'       => 'wpa0_client_secret_b64_encoded',
				'function' => 'render_client_secret_b64_encoded',
			),
			array(
				'name'     => __( 'JWT Signature Algorithm', 'wp-auth0' ),
				'opt'      => 'client_signing_algorithm',
				'id'       => 'wpa0_client_signing_algorithm',
				'function' => 'render_client_signing_algorithm',
			),
			array(
				'name'     => __( 'Cache Time (in minutes)', 'wp-auth0' ),
				'opt'      => 'cache_expiration',
				'id'       => 'wpa0_cache_expiration',
				'function' => 'render_cache_expiration',
			),
			array(
				'name'     => __( 'API Token', 'wp-auth0' ),
				'opt'      => 'auth0_app_token',
				'id'       => 'wpa0_auth0_app_token',
				'function' => 'render_auth0_app_token',
			),
			array(
				'name'     => __( 'WordPress Login Enabled', 'wp-auth0' ),
				'opt'      => 'wordpress_login_enabled',
				'id'       => 'wpa0_login_enabled',
				'function' => 'render_allow_wordpress_login',
			),
			array(
				'name'     => __( 'Allow Signups', 'wp-auth0' ),
				'id'       => 'wpa0_allow_signup',
				'function' => 'render_allow_signup',
			),
		);
		$this->init_option_section( '', 'basic', $options );
	}

	/**
	 * Render form field and description for the `domain` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_domain( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'], 'text', 'your-tenant.auth0.com' );
		$this->render_field_description(
			__( 'Auth0 Domain, found in your Application settings in the ', 'wp-auth0' ) .
			$this->get_dashboard_link( 'applications' )
		);
	}

	/**
	 * Render form field and description for the `custom_domain` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_custom_domain( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'], 'text', 'login.yourdomain.com' );
		$this->render_field_description(
			__( 'Custom login domain. ', 'wp-auth0' ) .
			$this->get_docs_link( 'custom-domains', __( 'More information here', 'wp-auth0' ) )
		);
	}

	/**
	 * Render form field and description for the `client_id` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_client_id( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'Client ID, found in your Application settings in the ', 'wp-auth0' ) .
			$this->get_dashboard_link( 'applications' )
		);
	}

	/**
	 * Render form field and description for the `client_secret` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_client_secret( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'], 'password' );
		$this->render_field_description(
			__( 'Client Secret, found in your Application settings in the ', 'wp-auth0' ) .
			$this->get_dashboard_link( 'applications' )
		);
	}

	/**
	 * Render form field and description for the `client_secret_b64_encoded` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_client_secret_b64_encoded( $args = array() ) {
		$this->render_switch( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'Enable this if your Client Secret is base64 encoded. ', 'wp-auth0' ) .
			__( 'This information is found below the Client Secret field in the ', 'wp-auth0' ) .
			$this->get_dashboard_link( 'applications' )
		);
	}

	/**
	 * Render form field and description for the `client_signing_algorithm` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_client_signing_algorithm( $args = array() ) {
		$curr_value = $this->options->get( $args['opt_name'] ) ?: WP_Auth0_Api_Client::DEFAULT_CLIENT_ALG;
		$this->render_radio_buttons(
			array( 'HS256', 'RS256' ),
			$args['label_for'],
			$args['opt_name'],
			$curr_value
		);
		$this->render_field_description(
			__( 'This value can be found the Application settings in the ' ) .
			$this->get_dashboard_link( 'applications' ) .
			__( ' under Show Advanced Settings > OAuth > "JsonWebToken Signature Algorithm"', 'wp-auth0' )
		);
	}

	/**
	 * Render form field and description for the `cache_expiration` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_cache_expiration( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'], 'number' );
		printf(
			' <input type="button" id="auth0_delete_cache_transient" value="%s" class="button button-secondary">',
			__( 'Delete Cache', 'wp-auth0' )
		);
		$this->render_field_description( __( 'JWKS cache expiration in minutes (use 0 for no caching)', 'wp-auth0' ) );
		if ( $domain = $this->options->get( 'domain' ) ) {
			$this->render_field_description(
				sprintf(
					'<a href="https://%s/.well-known/jwks.json" target="_blank">%s</a>',
					$domain,
					__( 'View your JWKS here', 'wp-auth0' )
				)
			);
		}
	}

	/**
	 * Render form field and description for the `auth0_app_token` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_auth0_app_token( $args = array() ) {
		$this->render_text_field( $args['label_for'], $args['opt_name'], 'password' );
		$this->render_field_description(
			__( 'This token should include the following scopes: ', 'wp-auth0' ) .
			'<br><br><code>' . implode( '</code> <code>', WP_Auth0_Api_Client::ConsentRequiredScopes() ) .
			'</code><br><br>' . $this->get_docs_link(
				'api/management/v2/tokens#get-a-token-manually',
				__( 'More information on manually generating tokens', 'wp-auth0' )
			)
		);
	}

	/**
	 * Render form field and description for the `wordpress_login_enabled` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @param array $args - callback args passed in from add_settings_field().
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_allow_wordpress_login( $args = array() ) {
		$this->render_switch( $args['label_for'], $args['opt_name'] );
		$this->render_field_description(
			__( 'Turn on to enable a link on wp-login.php pointing to the core login form. ', 'wp-auth0' ) .
			__( 'Logins and signups using the WordPress form will NOT be pushed to Auth0. ', 'wp-auth0' ) .
			__( 'This is typically only used while testing the plugin initially', 'wp-auth0' )
		);
	}

	/**
	 * Render description for the `wpa0_allow_signup` option.
	 * IMPORTANT: Internal callback use only, do not call this function directly!
	 *
	 * @see WP_Auth0_Admin_Generic::init_option_section()
	 * @see add_settings_field()
	 */
	public function render_allow_signup() {
		if ( is_multisite() ) {
			$settings_text = __(
				'"Allow new registrations" in the Network Admin > Settings > Network Settings',
				'wp-auth0'
			);
		} else {
			$settings_text = __( '"Anyone can register" in the WordPress General Settings', 'wp-auth0' );
		}
		$allow_signup = $this->options->is_wp_registration_enabled();
		$this->render_field_description(
			__( 'Signups are currently ', 'wp-auth0' ) . '<b>' .
			( $allow_signup ? __( 'enabled', 'wp-auth0' ) : __( 'disabled', 'wp-auth0' ) ) .
			'</b>' . __( ' by this setting ' ) . $settings_text
		);
	}

	public function auth0_delete_cache_transient() {
		check_ajax_referer( 'auth0_delete_cache_transient' );
		delete_transient( WPA0_JWKS_CACHE_TRANSIENT_NAME );
		exit;
	}

	public function basic_validation( $old_options, $input ) {

		if ( wp_cache_get( 'doing_db_update', WPA0_CACHE_GROUP ) ) {
			return $input;
		}

		$input['client_id']        = sanitize_text_field( $input['client_id'] );
		$input['cache_expiration'] = absint( $input['cache_expiration'] );

		$input['wordpress_login_enabled'] = ( isset( $input['wordpress_login_enabled'] )
			? $input['wordpress_login_enabled']
			: 0 );

		$input['allow_signup'] = ( isset( $input['allow_signup'] ) ? $input['allow_signup'] : 0 );

		// Only replace the secret or token if a new value was set. If not, we will keep the last one entered.
		$input['client_secret'] = ( ! empty( $input['client_secret'] )
			? $input['client_secret']
			: $old_options['client_secret'] );

		$input['client_secret_b64_encoded'] = ( isset( $input['client_secret_b64_encoded'] )
			? $input['client_secret_b64_encoded'] == 1
			: false );

		$input['auth0_app_token'] = ( ! empty( $input['auth0_app_token'] )
			? $input['auth0_app_token']
			: $old_options['auth0_app_token'] );

		// If we have an app token, get and store the audience
		if ( ! empty( $input['auth0_app_token'] ) ) {
			$db_manager = new WP_Auth0_DBManager( WP_Auth0_Options::Instance() );

			if ( get_option( 'wp_auth0_client_grant_failed' ) ) {
				$db_manager->install_db( 16, $input['auth0_app_token'] );
			}

			if ( get_option( 'wp_auth0_grant_types_failed' ) ) {
				$db_manager->install_db( 17, $input['auth0_app_token'] );
			}
		}

		if ( empty( $input['domain'] ) ) {
			$this->add_validation_error( __( 'You need to specify a domain', 'wp-auth0' ) );
		}

		if ( empty( $input['client_id'] ) ) {
			$this->add_validation_error( __( 'You need to specify a client id', 'wp-auth0' ) );
		}

		if ( empty( $input['client_secret'] ) && empty( $old_options['client_secret'] ) ) {
			$this->add_validation_error( __( 'You need to specify a client secret', 'wp-auth0' ) );
		}

		return $input;
	}

	/**
	 *
	 * @deprecated 3.6.0 - Should not be called directly, handled within WP_Auth0_Admin_Basic::render_allow_signup()
	 */
	public function render_allow_signup_regular_multisite() {
		// phpcs:ignore
		trigger_error( sprintf( __( 'Method %s is deprecated.', 'wp-auth0' ), __METHOD__ ), E_USER_DEPRECATED );
	}

	/**
	 *
	 * @deprecated 3.6.0 - Should not be called directly, handled within WP_Auth0_Admin_Basic::render_allow_signup()
	 */
	public function render_allow_signup_regular() {
		// phpcs:ignore
		trigger_error( sprintf( __( 'Method %s is deprecated.', 'wp-auth0' ), __METHOD__ ), E_USER_DEPRECATED );
	}

	/**
	 *
	 * @deprecated 3.6.0 - Handled by WP_Auth0_Admin_Generic::render_description()
	 */
	public function render_basic_description() {
		// phpcs:ignore
		trigger_error( sprintf( __( 'Method %s is deprecated.', 'wp-auth0' ), __METHOD__ ), E_USER_DEPRECATED );
		printf( '<p class="a0-step-text">%s</p>', $this->_description );
	}
}
