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
    <title><?= Html::encode($this->title . ' - 个人中心') ?></title>
    <?php $this->head() ?>
</head>
<body class="user">

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '首页',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
			if (Yii::$app->user->isGuest):
                $items = [['label' => 'Login', 'url' => ['/user/login']]];
		?>
		<?php
			else:
				$items = [
					[	
						'label' => Yii::$app->user->identity->username,
						'items'	=>	[
							'<li><a href="/user/blog/publish"><span class="icon icon15"></span>写博客</a></li>',
							'<li><a href="/user/profile/info/edit"><span class="icon icon21"></span>档案设置</a></li>'
						]
					],
                    ['label' => '个人中心', 'url' => ['/user']],
					['label' => '退出',
						'url' => ['/site/logout'],
						'linkOptions' => ['data-method' => 'post']
					],
				];
			endif;

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $items
            ]);
            NavBar::end();
        ?>

		<?php /*Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) */?>
		<?= $this->render('/user/widgets/header')?>

		<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<?= $content ?>
			</div>
			<div class="col-lg-3 col-lg-offset-1">
				<?= $this->render('/user/widgets/sidebar'); ?>
			</div>
		</div>
		</div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
