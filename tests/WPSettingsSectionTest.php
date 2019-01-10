<?php

require_once( 'MockWordPress.php' );

use PHPUnit\Framework\TestCase;
use WaughJ\WPSettings\WPSettingsSubPage;
use WaughJ\WPSettings\WPSettingsSection;

class WPSettingsSectionTest extends TestCase
{
	public function testBasic()
	{
		$page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
		$section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
		$this->assertEquals( 'main_scripts', $section->getSlug() );
		$this->assertEquals( new WPSettingsSubPage( 'settings', 'design', 'Design' ), $section->getPage() );
	}
}
