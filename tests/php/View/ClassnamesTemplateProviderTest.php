<?php

namespace Cambis\Classnames\Tests\View;

use Cambis\Classnames\View\ClassnamesTemplateProvider;
use InvalidArgumentException;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\View\ArrayData;
use SilverStripe\View\SSViewer;

class ClassnamesTemplateProviderTest extends SapphireTest
{
    public function testTemplateProviderHasKey(): void
    {
        $this->assertArrayHasKey(
            'Cn',
            ClassnamesTemplateProvider::get_template_global_variables(),
        );
    }

    public function validClassNamesDataProvider(): array
    {
        return [
            ['foo bar', ['foo', 'bar']],
            ['foo bar', ['foo', ['bar' => true]]],
            ['foo-bar', [['foo-bar' => true]]],
            ['', [['foo-bar' => false]]],
            ['foo bar', [['foo' => true], ['bar' => true]]],
            ['foo bar', [['foo' => true, 'bar' => true]]],
            ['foo bar', ['foo', 'foo', 'bar']],
            ['1 2 3', [1, 2, 3]],
            ['foo', [null, false, '', 'foo']],
        ];
    }

    /**
     * @dataProvider validClassNamesDataProvider
     */
    public function testValidClassnames(string $expected, array $classnames): void
    {
        // Render template
        $template = SSViewer::execute_string(
            "\$Cn(\$Classnames)",
            ArrayData::create([
                'Classnames' => json_encode($classnames)
            ])
        );

        // Assert that the template rendered the expected value
        $this->assertEquals($expected, $template);
    }

    public function testViewableData(): void
    {
        $object = TestObject::create();

        // Render template
        $template = SSViewer::execute_string(
            "<p class=\"{\$Cn(\$TestObject.Classnames)}\"></p>",
            ArrayData::create([
                'TestObject' => $object
            ])
        );

        // Assert that the template rendered the expected value
        $this->assertEquals('<p class="foo bar"></p>', $template);
    }

    public function testInvalidArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);

        SSViewer::execute_string(
            "\$Cn(\$Classnames)",
            ArrayData::create([
                'Classnames' => 'foo bar'
            ])
        );
    }
}
