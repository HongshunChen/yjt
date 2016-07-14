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
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master">全局</a> <span class="divider">/</span></li>
				<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-demand-vedio">视频列表</a> <span class="divider">/</span></li>
				
			</ul>
			<div class="row-fluid">
					

		
	
		
		
	

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
   }
    var upload = new PolyvUpload(obj);

	
</script>
			</div>
		</div>
	</div>
</div>
</body>
</html>