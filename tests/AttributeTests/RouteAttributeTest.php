<?php

namespace Spatie\RouteAttributes\Tests\AttributeTests;

use Spatie\RouteAttributes\Tests\TestCase;
use Spatie\RouteAttributes\RouteRegistrar;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\InvokableRouteGetTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RouteGetTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RoutemiddlewareTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RoutePostTestController;
use Spatie\RouteAttributes\Tests\TestClasses\Controllers\RouteAttribute\RouteNameTestController;
use Spatie\RouteAttributes\Tests\TestClasses\middleware\Testmiddleware;

class RouteAttributeTest extends TestCase
{
    protected RouteRegistrar $routeRegistrar;

    /** @test */
    public function the_route_annotation_can_register_a_get_route_()
    {
        $this->routeRegistrar->registerClass(RouteGetTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(RouteGetTestController::class, 'myGetMethod', 'get', 'my-get-method');
    }

    /** @test */
    public function the_route_annotation_can_register_a_post_route()
    {
        $this->routeRegistrar->registerClass(RoutePostTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(RoutePostTestController::class, 'myPostMethod', 'post', 'my-post-method');
    }

    /** @test */
    public function it_can_add_middleware_to_a_method()
    {
        $this->routeRegistrar->registerClass(RoutemiddlewareTestController::class);

        $this->assertRouteRegistered(
            controller: RoutemiddlewareTestController::class,
            middleware: Testmiddleware::class,
        );
    }

    /** @test */
    public function it_can_add_a_route_name_to_a_method()
    {
        $this->routeRegistrar->registerClass(RouteNameTestController::class);

        $this->assertRouteRegistered(
            controller: RouteNameTestController::class,
            name: 'test-name',
        );
    }

    /** @test */
    public function it_can_add_a_route_for_an_invokable()
    {
        $this->routeRegistrar->registerClass(InvokableRouteGetTestController::class);

        $this
            ->assertRegisteredRoutesCount(1)
            ->assertRouteRegistered(
            controller: InvokableRouteGetTestController::class,
            controllerMethod: '__invoke',
            uri: 'my-invokable-route'
        );
    }
}
