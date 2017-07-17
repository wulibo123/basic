<?PHP
/**
 * @brief 配送方式及费用计算类
 * @author               gaosk<gaoshikao@qq.com>
 * @file                 $RCSfile: Curl.class.php,v $
 * @version              $Revision: 50890 $
 * @modifiedby           $Author: gaosk $
 * @lastmodified         $Date: 2011-03-11 17:29:21 +0800 (五, 2011-03-11) $
 * @copyright            Copyright (c) 2011, onelee.com
 */
require_once WEB_V1 . '/common/SystemDeal.class.php';

class FeeUtil {

    /** Standard */
	const MODE_STANDARD = 1;

	/** Economy */
	const MODE_ECONOMY = 2;

    /** UPS */
    const MODE_UPS = 3;

    private static $_HANDLE_ARRAY   = array();

    /**
     * @brief 创建一个cache 对象
     *
     * @return  StandardAdapter|EconomyAdapter|UPSAdapter
     */
    public static function createFee($mode) {

        if (isset(self::$_HANDLE_ARRAY[$mode])) {
            return self::$_HANDLE_ARRAY[$mode];
        }

		switch($mode) {
			case self::MODE_STANDARD:
				require_once dirname(__FILE__) . '/adapter/StandardAdapter.class.php';
				$objCache = new StandardAdapter($servers);
				break;
			case self::MODE_ECONOMY:
			    require_once dirname(__FILE__) . '/adapter/EconomyAdapter.class.php';
				$objCache = new EconomyAdapter();
				break;
            case self::MODE_UPS:
                require_once dirname(__FILE__) . '/adapter/UPSAdapter.class.php';
                $objCache = new UPSAdapter();
                break;
			default:
			    require_once dirname(__FILE__) . '/adapter/StandardAdapter.class.php';
				$objCache = new StandardAdapter($servers);
				break;
		}

		self::$_HANDLE_ARRAY[$mode]    = $objCache;

		return $objCache;
	}

}