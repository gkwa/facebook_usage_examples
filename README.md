facebook_usage_examples
=======================
Setup
-----
Install composer to help manage Facebook PHP SDK.
```php
brew update
brew tap homebrew/homebrew-php
brew tap homebrew/dupes
brew tap homebrew/versions
brew install php55-intl
brew install homebrew/php/composer
composer install #to generate ./vendor/facebook/php-sdk-v4/src/Facebook/Facebook*.php
```

Usage
-----
```php
/usr/local/bin/php --file getUserName.php
```
```php
/usr/local/bin/php --file createTestUser.php
```
