<?php
/**
 * Logger class - Add log entries for debugging
 * @author Saurabh aka JSX <saurabh@rebugged.com>
 * 
 * @copyright Saurabh Nair < saurabh@rebugged.com >
 * @license MIT http://www.opensource.org/licenses/mit-license.php
 * @package PHP-Utils
 */

class Logger
{
    private $prepender_format = '[{timestamp}] {type}: ';
    private $log_fp = null;
    private $log_levels = array('LOG' => 0, 'DEBUG' => 1, 'WARN' => 2, 'ERROR' => 3);
    private $required_log_level;


    public function __construct($log_file_name, $log_level)
    {
        $this->log_fp = fopen($log_file_name, "a+");
        $this->required_log_level = strtoupper($log_level);
    }
    
    public function log($message)
    {
        $this_log_level = strtoupper(__FUNCTION__);
        if ($this->log_levels[$this_log_level] >= $this->log_levels[$this->required_log_level])
        {
            $this->add_log($this_log_level, $message);
        }
        return;
    }
    
    
    public function warn($message)
    {
        $this_log_level = strtoupper(__FUNCTION__);
        if ($this->log_levels[$this_log_level] >= $this->log_levels[$this->required_log_level])
        {
            $this->add_log($this_log_level, $message);
        }
        return;
    }
    
        public function debug($message)
    {
        $this_log_level = strtoupper(__FUNCTION__);
        if ($this->log_levels[$this_log_level] >= $this->log_levels[$this->required_log_level])
        {
            $this->add_log($this_log_level, $message);
        }
        return;
    }
    
    public function error($message)
    {
        $this_log_level = strtoupper(__FUNCTION__);
        if ($this->log_levels[$this_log_level] >= $this->log_levels[$this->required_log_level])
        {
            $this->add_log($this_log_level, $message);
        }
        return;
    }


    private function add_log($log_type, $log_message)
    {
        $log_message = $this->get_log_prepender($log_type).$log_message."\n";
        $logged = fputs($this->log_fp, $log_message);
        if ($logged)
        {
            return true;
        }
        return false;
    }
    
    private function get_log_prepender($message_type)
    {
        $needles = array('{timestamp}', '{type}');
        $replaces = array(date('Y-m-d H:i:s'), $message_type);
        $prepender_text = str_replace($needles, $replaces, $this->prepender_format);
        return $prepender_text;
    }
    
    public function __destruct()
    {
        fclose($this->log_fp);
    }
}