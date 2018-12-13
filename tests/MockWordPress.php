<?php

	global $settings_fields;
	$settings_fields = [];

	function __( $name )
	{
		return $name;
	}

	function add_action( $hook, $function )
	{
		$function();
	}

	function get_option( $option )
	{
		return false;
	}

	function add_settings_field( $slug, $name, $renderer, $group )
	{
		global $settings_fields;
		if ( !isset( $settings_fields[ $group ] ) )
		{
			$settings_fields[ $group ] = [];
		}
		$settings_fields[ $group ][] = $renderer;
	};

	function do_settings_sections( $group )
	{
		global $settings_fields;
		if ( isset( $settings_fields[ $group ] ) )
		{
			foreach ( $settings_fields[ $group ] as $renderer )
			{
				echo $renderer();
			}
		}
	};

	function add_theme_page() {};
	function add_option() {};
	function register_setting() {};
	function add_settings_section() {};
	function settings_errors() {};
	function settings_fields() {};
	function submit_button() { echo '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">'; };
