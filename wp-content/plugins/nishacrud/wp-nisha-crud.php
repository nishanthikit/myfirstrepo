<?php
/**
* Plugin Name: WP Nisha CRUD 
* Description: This plugin to create custom contact list-tables from database using WP_List_Table class.
* Version:     1.0
* Plugin URI: https://testing.com
* Author:      Nishanthi
* Author URI:  https://testing.com
* License:     GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wpcr
* Domain Path: /languages
*/

defined( 'ABSPATH' ) or die( '¡Sin trampas!' );

require plugin_dir_path( __FILE__ ) . 'includes/crudmetabox.php';

function wpcr_custom_admin_styles() {
    wp_enqueue_style('custom-styles', plugins_url('/css/styles.css', __FILE__ ));
	}
add_action('admin_enqueue_scripts', 'wpcr_custom_admin_styles');


function wpcr_plugin_load_textdomain() {
    load_plugin_textdomain( 'wpcr', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'plugins_loaded', 'wpcr_plugin_load_textdomain' );


global $wpcr_db_version;
$wpcr_db_version = '1.0'; 


function wpcr_install()
{
    global $wpdb;
    global $wpcr_db_version;

    $table_name = $wpdb->prefix . 'crud'; 


    $sql = "CREATE TABLE " . $table_name . " (
      id int(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR (50) NOT NULL,
      lastname VARCHAR (100) NOT NULL,
      email VARCHAR(100) NOT NULL,
      phone VARCHAR(15) NULL,
      company VARCHAR(100) NULL,
      web VARCHAR(100) NULL,  
      two_email VARCHAR(100) NULL,   
      two_phone VARCHAR(15) NULL,  
      job VARCHAR(100) NULL,
      address VARCHAR (250) NULL,
      notes VARCHAR (250) NULL,
      PRIMARY KEY  (id)
    );";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('wpcr_db_version', $wpcr_db_version);

    $installed_ver = get_option('wpcr_db_version');
    if ($installed_ver != $wpcr_db_version) {
        $sql = "CREATE TABLE " . $table_name . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          name VARCHAR (50) NOT NULL,
          lastname VARCHAR (100) NOT NULL,
          email VARCHAR(100) NOT NULL,
          phone VARCHAR(15) NULL,
          company VARCHAR(100) NULL,
          web VARCHAR(100) NULL,  
          two_email VARCHAR(100) NULL,   
          two_phone VARCHAR(15) NULL,  
          job VARCHAR(100) NULL,          
          address VARCHAR (250) NULL,
          notes VARCHAR (250) NULL,
          PRIMARY KEY  (id)
        );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        update_option('wpcr_db_version', $wpcr_db_version);
    }
}

register_activation_hook(__FILE__, 'wpcr_install');


function wpcr_install_data()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'crud'; 

}

register_activation_hook(__FILE__, 'wpcr_install_data');


function wpcr_update_db_check()
{
    global $wpcr_db_version;
    if (get_site_option('wpcr_db_version') != $wpcr_db_version) {
        wpcr_install();
    }
}

add_action('plugins_loaded', 'wpcr_update_db_check');



if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


class Custom_Table_Example_List_Table extends WP_List_Table
 { 
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'contact',
            'plural'   => 'contacts',
        ));
    }


    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }


    function column_phone($item)
    {
        return '<em>' . $item['phone'] . '</em>';
    }


    function column_name($item)
    {

        $actions = array(
            'edit' => sprintf('<a href="?page=contacts_form&id=%s">%s</a>', $item['id'], __('Edit', 'wpcr')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'wpcr')),
        );

        return sprintf('%s %s',
            $item['name'],
            $this->row_actions($actions)
        );
    }


    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', 
            'name'      => __('Name', 'wpcr'),
            'lastname'  => __('Last Name', 'wpcr'),
            'email'     => __('E-Mail', 'wpcr'),
            'phone'     => __('Phone', 'wpcr'),
            'company'   => __('Company', 'wpcr'),
            'web'       => __('Web', 'wpcr'),  
            'two_email' => __('Email', 'wpcr'),   
            'two_phone' => __('Phone', 'wpcr'),  
            'job'       => __('Job Title', 'wpcr'),
        );
        return $columns;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'name'      => array('name', true),
            'lastname'  => array('lastname', true),
            'email'     => array('email', true),
            'phone'     => array('phone', true),
            'company'   => array('company', true),
            'web'       => array('web', true),  
            'two_email' => array('two_email', true),   
            'two_phone' => array('two_phone', true),  
            'job'       => array('job', true),
        );
        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'crud'; 

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'crud'; 

        $per_page = 10; 

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
       
        $this->process_bulk_action();

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");


        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'lastname';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';


        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);


        $this->set_pagination_args(array(
            'total_items' => $total_items, 
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page) 
        ));
    }
}

function wpcr_admin_menu()
{
    add_menu_page(__('Contacts', 'wpcr'), __('Contacts', 'wpcr'), 'activate_plugins', 'contacts', 'wpcr_contacts_page_handler');
    add_submenu_page('contacts', __('Contacts', 'wpcr'), __('Contacts', 'wpcr'), 'activate_plugins', 'contacts', 'wpcr_contacts_page_handler');
   
    add_submenu_page('contacts', __('Add new', 'wpcr'), __('Add new', 'wpcr'), 'activate_plugins', 'contacts_form', 'wpcr_contacts_form_page_handler');
}

add_action('admin_menu', 'wpcr_admin_menu');


function wpcr_validate_contact($item)
{
    $messages = array();

    if (empty($item['name'])) $messages[] = __('Name is required', 'wpcr');
    if (empty($item['lastname'])) $messages[] = __('Last Name is required', 'wpcr');
    if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'wpcr');
    if(!empty($item['phone']) && !absint(intval($item['phone'])))  $messages[] = __('Phone can not be less than zero');
    if(!empty($item['phone']) && !preg_match('/[0-9]+/', $item['phone'])) $messages[] = __('Phone must be number');
    

    if (empty($messages)) return true;
    return implode('<br />', $messages);
}


function wpcr_languages()
{
    load_plugin_textdomain('wpcr', false, dirname(plugin_basename(__FILE__)));
}

add_action('init', 'wpcr_languages');

function testing(){
    wp_enqueue_style('custom-styless', plugins_url('/css/styles.css', __FILE__ ));
}
add_action('admin_enqueue_scripts', 'wpcr_custom_admin_styles');
