<?php

namespace App\Constant;

class Common
{


    const ORDER_RECOMMEND = '0';
    const ORDER_HIGHER = '1';
    const ORDER_LOWER = '2';
    const ORDER_LATER = '3';
    const ORDER_OLDER = '4';

    const SORT_ORDER = [
        'recommend' => self::ORDER_RECOMMEND,
        'higherPrice' => self::ORDER_HIGHER,
        'lowerPrice' => self::ORDER_LOWER,
        'later' => self::ORDER_LATER,
        'older' => self::ORDER_OLDER
    ];

    const SORT_ORDER = [
        'recommend' => '0',
        'higherPrice' => '1',
        'lowerPrice' => '2',
        'later' => '3',
        'older' => '4'
    ];
}

