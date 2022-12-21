<?php

namespace App\Enums;


enum ResultatType: string
{
    case p1 = 'p1';
    case p2 = 'p2';
    case ex1 = 'ex1';
    case t1 = 't1';

    case p3 = 'p3';
    case p4 = 'p4';
    case ex2 = 'ex2';
    case t2 = 't2';

    case p5 = 'p5';
    case p6 = 'p6';
    case ex3 = 'ex3';
    case t3 = 't3';

    case tg = 'tg';



    // label() match expression
    public function label(): string
    {
        return match ($this) {
            self::p1 => '1e',
            self::p2 => '2e',
            self::ex1 => 'Ex 1',
            self::t1 => 'Tr 1',

            self::p3 => '3e',
            self::p4 => '4e',
            self::ex2 => 'Ex 2',
            self::t2 => 'Tr 2',

            self::p5 => '5e',
            self::p6 => '6e',
            self::ex3 => 'Ex 3',
            self::t3 => 'Tr 3',

            self::tg => 'TG',
        };
    }

    public function longLabel(): string
    {
        return match ($this) {
            self::p1 => '1e Période',
            self::p2 => '2e Période',
            self::ex1 => 'Examen 1',
            self::t1 => 'Trimestre 1',

            self::p3 => '3e Période',
            self::p4 => '4e Période',
            self::ex2 => 'Examen 2',
            self::t2 => 'Trimestre 2',

            self::p5 => '5e Période',
            self::p6 => '6e Période',
            self::ex3 => 'Examen 3',
            self::t3 => 'Trimestre 3',

            self::tg => 'Total Général',
        };
    }
}
