<?php

namespace Idler\Model\Skill;

class DefaultSkill {
    /**
     * Skill name
     * @var string
     */
    public static $name = "Unknown";

    /**
     * Skill description
     * @var string
     */
    public static $description = "Default description";

    /**
     * Items this skill uses?
     * @var array
     */
    public static $childItems = [];

    public $exp = 0;
}