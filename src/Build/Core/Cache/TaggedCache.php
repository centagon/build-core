<?php

namespace Build\Core\Cache;

class TaggedCache extends \Illuminate\Cache\TaggedCache
{
    /** {@inheritdoc} */
    public function taggedItemKey($key): string
    {
        return $this->tags->getNamespace().$this->store->separator.$key;
    }

    /** {@inheritdoc} */
    protected function itemKey($key): string
    {
        return $this->taggedItemKey($key);
    }
}
