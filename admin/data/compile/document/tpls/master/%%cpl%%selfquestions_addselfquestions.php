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
				<li class="active">自备题批改</li>
			</ul>
		<form action="index.php?document-master-selfquestions-addselfquestions" method="post" class="form-horizontal">
		
			
			<div class="row-fluid">
				<div class="span6">
					<table class="table table-hover table-bordered"> 
					<thead>
						<tr>
							<th colspan="2">主观题答案 </th>
						</tr>
					</thead>
						<tr>
							<td>题目</td>
							<td><a href="#biaotiModal" role="button" data-toggle="modal" class="thumbnail">
								<img src="<?php echo $this->tpl_var['question']['subtiltle']; ?>"></a>
							</td>
						</tr>
							<tr>
							<td width="13%">题型</td>
							<td>自备题</td>
						</tr>
						<tr>
							<td>答题用户</td>
							<td><?php echo $this->tpl_var['question']['username']; ?></td>
						</tr>
						
						
							<tr>
							<td>图片答案</td>
							<td>
							<a href="#myModal" role="button" data-toggle="modal" class="thumbnail">
							<img data-src="holder.js/300x200" alt="" src="app/core/styles/images/daan.jpg"></a>
							</td>
						</tr>
						
					</table>	
				

				</div>

				<div class="span6" >
						<table class="table table-hover table-bordered"> 
					<thead>
						<tr>
							<th colspan="2">教师批改</th>
						</tr>
					</thead>
						<tr>
							<td>视频标题</td>
							<td><input id="basic" name="argss[videoname]" type="text" value="" needle="needle" msg="您必须输入视频名称" /></td>
						</tr>
						<tr>
							<td>视频简介</td>
							<td><textarea class="input-xlarge" rows="4" name="argss[content]" id="basicprice"></textarea>
					  	<span class="help-block">介绍一下课程，限制200字</span></td>
						</tr>
						<tr>
							<td width="15%">视频上传</td>
							<td>
							
							<button class="btn btn-large" id="upload" type="button">视频上传</button>
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

							
						</script></td>
						</tr>
							<tr>
							<td>视频预览</td>
							<td>
								<a href="#newModal" role="button" data-toggle="modal" class="thumbnail">
								<button class="btn btn-large" type="button">视频预览</button>
							</a>
							</td>
						</tr>
					</table>	
						<div class="control-group">
								<div id="HTML">
						
								</div>
						</div>	
						<div class="control-group">
							<div class="controls">
								<button class="btn btn-primary"  type="submit">提交</button>
								<input type="hidden" name="courseid" value="<?php echo $this->tpl_var['courseid']; ?>">
								<input type="hidden" name="args[videourl]" id="remoteurl" value="">
								<input type="hidden" name="args[teacherid]" value="<?php echo $this->tpl_var['_user']['userid']; ?>">
								<input type="hidden" name="args[videoid]" id="videovid" value="">
								<input type="hidden" name="args[mp4url]" id="mp4" value="">
								<input type="hidden" name="args[is_correcting]" value="1">
								<input type="hidden" name="args[videohumb]" value="" id="imaes">
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
			</div>
		</form>
		
	</div>
</div>
<div id="newModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">视频预览</h3>
  </div>
  <div class="modal-body">
   <embed width="520" height="350" src="<?php echo $this->tpl_var['cat']['remoteurl']; ?>" id="VEDIO_IMG" />
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
  </div>
</div>

<div id="biaotiModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="left:auto !important;width:auto !important;margin-left:auto !important;margin-right:auto !important">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">用户上传答案</h3>
  </div>
  <div class="modal-body" style="max-height:auto !important;height:auto;">
    <img width="100%" src="<?php echo $this->tpl_var['question']['subtiltle']; ?>">
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
  </div>
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="left:auto !important;width:auto !important;margin-left:auto !important;margin-right:auto !important">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">用户上传答案</h3>
  </div>
  <div class="modal-body" style="max-height:auto !important;height:auto;">
    <img width="100%" src="<?php echo $this->tpl_var['question']['answer_img']; ?>">
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
  </div>
</div>
</body>
</html>