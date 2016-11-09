<?php

namespace Build\Core\Bauhaus;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Collection;
use Build\Core\Bauhaus\Support\Row;
use Illuminate\Pagination\LengthAwarePaginator;

class Builder
{

    /**
     * Bind the mapped instance directly on the query.
     *
     * @param  Mapper  $mapper
     */
    public function build(Mapper $mapper)
    {
        switch ($mapper->getQueryType()) {
            // Build a single resultset. This happens when e.g. we're rendering forms.
            case Mapper::QUERY_TYPE_SINGLE:
                $mapper = $this->buildSingle($mapper);
                break;

            // In some cases it's needed to run a more 'complex' builder method that
            // builds each row of the query instead of just one single result.
            case Mapper::QUERY_TYPE_MULTIPLE:
                $mapper = $this->buildMultiple($mapper);
                break;
        }

        // For each child, we'll need to call the `build` method too...
        foreach ($mapper->getChildren() as $child) {
            $this->build($child);
        }
    }

    protected function buildSingle(Mapper $mapper)
    {
        // We do not have a query set. But we don't need one
        // when we've set the default value on a widget.
        if (! $query = app('build.bauhaus.query')) {
            $mapper->set('value', $mapper->get('default'));

            return $mapper;
        }

        // When the query is not a collection and not 'paginateable'
        // we can go ahead and build this query as a single row.
        if ($mapper->has('name')
            && (! $query instanceof Collection && ! $query instanceof LengthAwarePaginator)) {

            // It's possible to throw in an array as a query so when
            // that happens, we need to convert it to an object.
            if (is_array($query)) {
                $query = (object) $query;
            }

            // Get the value from the query.
            $value = $query->{$mapper->get('name')};

            // In case the value is an object (e.g. a multi select) we'll
            // need to fetch the array of id's and use them as the value.
            if (is_object($value)) {
                $value = $value->lists('id');
            }

            $mapper->set('value', $value);
        }

        return $mapper;
    }

    protected function buildMultiple(Mapper $mapper)
    {
        $rows = collect();
        $query = app('build.bauhaus.query');

        // When the query is an instance of `LengthAwarePaginator` we
        // can be very sure we'll need this result to be paginated.
        if ($query instanceof LengthAwarePaginator) {
            $mapper->isPaginated = true;
        }

        // Loop over each row in the query.
        foreach ($query as $id => $entry) {

            // When the entry is an array we don't have any method to
            // fetch the key from this row so we'll use the array key.
            if (is_array($entry)) {
                $key = $id;

                // Cast the entry to an object. This will make
                // our life easier in a couple of steps.
                $entry = (object) $entry;
            } else {
                $key = $entry->getKey();
            }

            $row = (new Row)->setKey($key);

            // Alright, we're ready for business... Let's run over each
            // mapped child and map the values we find on the current.
            // row (no real children were harmed in the process).
            foreach ($mapper->getChildren() as $child) {
                $clone = clone($child);
                $clone->setRow($entry);

                foreach ($clone->getProperties() as $key => $value) {
                    // When a closure is given we'll just execute it and
                    // set the returned value on the current property.
                    if ($value instanceof \Closure) {
                        $clone->set($key, $value($clone));
                    }
                }

                // When the field has a name we can try
                // to get the value by this name.
                if ($clone->has('name')) {
                    $name = $clone->get('name');

                    // If there's no value set we'll try to directly
                    // get the value from the entry by field name.
                    if (! $clone->has('value')) {
                        $value = $entry->{$name};
                    } else {
                        $value = $clone->get('value');

                        if (is_callable($value)) {
                            $value = $value($clone);
                        }
                    }

                    $clone->set('value', $value);

                    $row->put($name, $clone);
                } else {
                    $row->push($clone);
                }
            }

            $rows->put($id, $row);
        }

        $mapper->rows = $rows;

        return $mapper;
    }
}
