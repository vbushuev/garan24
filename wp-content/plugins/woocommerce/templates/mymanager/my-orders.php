<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if(!function_exists('garan24_get_shop_by_order')){
	function garan24_get_shop_by_order($order){
		global $wpdb;
		$sql = 'select
				d.id as id,
				d.date as datetime,
				d.amount as amount,
				d.currency as currency,
				d.shop_id as shop_id,
				d.status as status_id,
				d.internal_order_id,
				d.external_order_id,
				ds.status,
				ds.description as ststus_description,
				s.name as shop_name,
				s.link as shop_link
			from gr1_deals d
				inner join gr1_deal_statuses ds on ds.id=d.status
				inner join gr1_shops s on s.id=d.shop_id
			where d.internal_order_id = '.$order->get_order_number().' order by d.id desc';
		//echo $sql;
		$results = $wpdb->get_row( $sql );
		//echo json_encode($results);
		return $results;
	}
}
if ( !has_action( 'garan24_get_shop_by_order' ) ) {

	add_action( 'garan24_get_shop_by_order', 'garan24_get_shop_by_order' );
}

$my_orders_columns = apply_filters( 'woocommerce_my_shop_my_orders_columns', array(
	'shop'  => __( 'Shop', 'woocommerce' ),
	'order-number'  => __( 'Order', 'woocommerce' ),
	'order-date'    => __( 'Date', 'woocommerce' ),
	'order-status'  => __( 'Status', 'woocommerce' ),
	'order-total'   => __( 'Total', 'woocommerce' ),
	'order-actions' => '&nbsp;',
) );

$customer_orders = get_posts( apply_filters( 'woocommerce_my_manager_my_orders_query', array(
	//'numberposts' => $order_count,
	'numberposts' => -1,
	'meta_key'    => '_payment_method',
	'meta_value'  => 'garan24',
	'post_type'   => wc_get_order_types( 'view-orders' ),
	'post_status' => array_keys( wc_get_order_statuses() )
) ) );

if ( $customer_orders ) : ?>

	<h2><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', __( 'Recent Orders', 'woocommerce' ) ); ?></h2>

	<table class="shop_table shop_table_responsive my_account_orders">

		<thead>
			<tr>
				<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
					<th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>

		<tbody>
			<?php foreach ( $customer_orders as $customer_order ) :
				$order      = wc_get_order( $customer_order );
				$item_count = $order->get_item_count();
				$garan=garan24_get_shop_by_order($order);
				?>
				<tr class="order">
					<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
						<td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php
								if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) {do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order );}
								elseif ( 'shop' === $column_id ) {

									echo '<a target="__blank" href="'.esc_url( $garan->shop_link).'">'. $garan->shop_name."</a>";
								}
								elseif ( 'order-number' === $column_id ) {
									echo '<a href="'
										.esc_url( $order->get_view_order_url())
										.'">'
										._x( '#', 'hash before order number', 'woocommerce' )
										. $order->get_order_number()
										."</a>";
								}
								elseif ( 'order-date' === $column_id ){
									echo '<time datetime="'.date( 'Y-m-d', strtotime( $order->order_date ) ).'" title="'.esc_attr( strtotime( $order->order_date ) ).'">'.date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ).'</time>';
								}
								elseif ( 'order-status' === $column_id ) {
									//echo wc_get_order_status_name( $order->get_status() );
									echo $garan->status;
								}
								elseif ( 'order-total' === $column_id ){
									echo sprintf( _n( '%s for %s item', '%s for %s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count );
								}
								elseif ( 'order-actions' === $column_id ) {
									$actions = array(
										'view'   => array(
											'url'  => 'https://garan24.ru/my-manager/view-order/'.$order->get_order_number(),
											'name' => __( 'View', 'woocommerce' )
										),
										'credit' => array(
											'url'  => '#',
											'name' => __( 'Credit', 'woocommerce' )
										),
										'close' => array(
											'url'  => '#',
											'name' => __( 'Fund', 'woocommerce' )
										),
										'decline' => array(
											'url'  => "#",
											'name' => __( 'Decline', 'woocommerce' )
										)
									);

									if ( $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order ) ) {
										foreach ( $actions as $key => $action ) {
											echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
										}
									}
								}
								$_data_str = "amount=".$order->get_formatted_order_total();
							?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
