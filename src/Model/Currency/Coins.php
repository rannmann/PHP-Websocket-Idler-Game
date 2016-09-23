<?php

namespace Idler\Model\Currency;

class Coins {
    /**
     * Amount of currency per currency tier
     */
    const CURRENCY_STEP = 1000;
    /**
     * Full currency names by tier, currently unused
     * @var array
     */
    public static $currencyNames = [
        1 => 'Copper',
        2 => 'Silver',
        3 => 'Gold',
        4 => 'Platinum'
    ];
    /**
     * Suffix to each tier of currency names. Can be text, an image, whatever.
     * @var array
     */
    public static $currencyDisplay = [
        1 => 'c',
        2 => 's',
        3 => 'g',
        4 => 'p'
    ];

    /**
     * Formats coins for display
     * @param  int $coins    Coins
     * @return string        Ready to display string
     */
    public static function display($coins) {
        $remaining = $coins;
        $formatted = [];
        foreach (self::$currencyNames as $k => $currencyTier) {
            if ($remaining > self::CURRENCY_STEP) {
                $formatted[] = $remaining % self::CURRENCY_STEP . self::$currencyDisplay[$k];
            } elseif ($remaining > 0) {
                $formatted[] = $remaining . self::$currencyDisplay[$k];
            }
            $remaining = floor($remaining / self::CURRENCY_STEP);
        }
        if (empty($formatted)) {
            $formatted = 'Broke';
        } else {
            $formatted = implode(' ', array_reverse($formatted));
        }
        return $formatted;
    }
}