=== Product Features For WooCommerce ===
Contributors: Brad Davis
Tags: woocommerce, product, product-features
Requires at least:
Tested up to:
Stable tag: 1.1
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Product Features For WooCommerce allows you to easily create a feature for your products and display it so people can learn more about your product.

== Description ==

Product Features For WooCommerce allows you to easily create a key of features for your products.

** Requires WooCommerce to be installed. **

== Installation ==

= WooCommerce Compatibility =

Tested up to

1. Upload Product Features For WooCommerce to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3.
4.
5.
6.

== Frequently Asked Questions ==
= How do I add create a feature? =
In the left menu, look for "Product Features" just under "Products" and click "Add New".
Now you can add the title, provide a brief description of the feature in the "Tooltip Text" box add your image in the "Featured Image" area.

= How do I assign a feature to a product for display? =
After creating the feature, go to the product and on the right of the product and look for the "Product Features" box. Here you can select the product features you have created.

If you can not see the "Product Features" box, click on "Screen Options" in the top right of the window and tick the "Product Features" checkbox. 

= How do I move the product features to another location? =
When you are logged in to your site, go to "Appearance" -> "Customize" -> "WooCommerce" -> "Product Features"
Now you have the option of selecting from five locations:
- After product heading
- After product price
- After product description
- After product cart
- After product meta

= Can I change the title "Product Features" that is shown? =
Yes you can. This can be done using the built in [WordPress add filter function](http://codex.wordpress.org/Function_Reference/add_filter "Function Reference/add filter").
For example, if you want to make the tile "Super Awesome Title" you could use the following code snippet
`
function change_product_feature_title() {
  return 'Super Awesome Title';
}
add_action( 'pffwc_title', 'change_product_feature_title' );
`

= How can I change the font size of the title "Product Features"? =
You can target the font-size or any other CSS property by using like the following example:
`
p.pffwc-title {
  font-size: 3em;
}
`

= How can I change the size of the product feature images? =
You can change the max-width targeting .pffwc-item with your CSS, for example, if I you want four in the row, use 23% as the max-width.
`
.pffwc-item {
  max-width: 23%;
}
`
Wait what? Why 23%, why not 25%?
Well there is 2% margin on the right of each item, if you want four in the row that would be 4 x 2 = 8. 100 - 8 is 92, so you need to divide 92 by 4 = 23%

= How can I change the way the text box (tooltip) that appears displays? =
You can target the tooltip box using .pffwc-item-tooltip as the selector for your CSS, for example, if you want to change the background colour to orange:
`
.pffwc-item-tooltip {
  background: orange;
}
`

== Screenshots ==


== Changelog ==
= 1.0.1 =
* Changed the method to render the product keys on a product so it is more efficient.

= 1.0 =
* Original commit and released to the world.
