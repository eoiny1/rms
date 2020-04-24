<?php


namespace Neon\Rms\Model\Data;

use Neon\Rms\Api\Data\RmsSendInterface;

/**
 * Class RmsSend
 *
 * @package Neon\Rms\Model\Data
 */
class RmsSend extends \Magento\Framework\Api\AbstractExtensibleObject implements RmsSendInterface
{

    /**
     * Get rmssend_id
     * @return string|null
     */
    public function getRmssendId()
    {
        return $this->_get(self::RMSSEND_ID);
    }

    /**
     * Set rmssend_id
     * @param string $rmssendId
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setRmssendId($rmssendId)
    {
        return $this->setData(self::RMSSEND_ID, $rmssendId);
    }

    /**
     * Get sent_type
     * @return string|null
     */
    public function getSentType()
    {
        return $this->_get(self::SENT_TYPE);
    }

    /**
     * Set sent_type
     * @param string $sentType
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setSentType($sentType)
    {
        return $this->setData(self::SENT_TYPE, $sentType);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Neon\Rms\Api\Data\RmsSendExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Neon\Rms\Api\Data\RmsSendExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Neon\Rms\Api\Data\RmsSendExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get sent_status
     * @return string|null
     */
    public function getSentStatus()
    {
        return $this->_get(self::SENT_STATUS);
    }

    /**
     * Set sent_status
     * @param string $sentStatus
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setSentStatus($sentStatus)
    {
        return $this->setData(self::SENT_STATUS, $sentStatus);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get update_at
     * @return string|null
     */
    public function getUpdateAt()
    {
        return $this->_get(self::UPDATE_AT);
    }

    /**
     * Set update_at
     * @param string $updateAt
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setUpdateAt($updateAt)
    {
        return $this->setData(self::UPDATE_AT, $updateAt);
    }

    /**
     * Get rms_ticket
     * @return string|null
     */
    public function getRmsTicket()
    {
        return $this->_get(self::RMS_TICKET);
    }

    /**
     * Set rms_ticket
     * @param string $rmsTicket
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setRmsTicket($rmsTicket)
    {
        return $this->setData(self::RMS_TICKET, $rmsTicket);
    }

    /**
     * Get error_message
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->_get(self::ERROR_MESSAGE);
    }

    /**
     * Set error_message
     * @param string $errorMessage
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setErrorMessage($errorMessage)
    {
        return $this->setData(self::ERROR_MESSAGE, $errorMessage);
    }

    /**
     * Get send_attempt
     * @return string|null
     */
    public function getSendAttempt()
    {
        return $this->_get(self::SEND_ATTEMPT);
    }

    /**
     * Set send_attempt
     * @param string $sendAttempt
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setSendAttempt($sendAttempt)
    {
        return $this->setData(self::SEND_ATTEMPT, $sendAttempt);
    }

    /**
     * Get prev_status
     * @return string|null
     */
    public function getPrevStatus()
    {
        return $this->_get(self::PREV_STATUS);
    }

    /**
     * Set prev_status
     * @param string $prevStatus
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setPrevStatus($prevStatus)
    {
        return $this->setData(self::PREV_STATUS, $prevStatus);
    }

    /**
     * Get call_time
     * @return string|null
     */
    public function getCallTime()
    {
        return $this->_get(self::CALL_TIME);
    }

    /**
     * Set call_time
     * @param string $callTime
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setCallTime($callTime)
    {
        return $this->setData(self::CALL_TIME, $callTime);
    }
  
  
  
    /**
     * Get locked
     * @return string|null
     */
    public function getLocked()
    {
        return $this->_get(self::LOCKED);
    }

    /**
     * Set locked
     * @param string $locked
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setlocked($locked)
    {
        return $this->setData(self::LOCKED,$locked);
    }
  
  
     /**
     * Get success
     * @return string|null
     */
    public function getSuccess()
    {
        return $this->_get(self::SUCCESS);
    }

    /**
     * Set success
     * @param string $success
     * @return \Neon\Rms\Api\Data\RmsSendInterface
     */
    public function setSuccess($success)
    {
        return $this->setData(self::SUCCESS,$success);
    }
  
  
  
  
  
}

