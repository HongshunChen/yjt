				<table class="table table-hover">
			        <tr>
			          <td width="15%">题干</td>
			          <td>{x2;realhtml:$question['subname']}</td>
			        </tr>
			        <tr>
			        	<td>题型</td>
			        	<td>
			          		{x2;$question['questype']}
						</td>
			        </tr>
			        <tr>
			        	<td>答题用户</td>
			        	<td>{x2;$question['username']}</td>
			        </tr>
			        <tr>
			        	<td>答题时间</td>
			        	<td>
			          		{x2;date:$question['usertime'],'Y-m-d H:i:s'}
						</td>
			        </tr>
			        <tr>
			          <td>用户答案</td>
			          <td>{x2;$question['answer_text']}</td>
			        </tr>
			        
				</table>

