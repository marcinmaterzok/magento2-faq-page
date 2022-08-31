# Magento 2 FAQ Page

## 1. Documentation

- [Contribute on Github](https://github.com/marcinmaterzok/magento2-faq-page/)
- [Releases](https://github.com/marcinmaterzok/magento2-faq-page/releases)

## 2. How to install

### Install via composer (recommend)
Run the following command in Magento 2 root folder:

Without GraphQL:

```
composer require mtrzk/magento2-faqpage
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

With GraphQL (Support PWA):

```
composer require mtrzk/magento2-faqpage mtrzk/magento2-faqpage-graphql
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## CHANGELOG
Version 1.0.1

```
- Added README
```

Version 1.0.0

```
- First commit
- Added support for multistore
- Added adminhtml panel
- Added adminhtml panel
```
