=== WordPress PayPal ===
Contributors: naa986
Donate link: https://wphowto.net/
Tags: paypal, cart, checkout, donation, e-commerce
Requires at least: 5.3
Tested up to: 5.9
Stable tag: 1.2.3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily accept payment in WordPress by adding a PayPal button to your website. Add PayPal Buy Now, Add to Cart, Subscription or Donation button.

== Description ==

[WordPress PayPal](https://wphowto.net/wordpress-paypal-plugin-732) plugin allows you to easily create PayPal Buy Now, Add to Cart, Donation or Subscription type buttons. It generates dynamic buttons using shortcodes that enable PayPal checkout on your WordPress site.

https://www.youtube.com/watch?v=lYVRUDp8c9s&rel=0

Your customers will be able to pay for your products using PayPal or Credit Card. This plugin makes it easy for you to set up your online e-commerce store. You do not need to spend days configuring products and settings. All you need to do is insert a shortcode into one of your web pages and your website will be ready to go live.

WP PayPal supports PayPal Sandbox. PayPal Sandbox is a simulation environment which allows you to do test purchases between a test buyer and a seller account. This is to make sure that your store can process PayPal transactions without any issues. It also helps you get prepared before selling to real customers.

=== WP PayPal Features ===

* Sell products or services using PayPal
* Create PayPal buttons on the fly in a post/page using shortcodes
* Accept once off payments or recurring payments
* Accept donations from users
* Allow users to add multiple items to the shopping cart and checkout
* View or Manage orders received via PayPal buttons from your WordPress admin dashboard
* Quick settings configurations
* Enable debug to troubleshoot various issues (e.g. orders not getting updated)
* Accept subscriptions on a daily, weekly, monthly or yearly basis
* Sell items with different variation options (e.g. size, color, price)
* Switch your store to PayPal sandbox mode for testing
* Compatible with the latest version of WordPress
* Compatible with any WordPress theme
* Sell in any currency supported by PayPal
* Accept recurring payments/subscriptions
* Charge shipping on your products or services
* Charge tax on your products or services

=== WP PayPal Extensions ===

* [Buy Now Custom Amount](https://wphowto.net/wordpress-paypal-plugin-732)
* [Buy Now Discount](https://wphowto.net/applying-discount-to-a-paypal-buy-button-in-wordpress-834)
* [Product Variations](https://wphowto.net/how-to-configure-product-variations-in-wp-paypal-6413)
* [Variable Quantity](https://wphowto.net/how-to-add-a-quantity-field-to-a-paypal-button-6428)
* [Variable Subscription](https://wphowto.net/how-to-add-a-recurring-price-field-to-a-paypal-subscription-button-6450)

=== How to Use WP PayPal ===

Once you have installed this plugin you need to go to the settings menu to configure some default options (WP PayPal -> Settings).

* **PayPal Merchant ID**: Your PayPal Merchant ID
* **PayPal Email**: Your PayPal email address
* **Currency Code**: The default currency code

In order to create a button insert the shortcode like the following:

= PayPal Buy Now =

Buy Now buttons are for single item purchases. In order to create a buy button you need to specify it in the button parameter of the shortcode.

`[wp_paypal button="buynow" name="My product" amount="1.00"]`

= PayPal Add to Cart =

Add To Cart buttons let users add multiple items to their PayPal shopping cart and checkout.

`[wp_paypal button="cart" name="My product" amount="1.00"]`

= PayPal View Cart =

View Cart buttons let users view items that were added to their PayPal shopping cart.

`[wp_paypal button="viewcart"]`

= PayPal Donation =

Donation buttons let you accept donations from your users.

`[wp_paypal button="donate" name="My product"]`

= PayPal Subscription =

`[wp_paypal button="subscribe" name="My product" a3="1.00" p3="1" t3="M" src="1"]`

Subscribe buttons let you set up payment subscriptions.

=== PayPal Button Parameters ===

You can use additional parameters to customize your PayPal buttons.

* **type** - The type of button to render (e.g. "buynow", "cart", "donate" or "subscribe")
* **name** - Description of the item.
* **button_image** - Your custom button image URL (e.g. button_image="https://example.com/images/buy.png").
* **number** - The number of the item (Also known as SKU. e.g. number="16").
* **amount**- The price of the item (e.g. amount="4.95").
* **currency** - The currency of the item (e.g. currency="USD").
* **quantity** - Quantity of items to purchase (e.g. quantity="2").
* **shipping** - The cost of shipping this item. (e.g. shipping="0.75"). If you specify "shipping" and "shipping2" is not defined, this flat amount is charged regardless of the quantity of items purchased. 
* **shipping2** - The cost of shipping each additional unit of this item (e.g. shipping2="1.25")
* **tax** - Transaction-based tax override variable (e.g. tax="2.99").
* **locale** - The desired locale of the PayPal site (e.g. locale="GB"). This feature is useful if you want to render the payment page in a specific language.
* **return** - The URL to which the user will be redirected after the payment (e.g. return="https://example.com/thank-you").
* **cancel_return** - The URL to which PayPal will redirect the buyer if they cancel checkout before completing the payment (e.g. cancel_return="https://example.com/payment-canceled").
* **no_shipping** - This parameter allows you to control whether or not to prompt buyers for a shipping address (e.g. no_shipping="1"). Allowable values: 0 - Prompt for an address, but do not require one (This is set by default), 1 - Do not prompt for an address, 2 - Prompt for an address, and require one.
* **undefined_quantity** - Allow buyers to specify the quantity of the item on the payment page (e.g. undefined_quantity="1"). This option is only used with a Buy Now button.
* **target** - This parameter allows you to open a PayPal button in a new window or tab (e.g. target="_blank").
* **shopping_url** - This parameter allows you to customize the Continue Shopping URL for the View Cart button (e.g. shopping_url="https://example.com/shop").

= PayPal Add to Cart Button/Shopping Cart Specific Parameters =

* **handling** - Handling charges. This parameter is not quantity-specific, which means the same handling cost applies, regardless of the number of items on the order. (e.g. handling="2.00").

For detailed documentation please check out the [WordPress PayPal Plugin](https://wphowto.net/wordpress-paypal-plugin-732) page.

=== Translation ===

If you are a non-English speaker please help [translate WP PayPal](https://translate.wordpress.org/projects/wp-plugins/wp-paypal) into your language.

=== Additional PayPal Documentation ===

* [Add automatic discount to a buy button](https://wphowto.net/applying-discount-to-a-paypal-buy-button-in-wordpress-834)
* [Subscriptions & Recurring Payments Setup](https://wphowto.net/how-to-create-a-paypal-subscription-button-in-wordpress-911)

== Installation ==

1. Go to the Add New plugins screen in your WordPress Dashboard
1. Click the upload tab
1. Browse for the plugin file (wp-paypal.zip) on your computer
1. Click "Install Now" and then hit the activate button

== Frequently Asked Questions ==

= Can I accept PayPal payments in WordPress using this plugin? =

Yes.

= How much does it cost to use PayPal?

If you are a merchant or business that uses PayPal to accept payments from your customers, PayPal takes 2.9 percent of the payment plus 30 cents per transaction before putting the money in your account.

= Does PayPal have a monthly fee? =

No.

== Screenshots ==

1. PayPal Button Demo
2. PayPal Orders

== Upgrade Notice ==
none

== Changelog ==

= 1.2.3.3 =
* Added support for variable subscription price.

= 1.2.3.2 =
* Added support for variable quantity.

= 1.2.3.1 =
* Added support for product variations extension.

= 1.2.3.0 =
* Added support for trial period 2 in the PayPal subscription button.

= 1.2.2.9 =
* Added the shopping_url parameter for the View Cart button.

= 1.2.2.8 =
* Removed unused JS from the plugin.

= 1.2.2.7 =
* Added the notify_url parameter to send instant payment notification to a different URL.

= 1.2.2.6 =
* Made the shopping_url parameter available for add to cart type buttons.

= 1.2.2.5 =
* Made some security related improvements in the plugin

= 1.2.2.4 =
* The plugin now shows more error messages if it fails to insert/update an order.

= 1.2.2.3 =
* Merchant ID can now be entered in the plugin settings.

= 1.2.2.2 =
* Added a view cart button for the PayPal shopping cart.

= 1.2.2.1 =
* Charset is now set to utf-8 for all the buttons.

= 1.2.2 =
* Fixed an issue where the add to cart button would open a new tab.

= 1.2.1 =
* Shipping address is now displayed on a separate row in the order content area.

= 1.2.0 =
* Updated the parameters in the subscribe button. This should fix the button image rendering issue on some websites.

= 1.1.9 =
* Donate buttons now support the no_shipping parameter.

= 1.1.8 =
* Made some improvements to the donate button.

= 1.1.7 =
* Made some improvements to the orders menu.

= 1.1.6 =
* Added support for custom field in the shortcode.

= 1.1.5 =
* An action is now triggered after processing the PayPal ipn.

= 1.1.4 =
* Fixed a warning notice in the orders menu.

= 1.1.3 =
* Fixed a bug where the target attribute was not working.

= 1.1.2 =
* Made some improvements to WP PayPal orders.

= 1.1.1 =
* Made some improvements to the PayPal Buy Now button.

= 1.1.0 =
* Fixed this admin notice: screen_icon is deprecated since version 3.8.0 with no alternative available.
* Made some improvements to the add to cart functionality.
* Fixed a PayPal error that occurred when an item was added to the shopping cart: Things don't appear to be working at the moment. Please try again later.


= 1.0.9 =
* Added an option to open a PayPal button in a new window or tab.

= 1.0.8 =
* Fixed a bug where queries could be performed on orders on the front end.
* WP PayPal orders are now also excluded from search.

= 1.0.7 =
* Added a new action hook which will get triggered once the payment is processed by the plugin.
* Added a new shortcode parameter to customize the default PayPal button.

= 1.0.6 =
* Fixed an issue that was causing subscription payments to not get processed.

= 1.0.5 =
* Fixed an issue that was causing this error - "Cannot load wp-paypal settings".

= 1.0.4 =
* Made some improvements so language packs can be enabled

= 1.0.3 =
* Fixed a minor bug in the settings which was causing this error: "You do not have sufficient permissions to access this page".
* Plugin strings are now translatable.

= 1.0.2 =
* PayPal Button plugin is now compatible with WordPress 4.3

= 1.0.1 =
* First commit
