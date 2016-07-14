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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master">全局</a> <span class="divider">/</span></li>
				<li><a href="#">课程管理</a> <span class="divider">/</span></li>
				<li><a href="#">视频列表</a> <span class="divider">/</span></li>

				<li  class="active">添加视频</li>
				
			</ul>
				<ul class="nav nav-tabs">
				<li class="active">
					<a href="#">添加视频</a>
				</li>
				<li class="pull-right">
					<a href="index.php?vedio-master-demand-vedio&catid=<?php echo $this->tpl_var['courceid']; ?>">视频管理</a>
				</li>
			</ul>
	      <form action="index.php?vedio-master-demand-addvedio" method="post" class="form-horizontal">
				<fieldset>
				<div class="top_left" style="width: 50%;float: left;">
				<div class="control-group">
					<label for="basic" class="control-label">视频名称</label>
					<div class="controls">
						<input id="basic" name="args[videoname]" type="text" value="" needle="needle" msg="您必须输入视频名称" />
					</div>
				</div>
				
				
				<div class="control-group">
					<label for="basicthumb" class="control-label">视频上传</label>
					<div class="controls">

				<input type="button" id="upload" value="上传"></input>	
			
				<script src="app/core/styles/js/polyv-upload.js"></script>
				
<script type="text/javascript">

    var obj = {
            uploadButtton: "upload",   //打开上传控件按钮id
            writeToken: "<?php echo WRITETOKEN; ?>",
            userid : '<?php echo USERID; ?>',
            ts : '<?php echo TIME; ?>',
            hash : '<?php echo HASH; ?>' ,
            readToken: '<?php echo READTOKEN; ?>',
             response: function(json) { 
             	document.getElementById('VEDIO_IMG').src = json.swf_link;
             	var html = "<table class='table table-hover'><thead><tr><th width='20%'>项目</th><th>参数</th></tr></thead><tbody><tr><td>视频地址</td><td>"+json.swf_link+"</td></tr><tr><td>视频时长</td><td>"+json.duration+"</td></tr><tr><td>播放次数</td><td>"+json.times+"</td></tr>	<tr><td>视频大小</td><td>"+json.source_filesize+"</td></tr></tbody></table>";
             	document.getElementById('imaes').value = json.first_image;
             	document.getElementById('HTML').innerHTML = html;
     			document.getElementById('remoteurl').value = json.swf_link;
     			document.getElementById('duration').value = json.duration;
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
					<label for="basicsubjectid" class="control-label">所属课程</label>
					<div class="controls">
						<select id="basicsubjectid" name="args[courceid]" needle="needle" msg="您必须选择课程分类">
						<?php $cid = 0;
 foreach($this->tpl_var['cat'] as $key => $val){ 
 $cid++; ?>
						<?php if($val['courseid'] == $this->tpl_var['courseid']){ ?>
		        		<option value="<?php echo $val['courseid']; ?>" selected="selected"><?php echo $val['coursename']; ?></option>
				  		<?php } else { ?>
				  		<option value="<?php echo $val['courseid']; ?>"><?php echo $val['coursename']; ?></option>
				  		<?php } ?>
				  		<?php } ?>
				  		</select><span class="help-block">不需要转换课程的话 默认即可</span>
					</div>
				</div>
			</div>
				<div class="top_right" style="width: 50%;float: left;height: 200px;">

				<div class="control-group">
				<div >
					
<embed width="320" height="240" src="/i/bookmark.swf" id="VEDIO_IMG" />
					</div>
					<div id="HTML">
			
					</div>
				</div>
				</div>
				
				<div class="control-group">
					<label for="basicprice" class="control-label">视频简介</label>
					<div class="controls">
						<textarea class="input-xlarge" rows="4" name="args[content]" id="basicprice"></textarea>
					  	<span class="help-block">介绍一下课程，限制200字</span>
					</div>
				</div>
			
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-primary" onclick="ceshi();" type="submit">提交</button>
						
						<input type="hidden" name="args[remoteurl]" id="remoteurl" value="">
						<input type="hidden" name="args[duration]" value="" id="duration">
						<input type="hidden" name="args[videohumb]" value="" id="imaes">
						<input type="hidden" name="args[videotype]" value="0">
						<input type="hidden" name="courseid" value="<?php echo $this->tpl_var['courseid']; ?>">
						<input type="hidden" name="args[videovid]" id="videovid" value="">
						<input type="hidden" name="args[mp4url]" id="mp4" value=""> 
						<input type="hidden" name="insertquestype" value="1"/>
				
						
					</div>
				</div>
			<script type="text/javascript">
				$(document).ready(function(){
  					$("form").submit(function(){
    				  var  vid = document.getElementById('videovid').value;
    				  var  basic = document.getElementById('basic').value;
    				  var  basicprice = document.getElementById('basicprice').value;
    				  $.post("http://v.polyv.net/uc/services/rest?method=editById",{
    				  		"writetoken":"<?php echo WRITETOKEN; ?>",
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
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
</body>
</html>
<?php } ?>