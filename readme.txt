=== WPRule: Integrates WordPress with rule.io. ===
Contributors: adamadapt
Tags: newsletter signup, newsletter, rule, rule.io
Requires at least: 3.0.1
Tested up to: 6.5
Stable tag: 1.1.3
License: GPLv2 or later

Integrates WordPress with rule.io.

== Description ==

Integrate Rule.io's advanced email marketing, newsletters, and automation tools with your WordPress website. With WPRule, effortlessly sync subscribers with Rule.io's platform directly from your WordPress dashboard. Automate your marketing efforts by setting up workflows and triggers based on user behavior and demographics. Gain insights into your campaign performance with comprehensive analytics and reporting. WPRule simplifies the process of leveraging Rule.io's powerful marketing tools, making it easy to optimize your marketing strategy.

== Features ==

- Subscribes your user to your rule.io account
- Set tags that are autimatically added to your rule.io subscriber
- Allow subscriber to choose from selected tags when signing up

== Requirements ==

- Requires a <a href="https://rule.io">rule.io</a> subscription. <br>
- Requires WP at least: 3.0.1 <br>
- Requires cURL to be installed on the server <br>

== Todo ==

- localization

== Installation ==

1. Download the plugin Zip file
2. Login to your WordPress site at www.your-wordpress-site.com/wp-login.php
3. Hover over Plugins in the left sidebar
4. Click on Add New
5. Click on Upload and Upload the zip file that you just downloaded
6. Activate the plugin
7. Got to the settings page of WPRule and input your rule.io API-key
8. Place the shortcode [wprule] where you want the form to appear

== Installing cURL ==

Ubuntu

`$ php -v`

`PHP 8.1.2-1ubuntu2.14 (cli) (built: Aug 18 2023 11:41:11) (NTS)` <br>
`Copyright (c) The PHP Group` <br>
`Zend Engine v4.1.2, Copyright (c) Zend Technologies` <br>
`with Zend OPcache v8.1.2-1ubuntu2.14, Copyright (c), by Zend Technologies`

`$ sudo apt-get install php8.1-curl`
