<?php

$this->title = '主页';

$blogs = Yii::$app->userblog->all();

echo $this->render('widgets/list', ['data'=>$blogs]);
?>
