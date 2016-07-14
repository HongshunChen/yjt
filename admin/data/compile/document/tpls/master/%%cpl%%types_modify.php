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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-attachtype">文件类型</a> <span class="divider">/</span></li>
				<li class="active">添加文件类型</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加文件类型</a>
				</li>
				<li class="dropdown pull-right">
					<a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-attachtype">文件类型</a>
				</li>
			</ul>
			<form action="index.php?<?php echo $this->tpl_var['_app']; ?>-master-attachtype-modify" method="post" class="form-horizontal">
				<fieldset>
				<div class="control-group">
					<label for="basic" class="control-label">文件类型</label>
					<div class="controls">
						<input id="basic" name="args[attachtype]" type="text" value="<?php echo $this->tpl_var['attachtype']['attachtype']; ?>" needle="needle" msg="您必须文件类型" />
					</div>
				</div>
				<div class="control-group">
					<label for="basicapi" class="control-label">扩展名</label>
					<div class="controls">
						<input id="basicapi" name="args[attachexts]" type="text" value="<?php echo $this->tpl_var['attachtype']['attachexts']; ?>" needle="needle" msg="您必须填写文件类型扩展名"/>
						<span class="help-block">多个扩展名之间用英文逗号隔开</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
						<input type="hidden" name="modifyattachtype" value="1"/>
						<input type="hidden" name="atid" value="<?php echo $this->tpl_var['attachtype']['atid']; ?>"/>
						<?php $aid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $aid++; ?>
						<input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
						<?php } ?>
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