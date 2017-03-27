$(function(){
	//サイドメニューアコーディオン
	$("#sidebar .archive .year.current").next().show();
	$("#sidebar .archive .year").on('click', function(){
		$(this).toggleClass('current');
		$(this).next().slideToggle();
	});
});