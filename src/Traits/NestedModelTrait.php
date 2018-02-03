<?php


namespace Webfactor\Laravel\Backpack\NestedModels\Traits;

use Kalnoy\Nestedset\Collection;
use Kalnoy\Nestedset\NodeTrait;

trait NestedModelTrait
{
    use NodeTrait;

    /**
     * Build the collection representing the tree with possibly many root nodes
     *
     * @param Collection|null $nodes
     * @return Collection
     */
    public static function loadTree(Collection $nodes = null)
    {
        $nodes = $nodes ?? static::all();

        return $nodes->where((new static)->getParentIdName(), null)
            ->values()
            ->each(function ($item) use ($nodes) {
                $nodes->toTree($item);
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Kalnoy/NestedSet
    |--------------------------------------------------------------------------
    |
    | Overwrite the default tree columns here to fit with backpack reorder
    */

    public function getLftName()
    {
        return 'lft';
    }

    public function getRgtName()
    {
        return 'rgt';
    }

    public function getParentIdName()
    {
        return 'parent_id';
    }
}
