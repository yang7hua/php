<?php
use yii\helpers\Html;
use app\assets\SysadmAsset;

SysadmAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(($this->params['title'] ? $this->params['title'] . ' - ' : '')  . $this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="single">
<?php $this->beginBody() ?>
    <div class="wrap">
        <?= $content ?>
    </div>
<?php
	$this->endBody();
?>
</body>
</html>
<?php
$this->endPage();
?>
