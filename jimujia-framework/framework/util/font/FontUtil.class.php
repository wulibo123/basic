<?php
/**
 * 字体类库
 * @author gaoshikao <gaoshikao@qq.com>
 * @date 2013-3-26
 */

class FontUtil {

    //字体图片路径
    const FONT_IMAGE_URL = 'http://img.onelee.net/font/';

    //ttf字体目录
    const TTF_FONTS_DIR = '/usr/share/fonts/default/TrueType/';

    //字体列表
    private static $_FONTS = array(
      2 => array (
        'name' => 'Abbeyline',
        'image' => 'abbeyline',
      ),
      4 => array (
        'name' => 'Acadian',
        'image' => 'acadian',
      ),
      5 => array (
        'name' => 'Acid Dreamer',
        'image' => 'acid_dreamer',
      ),
      6 => array (
        'name' => 'Acknowledge',
        'image' => 'acknowledge',
      ),
      7 => array (
        'name' => 'Action Is',
        'image' => 'action_is',
      ),
      9 => array (
        'name' => 'Actionsh',
        'image' => 'actionsh',
      ),
      10 => array (
        'name' => 'AdineKirnberg-Script',
        'image' => 'adinekirnberg_script',
      ),
      11 => array (
        'name' => 'Adventure Subtitles',
        'image' => 'adventure_subtitles',
      ),
      12 => array (
        'name' => 'Aguardiente',
        'image' => 'aguardiente',
      ),
      13 => array (
        'name' => 'Alepholon',
        'image' => 'alepholon',
      ),
      14 => array (
        'name' => 'Allstar',
        'image' => 'allstar',
      ),
      15 => array (
        'name' => 'Ambassador Script',
        'image' => 'ambassador_script',
      ),
      16 => array (
        'name' => 'American Uncial',
        'image' => 'american_uncial',
      ),
      17 => array (
        'name' => 'Andalemo',
        'image' => 'andalemo',
      ),
      18 => array (
        'name' => 'Angles Octagon',
        'image' => 'angles_octagon',
      ),
      19 => array (
        'name' => 'Annabel Script',
        'image' => 'annabel_script',
      ),
      20 => array (
        'name' => 'AntsyPants',
        'image' => 'antsypants',
      ),
      21 => array (
        'name' => 'Arial Rounded',
        'image' => 'arial_rounded',
      ),
      22 => array (
        'name' => 'Arial',
        'image' => 'arial',
      ),
      27 => array (
        'name' => 'Athletic',
        'image' => 'athletic',
      ),
      29 => array (
        'name' => 'Bad Films',
        'image' => 'bad_films',
      ),
      30 => array (
        'name' => 'Ball',
        'image' => 'ball',
      ),
      31 => array (
        'name' => 'Barbatrick',
        'image' => 'barbatrick',
      ),
      32 => array (
        'name' => 'Baroque Antique Script',
        'image' => 'baroque_antique_script',
      ),
      33 => array (
        'name' => 'Billo Dream',
        'image' => 'billo_dream',
      ),
      34 => array (
        'name' => 'Boogie Nights NF',
        'image' => 'boogie_nights_nf',
      ),
      36 => array (
        'name' => 'Canarsie Slab',
        'image' => 'canarsie_slab',
      ),
      38 => array (
        'name' => 'Cargo',
        'image' => 'cargo',
      ),
      39 => array (
        'name' => 'Carrington',
        'image' => 'carrington',
      ),
      40 => array (
        'name' => 'Cast Iron',
        'image' => 'cast_iron',
      ),
      41 => array (
        'name' => 'Cherl',
        'image' => 'cherl',
      ),
      42 => array (
        'name' => 'ClarendonTMed',
        'image' => 'clarendontmed',
      ),
      43 => array (
        'name' => 'Comic',
        'image' => 'comic',
      ),
      46 => array (
        'name' => 'Courbd',
        'image' => 'courbd',
      ),
      49 => array (
        'name' => 'Courier New',
        'image' => 'courier_new',
      ),
      50 => array (
        'name' => 'D3 Archism',
        'image' => 'd3_archism',
      ),
      52 => array (
        'name' => 'Elephant',
        'image' => 'elephant',
      ),
      53 => array (
        'name' => 'Endor',
        'image' => 'endor',
      ),
      54 => array (
        'name' => 'Engravers',
        'image' => 'engravers',
      ),
      55 => array (
        'name' => 'Especial Kay',
        'image' => 'especial_kay',
      ),
      56 => array (
        'name' => 'Fancy Pants',
        'image' => 'fancy_pants',
      ),
      59 => array (
        'name' => 'Fuzzy Cootie',
        'image' => 'fuzzy_cootie',
      ),
      60 => array (
        'name' => 'Garamond',
        'image' => 'garamond',
      ),
      61 => array (
        'name' => 'Georgia',
        'image' => 'georgia',
      ),
      65 => array (
        'name' => 'Guevara',
        'image' => 'guevara',
      ),
      66 => array (
        'name' => 'ILS Script',
        'image' => 'ils_script',
      ),
      67 => array (
        'name' => 'Impact',
        'image' => 'impact',
      ),
      68 => array (
        'name' => 'Independence',
        'image' => 'independence',
      ),
      69 => array (
        'name' => 'Jabbie Junior',
        'image' => 'jabbie_junior',
      ),
      70 => array (
        'name' => 'JFSnobiz',
        'image' => 'jfsnobiz',
      ),
      71 => array (
        'name' => 'KUNSTLER',
        'image' => 'kunstler',
      ),
      72 => array (
        'name' => 'LaBrit',
        'image' => 'labrit',
      ),
      73 => array (
        'name' => 'Mael',
        'image' => 'mael',
      ),
      74 => array (
        'name' => 'Magik',
        'image' => 'magik',
      ),
      75 => array (
        'name' => 'Matura MT',
        'image' => 'matura_mt',
      ),
      76 => array (
        'name' => 'Miama',
        'image' => 'miama',
      ),
      77 => array (
        'name' => 'Mouser Outline',
        'image' => 'mouser_outline',
      ),
      78 => array (
        'name' => 'Musicals',
        'image' => 'musicals',
      ),
      79 => array (
        'name' => 'Oasis',
        'image' => 'oasis',
      ),
      80 => array (
        'name' => 'Patriot',
        'image' => 'patriot',
      ),
      82 => array (
        'name' => 'Royalacid',
        'image' => 'royalacid',
      ),
      83 => array (
        'name' => 'Sabrina',
        'image' => 'sabrina',
      ),
      84 => array (
        'name' => 'Salaryma',
        'image' => 'salaryma',
      ),
      86 => array (
        'name' => 'Star Jedi Outline',
        'image' => 'star_jedi_outline',
      ),
      87 => array (
        'name' => 'Star Jedi',
        'image' => 'star_jedi',
      ),
      88 => array (
        'name' => 'Tahoma',
        'image' => 'tahoma',
      ),
      90 => array (
        'name' => 'Teutonic',
        'image' => 'teutonic',
      ),
      94 => array (
        'name' => 'Timesi',
        'image' => 'timesi',
      ),
      95 => array (
        'name' => 'Tortillon Tryout',
        'image' => 'tortillon_tryout',
      ),
      100 => array (
        'name' => 'Tyrfing Demo',
        'image' => 'tyrfing_demo',
      ),
      101 => array (
        'name' => 'Verdana',
        'image' => 'verdana',
      ),
      102 => array (
        'name' => 'Verdanab',
        'image' => 'verdanab',
      ),
      105 => array (
        'name' => 'Wa CHa Ka',
        'image' => 'wa_cha_ka',
      ),
      107 => array (
        'name' => 'Zapfino',
        'image' => 'zapfino',
      )
    );

    /**
     * 获取字体列表
     * @param array $params
     * @return  string
     */
    public static function getFontList() {
        foreach (self::$_FONTS as $k => $v) {
            if (strpos($v['image'], '.png') === false) {
                self::$_FONTS[$k]['image_url'] = self::FONT_IMAGE_URL . $v['image'] . '.png';
            }
        }

        return self::$_FONTS;
    }

    //获取单个字体信息
    public static function getFontInfo($id = 22) {
        if (!isset(self::$_FONTS[$id])) {
            $id = 22;
        }
        $fontInfo = self::$_FONTS[$id];
        $fontInfo['font_file'] = self::TTF_FONTS_DIR . $fontInfo['name'] . '.ttf';

        return $fontInfo;
    }

}