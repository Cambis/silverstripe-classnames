<?php

namespace Cambis\Classnames\View;

use InvalidArgumentException;
use JsonException;
use Newride\Classnames\Classnames;
use SilverStripe\View\TemplateGlobalProvider;

class ClassnamesTemplateProvider implements TemplateGlobalProvider
{
    public static function get_template_global_variables(): array
    {
        return [
            'Cn' => [
                'method' => 'classnames',
                'casting' => 'HTMLText',
            ],
        ];
    }

    public static function classnames(string $classnames): string
    {
        try {
            $decoded = json_decode(html_entity_decode($classnames), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Argument must be a valid JSON object!');
        }

        return Classnames::make(...$decoded);
    }
}
