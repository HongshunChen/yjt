<?php if(!$this->tpl_var['userhash']){ ?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<?php $this->_compileInclude('menu'); ?>
		</div>
		<div class="span10" id="datacontent">
<?php } ?>
			<ul class="breadcrumb">
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a> <span class="divider">/</span></li>
				<li><a href="#">课程管理</a> <span class="divider">/</span></li>
				<li><a href="#">课程分类</a> <span class="divider">/</span></li>
				<li class="active">添加分类</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加分类</a>
				</li>
				<li class="pull-right">
					<a href="index.php?vedio-master-demand-area">分类管理</a>
				</li>
			</ul>
	        <form action="index.php?vedio-master-demand-addarea" method="post" class="form-horizontal">
				<fieldset>
				<div class="control-group">
					<label for="questype" class="control-label">分类名称：</label>
					<div class="controls">
						<input name="args[catname]" id="questype" type="text" size="30" value="" needle="needle" alt="请输入题型名称" />
					</div>
				</div>
				<!--
				<div class="control-group">
					<label for="questype" class="control-label">识别码：</label>
					<div class="controls">
						<input name="args[questchar]" id="questype" type="text" size="30" value="" needle="needle" alt="请输入题型识别码" />
					</div>
				</div>
				-->
				
				<div class="control-group">
				  	<div class="controls">
					  	<button class="btn btn-primary" type="submit">提交</button>
					 	<input type="hidden" name="args[catpid]" value="0">
					  	<input type="hidden" name="insertquestype" value="1"/>
					  	
					</div>
				</div>
				</fieldset>
			</form>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>