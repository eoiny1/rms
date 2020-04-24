<?php


namespace Neon\Rms\Api\Data;

/**
 * Interface RmsSendInterface
 *
 * @package Neon\Rms\Api\Data
 */
interface RmsSendInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const SENT_STATUS = 'sent_status';
    const ERROR_MESSAGE = 'error_message';
    const UPDATE_AT = 'update_at';
    const SENT_TYPE = 'sent_type';
    const RMSSEND_ID = 'rmssend_id';
    const SEND_ATTEMPT = 'send_attempt';
    const PREV_STATUS = 'prev_status';
    const CALL_TIME = 'call_time';
    const RMS_TICKET = 'rms_ticket';
    const CREATED_AT = 'created_at';
    const LOCKED = 'locked';
    const SUCCESS = 'success';
  

    /**
     * Get rmssend_id
     * @return string|null
     */
    public function getRmssendId();

    /**
     * Set rmssend_id
     * @param string $rmssendId
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setRmssendId($rmssendId);

    /**
     * Get sent_type
     * @return string|null
     */
    public function getSentType();

    /**
     * Set sent_type
     * @param string $sentType
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setSentType($sentType);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Neon\Rms\Api\Data\RmsSendExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Neon\Rms\Api\Data\RmsSendExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Neon\Rms\Api\Data\RmsSendExtensionInterface $extensionAttributes
    );

    /**
     * Get sent_status
     * @return string|null
     */
    public function getSentStatus();

    /**
     * Set sent_status
     * @param string $sentStatus
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setSentStatus($sentStatus);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get update_at
     * @return string|null
     */
    public function getUpdateAt();

    /**
     * Set update_at
     * @param string $updateAt
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setUpdateAt($updateAt);

    /**
     * Get rms_ticket
     * @return string|null
     */
    public function getRmsTicket();

    /**
     * Set rms_ticket
     * @param string $rmsTicket
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setRmsTicket($rmsTicket);

    /**
     * Get error_message
     * @return string|null
     */
    public function getErrorMessage();

    /**
     * Set error_message
     * @param string $errorMessage
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setErrorMessage($errorMessage);

    /**
     * Get send_attempt
     * @return string|null
     */
    public function getSendAttempt();

    /**
     * Set send_attempt
     * @param string $sendAttempt
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setSendAttempt($sendAttempt);

    /**
     * Get prev_status
     * @return string|null
     */
    public function getPrevStatus();

    /**
     * Set prev_status
     * @param string $prevStatus
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setPrevStatus($prevStatus);

    /**
     * Get call_time
     * @return string|null
     */
    public function getCallTime();

    /**
     * Set call_time
     * @param string $callTime
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setCallTime($callTime);
  
  
     /**
     * Get locked
     * @return string|null
     */
    public function getLocked();
      
      
     /**
     * Set locked
     * @param string $locked
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setlocked($locked);
      
      
     /**
     * Get success
     * @return string|null
     */
    public function getSuccess();
      
     
     /**
     * Set success
     * @param string $success
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setSuccess($success);
      
  
}

