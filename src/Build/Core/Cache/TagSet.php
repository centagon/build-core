<?php

namespace Build\Core\Cache;

class TagSet extends \Illuminate\Cache\TagSet
{
    /** {@inheritdoc} */
    public function tagKey($name): string
    {
        return 'cache_tags'
            .$this->store->separator
            .preg_replace('/[^\w\s\d\-_~,;\[\]\(\).]/', '~', $name);
    }

    /** {@inheritdoc} */
    public function getNamespace()
    {
        return implode('_', $this->tagIds());
    }
}
