<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter email_template Library
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * http://opensource.org/licenses/AFL-3.0
 *
 * @package     CodeIgniter
 * @author      Silambarasan.B
 * @copyright   Copyright (c) Blazedream Technologies (http://blazedream.com)
 * @license     http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * email_template Library
 *
 * @subpackage Libraries
 */
class Email_template
{
    public function send_mail($to, $from = NULL, $type, $data = array(), $body = '')
    {
        $CI =& get_instance();
        $return      = false;
        $temp_string = $replace_string = '';
        
        $template = $CI->base_model->get_record_by_id('email_templates', '*', array(
            'name' => $type,
            'is_active' => 1
        ));
        if (!empty($template)) {
            $default_data   = array(
                '[##MAIL_TITLE##]' => $template['subject'],
                '[##BASE_URL##]' => base_url(),
                '[##SITE_NAME##]' => SITE_NAME
            );
            $data           = array_merge($data, $default_data);
            $temp_string    = array_keys($data);
            $replace_string = array_values($data);
           
            $content           = html_entity_decode((str_replace($temp_string, $replace_string, trim($template['email_content']))));
				$body 			 = $CI->load->view(SITE_MAIL_TEMPLATE_PATH, array('subject'=>$template['subject'], 'content'=> $content), true); 

            $CI->load->library('email');
            $CI->email->initialize(array(
                'mailtype' => (($template['is_html'] == '1') ? 'html' : 'text'),
                'validate' => true
            ));
            if (!$from) {
                $from = $template['from_email'];
            } else {
                	//$CI->config->load('admin_config');
               	//$from = $CI->config->item('admin-email');
            }
           	if ($from != '') {
                $CI->email->from($from, 'Admin');
                $CI->email->to($to);
                $CI->email->subject($template['subject']);
                $CI->email->message($body);
                if ($CI->email->send()) {
                    $return = true;
                } else {
                    $return = false;
                }
            } else {
                $return = false;
            }
        }
        return $return;
    }
}
