<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPThemeOption\WPThemeOption;
use WaughJ\WPThemeOption\WPThemeOptionsPage;
use WaughJ\WPThemeOption\WPThemeOptionsSection;

class WPThemeOptionsPageTest extends TestCase
{
	public function testBasic()
	{
		$page = new WPThemeOptionsPage( 'design', 'Design' );
		$this->assertEquals( 'theme_design_options', $page->getOptionsGroup() );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertContains( '<div class="wrap">', $html );
		$this->assertContains( '<h1>Design</h1>', $html );
		$this->assertContains( '<form method="post" action="options.php">', $html );
		$this->assertContains( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
	}

	public function testWithOptions()
	{
		$page = new WPThemeOptionsPage( 'design', 'Design' );
		$section = new WPThemeOptionsSection( $page, 'main_scripts', 'Main Scripts' );
		$option = new WPThemeOption( $section, 'main_css', 'Main CSS' );
		ob_start();
		$page->render();
		$html = ob_get_clean();
		$this->assertContains( '<div class="wrap">', $html );
		$this->assertContains( '<h1>Design</h1>', $html );
		$this->assertContains( '<form method="post" action="options.php">', $html );
		$this->assertContains( '<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">', $html );
		$this->assertContains( '<input type="text" id="main_css" name="theme_design_options[main_css]" placeholder="Main CSS" value="" />', $html );
	}
}
