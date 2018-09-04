<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_CustomModule
 * @author    Webkul
 * @copyright Copyright (c) 2010-2016 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
 
namespace Review\Reminder\Model\Mail;
 
class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
     /**
     * Clears the sender from the mail
     *
     * @return Zend_Mail Provides fluent interface
     */
    public function clearFrom()
    {
        //$this->_from = null;
        $this->message->clearFrom('From');
        return $this;
    }
 
    public function clearSubject()
    {
        $this->message->clearSubject();
        return $this;
    }
 
    public function clearMessageId()
    {
        $this->message->clearMessageId();
        return $this;
    }
 
    public function clearBody()
    {
        $this->message->setParts([]);
        return $this;
    }
 
    public function clearRecipients()
    {
        $this->message->clearRecipients();
        return $this;
    }
 
    /**
     * Clear header from the message
     *
     * @param string $headerName
     * @return Zend_Mail Provides fluent inter
     */
    public function clearHeader($headerName)
    {
        if (isset($this->_headers[$headerName])){
            unset($this->_headers[$headerName]);
        }
        return $this;
    }
}