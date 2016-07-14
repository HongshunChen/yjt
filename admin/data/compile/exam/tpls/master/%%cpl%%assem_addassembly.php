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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-assem">组卷管理</a> <span class="divider">/</span></li>
				<li class="active">添加组卷规则</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加组卷规则</a>
				</li>
				<li class="pull-right">
					<a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-assem">组卷管理</a>
				</li>
			</ul>
	        <form action="index.php?exam-master-exams-addassembly" method="post" class="form-horizontal">
				<div class="control-group">
					<label class="control-label">规则名称：</label>
			  		<div class="controls">
			  			<input type="text" name="args[assemblyname]" value="" needle="needle" msg="您必须为该规则输入一个名称"/>
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">考试时间：</label>
			  		<div class="controls">
			  			<input type="text" name="args[assemblytime]" size="4" needle="needle" class="inline" value=""/> 分钟
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">试卷总分：</label>
			  		<div class="controls">
			  			<input type="text" name="args[assemblyzongfen]" value="" size="4" needle="needle" msg="你要为本规则设置总分" datatype="number"/>
			  		</div>
				</div>
				<div class="control-group">
					<label class="control-label">及格线：</label>
			  		<div class="controls">
			  			<input type="text" name="args[assemblyjigexian]" value="" size="4" needle="needle" msg="你要为本规则设置一个及格分数线" datatype="number"/>
			  		</div>
				</div>
				<!-- <div class="control-group">
					<label class="control-label">题型排序</label>
					<div class="controls">
						<div class="sortable btn-group">
							<?php if($this->tpl_var['exam']['examsetting']['questypelite']){ ?>
							<?php $eqid = 0;
 foreach($this->tpl_var['exam']['examsetting']['questypelite'] as $key => $qlid){ 
 $eqid++; ?>
							<a class="btn questpanel panel_<?php echo $key; ?>"><?php echo $this->tpl_var['questypes'][$key]['questype']; ?><input type="hidden" name="args[examsetting][questypelite][<?php echo $key; ?>]" value="1" class="questypepanelinput" id="panel_<?php echo $key; ?>"/></a>
							<?php } ?>
							<?php } else { ?>
							<?php $qid = 0;
 foreach($this->tpl_var['questypes'] as $key => $questype){ 
 $qid++; ?>
							<a class="btn questpanel panel_<?php echo $questype['questid']; ?>"><?php echo $questype['questype']; ?><input type="hidden" name="args[examsetting][questypelite][<?php echo $questype['questid']; ?>]" value="1" class="questypepanelinput" id="panel_<?php echo $questype['questid']; ?>"/></a>
							<?php } ?>
							<?php } ?>
						</div>
						<span class="help-block">拖拽进行题型排序</span>
					</div>
				</div> -->
				<div class="modeplane">
				<?php $qid = 0;
 foreach($this->tpl_var['questypes'] as $key => $questype){ 
 $qid++; ?>
				<div class="control-group questpanel panel_<?php echo $questype['questid']; ?>" style="display:block">
					<label class="control-label"><?php echo $questype['questype']; ?>：</label>
					<div class="controls">
						<span class="info">共&nbsp;</span>
						<input id="iselectallnumber_<?php echo $questype['questid']; ?>" type="text" class="input-mini" needle="needle" name="args[examsetting][questype][<?php echo $questype['questid']; ?>][number]" value="<?php echo $this->tpl_var['exam']['examsetting']['questype'][$questype['questid']]['number']; ?>" size="2" msg="您必须填写总题数"/>
						<span class="info">&nbsp;题，每题&nbsp;</span><input class="input-mini" needle="needle" type="text" name="args[examsetting][questype][<?php echo $questype['questid']; ?>][score]" value="<?php echo $this->tpl_var['exam']['examsetting']['questype'][$questype['questid']]['score']; ?>" size="2" msg="您必须填写每题的分值"/>
						<span class="info">&nbsp;分，描述&nbsp;</span><input class="input-mini" type="text" name="args[examsetting][questype][<?php echo $questype['questid']; ?>][describe]" value="<?php echo $this->tpl_var['exam']['examsetting']['questype'][$questype['questid']]['describe']; ?>" size="12"/>
						<span class="info">&nbsp;已选题数：<a id="ialreadyselectnumber_<?php echo $key; ?>"><?php echo intval($this->tpl_var['exam']['examnumber'][$key]); ?></a>&nbsp;&nbsp;题</span>
						<span class="info">&nbsp;<a class="selfmodal btn" href="javascript:;" data-target="#modal" url="index.php?exam-master-exams-selected&questionids={iselectquestions_<?php echo $key; ?>}&rowsquestionids={iselectrowsquestions_<?php echo $key; ?>}" valuefrom="iselectquestions_<?php echo $key; ?>|iselectrowsquestions_<?php echo $key; ?>">看题</a></span>
						<span class="info">&nbsp;<a class="selfmodal btn" href="javascript:;" data-target="#modal" url="index.php?exam-master-exams-selectquestions&search[questionsubjectid]=<?php echo $this->tpl_var['exam']['examsubject']; ?>&search[questiontype]=<?php echo $key; ?>&questionids={iselectquestions_<?php echo $key; ?>}&rowsquestionids={iselectrowsquestions_<?php echo $key; ?>}&useframe=1" valuefrom="iselectquestions_<?php echo $key; ?>|iselectrowsquestions_<?php echo $key; ?>">选题</a></span>
	  					<input type="hidden" id="iselectquestions_<?php echo $key; ?>" name="args[examquestions][<?php echo $key; ?>][questions]" value="<?php echo $this->tpl_var['exam']['examquestions'][$key]['questions']; ?>"/>
	  					<input type="hidden" id="iselectrowsquestions_<?php echo $key; ?>" name="args[examquestions][<?php echo $key; ?>][rowsquestions]" value="<?php echo $this->tpl_var['exam']['examquestions'][$key]['rowsquestions']; ?>"/>
			  		</div>
				</div>
				<?php } ?>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit">提交</button>
						<input type="hidden" name="submitsetting" value="1"/>
						<input name="examid" type="hidden" value="<?php echo $this->tpl_var['exam']['examid']; ?>">
			  		</div>
				</div>
			</form>
			<div aria-hidden="true" id="modal" class="modal hide fade" role="dialog" aria-labelledby="#myModalLabel">
				<div class="modal-header">
					<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
					<h3 id="myModalLabel">
						试题列表
					</h3>
				</div>
				<div class="modal-body" id="modal-body"></div>
				<div class="modal-footer">
					 <button aria-hidden="true" class="btn" data-dismiss="modal">完成</button>
				</div>
			</div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
<script>
$.getJSON('index.php?exam-master-basic-getsubjectquestype&subjectid=<?php echo $this->tpl_var['exam']['examsubject']; ?>&'+Math.random(),function(data){$('.questpanel').hide();$('.questypepanelinput').val('0');for(x in data){$('.panel_'+data[x]).show();$('#panel_'+data[x]).val('1');}});
</script>
</body>
</html>
<?php } ?>