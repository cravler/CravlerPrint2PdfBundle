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

## Usage

```php
<?php
$defaultOptions = array(
    'timeout' => 0,
    'landscape' => false,
    'print_background' => false,
    'scale' => 1,
    'paper_width' => 8.5,
    'paper_height' => 11,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_left' => 0,
    'margin_right' => 0,
    'prefer_css_page_size' => false,
    'page_ranges' => '',
    'ignore_invalid_page_ranges' => false,
    'header_template' => '',
    'footer_template' => '',
    'display_header_footer' => false,
);
$print2Pdf = $container->get('Cravler\Print2PdfBundle\Service\Print2Pdf');
$pdf = $print2Pdf->generate($url, $defaultOptions);
$pdf = $print2Pdf->generateFromHtml($html, $defaultOptions);
```

## Dockerfile

```dockerfile
ARG PHP_TAG=8
ARG PRINT2PDF_VERSION=0.1.0

FROM chromedp/headless-shell:stable AS headless-shell

FROM php:${PHP_TAG}

ARG PRINT2PDF_VERSION

# Install chrome headless-shell
ENV PATH /headless-shell:${PATH}
COPY --from=headless-shell /headless-shell /headless-shell

RUN \
# All our dependencies, in alphabetical order (to ease maintenance)
    apt-get update && apt-get install -y \
        dumb-init \
        libexpat1 \
        libfontconfig1 \
        libnspr4 \
        libnss3 \
        libuuid1 \
        wget && \
\
# Remove cache
    apt-get clean && rm -rf /var/lib/apt/lists/* && \
\
# Install print2pdf
    wget \
        https://github.com/cravler/go-print2pdf/releases/download/${PRINT2PDF_VERSION}/print2pdf_linux_amd64.tar.gz \
        -O /tmp/print2pdf.tar.gz && \
    tar --totals -xzf /tmp/print2pdf.tar.gz \
        -C /usr/local/bin print2pdf && \
    rm /tmp/print2pdf.tar.gz && \
    chmod +x /usr/local/bin/print2pdf

ENTRYPOINT ["dumb-init", "--", "docker-php-entrypoint"]
```

## License

This bundle is under the MIT license. See the complete license in the bundle:

```
LICENSE
```