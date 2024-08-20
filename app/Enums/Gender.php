<?php

namespace App\Enums;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';

    /**
     * Get label of gender.
     * 
     * @return string
     */
    public function getLabel(): string
    {
        return match($this) {
            self::Male => 'male',
            self::Female => 'female',
        };
    }

    /**
     * Get values of gender in array.
     * 
     * @return array
     */
    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $value) {
            $array[$value->value] = $value->getLabel();
        }

        return $array;
    }
}
