<?php


namespace EasySwoole\WeChat\Tests\Kernel\Messages;


use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Tests\TestCase;

class MessageTest extends TestCase
{
    protected $foo;

    protected function setUp(): void
    {
        $this->foo = new class extends Message {

        };
    }

    public function testSet()
    {
        $this->foo['foo'] = true;
        $this->assertTrue($this->foo->get('foo'));
        $this->assertNull($this->foo->get('bar'));
    }

    public function testUnset()
    {
        $this->foo['foo'] = true;
        $this->assertTrue($this->foo->get('foo'));
        unset($this->foo['foo']);
        $this->assertNull($this->foo->get('foo'));
    }

    public function testGet()
    {
        $this->assertNull($this->foo->get('foo'));
        $this->foo['foo'] = true;
        $this->assertTrue($this->foo->get('foo'));
    }

    public function testExist()
    {
        $this->assertFalse(isset($this->foo['foo']));
        $this->foo['foo'] = '';
        $this->assertTrue(isset($this->foo['foo']));
        $this->foo['foo'] = false;
        $this->assertTrue(isset($this->foo['foo']));
        $this->foo['foo'] = true;
        $this->assertTrue(isset($this->foo['foo']));
    }

    public function testIterator()
    {
        $this->foo['a'] = true;
        $this->foo['b'] = true;
        $this->foo['c'] = true;
        $this->foo['d'] = true;

        $this->assertIsIterable($this->foo);

        foreach ($this->foo as $k => $v) {
            $this->assertTrue(in_array($k, ['a', 'b', 'c', 'd']));
            $this->assertTrue($v);
        }
    }
}
