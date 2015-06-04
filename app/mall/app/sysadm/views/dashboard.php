{Layout#index}
<div class="nav">
</div>
<div class="dashboard">
<div class="col-xs-2 menu">
<ul id="sysadm-menu" class="row">
<?php
foreach ($nodes as $node):
?>
	<li class="node-module">
	<h3><?=$node['name']?></h3>
<?php
	foreach ($node['nodes'] as $node):
		if ($node['action_code']):
?>
		<a class="node" name="<?=$node['action_name']?>" controller="<?=$node['controller_code']?>" action="<?=$node['action_code']?>" href="<?=$this->CI->url('/'.$node['controller_code'].'/'.$node['action_code'])?>"><?=$node['action_name']?></a>
<?php
		else:
?>
	<h5><?=$node['controller_name']?></h5>
<?php
		endif;
		if (isset($node['nodes']) and is_array($node['nodes'])):
?>
	<ul>
<?php
		foreach ($node['nodes'] as $node):
?>
			<li><a class="node" name="<?=$node['action_name']?>" controller="<?=$node['controller_code']?>" action="<?=$node['action_code']?>" href="<?=$this->CI->url('/'.$node['controller_code'].'/'.$node['action_code'])?>">---&nbsp;<?=$node['action_name']?></a></li>	
<?php
		endforeach;
?>
	</ul>
<?php
		endif;
	endforeach;
?>
	</li>
<?php
endforeach;
?>
</ul>
</div>
<div class="frame-box col-xs-10">
	<div class="row">
		<div id="frame-box-header" class="frame-box-header"></div>
		<div id="frame-box-body" class="frame-box-body"></div>
	</div>
</div>
</div>
