WP Settings
=========================

Classes for simplifying the creation of general settings options, sections, & subpages in WordPress.

## Example

    use WaughJ\WPSettings\WPSettingsOption;
    use WaughJ\WPSettings\WPSettingsSection;
    use WaughJ\WPSettings\WPSettingsSubPage;

    $page = new WPSettingsSubPage( 'settings', 'design', 'Design' );
    $section = new WPSettingsSection( $page, 'main_scripts', 'Main Scripts' );
    $option = new WPSettingsOption( $section, 'main_css', 'Main CSS' );
    $page->submit();

Will generate a “Design” tab in Settings on WordPress admin with “Main Scripts” section & option headered “Main CSS”. The value saved into that input box can then be later retrieved by calling:

    $option->getOptionValue();

## Changelog

### 0.8.1
* Clean up & update code & fix readme errors:
    * Make namespaces cleaner
    * Remove outdated TestHashItem dependency
    * Fix inaccurate example info in readme
    * Add visibility keywords to const members

### 0.8.0
* Add custom render option

### 0.7.0
* Add select & other simple input types

### 0.6.0
* Add Textarea Input Type to Option Class

### 0.5.0
* Add Specific Type Classes

### 0.4.2
* Fix Missing Variables

### 0.4.1
* Fix getAddPageFunction Method

### 0.4.0
* Refactor Into General WPSettings

### 0.3.0
* Add Page Manager

### 0.2.0
* Add Checkbox Input Type

### 0.1.1
* Make It Possible to Get Option Value (WPThemeOption method getOptionValue must be public so it can be used for other things)

### 0.1.0
* Initial Version