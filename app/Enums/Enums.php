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

enum Enums:string {
    case Printed = 'Печатное издание';
    case Graphic = 'Графическое издание';
    case Electronic = 'Электронное издание';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
};

