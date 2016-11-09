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

    public function build(Mapper $mapper)
    {
        switch ($mapper->getQueryType()) {
            case Mapper::QUERY_TYPE_SINGLE:
                $mapper = $this->buildSingle($mapper);
                break;

            case Mapper::QUERY_TYPE_MULTIPLE:
                $mapper = $this->buildMultiple($mapper);
                break;
        }

        foreach ($mapper->getChildren() as $child) {
            $this->build($child);
        }
    }

    protected function buildSingle(Mapper $mapper)
    {
        if (! $query = app('build.bauhaus.query')) {
            $mapper->set('value', $mapper->get('default'));

            return $mapper;
        }

        if ($mapper->has('name')
            && (! $query instanceof Collection
            && ! $query instanceof LengthAwarePaginator)) {

            if (is_array($query)) {
                $query = (object) $query;
            }

            $value = $query->{$mapper->get('name')};

            if (is_object($value)) {
                $values = [];

                foreach ($value->lists('id') as $v) {
                    $values[$v] = $v;
                }

                $value = $values;
            }

            $mapper->set('value', $value);
        }

        return $mapper;
    }

    protected function buildMultiple(Mapper $mapper)
    {
        $rows = collect();
        $query = app('build.bauhaus.query');

        if ($query instanceof LengthAwarePaginator) {
            $mapper->isPaginated = true;
        }

        foreach ($query as $id => $entry) {
            if (is_array($entry)) {
                $key = $id;

                // Cast the entry to an object. This will make
                // our life easier in a couple of steps.
                $entry = (object) $entry;
            } else {
                $key = $entry->getKey();
            }

            $row = (new Row)->setKey($key);

            foreach ($mapper->getChildren() as $child) {
                $clone = clone($child);
                $clone->setRow($entry);

                foreach ($clone->getProperties() as $key => $value) {
                    if ($value instanceof \Closure) {
                        $clone->set($key, $value($clone));
                    }
                }

                if ($clone->has('name')) {
                    $clone->set('value', $this->getValue($clone, $entry));

                    $row->put($clone->get('name'), $clone);
                } else {
                    $row->push($clone);
                }
            }

            $rows->put($id, $row);
        }

        $mapper->rows = $rows;

        return $mapper;
    }

    protected function getValue($clone, $entry)
    {
        if (! $clone->has('value')) {
            return $entry->{$clone->get('name')};
        }

        $value = $clone->get('vakue');

        if (is_callable($value)) {
            return $value($clone);
        }

        return $value;
    }
}