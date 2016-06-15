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
                inner join gr1_woocommerce_api_keys wak on s.api_key_id = wak.key_id
                inner join gr1_users u on u.id=wak.user_id
			where u.id= '.get_current_user_id().'
            order by d.id desc';
		//echo $sql;
		$results = $wpdb->get_results( $sql );

$my_orders_columns = apply_filters( 'woocommerce_my_shop_my_orders_columns', array(
	'order-number'  => __( 'Order', 'woocommerce' ),
	'order-date'    => __( 'Date', 'woocommerce' ),
	'order-status'  => __( 'Status', 'woocommerce' ),
	'order-total'   => __( 'Total', 'woocommerce' ),
	'order-actions' => '&nbsp;',
) );

$shop_orders = $results;

if ( $shop_orders ) : ?>

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
			<?php foreach ( $shop_orders as $order ) :

				?>
				<tr class="order">
					<?php foreach ( $my_orders_columns as $column_id => $column_name ) : ?>
						<td class="<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php
								if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) {do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order );}
								elseif ( 'order-number' === $column_id ) {
									echo _x( '#', 'hash before order number', 'woocommerce' )
										. $order->external_order_id;
								}
								elseif ( 'order-date' === $column_id ){
									echo '<time datetime="'.date( 'Y-m-d', strtotime( $order->datetime ) ).'" title="'.esc_attr( strtotime( $order->datetime ) ).'">'.date_i18n( get_option( 'date_format' ), strtotime( $order->datetime ) ).'</time>';
								}
								elseif ( 'order-status' === $column_id ) {
									//echo wc_get_order_status_name( $order->get_status() );
									echo _e($order->status,'woocommerce');
								}
								elseif ( 'order-total' === $column_id ){
									//echo sprintf( _n( '%s for %s item', '%s for %s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count );
									echo sprintf('%s%s',$order->amount/100,$order->currency);
								}
								elseif ( 'order-actions' === $column_id ) {
									$actions = array(
										'view'   => array(
											'url'  => '#',//$order->get_view_order_url(),
											'name' => __( 'View', 'woocommerce' )
										),
										'cancel' => array(
											'url'  => "#",
											'name' => __( 'Cancel', 'woocommerce' )
										)
									);

									if ( $actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order ) ) {
										foreach ( $actions as $key => $action ) {
											echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
										}
									}
								}
							?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
