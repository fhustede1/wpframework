<?php

namespace WeltenretterDev\WPFramework\Controller;

use Illuminate\Support\Collection;
use WeltenretterDev\WPFramework\Contracts\ResolvesContext;
use WeltenretterDev\WPFramework\Contracts\ResolvesResponse;

/**
 * WPBaseController
 *
 * Provides an object-oriented approach to a generalized Wordpress Page Controller.
 *
 * The BaseController needs to be extended by every Controller in the project that wants to utilize its
 * features. the BaseController handles a lot of repetitive stuff regarding lumberjacks and timbers way
 * of working with the Wordpress Template Hierarchy.
 *
 * To get a Controller to work you just need to override the functions getPageTitle() and getTemplate().
 * WPBaseController uses twig to compile its view and creates a PSR-compatible HTTP response using TimberResponse.
 * There are a few debug functionalities that you can utilize in the development of the frontend.
 *
 * WPBaseController does depend on a DI container. This makes it possible to use unit tests and
 * mock relevant functions that would be dependable on our framework integration of Timber/Lumberjack otherwise.
 *
 * To use it inside of Wordpress/our Framework, extend LumberjackBaseController instead, or define your own
 * DI container to use. Please dont forget to bind the corresponding Resolvers to get Context and expose
 * a PSR-compliant response towards an webserver.
 *
 * @author Florian Hustede
 *
 * @since 1.0 initial version of WPBaseController
 * @since 2.0 improved WPBaseController-Version, reduce function complexity, capsulate external dependencies
 */
abstract class WPBaseController
{
    abstract public function getDIContainer();

    /**
     * basic function to handle the controller beeing executed by the Wordpress Template Hierarchy
     */
    final public function handle()
    {
        // call the init function for customized controller behavior
        $this->init();

        $context = $this->getContext();

        $wpResponseResolver = $this->getDIContainer()->get(ResolvesResponse::class);

        return $wpResponseResolver->resolveResponse($context, $this->getTemplate());
    }

    /**
     * gets the context to be used by the rendering engine to render the view.
     *
     * needs to have a defined ContextResolver via Dependency Injection.
     *
     * if you want to modify the context, please use prepareContext() in the controller.
     *
     * @since 0.1 initial commit
     * @since 0.2 now uses DI containers, ContextResolver to capsulate the dependencies.
     *
     * @return null|array context array to be used inside a templating engine
     * @internal
     */
    protected function getContext(): ?array
    {

        $resolvedContext = $this->getDIContainer()->get(ResolvesContext::class);

        $context = collect($resolvedContext->resolve());

        $context = $this->prepareContext($context);

        $title = $this->getPageTitle();
        if ($title) {
            $context->put("header_title", $title);
        }

        return $context->all();
    }

    abstract public function getPageTitle(): ?string;

    abstract public function getTemplate(): ?string;

    abstract public function prepareContext(Collection $context): Collection;

    public function init()
    {
    }
}
