{Layout#index}
	<div class="panel panel-default login">
		<div class="panel-heading">登录</div>
		<div class="panel-body">
<form class="form-horizontal" action="<?=$this->CI->url('/admini/login')?>" method="post">
	<div class="form-group">
		<label class="col-lg-2 control-label">用户名</label>
		<div class="col-lg-7"><input name="username" class="form-control {required:1}"></div>
		<div class="col-lg-3 help-block"></div>
	</div>		
	<div class="form-group">
		<label class="col-lg-2 control-label">密码</label>
		<div class="col-lg-7"><input name="password" type="password" class="form-control {required:1}"></div>
		<div class="col-lg-3 help-block"></div>
	</div>		
	<div class="form-group">
		<label class="col-lg-2 control-label">验证码</label>
		<div class="col-lg-8"><input type="input" name="captcha" class="form-control {required:1}">
			<img src="<?=base_url('/site/captcha')?>" class="captcha">
		<div class="help-block"></div>
		</div>
		<div class="col-lg-2 remark"></div>
	</div>				
	<div class="form-group">
		<label class="col-lg-2 control-label"></label>
		<div class="col-lg-6">
			<button type="submit" class="btn btn-primary">提交</button>
		</div>
	</div>		
</form>
		</div>
	</div>
<?php
$this->assert->validate();
