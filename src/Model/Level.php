<?php

namespace Idler\Model\Level;

class Level {
    public static function getExperienceForLevel($level) {
        $sum = 0;
        for($x = 1; $x < $level; $x++) {
            $sum += floor($x + 290 * pow(2, ($x / 7)));
        }
        return floor($sum / 4);
    }
    public static function getLevel($experience) {
        $level = 1;
        while(self::getExperienceForLevel($level) <= $experience) {
            $level++;
        }
        return $level - 1;

    }
}