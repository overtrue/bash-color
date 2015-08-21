<?php

use Overtrue\BashColor\BashColor;

date_default_timezone_set('PRC');

class BaseColorTest extends PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $this->assertEquals("string", BashColor::render('string'));
        $this->assertEquals("\033[0;49;39mstring\033[0m", BashColor::render('<fg>string</>'));
        $this->assertEquals("\033[0;49;39mstring\033[0m", BashColor::render('< >string</>'));
        $this->assertEquals("\033[0;49;39mstring\033[0m", BashColor::render('<fg=>string</>'));

        $this->assertEquals("\033[0;49;32mstring\033[0m", BashColor::render('<fg=green>string</>'));

        $this->assertEquals("\033[0;42;39mstring\033[0m", BashColor::render('<bg=green>string</>'));
        $this->assertEquals("\033[0;42;39mstring\033[0m", BashColor::render('<bg=Green>string</>'));
        $this->assertEquals("\033[0;49;96mstring\033[0m", BashColor::render('<fg=LightCyan>string</>'));

        $this->assertEquals("\033[1;49;39mstring\033[21m", BashColor::render('<opt=bold>string</>'));

        $this->assertEquals("\033[1;42;39mstring\033[21m", BashColor::render('<bg=green;opt=bold>string</>'));

        $this->assertEquals("\033[1;42;31mstring\033[21m", BashColor::render('<bg=green;fg=red;opt=bold>string</>'));

        $this->assertEquals("\033[1;42;31mstring\033[21m", BashColor::render('<bg=green; fg=red; opt=bold>string</>'));
        $this->assertEquals("\033[1;42;31mstring\033[21m", BashColor::render('<fg=red;bg=green;  opt=bold>string</>'));


        // bad color
        $this->assertEquals("\033[1;42;39mstring\033[21m", BashColor::render('<fg=foo;bg=green;  opt=bold>string</>'));
        $this->assertEquals("\033[1;49;39mstring\033[21m", BashColor::render('<fg=foo;bg=bar;  opt=bold>string</>'));
        $this->assertEquals("\033[0;49;39mstring\033[0m", BashColor::render('<fg=foo;bg=bar;  opt=hshshs>string</>'));


        // validate regex
        $this->assertEquals("\033[1;42;31mstring<div>\033[21m", BashColor::render('<bg=green;fg=red;opt=bold>string<div></>'));
        $this->assertEquals("\033[1;42;31mstring</div>\033[21m", BashColor::render('<bg=green;fg=red;opt=bold>string</div></>'));
    }

    public function testGetForegroundColors()
    {
        $this->assertEquals(19, count(BashColor::getForegroundColors()));
        $this->assertContains('default', BashColor::getForegroundColors());
        $this->assertContains('light_green', BashColor::getForegroundColors());
        $this->assertContains('white', BashColor::getForegroundColors());
    }

    public function testGetBackgroundColors()
    {
        $this->assertEquals(19, count(BashColor::getBackgroundColors()));
        $this->assertContains('default', BashColor::getBackgroundColors());
        $this->assertContains('light_green', BashColor::getBackgroundColors());
    }
}