<?php
/**
 * This file is part of the CosaVostra, Usyme package.
 *
 * (c) Mohamed Radhi GUENNICHI <rg@mate.tn> <+216 50 711 816>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Usyme\Typeform\Webhook\Tests\Model;

use PHPUnit\Framework\TestCase;
use Usyme\Typeform\Webhook\Model\AbstractObject;

class AbstractObjectTest extends TestCase
{
    public function test_simple_object(): void
    {
        $object = new SimpleObject([
            'foo' => 'bar'
        ]);

        $this->assertEquals('bar', $object->getFoo());
    }

    public function test_object_one_mapping(): void
    {
        $object = new ObjectOneMapping([
            'element' => [
                'foo' => 'bar'
            ]
        ]);

        $this->assertInstanceOf(SimpleObject::class, $object->getElement());
        $this->assertEquals($object->getElement()->getFoo(), 'bar');
    }

    public function test_object_many_mapping(): void
    {
        $object = new ObjectManyMapping([
            'items' => [
                [
                    'element' => ['foo' => 'bar']
                ],
                [
                    'element' => ['foo' => 'bee']
                ]
            ]
        ]);

        $this->assertIsArray($items = $object->getItems());

        $this->assertCount(2, $items);

        $this->assertInstanceOf(ObjectOneMapping::class, $items[0]);
        $this->assertInstanceOf(ObjectOneMapping::class, $items[1]);

        /**
         * @var ObjectOneMapping[] $items
         */
        $this->assertInstanceOf(SimpleObject::class, $element1 = $items[0]->getElement());
        $this->assertInstanceOf(SimpleObject::class, $element2 = $items[1]->getElement());

        $this->assertEquals('bar', $element1->getFoo());
        $this->assertEquals('bee', $element2->getFoo());
    }
}

class SimpleObject extends AbstractObject
{
    public function getFoo(): ?string
    {
        return $this->get('foo');
    }
}

class ObjectOneMapping extends AbstractObject
{
    protected static $oneObjectMap = [
        'element' => SimpleObject::class
    ];

    public function getElement(): ?SimpleObject
    {
        return $this->get('element');
    }
}

class ObjectManyMapping extends AbstractObject
{
    protected static $manyObjectsMap = [
        'items' => ObjectOneMapping::class
    ];

    public function getItems(): ?array
    {
        return $this->get('items');
    }
}