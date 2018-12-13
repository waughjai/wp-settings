<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPThemeOption\WPThemeOptionsPage;
use WaughJ\WPThemeOption\WPThemeOptionsSection;

class WPThemeOptionsSectionTest extends TestCase
{
	public function testBasic()
	{
		$page = new WPThemeOptionsPage( 'design', 'Design' );
		$section = new WPThemeOptionsSection( $page, 'main_scripts', 'Main Scripts' );
		$this->assertEquals( 'main_scripts', $section->getSlug() );
		$this->assertEquals( new WPThemeOptionsPage( 'design', 'Design' ), $section->getPage() );
	}
}
