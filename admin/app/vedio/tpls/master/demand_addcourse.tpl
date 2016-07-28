{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10" id="datacontent">
{x2;endif}
			<ul class="breadcrumb">
				<li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a> <span class="divider">/</span></li>
				<li><a href="#">课程管理</a> <span class="divider">/</span></li>
				<li class="active">添加课程</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加课程</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-demand-course">课程管理</a>
				</li>
			</ul>
	      <form action="index.php?vedio-master-demand-addcourse" method="post" class="form-horizontal">
				<fieldset>
				<div style="width:100%;height:270px;">
				<div class="top_left" style="width: 40%;float: left;">
				<div class="control-group">
					<label for="basic" class="control-label">课程名称</label>
					<div class="controls">
						<input id="basic" name="args[coursename]" type="text" value="" needle="needle" msg="您必须输入课程名称" />
					</div>
				</div>
				<div class="control-group">
					<label for="basicapi" class="control-label">主讲老师</label>
					<div class="controls">
						<input id="basicapi" name="args[courseusername]" type="text" value="{x2;$_user['usertruename']}" max="12" msg="" />
					<span class="help-block">如果上传者不是讲师 请修改为讲师的姓名</span>
					</div>
				</div>
				<div class="control-group">
					<label for="basicapi" class="control-label">课程价格</label>
					<div class="controls">
						<input id="basicapi" name="args[courseprice]" type="text" value="" max="12" msg="" />
					
					</div>
				</div>
				<div class="control-group">
					<label for="basicsubjectid" class="control-label">课程内容</label>
					<div class="controls">
						<select id="basicsubjectid" name="args[courseify1]" needle="needle" msg="您必须选择课程分类">
		        		<option value="">选择分类</option>
				  		{x2;tree:$courseify,ify,sid}
				  			{x2;if:v:ify['catpid'] == 1}
				  		<option value="{x2;v:ify['catname']}">{x2;v:ify['catname']}</option>
				  		{x2;endif}
				  		{x2;endtree}
				  		</select>
					</div>
				</div>
				</div>
				<div class="top_right" style="width: 50%;float: left;">
				<div class="control-group">
					<label for="basicthumb" class="control-label">课程首图</label>
					<div class="controls">
						<div class="thumbuper pull-left">
							<div class="thumbnail">
								<a href="javascript:;" class="second label"><em class="uploadbutton" id="catimg" exectype="thumb"></em></a>
								<div class="first" id="catimg_percent"></div>
								<div class="boot"><img src="app/core/styles/images/noimage.gif" id="catimg_view"/><input type="hidden" name="args[coursethumb]" value="" id="catimg_value"/></div>
							</div>
						</div>
					</div>
				</div>
				</div>
				</div>
				

				<div class="control-group">
					<label for="basicareaid" class="control-label">课程类别</label>
					<div class="controls">
						<select id="basicareaid" name="args[courseify2]" needle="needle" msg="您必须选择课程类别">
		        		<option value="">选择类别</option>
				  		{x2;tree:$courseify,ify,sid}
							{x2;if:v:ify['catpid'] == 2}
				  		<option value="{x2;v:ify['catname']}">{x2;v:ify['catname']}</option>
				  		{x2;endif}
				  		{x2;endtree}
				  		</select>
					</div>
				</div>
                                <div class="control-group">
					<label for="basic" class="control-label">截止时间</label>
					<div class="controls">
						<input class=" datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" type="text" name="args[courseendtime]" size="10" id="stime" value=""/>
					</div>
				</div>
				<div class="control-group">
					<label for="basicareaid" class="control-label">考试类别</label>
					<div class="controls">
						<select id="basicareaid" name="args[courseify3]" needle="needle" msg="您必须选择课程类别">
		        		<option value="">选择类别</option>
				  		{x2;tree:$courseify,ify,sid}
				  		{x2;if:v:ify['catpid'] == 3}
				  		<option value="{x2;v:ify['catname']}">{x2;v:ify['catname']}</option>
				  		{x2;endif}
				  		{x2;endtree}
				  		</select>
					</div>
				</div>
                               
				<div class="control-group">
					<label for="basicprice" class="control-label">课程吸引</label>
					<div class="controls">
						<textarea class="input-xlarge" rows="4" name="args[courseatract]" id="courseatract">{x2;$basic['basicprice']}</textarea>
					  	<span class="help-block">介绍一下课程吸引点，限制100字</span>
					</div>
				</div>
                                 <div class="control-group">
					<label for="teacherintro" class="control-label">名师简介</label>
					<div class="controls">
						<textarea class="ckeditor" rows="4" name="args[teacherintro]" id="teacherintro"></textarea>
					  	
					</div>
				</div>
				<div class="control-group">
					<label for="basicprice" class="control-label">课程简介</label>
					<div class="controls">
						<textarea class="ckeditor" rows="4" name="args[courseintro]" id="basicprice">{x2;$basic['basicprice']}</textarea>
					  	
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">课程内容</label>
				  	<div class="controls">
					  	<textarea class="ckeditor" name="args[contentintro]" id="question"></textarea>
					  
					</div>
				</div>
                                  <div class="control-group">
					<label class="control-label">需购买后查看的内容</label>
				  	<div class="controls">
					  	<textarea class="ckeditor" name="args[cpaidcontent]" id="cpaidcontent"></textarea>
					  	<span class="help-block">加超链接的时候请首先点击源码，然后往给的标签中添加内容</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit">保存</button>
						<input type="hidden" name="args[teacherid]" value="{x2;$_user['userid']}">
						<input type="hidden" name="insertquestype" value="1"/>
						
					</div>
				</div>
				
				</fieldset>
			</form>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}