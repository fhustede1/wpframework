<?php

namespace WeltenretterDev\WPFramework\Test\ViewModel;

use PHPUnit\Framework\TestCase;
use WeltenretterDev\WPFramework\ViewModel\RenderableViewModel;

class RenderableViewModelTest extends TestCase
{
    public function testCreatesWellFormedContextArray()
    {
        $rendViewModel = new RenderableViewModel(["lorem" => "ipsum"], ["init-class"]);

        dump($rendViewModel->toArray());

        $array = $rendViewModel->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey("fields", $array);
        $this->assertArrayHasKey("template", $array);

        // check fields sub array, has to include "class" key at default
        $fields = $array["fields"];

        $this->assertIsArray($fields);
        $this->assertArrayHasKey("classes", $fields);
        $this->assertArrayHasKey("lorem", $fields);
        $this->assertEquals("ipsum", $fields["lorem"]);
        $this->assertEquals(["init-class"], $fields["classes"]);
    }
}
