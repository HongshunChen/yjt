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
				<li class="active">编辑课程</li>
			</ul>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">编辑课程</a>
				</li>
				<li class="pull-right">
					<a href="index.php?{x2;$_app}-master-demand-course">课程管理</a>
				</li>
			</ul>
	      <form action="index.php?vedio-master-demand-editcourse" method="post" class="form-horizontal">
				<fieldset>
				<div style="width:100%;height:270px;">
				<div class="top_left" style="width: 40%;float: left;">
				<div class="control-group">
					<label for="basic" class="control-label">课程名称</label>
					<div class="controls">
						<input id="basic" name="args[coursename]" type="text" value="{x2;$cat['coursename']}" needle="needle" msg="您必须输入课程名称" />
					</div>
				</div>
				<div class="control-group">
					<label for="basicapi" class="control-label">主讲老师</label>
					<div class="controls">
						<input id="basicapi" name="args[courseusername]" type="text" value="{x2;if:$cat['courseusername'] ==''}{x2;$_user['usertruename']}{x2;else}{x2;$cat['courseusername']}{x2;endif}" max="12" msg="" />
					<span class="help-block">如果上传者不是讲师 请修改为讲师的姓名</span>
					</div>
				</div>
                                
                                
				<div class="control-group">
					<label for="basicapi" class="control-label">课程价格</label>
					<div class="controls">
						<input id="basicapi" name="args[courseprice]" type="text" value="{x2;$cat['courseprice']}" max="12" msg="" />
					
					</div>
				</div>
				<div class="control-group">
					<label for="basicsubjectid" class="control-label">课程内容</label>
					<div class="controls">
						<select id="basicsubjectid" name="args[courseify1]">
		        		<option selected = "selected" value="{x2;$cat['courseify1']}">{x2;$cat['courseify1']}</option>
				  		{x2;tree:$courseify,ify,sid}
				  		{x2;if:v:ify['catpid'] == 1}
				  		{x2;if:v:ify['catname'] != $cat['courseify1']}
				  		<option value="{x2;v:ify['catname']}">{x2;v:ify['catname']}</option>
				  		{x2;endif}
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
								<div class="boot"><img src="{x2;$cat['coursethumb']}" id="catimg_view"/><input type="hidden" name="args[coursethumb]" value="{x2;$cat['coursethumb']}" id="catimg_value"/></div>
							</div>
						</div>
					</div>
				</div>
				</div>
				</div>
				
				<div class="control-group">
					<label for="basicareaid" class="control-label">课程类别</label>
					<div class="controls">
						<select id="basicareaid" name="args[courseify2]" >
		        		<option selected = "selected" value="{x2;$cat['courseify2']}">{x2;$cat['courseify2']}</option>
				  		{x2;tree:$courseify,ify,sid}
				  		{x2;if:v:ify['catpid'] == 2}
				  		{x2;if:v:ify['catname'] != $cat['courseify2']}
				  		<option value="{x2;v:ify['catname']}">{x2;v:ify['catname']}</option>
				  		{x2;endif}
				  		{x2;endif}
				  		{x2;endtree}
				  		</select>
					</div>
				</div>
                                <div class="control-group">
					<label for="basic" class="control-label">截止时间</label>
					<div class="controls">
						<input class=" datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" type="text" name="args[courseendtime]" size="20" id="stime" value="{x2;date:$cat['courseendtime'],'Y-m-d H:i:s'}"/>
					</div>
				</div>
				<div class="control-group">
					<label for="basicareaid" class="control-label">考试类别</label>
					<div class="controls">
						<select id="basicareaid" name="args[courseify3]" >
		        		<option  selected = "selected" value="{x2;$cat['courseify3']}">{x2;$cat['courseify3']}</option>
				  		{x2;tree:$courseify,ify,sid}
				  		{x2;if:v:ify['catpid'] == 3}
				  		{x2;if:v:ify['catname'] != $cat['courseify3']}
				  		<option value="{x2;v:ify['catname']}">{x2;v:ify['catname']}</option>
				  		{x2;endif}
				  		{x2;endif}
				  		{x2;endtree}
				  		</select>
					</div>
				</div>
                              
				<div class="control-group">
					<label for="basicprice" class="control-label">课程吸引</label>
					<div class="controls">
						<textarea class="input-xlarge" rows="4" name="args[courseatract]" id="courseatract">{x2;$cat['courseatract']}</textarea>
					  	<span class="help-block">介绍一下课程吸引点，限制100字</span>
					</div>
				</div>
                                 <div class="control-group">
					<label for="teacherintro" class="control-label">老师简介</label>
					<div class="controls">
						<textarea class="ckeditor" rows="4" name="args[teacherintro]" id="teacherintro">{x2;$cat['teacherintro']}</textarea>
					  	
					</div>
				</div>
				<div class="control-group">
					<label for="basicprice" class="control-label">课程简介</label>
					<div class="controls">
						<textarea class="ckeditor" rows="4" name="args[courseintro]" id="basicprice">{x2;$cat['courseintro']}</textarea>
					  	
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">课程内容</label>
				  	<div class="controls">
					  	<textarea class="ckeditor" name="args[contentintro]" id="question">{x2;$cat['contentintro']}</textarea>
					  
					</div>
				</div>
                               <div class="control-group">
					<label class="control-label">需购买后查看的内容</label>
				  	<div class="controls">
					  	<textarea class="ckeditor" name="args[cpaidcontent]" id="cpaidcontent">{x2;$cat['cpaidcontent']}</textarea>
					  	<span class="help-block">加超链接的时候请首先点击源码，然后往给的标签中添加内容</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" type="submit">保存</button>
						<input type="hidden" name="args[teacherid]" value="{x2;$_user['userid']}">
						<input type="hidden" name="catid" value="{x2;$cat['courseid']}">
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