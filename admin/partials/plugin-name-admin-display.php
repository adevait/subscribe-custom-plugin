<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

<?php
if ($_GET['page'] == 'plugin-name-list') {
    $active_tab = isset($_GET[ 'tab' ]) ? $_GET[ 'tab' ] : 'subscribe_list';
} else {
    $active_tab = isset($_GET[ 'tab' ]) ? $_GET[ 'tab' ] : 'subscribe_options';
}
?>

<h2 class="nav-tab-wrapper"">
    <a href="options-general.php?page=plugin-name&tab=subscribe_options" class="nav-tab <?php echo $active_tab == 'subscribe_options' ? 'nav-tab-active' : ''; ?>">Subscribe Options</a>
    <a href="options-general.php?page=plugin-name&tab=subscribe_list" class="nav-tab <?php echo $active_tab == 'subscribe_list' ? 'nav-tab-active' : ''; ?>">Subscribe List</a>
</h2>
<?php
if ($active_tab =='subscribe_options') {
    ?>
 	<div class='wrap'>
    	<form method='post' action="options.php">
        <?php 
            do_settings_sections('plugin-name');
    settings_fields('general');
    submit_button(); ?>
        </form>
    </div>
<?php

} else {
    if (! class_exists('WP_List_Table')) {
        require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
    }
    class Subscribe_List_Table extends WP_List_Table
    {
        public function get_columns()
        {
            $columns = array(
            'id' => 'Subsribe Number',
            'email'    => 'Email',
            'time'      => 'Subscribed at',
      );
            return $columns;
        }
        public function __construct()
        {
            parent::__construct(array(
            'singular' => 'subscriber',
            'plural' => 'subscribers',
            'ajax' => false,
        ));
        }
        public static function get_subscribers($per_page = 10, $page_number = 1)
        {
            global $wpdb;
        // this adds the prefix which is set by the user upon instillation of wordpress
      $table_name = $wpdb->prefix . "stefan";
        // this will get the data from your table
      $sql = "SELECT * FROM $table_name";

            if (! empty($_REQUEST['orderby'])) {
                $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
                $sql .= ! empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
            }

            $sql .= " LIMIT $per_page";

            $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;

            $result = $wpdb->get_results($sql, 'ARRAY_A');

            return $result;
        }
        public static function delete_subscriber($id)
        {
            global $wpdb;

            $wpdb->delete(
        "{$wpdb->prefix}stefan",
        [ 'id' => $id ],
        [ '%d' ]
      );
        }
        public static function record_count()
        {
            global $wpdb;

            $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}stefan";

            return $wpdb->get_var($sql);
        }
        public function no_items()
        {
            _e('No subscribers found.');
        }
        public function prepare_items()
        {
            $this->_column_headers = array($this->get_columns());

            $per_page     = $this->get_items_per_page('customers_per_page', 10);
            $current_page = $this->get_pagenum();
            $total_items  = self::record_count();

            $this->set_pagination_args([
         'total_items' => $total_items, //WE have to calculate the total number of items
        'per_page'    => $per_page //WE have to determine how many items to show on a page
      ]);

            $this->items = self::get_subscribers($per_page, $current_page);
        }
        public function column_default($item, $column_name)
        {
            switch ($column_name) {
            case 'id':
            case 'email':
            case 'time':
             return $item[ $column_name ];
            default:
              return print_r($item, true);
        }
        }
    }
    $list_table = new Subscribe_List_Table();
    //$list_table->prepare_items();
    $list_table->prepare_items();
    $list_table->display();
}
