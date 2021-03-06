=== Plugin Name ===
Contributors: wordlift, ziodave
Donate link: http://www.linkedin.com/company/insideout10/wordlift-327348/product
Tags: semantic, stanbol, seo, iks, semantic web, schema.org, microdata, authorship, google, google authorship, google plus, google plus author, google plus integration, google plus search, in-depth, indepth
Requires at least: {wpversion}
Tested up to: 4.3.0
Stable tag: {version}
License: GPLv2 or later

Supercharge your WordPress Site with Smart Tagging and #Schemaorg support - a new way to write, and publish your contents to the Linked Data Cloud.

== Description ==

**WordLift** is a WordPress Plug-in developed by [InSideOut10](http://www.insideout.io) to help you organise your post and pages using "concepts" like you do in the real world. 

**In-Depth features**

The web is changing fast and search engines update the algorithms to find quality content. For editor it means to mark up their pages in the right way.

WordLift comes to the rescue with new **In-Depth features** that automatically add the correct semantic tagging for you, just download, install and activate WordLift.

Features:

 * Article
   * author
   * name
   * text
   * interactionCount
   * datePublished (Twenty Thirteen)

 * Organization (Avamsys)
   * logo
   * url

Since these tags are highly coupled with your WordPress theme, we list here the themes we tested so far:

 * Twenty Thirteen
 * Twenty Twelve
 * [DW Focus](http://www.designwall.com/wordpress/themes/dw-focus/) 1.0.3
 * [Avamsys](http://themeforest.net/item/avamys-retina-ready-business-wordpress-theme/4122827?ref=cyberandy)

Please let us know if your theme is working or not, and we'll try to add support for it.

**WordLift Bar**

We now feature the **WordLift Bar** with the list of entities and links to the entity page right within your blog. WordLift Bar is *experimental*, if you encounter any issue you can disable it from the plugin options and report us any trouble or suggestion.

You can view some examples of the WordLift Bar:

 * English: [demo 1](http://bit.ly/wlbar-english)
 * Russian: [demo 2](http://bit.ly/wlbar-russian)

**Warning:** WordLift is still under heavy testing, therefore some features might not work as expected or not work at all. Should you encounter any issue while installing, activating, configuring and using the plug-in, we would love to receive your feedback to support [AT] wordlift.it

"Concepts" are just like tags but let you add structure to your information providing you and your visitors many ways to filter and visualize your content. 

We developed WordLift with love because we believe that your website deserves a special place in the Semantic Web.

WordLift reads your pages or blog posts, understands it, *enriches it* by querying the semantic web and tags them using a markup vocabulary that all major search providers (Google, Bing, Yahoo! and Yandex) recognise. 

Through a simple Plug-in all your contents will be instantly compliant with [schema.org](http://www.schema.org) specifications; moreover WordLift will add to your blog an interface to ask *meaning-driven questions* about your contents (hence connecting your website to the Linked Data Cloud).

 * Organize your contents using "Concepts" (or Entities)
 * Treemap, Geomap and Entity List available as add-on Widgets
 * Multi-language support (see below)  
 * Attract more search traffic
 * Compatible with WordPress 3.3.0 and above
 * Eye-catching supplementary SERP data
 * Instantly review and markup old post
 * Use the [schema.org](http://www.schema.org) vocabulary
 * Add HTML Microdata
 * Enable a SPARQL end-point for your site

WordLift currently supports the following languages: English, 中文 (Chinese), Español (Spanish), Русский (Russian), Português (Portuguese), Deutsch (German), Italiano (Italian), Nederlands (Dutch), Svenska (Swedish) and Dansk (Danish). 

The Plug-in is powered by [RedLink](http://redlink.co): Europe's *open source* largest platform for semantic enrichment and search. 

== Installation ==

1. Upload `wordlift.zip` to the `/wp-content/plugins/` directory
2. Extract the files in the wordlift subfolder
3. Activate the plug-in

== Frequently Asked Questions ==

= How do I get my API-Key? =

To grab an existing API-Key or to generate a new one, follow these steps:
1. go to the **Register/Login** section in the WordLift menu on the Dashboard
2. register using your Facebook, LinkedIn or Twitter account or choose login, password and e-mail by clicking *"Click here to register"*
3. enter the **Consumer Key** and hit the **Save** button. API-Key provide full access to your WordLift account, so always keep them secure.

= Can I use WordLift on other blogging platforms other then WordPress? =

WordLift is powered by RedLink a semantic enrichment platform that is currently available for Drupal, Typo3, Alfresco and OpenCMS. Get in contact with us for more information, we'll be happy to help.

= Which version of WordPress do you support? =

We currently support WordPress 3.3.0 or higher.

= What is an "entity"? =

An entity is something that exists in the real-world: celebrities, cities, sports teams, buildings, geographical features, movies, celestial objects and works of art are all entities. WordLift by reading your posts and pages understands the real-world entities associated with your contents as well as their relationships —in geek-speak— it builds a “graph” of your website.

= What do I do if I have questions? =

We're glad to support you and you can send us an e-mail to
 <wordpress@insideout.io>

== Screenshots ==

1. To add the schema.org mark-up simply add the [wordlift.entites] shortcode, WordLift will take care of the rest.
2. User Registration
3. WordLift Widget in Edit Post
4. In order to add the Geo-map Widget use the shortcode <em>[wordlift.geomap]</em>
5. In order to add the Treemap Widget use the shortcode <em>[wordlift.treemap]</em>
6. The WordLift Bar.

== Changelog ==

= 2.6.19 =
 * Fix: [issue 13](https://github.com/insideout10/wordlift-plugin/issues/13): authorship tagging is now shown only on single pages and posts (thanks to Kevin Polley)

= 2.6.18 =
 * Enhancement: Twitter authentication is now back.

= 2.6.17 =
 * Fix: change regular expression to add image itemprops for In-Depth articles to avoid conflicts with linked images and plugins such Nav Menu Images (thanks to Lee Hodson).

= 2.6.16 =
 * Fix: removed useless references to jQuery UI libraries and conflicting CSS (thanks to Lee Hodson).

= 2.6.15 =
 * Fix: PHP warning in RecordSetService (thanks to Kevin Polley),
 * Fix: image alt attributes were incorrectly highlighted with entities (thanks to Lee Hodson).

= 2.6.14 =
 * Fix: post thumbnail html output even if there's no thumbnail.
 * Fix: adding schema.org title using the_title filter could cause issues with theme that use this function for the img tag alt attribute value.
 * Enhancement: add support for DW Focus theme.

= 2.6.13 =
 * Fix: overlap with Facebook admin menu.

= 2.6.12 =
 * Fix: enable authorship information only for regular posts (post type 'post').

= 2.6.11 =
 * Fix: the entity page might appear in the primary menu with some themes (e.g. Twenty Thirteen).
 * Fix: the entity page called without an entity parameter would return a warning.
 * Fix: a warning might appear in the entity page.

= 2.6.10 =
 * Fix: temporary disabled twitter authentication due to API changes.

= 2.6.9 =
 * Improvement: add better support for is_single call.

= 2.6.8 =
 * Other: fix repository versioning.

= 2.6.7 =
 * Fix: html tagging in the title did cause issues when the post title is being used as an html attribute.

= 2.6.6 =
 * Other: add new keywords.

= 2.6.5 =
 * Other: add compatibility up to WordPress 3.6.

= 2.6.4 =
 * Fix: fix a bug that would cause the interaction count to show up in the page title.
 * Fix: ensure adding schema.org mark-up happens only in single post views.

= 2.6.2 =
 * Fix: fix a bug that would cause rewrite rules to be incomplete (WordPress Framework).

= 2.6.1 =
 * Feature: add option to disable *In-Depth* features.

= 2.6.0 =
 * Feature: add new *In-Depth* features.

= 2.5.33 =
 * "Registration failed: undefined (undefined)": Fixed a configuration setting that didn't allow some blogs to register to WordLift Services. (Many thanks to http://www.pruk2digital.com/ for helping us out finding this error).

= 2.5.32 =
 * Added initial compatibility with WordPress 3.6 beta 1,
 * Fix an issue that displayed entities alway for the most recent post.

= 2.5.31 =
 * Fixed a 'notice' in the WordLift Bar,
 * Changed the WordLift Bar to show entities from the most recent post in the
   home page,
 * Added HTML encoding of entity data on the WordLift Bar.

= 2.5.30 =
 * WordLift Bar stays hidden for screen width <= 320px.

= 2.5.29 =
 * WordLift Bar hides/shows automatically when the page is scrolled down.

= 2.5.28 =
 * readme updated with links to WordLift Bar samples.

= 2.5.27 =
 * Now featuring the experimental WordLift Bar.

= 2.5.26 =
 * Cloud Services address changed to use standard ports to ease WordPress installations behind firewalls or proxies.

= 2.5.7 =
 * Major release with fixes on the user registration.

= 1.6 =
 * Fixed an issue that would prevent the plug-in from working. This upgrade is strongly recommended.

= 1.5 =
 * Fixed an issue that would block the plug-in when discovering corrupted type formats.
   (NOTE: this version does not work, please upgrade to 1.6)

= 1.4 =
 * Fixed some compatibility issues with Internet Explorer.

= 1.3 =
 * Added support for WordPress 3.0.x

= 1.2 =
 * The entity elements are now hidden by default.

= 1.1 =
* Removed the requirement for a logs folder

= 1.0 =
* First public release

== Upgrade Notice ==

= 1.0 =
* First public release

== More Information ==

Find more information about "WordLift: HTML Microdata for WordPress using the Interactive Knowledge Stack (IKS)" see below:
 * [WordLift presentation](http://www.slideshare.net/cyberandy/wordlift-microdata-for-wordpress-using-the-interactive-knowledge-stack-iks) on SlideShare,
 * [WordLift screencast](http://vimeo.com/26049653).
 * [Blog Post on the Semantic Web Workshop where WordLift was first announced](http://blog.iks-project.eu/what-do-you-love-about-iks-an-early-adopters-account/) on the IKS Blog.
