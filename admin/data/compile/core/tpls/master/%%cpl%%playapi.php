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
				<li><a href="index.php?core-master">全局</a> <span class="divider">/</span></li>
				<li class="active">支付设置</li>
			</ul>
      
        <table class="table table-hover table-bordered"> 
          <thead>
            <tr>
              <th >支付宝接口API</th>
              <th ><a href="#myModal" role="button" data-toggle="modal" class="btn btn-primary disabled">修改</a></th>
            </tr>
          </thead>
            <tbody>
            <tr>
              <td width="16%">合作身份者ID</td>
              <td id="cfgapp">
                <?php echo $this->tpl_var['config']['partner']; ?> </td>
            </tr>
              <tr>
              <td>收款支付宝账号</td>
              <td><?php echo $this->tpl_var['config']['seller_id']; ?></td>
            </tr>
            <tr>
            	<td>MD5密钥</td>
				<td><?php echo $this->tpl_var['config']['key']; ?></td>
            </tr>
            <tr>
            	<td>服务器异步通知页面路径</td>
				<td><?php echo $this->tpl_var['config']['notify_url']; ?></td>
            </tr>
            <tr>
            	<td>页面跳转同步通知页面路径</td>
				<td><?php echo $this->tpl_var['config']['return_url']; ?></td>
            </tr>

           
                      </tbody></table>

		</div>
	</div>
</div>
  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">修改短信接口API</h3>
  </div>

  <div class="modal-body">
 
      <table class="table table-hover table-bordered"> 
            <tbody>
              <tr>
              <td width="30%">合作身份者ID</td>
              <td id="cfgapp">
                <input name="args[partner]" id="partner" type="text" value="<?php echo $this->tpl_var['config']['partner']; ?>"  alt="请输入账号" /></td>
            </tr>
              <tr>
              <td>收款支付宝账号</td>
              <td><input name="args[seller_id]" id="seller_id" type="text" value="<?php echo $this->tpl_var['config']['seller_id']; ?>"  alt="请输入账号" /></td>
            </tr>
            <tr>
            	<td>MD5密钥</td>
				<td><input name="args[key]" id="key" type="text" value="<?php echo $this->tpl_var['config']['key']; ?>"  alt="请输入账号" /></td>
            </tr>
            <tr>
            	<td>服务器异步通知页面</td>
				<td><input name="args[notify_url]" id="notify_url" type="text" value="<?php echo $this->tpl_var['config']['notify_url']; ?>"  alt="请输入账号" /></td>
            </tr>
            <tr>
            	<td>页面跳转同步通知页面</td>
				<td><input name="args[return_url]" id="return_url" type="text" value="<?php echo $this->tpl_var['config']['return_url']; ?>"  alt="请输入账号" /></td>
            </tr>
            
           
                      </tbody></table>
                      <script type="text/javascript">
                      function  addsms() {
                        var partner = document.getElementById('partner').value;
                        var seller_id  = document.getElementById('seller_id').value;
                         var key  = document.getElementById('key').value;
                          var notify_url  = document.getElementById('notify_url').value;
                           var return_url  = document.getElementById('return_url').value;
                        $.post('index.php?core-master-playapi-addplayapi',{
                          cfid:1,
                          partner:partner,
                          seller_id:seller_id,
                          key:key,
                          notify_url:notify_url,
                          return_url:return_url
                        },function (data) {
                           $('#myModal').modal('hide')
                        });
                      }
                      </script>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <button class="btn btn-primary" onclick="addsms();">提交</button>
  </div>
</div>
</body>
</html>