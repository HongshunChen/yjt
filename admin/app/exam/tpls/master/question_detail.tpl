				<table class="table table-hover">
			        <tr>
			          <td width="65">标题：</td>
			          <td>{x2;realhtml:$question['question']}</td>
			        </tr>
			        <tr>
			        	<td>备选项：</td>
			        	<td>
			          	{x2;realhtml:$question['questionselect']}
						</td>
			        </tr>
			        <tr>
			          <td>答案：</td>
			          <td>{x2;realhtml:$question['questionanswer']}</td>
			        </tr>
			        <tr>
			          <td>解析：</td>
			          <td>{x2;realhtml:$question['questiondescribe']}&nbsp;</td>
			        </tr>
			        <tr>
			          <td>难度：</td>
			          <td>{x2;if:$question['questionlevel']==1}易{x2;elseif:$question['questionlevel']==2}中{x2;elseif:$question['questionlevel']==3}难{x2;endif}&nbsp;</td>
			        </tr>
				</table>