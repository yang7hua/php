<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
	<?php $this->registerMetaTag(['name'=>'keywords', 'content'=>implode(',', $this->params['keywords'])]); ?>
	<?php $this->registerMetaTag(['name'=>'description', 'content'=>$this->params['description']]); ?>
    <title><?= Html::encode(($this->params['title'] ? $this->params['title'] . ' - ' : '')  . $this->title) ?></title>
    <?php $this->head() ?>
<?php
$theme = $_COOKIE['themeColor'];
if (!empty($theme))
	echo $this->registerCssFile('/css/themes/' . $theme . '.css', ['id'=>'themecss', 'depends'=>['app\assets\AppAsset']]);
?>
</head>

<body class="site single">
<?php $this->beginBody() ?>
    <?= $content ?>
<?php
	$this->registerJsFile('/js/lib/bootstrap.min.js', ['depends'=>['app\assets\AppAsset']]);
	$this->endBody();
?>
<!-- JiaThis Button BEGIN -->
	<script type="text/javascript" src="http://v3.jiathis.com/code_mini/jiathis_r.js?uid=1410501383202585&type=right&amp;move=0" charset="utf-8"></script>
<!-- JiaThis Button END -->
</body>
</html>
<?php $this->endPage() ?>
