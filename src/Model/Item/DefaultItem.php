<?php

namespace Idler\Model\Item;

use ItemAttributes;

class DefaultItem {
    public $traits = [];
    public $quality = ItemAttribute::QUALITY_NONE;
    //public $color =
    public $origin = ItemAttribute::ORIGIN_PURCHASED;
    public $image = '/img/404.png';


    public function canVendor() {
        return in_array(ItemAttribute::TRAIT_VENDORABLE, $this->traits);
    }

    public function onVendor(\Idler\Model\Player &$player) {
        if (!$this->canVendor()) {
            throw new \Exception("This item cannot be sold to the vendor.");
        }
        if (empty($this->vendorData) || empty($this->vendorData['price'])) {
            throw new \Exception("This item is missing a price");
        }
        // Todo: Does this user actually own this item?
        $player->coins += $this->vendorData['price'];
        // Todo: Remove this?  How should we handle selling multiple items?
    }
}