<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.instant-programming.com
 * @since      1.0.0
 *
 * @package    Ip_Poi_map_list
 * @subpackage Ip_Poi_map_list/admin/partials
 */

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class POITableList extends WP_List_Table {

    public function prepare_items() {

        $orderby = sanitize_sql_orderby(isset($_GET['orderby']) ? trim($_GET['orderby']) : "");
        $order = sanitize_sql_orderby(isset($_GET['order']) ? trim($_GET['order']) : "");
        $search_term = esc_attr( apply_filters( 'get_search_query', isset($_POST['s']) ? trim($_POST['s']) : "" ) );

        $datas = $this->get_data($orderby, $order, $search_term);

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = count($datas);

        $this->set_pagination_args(array(
           "total_items" => $total_items,
           "per_page"    => $per_page
        ));

        $this->items = array_slice($datas, (($current_page - 1) * $per_page), $per_page);

        $columns = $this  ->get_columns();
        $hidden = $this   ->get_hidden_columns();
        $sortable = $this ->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();


    }

    public function get_data($orderby= '', $order= '', $search_term = '') {
        global $wpdb;

        if (!empty($search_term)){
            $all_items = $wpdb->get_results(
                "SELECT * FROM wp_ip_poi_map_list WHERE title LIKE '%$search_term%' OR description LIKE '%$search_term%'"
            );
        }else{
            if ($orderby=='title' && $order == 'desc'){
                $all_items = $wpdb->get_results(
                    "SELECT * FROM wp_ip_poi_map_list ORDER BY title DESC"
                );
            } elseif($orderby=='title' && $order == 'asc') {
                $all_items = $wpdb->get_results(
                    "SELECT * FROM wp_ip_poi_map_list ORDER BY title ASC"
                );
            } else {
                $all_items = $wpdb->get_results(
                    "SELECT * FROM wp_ip_poi_map_list"
                );
            }
        }

        $items_array = array();

        if (count($all_items) > 0) {

            foreach ($all_items as $index => $listItem) {
                $items_array[] = array(
                    "id"    => $listItem->id,
                    "title" => $listItem->title,
                    "description" => $listItem->description,
                    "city" => $listItem->city,
                    "country" => $listItem->country,
                    "created" => $listItem->created,
                );
            }
        }

        return $items_array;
    }

    public function get_hidden_columns()
    {
        return array();
    }

    public function get_sortable_columns()
    {
        return array(
            "title" => array("title", false)
        );
    }
    public function get_bulk_actions() {

        return array(
            'delete' => 'Delete',

        );

    }

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
    function process_bulk_action() {
        global $wpdb;
        if ('delete' === $this->current_action()) {

            $ids = sanitize_key(isset($_REQUEST['id']) ? $_REQUEST['id'] : array());
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {

                $wpdb->query("DELETE FROM wp_ip_poi_map_list WHERE id IN($ids)");

            }
            echo '<script>location.href="admin.php?page=ip-poi_map_list"</script>';
        }
    }




    public function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
                "id"    => "ID",
                "title" => "Title",
                "description" => "Description",
                "city" => "City",
                "country" => "Country",
                "created" => "Published",
        );

        return $columns;
    }
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }



    public function column_default($item, $column_name) {
        switch ($column_name){
            case 'id':
            case 'title':
            case 'description':
            case 'city':
            case 'country':
            case 'created':
                return $item[$column_name];
            default:
                return "no value";
        }
    }

    public function column_title($item) {
        $action = array(
                "edit"=> sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>', $_GET['page'], 'poi-edit', $item['id']),
                "delete"=> sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>', $_GET['page'], 'poi-delete', $item['id'])
        );

        return sprintf('%1$s %2$s', $item['title'],$this->row_actions($action));
    }
}

function IP_show_data_list_table() {

    $POI_list_table = new POITableList();

    $POI_list_table->prepare_items();

    echo '<div class="wrap">';
        echo "<form method='post' name='frm_search_post' action='" . $_SERVER['PHP_SELF'] . "?page=ip-poi_map_list'>";
            echo '<h1 class="wp-heading-inline">POI List </h1>';
            echo '<a href="admin.php?page=new_poi_item" class="page-title-action"> Add new </a>';
            $POI_list_table->search_box("Search List ", "search_list_id");
            $POI_list_table->display();
        echo "</form>";
    echo '</div>';
}

IP_show_data_list_table();