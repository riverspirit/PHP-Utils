<?php

/**
 * Common utility functions
 * @author Saurabh aka JSX
 * 
 * @copyright Saurabh Nair < saurabh@rebugged.com >
 * @license MIT http://www.opensource.org/licenses/mit-license.php
 * @package PHP-Utils
 */
class Utils
{
    /**
     * Redirect user
     * @param string $page Default = null -> to redirect to the same page.
     * @param string $message
     * @param string $status Eg: success, failure etc
     * @param string $context Eg: signup, account_activation etc
     */
    public static function redirect($page = null, $message = null, $status = 'success', $context = null)
    {
        if (!$page)
        {
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')? "https://" : "http://";
            $page = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        self::set_message($message, $status, $context);
        header("Location: $page");
        die;
    }
    
    /**
     * Set message in $_SESSION['message']
     * @param string $message
     * @param string $type Eg: success, failure etc
     * @param string $context Eg: signup, account_activation etc
     */
    public static function set_message($message, $type=null, $context=null)
    {
        $_SESSION['message']['text'] = $message;
        $_SESSION['message']['type'] = $type;
        $_SESSION['message']['context'] = $context;
        $_SESSION['message']['set_page'] = $_SERVER['PHP_SELF']; // for debuggin
    }
    
    
    /**
     * Displays the message in $_SESSION['message']
     * 
     * If a wrapper is specified, the message[text] will be wrapped inside that element.
     * If message['type'] is absent, the css class 'message' will be applied to the wrapping element,
     * else the message['type'] itself will be applied as css class.
     * 
     * @param string $context Eg: signup, account_activation etc
     * @param string $wrapper Eg: div, span, p etc
     */
    public static function show_message($context, $wrapper='')
    {
        $css_class = (isset($_SESSION['message']['type']))?$_SESSION['message']['type']:'message';
       
        if (isset($_SESSION['message']) && $_SESSION['message']['context'] == $context)
        {
            if ($wrapper == '')
            {
                echo $_SESSION['message']['text'];
            }
            else
            {
                echo "<", $wrapper, " class='", $css_class, "' >", $_SESSION['message']['text'], "</", $wrapper, ">";
            }
            unset($_SESSION['message']);
        }
    }
	
	/**
     * Get time elapsed since a timestamp/date
     * @param timestamp | a valid date format $old_time
     * @param type $convert_to_timestamp optional default true If true, the passed value will be converted to timestamp
     * @return string Eg: 2 seconds
     */
	public static function get_time_since($old_time, $convert_to_timestamp = true)
    {
        if ($convert_to_timestamp)
        {
            $stamp = time() - strtotime($old_time);
        }
        else
        {
            $stamp = time() - $old_time;
        }
        
        $seconds = gmdate('s', $stamp);
        $minutes = gmdate('i', $stamp);
        $hours = gmdate('H', $stamp);
        $days = gmdate('d', $stamp);
        $months = gmdate('n', $stamp);
        $years = gmdate('Y', $stamp);
        
        if ($years < 1970)
        {
            $long_time = date('Y') - 1970;
            return "more than ".$long_time." years ";
        }
        
        $years = $years - 1970;
        
        if ($stamp < 60)
        {
            $time_string = (int)$seconds." seconds ";
        }
        elseif ($stamp < 60*60)
        {
            $time_string = (int)$minutes." minutes ";
        }
        elseif ($stamp < 60*60*24)
        {
            $time_string = (int)$hours." hours ";
        }
        elseif ($stamp < 60*60*24*30)
        {
            $time_string = (int)$days." days ";
        }
        elseif ($stamp < 60*60*24*30*365)
        {
            $time_string =  (int)$months." months ";
        }
        elseif ($stamp >= 60*60*24*365)
        {
            $time_string = (int)$years." years ";
        }

        return trim($time_string, " ");
    }
    
	
	
	/**
	 * Trim the given string at the specified length
	 * @param string $string String to be trimmed
	 * @param number $length Length at which the string to be trimmed
	 * @param string $tail An optional string to be appended after the trimmed string. Default: .. (two dots)
	 * 
	 */
	public static function trim_text($string, $length = null, $tail = "..")
	{
	    $tail = (strlen($string) > $length) ? $tail : null;
	    $trimmed_string = isset($length) ? substr($string, 0, $length).$tail : $string;
	    return $trimmed_string;
	}
	
	/**
	 * Get the title of a remote web page, given the URL
	 *
	 * @param string $url URL of the remote web page
	 * @return string title
	 */
	public static function get_page_title($url)
    {
        $page_markup = file_get_contents($url);
        preg_match("|<title>(.*?)</title>|i", $page_markup, $matches);
        $title = $matches[1];
        return $title;
    }
    
    
    /**
     * Create the html code for a select list from a given array
     * @param array $items_array Array to be used to create te select list
     * @param string $index_value Name of the array key to be used as 'value' in the select list
     * @param string $index_text Name of the array key to be used as text in the select list
     * @param string $selected_index Value of the selected index, if any. Else, leave NULL
     * @param string $extra_params This string will be appended as attribute of the select list Eg: name='mylist'
     * @return string
     */
    public static function get_select_list_from_array($items_array, $index_value, $index_text, $selected_index = NULL, $extra_params = "")
    {
        $html = "<option>Select</option>";
        
        foreach ($items_array as $item)
        {
            $selected = '';
            
            if ($item[$index_value] == $selected_index)
            {
                $selected = "selected = 'true'";
            }
            
            $html .= "<option value='{$item[$index_value]}' {$selected}>{$item[$index_text]}</option>";
        }
        
        $html = "<select {$extra_params}>{$html}</select>";
        return $html;
    }
    
    public static function create_seo_url()
    {
        //
    }
    
    public function format_url()
    {
        //
    }
    
}

?>
