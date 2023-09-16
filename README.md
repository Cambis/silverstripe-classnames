# Silverstripe Classnames
This package is a Silverstripe port of [php-classnames](https://github.com/newridetech/php-classnames).

## Getting started
Install the package via composer.
```sh
composer require cambis/silverstripe-classnames
```

## Usage
This package provides the `$Classnames` (alias `$Cn`) method for use Silverstripe templates.
Arguments must be parsed as a JSON encoded array.

One way to accomplish this is to create a function that returns the appropriate encoded values,
i.e. `getClassnames()`.

```php
<?php

use JsonSerializable;
use SilverStripe\ORM\DataObject;

class MyObject extends DataObject implements JsonSerializable
{
    public function getClassnames(): string
    {
        return json_encode($this);
    }

    public function jsonSerialize(): mixed
    {
        return [
            ['foo' => true],
            'bar',
        ];
    }
}
```

Then call the function in your template file.

```html
<!-- MyObject.ss -->
<p class="{$Cn($Classnames)}">Classnames</p>
```
