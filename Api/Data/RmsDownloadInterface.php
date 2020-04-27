<?php


namespace Neon\Rms\Api\Data;

/**
 * Interface RmsDownloadInterface
 *
 * @package Neon\Rms\Api\Data
 */
interface RmsDownloadInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ERROR_MESSAGE = 'error_message';
    const RMSDOWNLOAD_ID = 'rmsdownload_id';
    const DOWNLOAD_LOG = 'download_log';
    const CSV_NAME = 'csv_name';
    const LOCKED = 'locked';
    const STATUS = 'status';
    const DOWNLOAD_TIME = 'download_time';
    const DOWNLOAD_TYPE = 'download_type';
    const SUCCESS = 'success';
    const DOWNLOAD_ATTEMPTS = 'download_attempts';
    const CREATED_AT = 'created_at';
    const GZ_URL = 'gz_url';

    /**
     * Get rmsdownload_id
     * @return string|null
     */
    public function getRmsdownloadId();

    /**
     * Set rmsdownload_id
     * @param string $rmsdownloadId
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setRmsdownloadId($rmsdownloadId);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Neon\Rms\Api\Data\RmsDownloadExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Neon\Rms\Api\Data\RmsDownloadExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Neon\Rms\Api\Data\RmsDownloadExtensionInterface $extensionAttributes
    );


    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setStatus($status);

    /**
     * Get success
     * @return string|null
     */
    public function getSuccess();

    /**
     * Set success
     * @param string $success
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setSuccess($success);

    /**
     * Get gz_url
     * @return string|null
     */
    public function getGzUrl();

    /**
     * Set gz_url
     * @param string $gzUrl
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setGzUrl($gzUrl);

    /**
     * Get locked
     * @return string|null
     */
    public function getLocked();

    /**
     * Set locked
     * @param string $locked
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setLocked($locked);

    /**
     * Get download_time
     * @return string|null
     */
    public function getDownloadTime();

    /**
     * Set download_time
     * @param string $downloadTime
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setDownloadTime($downloadTime);

    /**
     * Get download_attempts
     * @return string|null
     */
    public function getDownloadAttempts();

    /**
     * Set download_attempts
     * @param string $downloadAttempts
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setDownloadAttempts($downloadAttempts);

    /**
     * Get error_message
     * @return string|null
     */
    public function getErrorMessage();

    /**
     * Set error_message
     * @param string $errorMessage
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setErrorMessage($errorMessage);

    /**
     * Get download_log
     * @return string|null
     */
    public function getDownloadLog();

    /**
     * Set download_log
     * @param string $downloadLog
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setDownloadLog($downloadLog);

    /**
     * Get csv_name
     * @return string|null
     */
    public function getCsvName();

    /**
     * Set csv_name
     * @param string $csvName
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setCsvName($csvName);

    /**
     * Get download_type
     * @return string|null
     */
    public function getDownloadType();

    /**
     * Set download_type
     * @param string $downloadType
     * @return \Neon\Rms\Api\Data\RmsDownloadInterface
     */
    public function setDownloadType($downloadType);
}

