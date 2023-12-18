# Magento2 Hreflang management module <img src="https://avatars.githubusercontent.com/u/168457?s=40&v=4" alt="magento" /> 

## Features
This modules adds
- homepage
- cms pages
- product pages
- category pages

aternate urls management.

## Compatibility
Fully tested and working on Magento CE(EE) 2.4.4, 2.4.5, 2.4.6

## Installation
You can install this module adding it on app/code folder or with composer.
```
composer require dadolun95/magento2-hreflang
```
Then you'll need to enable the module and update your database and files:
```
php bin/magento module:enable Dadolun_Hreflang
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

##### CONFIGURATION
You must enable the module from "Stores > Configurations > Dadolun > Alternate Urls Management" section adding your locale codes specified by website/store view scope.

#### EXTENSION
You can add multiple controllers/url retrievers configurations mapping other scenarios trough Dependency injection.
Create a new module with Dadolun_Hreflang on module.xml sequence, then add your di.xml like this:
```
<?xml version="1.0"?>

<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
    <type name="Dadolun\Hreflang\Model\Retriever\HreflangService">
        <arguments>
            <argument name="retrievers" xsi:type="array">
                <item name="other_controller_path" xsi:type="object">Vendor\Module\Model\Retriever\OtherScenarioHreflangRetriever</item>
            </argument>
        </arguments>
    </type>
</config>
```

## Contributing
Contributions are very welcome. In order to contribute, please fork this repository and submit a [pull request](https://docs.github.com/en/free-pro-team@latest/github/collaborating-with-issues-and-pull-requests/creating-a-pull-request).
