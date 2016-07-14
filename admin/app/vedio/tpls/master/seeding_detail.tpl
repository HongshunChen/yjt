<div>
	<div ><embed width="520" height="350" src="{x2;$cat['vurl']}" id="VEDIO_IMG" />	
				</div>
				<table class="table table-hover">
			        <tr>
			          <td width="30%">直播名称</td>
			          <td>{x2;$cat['vname']}</td>
			        </tr>
			        <tr>
			        	<td>截止时间</td>
			        	<td>
			          	{x2;date:$cat['endtime'],'Y-m-d H:i:s'}
						</td>
			        </tr>
			        <tr>
			          <td>直播价格</td>
			          <td>{x2;$cat['vprice']}</td>
			        </tr>
			        <tr>
			          <td>直播简介</td>
			          <td>{x2;$cat['vintro']}</td>
			        </tr>
			        
				</table>

</div>