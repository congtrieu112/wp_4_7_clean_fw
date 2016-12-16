<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! wc_coupons_enabled() ) {
	return;
}

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'theshopier' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'theshopier' ) . '</a>' );
//wc_print_notice( $info_message, 'notice' );
?>

<div class="nth-pretty-wrapper nth-checkout-coupon-box hidden" id="nth_checkout_coupon" >

	<h3 class="nth-pretty-header"><?php esc_html_e("Your Coupon", "theshopier");?></h3>

	<form class="checkout_coupon" method="post" style="display:none;">

		<p class="form-row form-row-first">
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'theshopier' ); ?>" id="coupon_code" value="" />
		</p>

		<p class="form-row form-row-last">
			<input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'theshopier' ); ?>" />
		</p>

		<div class="clear"></div>
	</form>
</div>
