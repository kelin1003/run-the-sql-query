=== Run The SQL Query ===
Tags: database, query, sql, manager, admin, DBA, mysql, phpMyAdmin
Requires at least: 4.4
Tested up to: 4.9.4
Stable tag: 4.9.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Run The SQL Query is a fork of Run SQL Query plugin by Fabricio Carell. It's a simple plugin to quickly execute any type of SQL query into the WordPress's DB and export the results in a CSV format file.

== Description ==

This plugin will allow you to execute any type of SQL query into the WordPress's DB connecting through the driver provided by the MySQLi extension without the need to use another tool like phpMyAdmin.

It also gives you the ability to export the results in a CSV format file.

In order to access this plugin's admin page (Tools -> Run The SQL Query), your account needs to have the `install_plugins` capability, that means a Super Admin in the multi-site installation or an Admin in a single site.

Run The SQL Query is a fork of Run SQL Query plugin by Fabricio Carell. And it provides some extra control over plugin settings and configs.

Feel free to contribute:
https://github.com/kelin1003/run-the-sql-query

Use on you own risk. Under no circumstances will the Author of this plugin assume responsibility or liability for any damages or destructive effects on the database resulting from the queries executed using this tool.

== Installation ==

1. Upload the plugin folder `run-the-sql-query` to the `/wp-content/plugins/` directory or by using the "Add Plugin" function of WordPress.
2. Activate the plugin `Run The Sql Query` through the 'Plugins' menu in WordPress
3. The plugin page can be accessed via the 'Run The SQL Query' link under 'Tools' menu in the administration area of a site (if your role is Admin for site administration role for single-site installs, or Super Admin for network installs).
4. The plugin settings page can be accessed via 'Run The SQL Query Settings' link under 'Settings' menu in administration area of site.

== Added Features ==

1. Capability Settings.
   One problem that I faced while using Run SQL Query plugin is, that the plugin uses plugin_installs capability to add the console page and my wp-config file had DISALLOW_FILE_MODS set to true which was messing up with the plugin_installs capability, so I added a settings page where you can choose the capability.

* More enchancements and settings will be added as required.

== Frequently Asked Questions ==

= Where is the plugin page to run the queries? =

The plugin page can be accessed via the 'Run The SQL Query' link under 'Tools' menu in the administration area of a site (if your role is Admin for site administration role for single-site installs, or Super Admin for network installs).

= Where is the plugin settings page to change the configs =

The plugin settings page can be accessed via the 'Run The SQL Query Settings' link under 'Settings' menu in the administration area of a site (if your role is Admin for site administration role for single-site installs, or Super Admin for network installs).

= Can a query make unrecoverable changes in the database? =
Yes, and this plugin doesn't provide and a way to undo the changes. Under no circumstances will the Author of this plugin assume responsibility or liability for any damages or destructive effects on the database resulting from the queries executed using this tool.

= What driver it uses to connect to the Database? =

Unlike other similar plugins it uses the driver provided by the MySQLi extension included since PHP 5.3.0 which is designed to work with MySQL version 4.1.13 or newer.

== Changelog ==

= 1.0 =
* Initial version
