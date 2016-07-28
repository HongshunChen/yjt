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
				<li><a href="#">直播课程管理</a> <span class="divider">/</span></li>
				<li  class="active">修改直播课程</li>
				
			</ul>
				<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">修改直播课程</a>
				</li>
				<li class="pull-right">
					<a href="index.php?vedio-master-seeding">直播课程管理</a>
				</li>
			</ul>
	      <form action="index.php?vedio-master-seeding-editseeding" method="post" class="form-horizontal">
				<fieldset>
				<div class="top_left" style="width: 40%;float: left;">
				<div class="control-group">
					<label for="vname" class="control-label">直播课程名称</label>
					<div class="controls">
						<input id="vname" name="args[vname]" type="text" value="{x2;$cat['vname']}" needle="needle" msg="您必须输入视频名称" />
					</div>
				</div>
				<div class="control-group">
					<label for="vprice" class="control-label">直播课程价格</label>
					<div class="controls">
						<input id="vprice" name="args[vprice]" type="text" value="{x2;$cat['vprice']}" needle="needle" msg="您必须输入视频名称" />
					</div>
				</div>
				
				<div class="control-group">
					<label for="basicthumb" class="control-label">直播课程上传</label>
					<div class="controls">

				<input type="button" id="upload" value="上传"></input>	
			
				<script src="app/core/styles/js/polyv-upload.js"></script>
				
<script type="text/javascript">

    var obj = {
            uploadButtton: "upload",   //打开上传控件按钮id
            writeToken: "{x2;c:WRITETOKEN}",
            userid : '{x2;c:USERID}',
            ts : '{x2;c:TIME}',
            hash : '{x2;c:HASH}' ,
            readToken: '{x2;c:READTOKEN}',
             response: function(json) { 
             	document.getElementById('VEDIO_IMG').src = json.swf_link;
             	var html = "<table class='table table-hover'><thead><tr><th width='20%'>项目</th><th>参数</th></tr></thead><tbody><tr><td>视频地址</td><td>"+json.swf_link+"</td></tr><tr><td>视频时长</td><td>"+json.duration+"</td></tr><tr><td>播放次数</td><td>"+json.times+"</td></tr>	<tr><td>视频大小</td><td>"+json.source_filesize+"</td></tr></tbody></table>";
             	document.getElementById('HTML').innerHTML = html;
             	document.getElementById('imaes').value = json.first_image;
     			document.getElementById('remoteurl').value = json.swf_link;
     			document.getElementById('mp4').value = json.mp4;
     			document.getElementById('videovid').value = json.vid;
        //如果需要关闭窗口
        upload.closeWrap();
         
    }
   }
    var upload = new PolyvUpload(obj);

	
</script>
					</div>
				</div>
	
				<div class="control-group">
					<label for="basicsubjectid" class="control-label">课程内容</label>
					<div class="controls">
						<select id="basicsubjectid" name="args[courseify1]" needle="needle" msg="您必须选择课程分类">
		        		<option value="{x2;$cat['courseify1']}">{x2;$cat['courseify1']}</option>
				  		{x2;tree:$courseify,ify,sid}
				  			{x2;if:v:ify['catpid'] == 1}
				  			{x2;if:v:ify['catname'] !=$cat['courseify1']}
				  		<option value="{x2;v:ify['catname']}">{x2;v:ify['catname']}</option>
				  		{x2;endif}
				  		{x2;endif}
				  		{x2;endtree}
				  		</select>
					</div>
				</div>
				<div class="control-group">
					<label for="basicareaid" class="control-label">课程类别</label>
					<div class="controls">
						<select id="basicareaid" name="args[courseify2]" needle="needle" msg="您必须选择课程类别">
		        		<option value="{x2;$cat['courseify2']}">{x2;$cat['courseify2']}</option>
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
			</div>
				<div class="top_right" style="width: 50%;float: left;height: 260px;">

				<div class="control-group">
				<div >
					
