<?php

namespace WeltenretterDev\WPFramework\Test\ViewModel;

use PHPUnit\Framework\TestCase;
use DI\Container;
use WeltenretterDev\WPFramework\Contracts\ResolvesContext;
use WeltenretterDev\WPFramework\Contracts\ResolvesResponse;
use WeltenretterDev\WPFramework\Controller\WPBaseController;

class WPBaseControllerTest extends TestCase
{
    public function testBaseController()
    {
        $container = new Container();

        $mockResolve = $this->getMockBuilder(ResolvesContext::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockResponse = $this->getMockBuilder(ResolvesResponse::class)
            // ->addMethods(["resolveResponse"])
            ->disableOriginalConstructor()
            ->getMock();

        $mockResponse->method("resolveResponse")->withAnyParameters()->willReturn("");
        $mockResolve->method("resolve")->willReturn([]);

        $container->set(ResponseResolver::class, $mockResponse);
        $container->set(ContextResolver::class, $mockResolve);

        $instance = $this->getMockForAbstractClass(WPBaseController::class);
        $instance->method("getDIContainer")->willReturn($container);

        $this->assertNotNull($instance->handle());
    }

    public function testBaseControllerWpDependentFunctionsWithoutWp()
    {
        $mockResolve = $this->getMockBuilder(ResolvesContext::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockResponse = $this->getMockBuilder(ResolvesResponse::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockResponse->method("resolveResponse")->willReturn("I am resolved template code.");
        $mockResolve->method("resolve")->willReturn([]);

        $container = new Container();
        $container->set(ResolvesResponse::class, $mockResponse);
        $container->set(ResolvesContext::class, $mockResolve);

        $instance = $this->getMockForAbstractClass(WPBaseController::class);
        $instance->method("getDIContainer")->willReturn($container);
        $instance->method("getPageTitle")->willReturn("lorem ipsum");

        $this->assertNotNull($instance->handle());
    }
}
