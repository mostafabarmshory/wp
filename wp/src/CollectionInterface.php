<?php
namespace Pluf\WP;

use Iterator;

interface CollectionInterface
{

    /**
     * Init the collection
     *
     * some collections required init befor start
     */
    public function init();

    /**
     * Search the collection and return results
     *
     * @param SearchParams $params
     * @return Iterator
     */
    public function find(SearchParams $params): Iterator;
}

