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

}