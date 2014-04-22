<?php

namespace Benijaco\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testOk()
    {
        $this->assertEquals(0, 0);
    }

    public function testKo()
    {
        $this->assertEquals(1, 0);
    }
}
