var i = 1,
	gentry = null,
	w = null;
var hl = null,
	le = null,
	de = null,
	ie = null;
var unv = true;
var path = null;
// H5 plus事件处理
function plusReady() {
	// 获取摄像头目录对象
	plus.io.resolveLocalFileSystemURL("_doc/", function(entry) {
		path = entry.toLocalURL();
		entry.getDirectory("camera", {
			create: true
		}, function(dir) {
			gentry = dir;
		}, function(e) {
			outSet("Get directory \"camera\" failed: " + e.message);
		});
	}, function(e) {
		outSet("Resolve \"_doc/\" failed: " + e.message);
	});
}
if (window.plus) {
	plusReady();
} else {
	document.addEventListener("plusready", plusReady, false);
}
// 监听DOMContentLoaded事件
document.addEventListener("DOMContentLoaded", function() {
	// 获取DOM元素对象
	if (ie = document.getElementById("index")) {
		alert(indexChanged);
		ie.onchange = indexChanged;
	}
	// 判断是否支持video标签
	unv = !document.createElement('video').canPlayType;
}, false);

function indexChanged() {
	de.innerText = ie.options[ie.selectedIndex].innerText;
	i = parseInt(ie.value);
	outLine(de.innerText);
}
// 拍照
function getImage(id,zhi) {
	var cmr = plus.camera.getCamera();
	cmr.captureImage(function(p) {
		var a = p.substring(12);
		var localPath = path + 'camera/' + a;
		document.getElementById(id).src = localPath;
		//压缩图片加上传

		compressImage(localPath, a,zhi);
		plus.io.resolveLocalFileSystemURL(p, function(entry) {}, function(e) {
			$.alert("读取拍照文件错误：" + e.message);
		});
	}, function(e) {
		$.alert('取消拍照');
	}, {
		filename: "_doc/camera/",
		index: 1
	});
}
// 从相册中选择图片
function galleryImg(id,zhi) {
	plus.gallery.pick(function(path) {
	
		var a = path.substring(12);
		var t = path.substring(path.lastIndexOf("/"), path.length);
		//压缩图片加上传
		
		compressImage(path, t,zhi);
			document.getElementById(id).src = path;
	}, function(e) {
		$.alert("取消选择图片");
	}, {
		filter: "image"
	});
}

function selectImg(id,zhi) {
	console.log('执行');
	if (mui.os.plus) {
		var a = [{
			title: "拍照"
		}, {
			title: "从手机相册选择"
		}];
		plus.nativeUI.actionSheet({
			title: "添加图片",
			cancel: "取消",
			buttons: a
		}, function(b) {
			switch (b.index) {
				case 0:
					break;
				case 1:
					getImage(id,zhi); //拍照
					break;
				case 2:
					galleryImg(id,zhi); //相册选择
					break;
				default:
					break
			}
		})
	}
}
//图片压缩
function compressImage(path, a,zhi) {
	plus.zip.compressImage({
			src: path,
				dst: '_doc/' + a,
			quality: 20,
			overwrite: true,
		},
		function() {
			var localPath = '_doc' + a;
			if(zhi==1){
				localStorage.setItem('yasuo',localPath);
			}else{
				localStorage.setItem('yasuo1',localPath);
			}
			alert('压缩成功');

		},
		function(error) {
			var localPath = '_doc' + a;
			if(zhi==1){
				localStorage.setItem('yasuo',localPath);
			}else{
				localStorage.setItem('yasuo1',localPath);
			}
			$.alert("请重试！");
		});
}