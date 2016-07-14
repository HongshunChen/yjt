function none_blo(no, div_id_img, div_id_text) {
	var obj_img = document.getElementById(div_id_img);
	var obj = document.getElementById(div_id_text);
	if (no == 0) {
		if (obj_img.style.display == "block") {
			obj_img.innerHTML = "";
			obj_img.style.display = "none";
		}
		if (obj.style.display == "none") {
			obj.style.display = "block";
			obj.focus();
		}
	} else if (no == 1) {
		if (obj.style.display == "block") {
			obj.style.display = "none";
			obj.value = "";
		}
		if (obj_img.style.display == "none") {
			obj_img.style.display = "block";
		}
	}
}