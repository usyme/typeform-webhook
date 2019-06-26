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

namespace Usyme\Typeform\Webhook\Model;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

abstract class AbstractObject implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array
     */
    protected static $oneObjectMap = [];

    /**
     * @var array
     */
    protected static $manyObjectsMap = [];

    /**
     * @var array
     */
    protected $elements = [];

    /**
     * AbstractObject constructor.
     *
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $this->convert($elements);
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->elements[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->elements;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return array_key_exists($key, $this->elements);
    }

    /**
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->elements[$key];
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function offsetSet($key, $value)
    {
        if ($key !== null) {
            $this->elements[$key] = $value;
        } else {
            $this->elements[] = $value;
        }
    }

    /**
     * @param string $key
     */
    public function offsetUnset($key)
    {
        unset($this->elements[$key]);
    }

    /**
     * @param int $options
     *
     * @return string
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function convert(array $data): array
    {
        // Mapping one object
        foreach ($data as $key => $item) {
            if (!isset(static::$oneObjectMap[$key])) {
                continue;
            }

            $data[$key] = new static::$oneObjectMap[$key]($item ?: []);
        }

        // Mapping many objects
        foreach ($data as $key => $items) {
            if (!isset(static::$manyObjectsMap[$key])) {
                continue;
            }

            if (is_array($items)) {
                foreach ($items as $k1 => $item) {
                    $data[$key][$k1] = new static::$manyObjectsMap[$key]($item ?: []);
                }
            }
        }

        return $data;
    }
}