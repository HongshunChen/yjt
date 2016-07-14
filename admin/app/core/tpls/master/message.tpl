{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{x2;include:menu}
		</div>
		<div class="span10">
			<ul class="breadcrumb">
				<li><a href="index.php?core-master">全局</a> <span class="divider">/</span></li>
				<li class="active">短信设置</li>
			</ul>
      
        <table class="table table-hover table-bordered"> 
          <thead>
            <tr>
              <th >短信接口API</th>
              <th ><a href="#myModal" role="button" data-toggle="modal" class="btn btn-primary disabled">修改</a></th>
            </tr>
          </thead>
            <tbody><tr>
              <td width="16%">账号</td>
              <td id="cfgapp">
                {x2;$config['cfgapp']} </td>
            </tr>
              <tr>
              <td>密钥</td>
              <td>{x2;$config['cfgsetting']}</td>
            </tr>

           
                      </tbody></table>
   <table class="table table-hover table-bordered"> 
          <thead>
            <tr>
              <th >短信模板</th>
              <th ><a href="#SmsModal" role="button" data-toggle="modal" class="btn btn-primary disabled">修改</a></th>
            </tr>
          </thead>
            <tbody>
            <tr>
              <td width="16%">模板名称</td>
              <td>
                {x2;$mobile['smsname']}</td>
            </tr>
              <tr>
              <td>模板内容</td>
              <td>{x2;$mobile['smstemplate']}</td>
            </tr>
             <tr>
              <td>用户签名</td>
              <td>{x2;$mobile['smsautograph']}</td>
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
            <tbody><tr>
              <td width="16%">账号</td>
              <td>
               <input name="args[smsname]" id="smsname" type="text" value="{x2;$config['cfgapp']}"  alt="请输入账号" /></td>
            </tr>
              <tr>
              <td>密钥</td>
              <td><input name="args[smspwd]" id="smspwd" type="text" value="{x2;$config['cfgsetting']}"  alt="请输入密钥"  /></td>
            </tr>
            
           
                      </tbody></table>
                      <script type="text/javascript">
                      function  addsms() {
                        var smsname = document.getElementById('smsname').value;
                        var smspwd  = document.getElementById('smspwd').value;
                        $.post('index.php?core-master-message-addsms',{
                          cfid:1,
                          smsname:smsname,
                          smspwd:smspwd
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
  <div id="SmsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">修改短信模板</h3>
  </div>

  <div class="modal-body">
 
      <table class="table table-hover table-bordered"> 
            <tbody> <tr>
              <td width="16%">模板名称</td>
              <td>
                <input name="name" id="name" type="text" value=""  alt="请输入"  /></td>
            </tr>
              <tr>
              <td>模板内容</td>
              <td><textarea class="input-xlarge" rows="4" name="template" id="template"></textarea><span class="help-block">@为可变值；可代替任意多个字符<br>
例：尊敬的：@，您的余额为：@，为确保正常使用，请及时充值【企业签名】 </span></td>
            </tr>
             <tr>
              <td>签名</td>
              <td><input name="autograph" id="autograph" type="text" value=""  alt="请输入"  /></td>
            </tr>
            
             <script type="text/javascript">
                      function  addtempalte() {
                        var name = document.getElementById('name').value;
                        var template  = document.getElementById('template').value;
                        var autograph = document.getElementById('autograph').value;
                        $.post('index.php?core-master-message-addtemplate',{
                          name:name,
                          template:template,
                          autograph:autograph,
                          id:1,
                        },function (data) {
                               $('#SmsModal').modal('hide');
                                
                        });

                      }
                      </script>
                      </tbody></table>
                   
  </div>

  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <button class="btn btn-primary" onclick="addtempalte();">提交</button>
  </div>
</div>


</body>
</html>