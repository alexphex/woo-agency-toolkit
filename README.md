# Woo Agency Toolkit

WooCommerce extension for agency projects. Adds custom product fields, checkout fields, order columns, and email customization.

Built as a portfolio project to practice WooCommerce hooks and filters.

## Features

- Custom field "Production Time (days)" on product admin page — displays on single product page
- Custom field "Delivery Comment" on Classic Checkout — saved to order meta
- Custom column "Delivery Comment" in orders list table
- Delivery Comment displayed in order emails (HTML and plain text)

## Stack

- PHP 8.2, OOP, type declarations
- WooCommerce hooks and filters
- WordPress 6.7+, WooCommerce 9.x+

## Setup

```bash
git clone https://github.com/alexphex/woo-agency-toolkit.git wp-content/plugins/woo-agency-toolkit
```

Activate the plugin in WordPress admin. WooCommerce must be installed and activated.

## Notes

**Classic Checkout only.** The delivery comment field works with WooCommerce Classic Checkout. Block Checkout support requires additional integration via WooCommerce Blocks API — not implemented in this version.

Production time field uses `absint()` for sanitization — prevents negative values and non-numeric input.

All output is escaped with `esc_html()` and `esc_attr()`.

OOP architecture with `spl_autoload_register()` — no manual requires.
