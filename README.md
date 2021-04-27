WP Settings
=========================

Classes for simplifying the creation of general settings options, sections, & subpages in WordPress.

## Example

    use WaughJ\WPSettings\WPSettingsOption;
    use WaughJ\WPSettings\WPSettingsSection;
    use WaughJ\WPSettings\WPSettingsPage;

    $page = new WPSettingsPage( 'settings', 'design', 'Design' );
    $page->addSection( 'main_scripts', 'Main Scripts' );
    $page->getSection( 'main_scripts' )->addOption( 'main_css', 'Main CSS' );
    $page->register();

Will generate a “Design” tab in Settings on WordPress admin with “Main Scripts” section & option headered “Main CSS”. The value saved into that input box can then be later retrieved by calling:

    $page->getSection( 'main_scripts' )->getOption( 'main_css' )->getValue();

## Changelog

### 1.0.0
* Revamp & clean up code
* Upgrade to PHP 7.4

### 0.10.0
* Add autoincrement option to WPSettingsOption

### 0.9.0
* Add ability to create page for main top admin bar

### 0.8.2
* Improve textarea rendering in option page:
    * Make textarea taller and wider

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