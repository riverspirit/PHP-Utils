<?php
/**
 * Validation class - Contains utilites to handle common valiadtion scenarios
 * @author Saurabh aka JSX <saurabh@rebugged.com>
 * 
 * @copyright Saurabh Nair < saurabh@rebugged.com >
 * @license MIT http://www.opensource.org/licenses/mit-license.php
 * @package PHP-Utils
 */

class validate
{
    /**
     * Check whether the given value already exists in the specified db_field.
     * @param string $table
     * @param string $db_field eg: username
     * @param mixed $value eg: admin
     */
    public static function check_already_exists($table, $db_field, $value) {
        $res = mysql_query("SELECT COUNT(*) as count FROM ".$table." WHERE ".$db_field."='$value'");
        $res = mysql_fetch_array($res);
        if ($res[0]['count'] > 0)
        {
            return true; // value already exists!
        }
        return false;
    }
    
    /**
     *
     * Checks if the mentioned fields are set in the given array
     * @param array $post_data
     * @param array $required_fields
     * @return true if valid, else false
     */
    public static function is_set($post_data, $required_fields) {
        $error = true;
        foreach ($required_fields as $field)
        {
            if (trim($post_data[$field]) == '')
            {
                $error = false;
            }
        }
        return $error;
    }
    
    /**
     * Validate email address
     * @param string $email
     * @return boolean
     * 
     * @assert ('user@example.com') == true
     */
    public static function is_email($email) {
        return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', strtolower($email));
    }
    
    
    /**
     * Checks if the given value is in a valid us phone number format.
     * Eg: Both 555-123-1111, 5551231111, (555) 123-1111 and (555)123-1111 will be valid
     * @param string $phone
     */
    public static function is_us_phone($phone) {
        $format1 = '^[0-9]{3}-[0-9]{3}-[0-9]{4}$';
        $format2 = '^[0-9]{10}$';
        $format3 = '^\([0-9]{3}\) ?[0-9]{3}-[0-9]{4}$';
        
        return preg_match("/$format1|$format2|$format3/", $phone); // \m/
    }
	
    
    /**
     * Checks a string for special characters.
     * @param string $string
     * @param boolean $numbers_allowed true by default
     * @param string $other_allowed_chars default value " " (space)
     * @return boolean
     */
    public static function no_special_chars($string, $numbers_allowed = true, $other_allowed_chars = " ") {
        if ($numbers_allowed)
        { 
            return preg_match('/^[a-zA-Z0-9'.preg_quote($other_allowed_chars).']*$/', $string); // numbers are allowed
        }
        return preg_match('/^[a-zA-Z'.preg_quote($other_allowed_chars).']*$/', $string); // numbers are not allowed
    }
    
    /**
     * Checks if string is in valid date format 
     * @param string $date
     * @param string $format ("dmy" | "mdy") default = "dmy"
     * @return boolean
     */
    public static function is_date($date, $format="dmy") {
        switch (strtolower($format))
        {
            case 'dmy' : {
                return preg_match('/^((0?[1-9]|[12][0-9]|3[01])[- \/\.](0?[1-9]|1[012])[- \/\. ](19|20)?[0-9]{2})*$/', $date);
            }
            case 'mdy' : {
                return preg_match('/^((0?[1-9]|1[012])[- \/\.](0?[1-9]|[12][0-9]|3[01])[- \/\. ](19|20)?[0-9]{2})*$/', $date);
            }
        }
    }
    
    /**
     * Sanitize all members in an array. Trims and escapes special characters for use in an sql statement
     * @param array $data eg: $_POST
     * @return array
     */
    public static function sanitize($data) {
        foreach ($data as $key=>$value)
        {
            if (!is_array($value))
            {
                $data[$key] = trim(mysql_escape_string($value));
            }
            else
            {
                self::sanitize($value);
            }
        }
        return $data;
    }
    
    /**
     * Validates common URL patterns
     * @param string $url
     * @return boolean
     */
    public static function is_valid_url($url)
    {
        $pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
        return preg_match($pattern, $url);
    }
    
    
    /**
     * Checks if a string is in valid date time format
     * @param string $datetime
     * @return boolean
     */
    public static function is_valid_datetime($datetime)
    {
        if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $datetime, $matches))
        {
            if (checkdate($matches[2], $matches[3], $matches[1]))
            {
                return true;
            }
        }
        return false;
    }

}
?>
