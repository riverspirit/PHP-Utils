<?php
/**
 * Email class - Send emails
 * @author Saurabh aka JSX <saurabh@rebugged.com>
 * 
 * @copyright Saurabh Nair < saurabh@rebugged.com >
 * @license MIT http://www.opensource.org/licenses/mit-license.php
 * @package PHP-Utils
 */

class Email
{
    private $to_email;
    private $from_email;
    private $to_name;
    private $from_name;
	private $headers;
	private $subject;
	private $message;
    
    /**
     * Create new email message
     * @param string $from_email
     * @param string $from_name
     * @param string $to_email
     * @param string $to_name
     * @param string $subject
     * @param string $message 
     */
    public function __construct($from_email, $from_name, $to_email, $to_name, $subject, $message)
    {
        $this->set_from_name($from_name);
        $this->set_from_email($from_email);
        $this->set_to_email($to_email);
        $this->set_to_name($to_name);
        $this->set_subject($subject);
        $this->set_message($message);

		$headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "From: ".$this->from_name." <".$this->from_email.">" . "\r\n";
		$this->headers = $headers;
	}
    
    /**
     * Send the currently constructed email message
     * @return boolean
     */
    public function send()
	{
 		if (mail($this->to_email, $this->subject, $this->message, $this->headers))
        {
             return true;
        }
        return false;
   	}
    
    public function set_to_email($to_email)
    {
        $this->to_email = $to_email;
    }
    
    
    public function set_from_email($from_email)
    {
        $this->from_email = $from_email;
    }
    
    
    public function set_to_name($to_name)
    {
        $this->to_name = $to_name;
    }
    

    public function set_from_name($from_name)
    {
        $this->from_name = $from_name;
    }
    
    
    public function set_subject($subject)
    {
        $this->subject = $subject;
    }
    
    public function set_message($message)
    {
        $this->message = $message;
    }
}

?>