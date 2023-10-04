<?php

namespace App\Enums;
/*
final class Edition extends Enum {
    public const Printed = 'PRI';
    public const Graphic = 'GRA';
    public const Electronic = 'ELC';

    //public function getInstances(): self {
    //    return self:
    //}
}
*/

enum UserTags:string {
    case User = 'Пользователь';
    case Author = 'Издатель';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function randomValue(): string {
        $arr = array_column(self::cases(), 'value');

        return $arr[array_rand($arr)];
    }
};
