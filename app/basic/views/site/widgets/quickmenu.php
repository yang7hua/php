<?php
$colors = [
'green'=>'green',
'sky'	=>	'#4CDDF3',
'sunflower'	=>	'#FDA527',
'red'	=>	'red',
'purple'	=>	'#D786FE',
'amethyst'	=>	'#9b59b6',
'river'	=>	'#3498db',
'pumpkin'	=>	'#d35400',
'black'	=>	'black'
];
?>
<div class="quickmenu">
	<span class="mini"><span class=" glyphicon glyphicon-cog"></span></span>
	<div class="menu">
		<h5>选择主题颜色</h5>
		<ul>
<?php foreach ($colors as $key=>$color): ?>
<li class="colors" style="background:<?=$color?>" color="<?=$key?>"></li>
<?php endforeach; ?>
		</ul>
	</div>
</div>
