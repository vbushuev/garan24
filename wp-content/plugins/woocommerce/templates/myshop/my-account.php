<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
wc_print_notices();
global $wpdb;
$sql = 'select
		s.name as shop_name,
		s.link as shop_link
	from gr1_shops s on s.id=d.shop_id
		inner join gr1_woocommerce_api_keys wak on s.api_key_id = wak.key_id
	where wak.user_id= '.get_current_user_id().'
	order by d.id desc';
//echo $sql;
$results = $wpdb->get_results( $sql );
$shop_name = "";
foreach ($results as $shop) {
	$shop_name .= (empty($shop_name)?"":", ").$shop->shop_name;
}
?>
<p class="myaccount_user">
	<?php
	printf( $shop_name );
	?>
</p>
<p>
	<a class="button" href="<?php echo wc_customer_edit_account_url();?>">Редактировать профиль</a>
	<a class="button" href="<?php echo wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( '/' ));?>">Выйти</a>
</p>

<?php
do_action( 'woocommerce_before_my_account' );
//wc_get_template( 'myshop/my-downloads.php' );
wc_get_template( 'myshop/my-orders.php', array( 'order_count' => $order_count ) );
//wc_get_template( 'myshop/my-address.php' );
do_action( 'woocommerce_after_my_account' );
?>
