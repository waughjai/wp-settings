<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPThemeOption\WPThemeOption;
use WaughJ\WPThemeOption\WPThemeOptionsPage;
use WaughJ\WPThemeOption\WPThemeOptionsSection;

class WPThemeOptionTest extends TestCase
{
	public function testBasic()
	{
		$page = new WPThemeOptionsPage( 'design', 'Design' );
		$section = new WPThemeOptionsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPThemeOption( $section, 'main_css', 'Main CSS' );
		ob_start();
		$option->render();
		$this->assertEquals( '<input type="text" id="main_css" name="theme_design_options[main_css]" placeholder="Main CSS" value="" />', ob_get_clean() );
	}
}
