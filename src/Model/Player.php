<?php

namespace Idler\Model;

use Idler\Model\Currency\Coins;

class Player {
    // Max: PHP_INT_MAX (9,223,372,036,854,775,807)
    // The format we intend on using:
    // 9,223,372,036 platinum 854 gold 775 silver 807 copper
    public $coins = 0;
    public $gameTime = 0;
    public $sessionTime = 0;
    public $skills = []; // Populated by modules
    public $items = []; // Populated by modules

    public function __construct() {
        // Load player info from database
        //echo "You have " . Coins::display($this->coins) . " coins\n";
    }
}