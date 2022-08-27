<?php

namespace WeltenretterDev\WPFramework\ViewModel;

use Illuminate\Support\Collection;
use WeltenretterDev\WPFramework\Contracts\HasRenderTemplate;
use WeltenretterDev\WPFramework\Contracts\TranslatesToArray;

/**
 * A ViewModel represents a simplified data structure that creates a context to be used in
 * a render engine. This class is usable for every render engine that uses arrays as context,
 * in this case twig. Other Engines are usable too.
 *
 * ### Conventions
 *
 * Each ViewModel should create an array with the following structure:
 *
 * ```
 * ["fields" => "all the fields that get used in the viewmodel",
 * "template" => "a location/reference to the template file"]
 * ```
 *
 * this class helps you with achieving this. Extend this class and call this constructor
 * (using parent::__construct) and pass the fields that the ViewModel should contain.
 * Your ViewModels should be immutable and shouldnt be changed after they got created.
 *
 * Because we create ViewModels that in the end get used in HTML components, this class also has
 * additional functions to append CSS Class names.
 *
 * @author Florian Hustede, Weltenretter UG @ 2022
 * @since 1.0
 *
 */
class RenderableViewModel implements TranslatesToArray, HasRenderTemplate
{
    private Collection $fields;
    private array $classes;

    private string $templatePath = "";

    /**
     * __construct
     *
     * @param  array $fields the fields that will be added to the context array
     * @param  array $baseClasses the css classes that every viewModel should contain
     * @param  string $templatePath path to the template (detail depends on render implementation and
     * how its configured)
     * @return void
     */
    public function __construct(array $fields = [], array $baseClasses = [], string $templatePath = "")
    {
        $this->fields = $this->prepareFields($fields);
        $this->classes = $baseClasses;
        $this->templatePath = $templatePath;
    }

    protected function prepareFields(array $fields): Collection
    {
        return collect($fields);
    }

    /**
     * addCSSClass
     *
     * @param  mixed $className
     * @return void
     *
     * @ignoreCodeCoverage
     */
    private function addCSSClass(string $className)
    {
        $this->classes[] = $className;
    }

    private function getFields(): Collection
    {
        $filteredFields = $this->fields;

        // Fields always get a class array appended
        $filteredFields->put("classes", $this->classes);

        return $filteredFields;
    }

    final public function toArray(): array
    {
        return [
            "template" => $this->getTemplatePath(),
            "fields" => $this->getFields()->toArray()
        ];
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }
}
