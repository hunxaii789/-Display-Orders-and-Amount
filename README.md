# -Display-Orders-and-Amount
dds the [wc_order_count] OR [user_on_hold_total] OR [user-total-amount] OR [user_order_counts] (for only user) shortcode to display the total number of orders placed on your site.
##  Display Orders and Amount 

This plugin will display the total number of completed orders on your site wherever the [wc_order_count] shortcode is used. This is helpful for showing trust badges like, "13,124 orders already shipped!".

You can optionally display a total that includes orders with another status using the optional `status` attribute.

For example, using `[wc_order_count status="completed,processing"]` will display a total that includes both processing and completed orders. You can use a comma-separated list of all order statuses you'd like to include.Adds the [wc_order_count] OR [user_on_hold_total] OR [user-total-amount] OR [user_order_counts] (for only user) shortcode to display the total number of orders placed on your site.

Here's a list of the core statuses and how you should use them in the "status" attribute:

```
completed
processing
on-hold
pending
cancelled
refunded
failed
```

Though custom statuses could be used as well.

**There are no settings**. The plugin only adds the ability to use this shortcode.

### Requirements

 - WordPress 4.0 or newer
 - WooCommerce 2.2 or newer
 
### Frequently Asked Questions

**Why does this show the shortcode text instead of the count?**

Chances are you're using this in a text widget -- your site needs to have this included in the functions.php or custom plugin to do so.

`add_filter( 'widget_text', 'do_shortcode' );`
