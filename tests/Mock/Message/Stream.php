<?php

namespace EasySwoole\WeChat\Tests\Mock\Message;


use EasySwoole\Spl\SplStream;
use Psr\Http\Message\StreamInterface;

class Stream extends SplStream implements StreamInterface
{

}