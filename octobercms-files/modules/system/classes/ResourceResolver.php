<?php namespace System\Classes;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

/**
 * ResourceResolver resolves objects to JSON resources.
 *
 * @method static ResourceResolver instance()
 *
 * @package october\system
 * @author Alexey Bobkov, Samuel Georges
 */
class ResourceResolver
{
    use \October\Rain\Support\Traits\Singleton;

    /**
     * resolve to the necessary JSON resource
     */
    public function resolve($resource)
    {
        if (is_scalar($resource)) {
            $resource = ['data' => $resource];
        }

        if (
            $resource instanceof Collection ||
            $resource instanceof AbstractPaginator ||
            $resource instanceof AbstractCursorPaginator
        ) {
            return new ResourceCollection($resource);
        }

        return new JsonResource($resource);
    }
}
