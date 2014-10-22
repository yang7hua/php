<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
</head>
<body class="site">
<?php $this->beginBody() ?>
	<?= $this->render('/site/widgets/topbar') ?>
    <div class="wrap">
        <?= $content ?>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
