# Html to PDFlib

An extendable library to convert HTML-Content to text 
usable with textflows of [PDFlib](http://pdflib.com)

## Installation

Via [composer](https://getcomposer.org) like this:

```json
{
    "name": "my/project",
    "repositories": [
        {
            "url": "https://github.com/NRCommunication/htmltopdflib.git",
            "type": "vcs"
        }
    ],
    "require": {
        "org_heigl/html-to-pdflib": "0.1"
    },
    "require-dev": {
    }
}
```

## Usage

In your PHP-Code you can use the package like this:

```php
<?php

use Org_Heigl\HtmlToPdflib\Converter as Converter;

$converter = new Converter();

// configure sanitizer
$converter->setAllowedTags([
    '<b>',
    '<i>
]);

// building content
$converter->build('Lorem <b>ipsum dolor</b> sit amet, <i>sed lectus</i> nec ultricies');

// add style rules
$styleProvider = $this->converter->getStyleProvider();

// setting default properties
// mixed with further rules
$styleProvider->setDefaultProperties([
    'encoding' => 'utf8',
    'italicangle' => 0,
    'fontname' => 'Helvetica',
    'fontsize' => 11
]);

// applying rules
$styleProvider
->applyRule('b, strong', [
    'fontname' => 'Helvetica-Bold'
])
->applyRule('i', [
    'italicangle' => -12
]);

echo $converter->convert();
```

result: 

```html
<macro { 
    m0 { encoding=utf8 italicangle=0 fontname=Helvetica-Bold fontsize=11 } 
    m1 { encoding=utf8 italicangle=-12 fontname=Helvetica fontsize=11 } 
}>Lorem <&m0>ipsum dolor sit amet, <&m1>sed lectus nec ultricies
```

## Contributing

Contributions are welcome!

## License

This package is licensed unter the MIT-License.