<embed width="320" height="240" src="{x2;$cat['vurl']}" id="VEDIO_IMG" />
					</div>
					<div id="HTML">
			
					</div>
				</div>
				</div>
				<div class="control-group">
					<label for="basicareaid" class="control-label">考试类别</label>
					<div class="controls">
						<select id="basicareaid" name="args[courseify3]" needle="needle" msg="您必须选择课程类别">
		        		<option value="{x2;$cat['courseify3']}">{x2;$cat['courseify3']}</option>
				  		{x2;tree:$courseify,ify,sid}
				  		{x2;if:v:ify['catpid'] == 3}
				  		{x2;if:v:ify['catname'] !=$cat['courseify3']}
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
						<input class="input-small datetimepicker" data-date="{x2;date:TIME,'Y-m-d'}" data-date-format="yyyy-mm-dd" type="text" name="args[endtime]" size="20" id="stime" value="{x2;date:$cat['endtime'],'Y-m-d H:i:s'}"/>
					</div>
				</div>
                                <div class="control-group">
					<label for="vteachername" class="control-label">直播老师</label>
					<div class="controls">
						<input id="vteachername" name="args[vteachername]" type="text" value="{x2;$cat['vteachername']}" needle="needle" msg="您必须输入老师名称" />
					</div>
				</div>
				<div class="control-group">
					<label for="vteacherintro" class="control-label">直播课老师简介</label>
					<div class="controls">
						<textarea class="input-xlarge" rows="4" name="args[vteacherintro]" id="vteacherintro">{x2;$cat['vteacherintro']}</textarea>
					  	<span class="help-block">介绍一下老师，限制200字</span>
					</div>
				</div>
                                <div class="control-group">
					<label for="vatract" class="control-label">直播课吸引点</label>
					<div class="controls">
						<textarea class="input-xlarge" rows="4" name="args[vatract]" id="vatract">{x2;$cat['vatract']}</textarea>
					  	<span class="help-block">介绍一下课程，限制200字</span>
					</div>
				</div>
				<div class="control-group">
					<label for="vintro" class="control-label">直播课程简介</label>
					<div class="controls">
						<textarea class="input-xlarge" rows="4" name="args[vintro]" id="vintro">{x2;$cat['vintro']}</textarea>
					  	<span class="help-block">介绍一下课程，限制200字</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">直播课程内容</label>
				  	<div class="controls">
					  	<textarea class="ckeditor" name="args[vcontent]" id="vcontent">{x2;$cat['vcontent']}</textarea>
					  	<span class="help-block">加超链接的时候请首先点击源码，然后往给的标签中添加内容</span>
					</div>
				</div>
			        <div class="control-group">
					<label class="control-label">需购买后查看的内容</label>
				  	<div class="controls">
					  	<textarea class="ckeditor" name="args[vpaidcontent]" id="vpaidcontent">{x2;$cat['vpaidcontent']}</textarea>
					  	<span class="help-block">加超链接的时候请首先点击源码，然后往给的标签中添加内容</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" onclick="ceshi();" type="submit">保存</button>
						
						<input type="hidden" name="args[vurl]" id="remoteurl" value="{x2;$cat['vurl']}">
						<input type="hidden" name="args[videoid]" id="videovid" value="{x2;$cat['videoid']}">
						<input type="hidden" name="catid" id="catid" value="{x2;$cat['vid']}">
						<input type="hidden" name="args[mp4url]" id="mp4" value="">
						<input type="hidden" name="insertquestype" value="1"/>
						<input type="hidden" name="args[videohumb]" value="{x2;$cat['videohumb']}" id="imaes">
						
					</div>
				</div>
			<script type="text/javascript">
				$(document).ready(function(){
  					$("form").submit(function(){
    				  var  vid = document.getElementById('videovid').value;
    				  var  basic = document.getElementById('vname').value;
    				  var  basicprice = document.getElementById('vcontent').value;
    				  $.post("http://v.polyv.net/uc/services/rest?method=editById",{
    				  		"writetoken":"{x2;c:WRITETOKEN}",
    				  		"vid":vid,
    				  		"title":basic,
    				  		"context":basicprice,
    				  },function (data) {
    				  	
    				  });
    				 
 					 });
				});
			</script>	
				</fieldset>
			</form>
{x2;if:!$userhash}
		</div>
	</div>
</div>
</body>
</html>
{x2;endif}