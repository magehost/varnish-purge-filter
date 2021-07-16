Varnish Purge Filter Extension for Magento 2
=====================

The free Varnish Purge Filter Extension by [MageHost.pro](https://magehost.pro) adds an option to filter purges for specific tags.
This extension is useful to prevent shop admins from busting the cache on important moments.

# Install via Composer #

```
composer require magehost/varnish-purge-filter
php bin/magento module:enable MageHost_VarnishPurgeFilter
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

# Usage #

* In Admin go to *Stores > Configuration > Advanced > System > Full Page Cache*.

# Uninstall #
```
php bin/magento module:disable MageHost_VarnishPurgeFilter
composer remove magehost/varnish-purge-filter
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

# Description #
**This extension is free, licence: [MIT](https://github.com/magehost/varnish-purge-filter/blob/master/LICENSE).**

During black friday, we noticed unnecessary pressure on some environments caused by too much purges.  
These purges are often caused by imports or shop admins changing thing last minute.  
Preventing the purges is often crucial for the health of your environment.  
