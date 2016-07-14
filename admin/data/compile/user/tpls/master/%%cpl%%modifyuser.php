<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10">
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				<li><a href="index.php?user-master-user">用户管理</a> <span class="divider">/</span></li>
				<li class="active">编辑用户</li>
			</ul>
			<div id="tabs-694325" class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#panel-344373" data-toggle="tab">用户资料</a>
					</li>
				
					<li>
						<a href="#panel-788885" data-toggle="tab">修改密码</a>
					</li>
					<li class="pull-right">
						<a href="index.php?user-master-user">用户列表</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="panel-344373" class="tab-pane active">
						<form action="index.php?user-master-user-modify" method="post" class="form-horizontal">
							<fieldset>
								<legend><?php echo $this->tpl_var['user']['username']; ?></legend>
								<div class="control-group">
									<label for="usertruename" class="control-label">用户昵称：</label>
									<div class="controls">
										<input autocomplete="off" value="<?php echo $this->tpl_var['user']['nickname']; ?>" name="args[nickname]" id="nickname" type="text">									</div>
								</div>


							<?php if($this->tpl_var['user']['usergroupid'] ==1){ ?>
								<div class="control-group">
							
					<label for="basicthumb" class="control-label">用户头像</label>
					<div class="controls">
						<div class="thumbuper pull-left">
							<div class="thumbnail">
								<a href="javascript:;" class="second label"><em class="uploadbutton" id="catimg" exectype="thumb"></em></a>
								<div class="first" id="catimg_percent"></div>
								<div class="boot"><img src="<?php echo $this->tpl_var['user']['photo']; ?>" id="catimg_view"/><input type="hidden" name="args[photo]" value="<?php echo $this->tpl_var['user']['photo']; ?>" id="catimg_value"/></div>
							</div>
						</div>
					</div>
				</div>
				<div class="control-group">
						<label for="email" class="control-label">简介</label>
						<div class="controls">
							<textarea class="input-xlarge" rows="4" name="args[teacher_subjects]" id="basicprice"><?php echo $this->tpl_var['user']['teacher_subjects']; ?></textarea>
					  	<span class="help-block">介绍一下简介，限制200字</span>
						</div>
					</div>
							<?php } ?>	
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-primary" type="submit">提交</button>
										<input type="hidden" name="userid" value="<?php echo $this->tpl_var['user']['userid']; ?>"/>
										<input type="hidden" name="modifyuserinfo" value="1"/>
										<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
										<?php $aid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $aid++; ?>
										<input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
										<?php } ?>
									</div>
								</div>
							</fieldset>
						</form>
					</div>

					<div id="panel-788885" class="tab-pane">
						<form action="index.php?user-master-user-modify" method="post" class="form-horizontal">
							<fieldset>
								<legend><?php echo $this->tpl_var['user']['username']; ?></legend>
								<div class="control-group">
									<label for="passowrd1" class="control-label">新密码：</label>
									<div class="controls">
										<input id="passowrd1" type="password" name="args[password]" needle="true" datatype="password" msg="密码字数必须在6位以上"/>
									</div>
								</div>
								<div class="control-group">
									<label for="password2" class="control-label">重复密码：</label>
									<div class="controls">
										<input id="password2" type="password" name="args[password2]" needle="true" equ="passowrd1" msg="前后两次密码必须一致且不能为空"/>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<button class="btn btn-primary" type="submit">提交</button>
										<input type="hidden" name="userid" value="<?php echo $this->tpl_var['user']['userid']; ?>"/>
										<input type="hidden" name="modifyuserpassword" value="1"/>
										<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
										<?php $aid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $aid++; ?>
										<input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
										<?php } ?>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>