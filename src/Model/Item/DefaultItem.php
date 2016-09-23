<?php

namespace Idler\Model\Item;

use ItemAttributes;

class DefaultItem {
    public $traits = [];
    public $quality = ItemAttribute::QUALITY_NONE;
    //public $color =
    public $origin = ItemAttribute::ORIGIN_PURCHASED;
    public $image = '/img/404.png';
}