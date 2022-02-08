<?php
/**
 * @package MonsterGroup
 */
namespace Inc\Shortcodes;

use Inc\Base\BaseController;

class CustomerForm extends BaseController
{
    /**
     * Calls on stylesheet and javascript for shortcode
     * @return
     */
    public function load_assets()
    {
        // load css stylesheet
        wp_enqueue_style(
            'monster-grp',
            $this->plugin_url. 'assets/shortcode/shortcode.css',
            array(),
            1,
            'all'
        );

        // load javscript script
        wp_enqueue_script(
            'monster-grp',
            $this->plugin_url . 'assets/shortcode/shortcode.js',
            array('jquery'),
            1,
            true
        );
    }

    /**
     * Builds the HTML customer form template
     * @return string
     */
    public function load_shortcode()
     { 
         $output = '';
         $output .= '<div id="container-customer-form">';
         $output .= '<h1>Contact Us</h1>';
         $output .= '<div id="response-message"></div>';
         $output .= '<form id="monster-customer-form">';
         $output .= '<div>';
         $output .= '<label for="name">Name</label>';
         $output .= '<input type="text" name="name" placeholder="Your Name" />';
         $output .= '</div><div>';
         $output .= '<label for="email">Email</label>';
         $output .= '<input type="email" name="email" placeholder="Your Email" />';
         $output .= '</div><div>';
         $output .= '<label for="phone_number">Phone Number</label>';
         $output .= '<input type="text" name="phone_number" placeholder="Your Phone Number" />';
         $output .= '</div><div>';
         $output .= '<label for="service">Service Required</label>';
         $output .= '<select name="service">';
         $output .= '<option value="Electricity">Electricity</option>';
         $output .= '<option value="Internet">Internet</option>';
         $output .= '<option value="Solar">Solar</option>';
         $output .= '</select>';
         $output .= '</div><div>';
         $output .= '<input type="submit" name="lead_submit" id="lead_submit" value="SEND CUSTOMER INFORMATION" />';
         $output .= '</form>';
         $output .= '</div>';

         return $output;
     }

     /**
     * Call javscript file for form submission
     * @return string
     */
     public function load_scripts()
     {
        // register javascript file
        wp_register_script(
            'customer-form-script',
            $this->plugin_url. 'assets/shortcode/customer-form.js',
            array(),
            1,
            true
       );

       // enqueue registered javascript file
       wp_enqueue_script('customer-form-script');

       // pass variables to javascript file
       wp_localize_script('customer-form-script', 'params', array(
            'nonce' => wp_create_nonce('wp_rest'),
            'url' => get_rest_url(null, 'monster-grp/v1/submit-customer-form')
       ));
     }

     /**
     * REST API setup
     * @return
     */
     public function register_rest_api()
     {
         register_rest_route('monster-grp/v1', 'submit-customer-form', array(
             'methods' => 'POST',
             'callback' => array($this, 'handle_customer_form')
         ));
     }

     /**
     * Validates form post
     * @return boolean or array
     */
     public function validate_customer_form(array $params)
     {
        if (isset($params)) {
            $errors = new \WP_Error;

            if ( empty($params['name']) || empty($params['email']) || empty($params['phone_number'])) {
                $errors->add('field', 'Required form field is missing');
            }
    
            if (4 > strlen($params['name']) ) {
                $errors->add('name_length', 'Name too short. At least 4 characters is required');
            }
    
            if (!is_email($params['email'])) {
                $errors->add('email_invalid', 'Email is not valid');
            }
    
            if (is_wp_error($errors)) {
                return $errors->get_error_messages();
            }

            return false;
        }
     }

     /**
     * Handles form submission
     * @return array
     */
     public function handle_customer_form($data)
     {
        global $wpdb;
        
        $headers = $data->get_headers();
        $params = $data->get_params();
        $nonce = $headers['x_wp_nonce'][0];

        if (!wp_verify_nonce($nonce, 'wp_rest')) {
            return new WP_REST_Response('Customer form not sent', 422);
        }

        $validation = $this->validate_customer_form($params);

        if (!$validation) {
            $table = $wpdb->prefix . 'mg_leads';
            $post = array(
                'name' => sanitize_text_field($params['name']),
                'email' =>sanitize_email($params['email']),
                'phone_number' => sanitize_text_field($params['phone_number']),
                'service' => sanitize_text_field($params['service'])
            );
            $result = $wpdb->insert($table, $post);

            return array(
                'status' => $result // returns true
            );
        }

        return array(
            'status' => false,
            'errors' => $validation
        );
     }

     /**
     * Registers class for service
     * @return
     */
     public function register()
     {
        // Add assets 
        add_action('wp_enqueue_scripts', array($this, 'load_assets'));

        // Add shortcode
        add_shortcode('monster_customer_form', array($this, 'load_shortcode'));

        // Add footer for javascripts
        add_action('wp_footer', array($this, 'load_scripts'));

        // Register REST API
        add_action('rest_api_init', array($this, 'register_rest_api'));

        // Pass array variable to custom javascript file
        add_action('wp_enqueue_scripts', array($this, 'load_scripts'));
     }
}