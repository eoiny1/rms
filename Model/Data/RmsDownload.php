<?php


namespace Neon\Rms\Model\Data;

use Neon\Rms\Api\Data\RmsDownloadInterface;

/**
 * Class RmsDownload
 *
 * @package Neon\Rms\Model\Data
 */
class RmsDownload extends \Magento\Framework\Api\AbstractExtensibleObject implements RmsDownloadInterface
{

    /**
     * Get rmsdownload_id
     * @return string|null
     */
    public function getRmsdownloadId()
    {
        return $this->_get(self::RMSDOWNLOAD_ID);
    }

    /**
     * Set rmsdownload_id
     * @param string $rmsdownloadId
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setRmsdownloadId($rmsdownloadId)
    {
        return $this->setData(self::RMSDOWNLOAD_ID, $rmsdownloadId);
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
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Neon\Rms\Api\Data\RmsDownloadExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Neon\Rms\Api\Data\RmsDownloadExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Neon\Rms\Api\Data\RmsDownloadExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }



    /**
     * Get status
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
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
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setSuccess($success)
    {
        return $this->setData(self::SUCCESS, $success);
    }

    /**
     * Get gz_url
     * @return string|null
     */
    public function getGzUrl()
    {
        return $this->_get(self::GZ_URL);
    }

    /**
     * Set gz_url
     * @param string $gzUrl
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setGzUrl($gzUrl)
    {
        return $this->setData(self::GZ_URL, $gzUrl);
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
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setLocked($locked)
    {
        return $this->setData(self::LOCKED, $locked);
    }

    /**
     * Get download_time
     * @return string|null
     */
    public function getDownloadTime()
    {
        return $this->_get(self::DOWNLOAD_TIME);
    }

    /**
     * Set download_time
     * @param string $downloadTime
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setDownloadTime($downloadTime)
    {
        return $this->setData(self::DOWNLOAD_TIME, $downloadTime);
    }

    /**
     * Get download_attempts
     * @return string|null
     */
    public function getDownloadAttempts()
    {
        return $this->_get(self::DOWNLOAD_ATTEMPTS);
    }

    /**
     * Set download_attempts
     * @param string $downloadAttempts
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setDownloadAttempts($downloadAttempts)
    {
        return $this->setData(self::DOWNLOAD_ATTEMPTS, $downloadAttempts);
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
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setErrorMessage($errorMessage)
    {
        return $this->setData(self::ERROR_MESSAGE, $errorMessage);
    }

    /**
     * Get download_log
     * @return string|null
     */
    public function getDownloadLog()
    {
        return $this->_get(self::DOWNLOAD_LOG);
    }

    /**
     * Set download_log
     * @param string $downloadLog
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setDownloadLog($downloadLog)
    {
        return $this->setData(self::DOWNLOAD_LOG, $downloadLog);
    }

    /**
     * Get csv_name
     * @return string|null
     */
    public function getCsvName()
    {
        return $this->_get(self::CSV_NAME);
    }

    /**
     * Set csv_name
     * @param string $csvName
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setCsvName($csvName)
    {
        return $this->setData(self::CSV_NAME, $csvName);
    }

    /**
     * Get download_type
     * @return string|null
     */
    public function getDownloadType()
    {
        return $this->_get(self::DOWNLOAD_TYPE);
    }

    /**
     * Set download_type
     * @param string $downloadType
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setDownloadType($downloadType)
    {
        return $this->setData(self::DOWNLOAD_TYPE, $downloadType);
    }
  
  
  
    /**
    * Get sku_added
    * @return string|null
    */
    public function getSkuAdded() 
    {
      
      return $this->_get(self::SKU_ADDED);
      
    }
  
   /**
   * Set sku_added
   * @param string $skuAdded
   * @return \Neon\Rms\Api\Data\RmsDownloadInterface
   */
   public function setSkuAdded($skuAdded)
   {
      return $this->setData(self::SKU_ADDED,$skuAdded); 
   }
  
  
  
  /**
    * Get qty_added
    * @return string|null
    */
    public function getQtyAdded() 
    {
      
      return $this->_get(self::QTY_ADDED);
      
    }
  
   /**
   * Set qty_added
   * @param string $qtyAdded
   * @return \Neon\Rms\Api\Data\RmsDownloadInterface
   */
   public function setQtyAdded($qtyAdded)
   {
      return $this->setData(self::QTY_ADDED,$qtyAdded); 
   }
  
  
  
  /**
  * Get sku_excluded
  * @return string|null
  */
  public function getSkuExcluded()
  {
    return $this->_get(self::SKU_EXCLUDED);  
  }
  
  
  /**
  * Set sku_excluded
  * @param string $skuExcluded
  * @return \Neon\Rms\Api\Data\RmsDownloadInterface
  */
  public function setSkuExcluded($skuExcluded)
  {
     return $this->setData(self::SKU_EXCLUDED,$skuExcluded); 
  }
  
  
    /**
     * Get rms_interaction
     * @return string|null
     */
    public function getRmsInteraction()
    {
        return $this->_get(self::RMS_INTERACTION);
    }

  
    /**
     * Set rms_interaction
     * @param string rms_interaction
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setRmsInteraction($rms_interaction)
    {
        return $this->setData(self::RMS_INTERACTION,$rms_interaction);
    }
    
  
  
  
  
  
}

