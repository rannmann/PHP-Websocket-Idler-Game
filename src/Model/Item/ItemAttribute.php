<?php

namespace Idler\Model\Item;

class ItemAttribute {
    const QUALITY_NONE = 0;
    const QUALITY_COMMON = 1;
    const QUALITY_UNCOMMON = 2;
    const QUALITY_RARE = 3;
    const QUALITY_EPIC = 4;
    const QUALITY_LEGENDARY = 5;
    const QUALITY_ARTIFACT = 6; // is this what we want to call it?
    const QUALITY_UNIQUE = 7; // Only item of this type in the game.

    public static $qualityName = array(
        self::QUALITY_NONE => '',
        self::QUALITY_COMMON => 'Common',
        self::QUALITY_UNCOMMON => 'Uncommon',
        self::QUALITY_RARE => 'Rare',
        self::QUALITY_EPIC => 'Epic',
        self::QUALITY_LEGENDARY => 'Legendary',
        self::QUALITY_ARTIFACT => 'Artifact',
        self::QUALITY_UNIQUE => 'Unique',
    );

    public static $qualityColor = array(); // Todo

    const ORIGIN_FOUND = 1;
    const ORIGIN_PURCHASED = 2;
    const ORIGIN_TRADED = 3;
    const ORIGIN_CRAFTED = 4;

    public static $originName = array(
        self::ORIGIN_FOUND => 'Found',
        self::ORIGIN_PURCHASED => 'Purchased',
        self::ORIGIN_TRADED => 'Traded',
        self::ORIGIN_CRAFTED => 'Crafted',
    );

    const TRAIT_CRAFTABLE = 1; // Can be crafted into something else
    const TRAIT_TRADABLE = 2; // Can be traded on the market
    const TRAIT_CONSUMABLE = 3; // Can be "used" to receive some sort of buff
    const TRAIT_PURCHASABLE = 4; // Can be purchased from an NPC (requires extra information including price, which NPC, minimum reqs)
    const TRAIT_EQUIPPABLE = 5; // Can be worn. Requires extra information such as slot and skill modifiers
    const TRAIT_VENDORABLE = 6; // Can be sold back to the game

}