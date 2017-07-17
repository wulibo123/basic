<?PHP
/**
 * @Copyright (c) 2011 onelee Inc.
 * @author        gaoshikao@qq.com
 * @date          2013-06-19
 *
 * 中国邮政小包经济型
 */


/**
 * @class: EconomyAdapter
 * @PURPOSE:  中国邮政小包经济型
 */
class EconomyAdapter {
    /* 名称*/
    const SHIP_NAME = 'Economy Shipping';

    /* 天数 */
    const SHIP_DAYS = '14-20 business days';

    /* 起重费 */
    const BASIC_FEE = 18.00;

    //配送区域
    private static $_DISPATCH_AREA = array(
        'A' => array(84),
        'B' => array(78,79,99,152,158,171),
        'C' => array(10,11,42,44,57,64,66,76,80,81,82,117,125,133,134,153,166,167),
        'D' => array(120,176),
        'E' => array(30,58,95,96,131,154,159,181,183,184,189),
        'F' => array(157),
        'G' => array(7,24,108),
        'H' => array(130,182),
        'I' => array(77,187),
        'J' => array(56,170),
        'K' => array(139)
    );

    //每公斤运费
    private static $_FEE_PER_KILOGRAM = array(
        'A' => 62.00,
        'B' => 71.50,
        'C' => 90.50,
        'D' => 85.00,
        'E' => 81.00,
        'F' => 105.00,
        'G' => 110.00,
        'H' => 120.00,
        'I' => 147.50,
        'J' => 176.00,
        'K' => 96.30
    );

    //计算费用，重量参数单位是克
    public static function CalcFee($nation_id, $weight, $amount){
        $area = self::checkSupport($nation_id);
        if (!$area) return 0;

        //只有经济型的可以设置包邮
        $freeAmount = SystemDeal::getConfigByCode('free_shipping');
        if ($freeAmount > 0 and $freeAmount <= $amount) {
            return '0.00';
        }

        //计算重量费用
        $weightFee = $weight / 1000 * self::$_FEE_PER_KILOGRAM[$area];
        $totalFee = self::BASIC_FEE + $weightFee;
        $totalFee = ExchangeRate::getCurrencyPrice($totalFee);
        $totalFee *= 1.2;
        return number_format($totalFee, 2, '.', '');
    }

    //判断一个国家是否支持此邮寄方式，并返回所支持的区域id
    public static function checkSupport($nation_id){
        foreach (self::$_DISPATCH_AREA as $id => $area) {
            if (in_array($nation_id, $area))return $id;
        }
        return 0;
    }

}

