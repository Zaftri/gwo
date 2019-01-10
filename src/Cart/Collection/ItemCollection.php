<?php

namespace Recruitment\Cart\Collection;

use Recruitment\Common\CommonCollection;
use Recruitment\Cart\Item;

class ItemCollection extends CommonCollection
{
    /** @var Item */
    private $type = Item::class;

    /** ItemCollection constructor */
    public function __construct()
    {
        parent::__construct($this->type);
    }
}
