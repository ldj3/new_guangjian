function i3geek_xzh_submit(id, nonce){
	document.getElementById("i3geek_content"+id).innerHTML = '已提交';
	jQuery.post("admin.php?page=i3geek_xzh", { action: "i3geek_xzh_submit_manual", postid: id, _i3geek_xzh_post_nonce: nonce, original:1 } );
}