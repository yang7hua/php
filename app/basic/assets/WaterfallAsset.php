<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WaterfallAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
		'js/lib/jquery.wookmark.min.js',
		//'js/lib/masonry.pkgd.min.js',
		'js/lib/imagesloaded.pkgd.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
