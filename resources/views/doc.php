<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
		<title>api</title>
		<!-- Bootstrap -->
		<link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/css/main.css" rel="stylesheet" type="text/css"  />
		<script src="assets/js/vue.js" type="text/javascript" charset="utf-8"></script>
		<script src="assets/config/config.js" type="text/javascript" charset="utf-8"></script>
		<script src="assets/config/host.js" type="text/javascript" charset="utf-8"></script>
		<script src="assets/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="assets/js/js.cookie.js"></script>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
      <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	</head>

	<body>
		<div id="app" class="panel panel-default">
			<div class="panel-heading">API文档</div>
			<div class="row">
				<div id="left" class="col-md-2">
					<ul class="nav nav-pills nav-stacked main-nav">
						<li role="presentation" v-for="(mainIndex,main) in nav" >
							<a class="main-title" href="#">{{main.title}}</a>
							<ul class="nav nav-pills nav-stacked sub-nav">
								<li role="presentation" v-for="(subIndex,sub) in main.sub" v-on:click="chgInfo(mainIndex,subIndex)">
									<a class="sub-title" :class="{'del': sub.del}" href="#">{{sub.title}}</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				<div id="center" class="col-md-10">
					<template v-if="url">
						<div class="panel panel-default">
							<div class="panel-heading">基本信息</div>
							<div class="panel-body">
								<p v-if="desc">接口描述 : {{desc}}</p>
								<p v-else>接口描述 : {{title}}</p>
								<p>请求类型 : {{type}}</p>
								<p>host地址 : {{host}}</p>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">调用地址</div>
							<div class="panel-body">
								host + {{url}}
							</div>
						</div>
						<div class="panel panel-default" >
							<div class="panel-heading">接收参数</div>
							<div class="panel-body">
								<template v-if="requireList.length">
									<div class="row">
										<div class="col-md-2">参数名称</div>
										<div class="col-md-10">描述</div>
									</div>
									<div class="row" v-for="require in requireList" >
										<div class="col-md-2">{{require.name}}</div>
										<div class="col-md-10">{{require.desc}}</div>
									</div>
								</template>
								<template v-if="!requireList.length">
									<p>不需要参数</p>
								</template>
							</div>
						</div>
						
						<div class="panel panel-default">
							<div class="panel-heading">返回参数</div>
							<div class="panel-body">
								<template v-if="responseList.length">
									<div class="row">
										<div class="col-md-2">参数名称</div>
										<div class="col-md-10">描述</div>
									</div>
									<div class="row" v-for="response in responseList" >
										<div class="col-md-2">{{response.name}}</div>
										<div class="col-md-10">
											<div>
												{{response.desc}}
											</div>
											<div class="sub" v-if="response.sub.length>0" v-for="sub in response.sub">
												<div class="col-md-2">{{sub.name}}</div>
												<div class="col-md-10">{{sub.desc}}</div>
												<div class="sub2" v-if="sub.sub.length>0" v-for="sub2 in sub.sub">
													<div class="col-md-2">{{sub2.name}}</div>
													<div class="col-md-10">{{sub2.desc}}</div>
												</div>
											</div>
										</div>
									</div>
								</template>
								<template v-if="!responseList.length">
									<p>没有返回数据</p>
								</template>
							</div>
						</div>
						<div class="panel panel-default" >
							<div class="panel-heading">测试</div>
							<div class="panel-body">
								<form id="form" action="#" target="_blank" method="{{type}}" enctype="multipart/form-data">
									<div class="row" v-for="require in requireList" >
										<div class="col-md-2">{{require.name}}</div>
										<div v-if="require.name == 'token'" class="col-md-10">
											<input  type="text" name="{{require.name}}" value="{{token}}" />
										</div>
										<div v-if="require.type=='file'" class="col-md-10">
											<input  type="file" name="{{require.name}}" value="{{require.default}}" />
										</div>
										<div v-if="!require.type && require.name != 'token'" class="col-md-10">
											<input  type="text" name="{{require.name}}" value="{{require.default}}" />
										</div>
										
									</div>
									<div>
										<input v-on:click="formTest" type="button" value="form提交"/>
									</div>
									<div>
										<input v-on:click="submit" type="button" value="ajax提交"/>
									</div>
								</form>
							</div>
							<div class="panel-body">
								{{dataJson}}
							</div>
						</div>
					</template>
					<template v-if="!url">
						<div class="welcome">
							欢迎使用 :)
						</div>
					</template>
					
				</div>
			</div>
		</div>
		<script src="assets/js/bootstrap.min.js"></script>
		<script type="text/javascript">
		
			var vm = new Vue({
				el:"#app",
				data:{
					host:host,
					nav:nav,
					title:'',
					desc:'',
					url:'',
					type:'',
					requireList:'',
					responseList:'',
					token:'',
					dataJson:''
				},
				methods:{
					chgInfo:function(mainIndex,subIndex){
						vm.url = nav[mainIndex]['sub'][subIndex].url;
						vm.dataJson = '';
						vm.requireList = nav[mainIndex]['sub'][subIndex].require;
						vm.responseList = nav[mainIndex]['sub'][subIndex].response;
						vm.type = nav[mainIndex]['sub'][subIndex].type;
						vm.title = nav[mainIndex]['sub'][subIndex].title;
						vm.desc = nav[mainIndex]['sub'][subIndex].desc;
					},
					submit:function(){

						var data = {};
						$("form").serializeArray().map(function(x){data[x.name] = x.value;});

						$.ajax({
							type: 'get',
							data: data,
							dataType:"jsonp",
							url: host + vm.url,
							success:function(data){
								if (data.data.token) {
									Cookies.set('token', data.data.token);
								}
								var dataJson = JSON.stringify(data);
								vm.dataJson = dataJson;
							},
							error:function(){
								console.log('fail');
							}
						})
					},
					formTest:function(){
						var url = host + vm.url;
// 						var url = vm.url;
						var method = vm.method;
						
						$("#form").attr("action",url);
						$("#form").attr("method",method);
						
						$("#form").submit();
						
					}
				}
			})
			
			var token = Cookies.get('token');
			vm.token = token;
		</script>
	</body>

</html>