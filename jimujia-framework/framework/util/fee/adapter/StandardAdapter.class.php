<?PHP
/**
 * @Copyright (c) 2011 onelee Inc.
 * @author        gaoshikao@qq.com
 * @date          2013-06-19
 *
 * 新加坡邮政小包普通型
 */


/**
 * @class: StandardAdapter
 * @PURPOSE:  新加坡邮政小包普通型
 */
class StandardAdapter {
    /* 名称*/
    const SHIP_NAME = 'Standard Shipping';

    /* 天数 */
    const SHIP_DAYS = '8-14 business days';

    /* 起重费 */
    const BASIC_FEE = 24.00;

    //配送区域
    private static $_DISPATCH_AREA = array(
        'A' => array(10,11,30,58,64,78,82,84,99,120,152,158,166,167,168,171,183,184,189),
        'B' => array(16,42,44,57,66,76,77,80,94,95,96,117,125,133,134,187),
        'C' => array(139,181),
        'D' => array(7,24,36,49,85,108,157,182)
    );

    //每公斤运费
    private static $_FEE_PER_KILOGRAM = array(
        'A' => 96.00,
        'B' => 98.00,
        'C' => 106.00,
        'D' => 118.00
    );

    //计算费用，重量单位为g
    public static function CalcFee($nation_id, $weight, $amount){
        $area = self::checkSupport($nation_id);
        if (!$area) return 0;

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

