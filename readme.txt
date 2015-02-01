=== Privilege Widget ===
Contributors: fuzzguard
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=G8SPGAVH8RTBU
tags: widget, widgets, privilege, sidebar, sidebars
Requires at least: 3.9
Tested up to: 4.1
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
This plugin allows you to display widgets based on if a user is logged in, logged out, an Admin User or to All Users.

This solves the problem of having to modify theme functions.php files to add in widget restrictions based on users status.  The changes in functions.php is often overwritten by a theme update.  This plugin removes that worry, as you can update the theme, independent of the plugin.

== Installation ==

1. Upload the `plugin` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' area in WordPress
1. Go to Appearance > Widgets
1. Add a widget to a sidebar.
1. Edit the widget accordingly.  First select whether you'd like to display the item to all logged in users, all logged out users, Admin Users or All Users (Default).
1. Save the changes to each individual widget.

== Frequently Asked Questions ==

= I cannot see the options for Privilege Widget under widgets in the Admin Panel? =

You need to add the widget to a sidebar before you can change the display status on the widget.

== Screenshots ==

1. View of the rescriction option added to each widget in the admin panel so you can restrict the display of each widget.

== Changelog ==

= 1.4 =
* Added "lang" folder for localization files
* Added French, German, Spanish and Chinese translations
* Added .pot file for localization by others.  Located in "lang" folder
* Added light top and bottom border around extra coding to emphasize restrictions area

= 1.3 =
* Changed widget hook to utilize in_widget_form to load extra options. Advantage is increased stability of plugin.

= 1.2 =
* Fixed bug where widgets were failing to display in admin panel.
* Fixed for loop bug in saving privilege widget.

= 1.1 =
* Uncommented Wordpress admin class protection coding from testing
* Changed "Display Mode" to "User Restriction"
* Added in bottom border to "User Restriction" area in each widget to make the widget area easier to read

= 1.0 =
* Gold release
