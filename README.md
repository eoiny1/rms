# Mage2 Module Neon Rms

    ``neon/module-rms``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Magento RMS Connector 

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Neon`
 - Enable the module by running `php bin/magento module:enable Neon_Rms`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require neon/module-rms`
 - enable the module by running `php bin/magento module:enable Neon_Rms`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - Secret Key (rms/api_settings/secret_key)

 - Access Identifier (rms/api_settings/access_identifier)

 - Database Name (rms/api_settings/database_name)

 - database_server (rms/api_settings/database_server)

 - Database Login Name (rms/api_settings/database_login_name)

 - Database Password (rms/api_settings/database_login_password)

 - RMS Type (rms/api_settings/rms_type)

 - InstanceName (rms/api_settings/instance_name)

 - Endpoint (rms/api_settings/api_endpoint)

 - Post URL (rms/api_settings/post_url)

 - Peek URL (rms/api_settings/peek_url)


## Specifications

 - Helper
	- Neon\Rms\Helper\Config


## Attributes



