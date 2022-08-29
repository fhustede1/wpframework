<?php

namespace WeltenretterDev\WPFramework\ViewModel;

use Illuminate\Support\Collection;
use WeltenretterDev\WPFramework\Contracts\CanIterateViewModels;
use WeltenretterDev\WPFramework\Contracts\TransformableModel;
use WeltenretterDev\WPFramework\Contracts\TranslatesToArray;

/**
 * this Iterator handles the creation of ViewModels from a collection of models.
 *
 * ### Motivation
 *
 * most of the time, we dont need to create only one viewmodel but from a list of models (for example
 * a list of posts that are represented each by a model object). often, they need to be "chained", because
 * inner properties of these models themselves need to be translated to a viewmodel first (for example Categories
 * inside a post). An Iterator can provide a streamlined and - more importantly - standarized way to create a list of
 * ViewModels from complex model objects.
 *
 * ### Working with iterators
 *
 * each model object that you want to create a list of viewmodels for need to have its own iterator. Simply extend this
 * class and configure the createViewModel-Function. This function takes any model object that implements the
 * TransformableModel contract and creates a ViewModel from it. If you need to use a more elaborate contract, you can
 * also extend a Transformable<Context>Model contract that has access to the additional fields configured in the model
 * object. because PHP cant do generalized classes, its recommended to add a type check for the specific
 * TransformableModel-extension to use inside the createViewModel-Function.
 *
 * to use an iterator you need to pass the itemClassString, because to ensure type safety this class also checks
 * that it only produces a collection of viewmodels for one specific or derived view model type.
 *
 * ### Example
 *
 * in this example, we use the TransformablePostModel contract that says every model object has the function category().
 * category itself is a model that we need to translate to viewmodels inside the viewmodel of the post ("chaining").
 *
 * so at first we create the PostViewModelIterator:
 *
 * ```
 * class PostViewModelIterator extends BasicViewModelIterator {
 *
 *      public function createViewModel(TransformableModel $item): TranslatesToArray {
 *
 *          // we need to check the specificity of the model passed through here,
 *          // especially to get IDE support
 *          if ($item instanceof TransformablePostModel) {
 *
 *              // now we can access the categories() function
 *              $categories = $item->categories();
 *
 *              // using the collection helpers, we create a collection from the array
 *              $categories = collect($categories);
 *
 *              // in this case, we will manually iterate over the category model.
 *              // if you were paying attention, you realize that you could use an iterator
 *              // for categories too - we will use a simplified approach here
 *              $cat_vm = array();
 *
 *              $categories->map(function($item) {
 *                  $cat_vm = new CategoryViewModel($item->name());
 *
 *                  // ...
 *              });
 *
 *              return new SinglePostViewModel($item->name(), $cat_vm->toArray());
 *          }
 *      }
 * }
 * ```
 *
 * after that, we can use iterate() to create a list of viewmodels based on post model objects and also chain ViewModels
 * that come from internal model types inside the "master" of the post model object.
 *
 * @author Florian Hustede @ Weltenretter UG, 2022
 * @since 1.0
 */
abstract class BasicViewModelIterator implements CanIterateViewModels
{
    private $itemClassString;
    private $items;

    public function __construct($itemClassString)
    {
        $this->itemClassString = $itemClassString;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function checkTypeAndCreateViewModel($item): ?array
    {
        if ($this->checkType($item)) {
            $vm = $this->createViewModel($item);
            return $vm->toArray();
        }

        return null;
    }

    public function checkType($item): bool
    {
        if ($item instanceof $this->itemClassString) {
            return true;
        }

        return false;
    }

    public function iterate(): ?Collection
    {
        $items  = $this->items;
        $viewmodels = null;

        if (!empty($items)) {
            $items = collect($items);

            $viewmodels = $items->map(function ($item) {
                return $this->checkTypeAndCreateViewModel($item);
            });

            return $viewmodels;
        }

        return null;
    }


    abstract protected function createViewModel(TransformableModel $item): TranslatesToArray;
}
