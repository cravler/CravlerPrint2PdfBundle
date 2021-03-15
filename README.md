# CravlerPrint2PdfBundle

This bundle depends on [go-print2pdf](https://github.com/cravler/go-print2pdf).

## Installation

### Step 1: Update your vendors by running

``` bash
composer require cravler/print2pdf-bundle:dev-master
```

### Step 2: Enable the bundle (optional if you are using the Flex recipe with Symfony >= 4)

```php
<?php
// config/bundles.php
return [
    //...
    Cravler\Print2PdfBundl\CravlerPrint2PdfBundle::class => ['all' => true],
];
```

## License

This bundle is under the MIT license. See the complete license in the bundle:

```
LICENSE
```