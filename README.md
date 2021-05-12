# HTML Template for CF7 #
**Contributors:** mariovalney  
**Donate link:** https://mariovalney.com  
**Tags:** emails, cf7, contact form, contact form 7, email template, html email  
**Requires at least:** 4.5  
**Tested up to:** 5.7  
**Stable tag:** 2.1.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Improve your Contact Form 7 emails with a HTML Template.

## Description ##

[Contact Form 7 (CF7)](https://wordpress.org/plugins/contact-form-7/ "Install it first, of course") is a awesome plugin used by 1+ million WordPress websites.

But even it allow users to use HTML instead of just Plain Text email it's not trivial to users who aren't developers create something really pro.

However, time to leave all your worries behind! As a recently launched "Contact Form 7 - HTML Mail Template Extension" will allow you, WordPress developers or not, to use a simply but beautiful HTML Template in your CF7 so users will get better emails than just amount of text.

### Configurations ###

Easily and quickly! No configurations required to start, but you can change a lot of stuff like colors, header image and width (by now... new versions will come).

### Email Template ###

The plugin applies a HTML template to email sent from your CF7. The Template is optimized to show your HTML emails perfectly in the most popular email browsers including mobile ones.

## Installation ##

`Install [Contact Form 7](https://wordpress.org/plugins/contact-form-7/)`

1. Upload `contact-form-7-html-mail-template-extension.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Done!

## Frequently Asked Questions ##

### Does it works for emails sent out of CF7? ###

No. The intention here is to improve CF7 functionality.
We'll create another version to all WordPress emails or add an option to extend this plugin, but not in this version.

### I don't like the new editor. How to disable it? ###

You can add the following code to your `functions.php` file:

`add_filter( 'cf7hete-disable-ace-editor', '__return_true' );`

## Screenshots ##

### 1. HTML Template configurations ###
![1. HTML Template configurations](http://ps.w.org/html-template-for-cf7/assets/screenshot-1.png)

### 2. Example HTML Email with CF7 default Form ###
![2. Example HTML Email with CF7 default Form](http://ps.w.org/html-template-for-cf7/assets/screenshot-2.png)


## Changelog ##

### 2.1.0 ###

* Added a filter for developers: "cf7hete_default_template" allow you to override the default template content.
* Replaced "cf7hete-disable-ace-editor" filter by "cf7hete_disable_ace_editor". We kept the Backward compatibility.

### 2.0.3 ###

* Fix saving header and foot with new editor.

### 2.0.0 ###

* Improved Code Editor.
* Refact all the plugin boilerplate (only for developers).

### 1.0.2 ###

* Plugin Renamed.

### 1.0 ###

* It's alive!
* Basic use and configurations.
* Send HTML Emails like in screenshot 2.
* User can choose it Form will use HTML Template.
* HTML Template can be edited or customized.
