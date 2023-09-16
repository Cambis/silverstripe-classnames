<?php

namespace Cambis\Classnames\Tests\View;

use JsonSerializable;
use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;

class TestObject extends DataObject implements JsonSerializable, TestOnly
{
    public function getClassnames(): string
    {
        return json_encode($this);
    }

    public function jsonSerialize()
    {
        return [
            ['foo' => true],
            'bar',
        ];
    }
}
