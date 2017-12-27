jQuery(document).ready(function($){
	
	
	$('[data-toggle="tooltip"]').tooltip(); 

	$(document).on( 'click', '.link_download', function() {
		var docID = $(this).attr('data-id');
		var key = $(this).attr('data-key');
		$("body > .rs-loading").remove();		
		$("body").append('<div class="rs-loading"></div>');
		$.post(site_ajax + 'ajax/download_direct', { id: docID, key: key, _nonce : $.cookie('_csrf_cookie') }, function(data) {
			$('.rs-loading').delay(100).animate({
				"opacity" : "0"
			}, 500).promise().done(function(){
				$(this).remove();
				if(data.complete != undefined){
					
					if(data.alert != undefined){
						$('.z-index').css({ zIndex: 9 });
						bootbox.alert(data.alert, function() {
							if(data.reload != undefined){
								location.reload();
							}else{
								window.location.href = data.location;
							}
						});
					}else{
						window.location.href = data.location;
					}
				}else{
					if(data.alert != undefined){
						$('.z-index').css({ zIndex: 9 });
						bootbox.alert(data.alert, function() {
							setTimeout(function(){
								$('.z-index').removeAttr('style');
							}, 700);
						});
					}
				}
			});
		}, 'json').error(function(xhr, ajaxOptions, thrownError) {
			$("body > .rs-loading").remove();
		});
	});

	$(document).on( 'click', '.task-submit', function() {
		$("body > .rs-loading").remove();		
		$("body").append('<div class="rs-loading"></div>');
	
		$.post(site_ajax + 'task/ajax/verify', { id: $('.task_hash').val(), content: $('.task_content').val(), _nonce : $.cookie('_csrf_cookie') }, function(data) {
			$('.rs-loading').delay(100).animate({
				"opacity" : "0"
			}, 500).promise().done(function(){
				$(this).remove();
				if(data.complete != undefined){
					
					if(data.alert != undefined){
						$('.z-index').css({ zIndex: 9 });
						bootbox.alert(data.alert, function() {
							if(data.reload != undefined){
								location.reload();
							}else{
								window.location.href = data.location;
							}
						});
					}else{
						if(data.reload != undefined){
							location.reload();
						}else{
							window.location.href = data.location;
						}
					}
				}else{
					if(data.alert != undefined){
						$('.z-index').css({ zIndex: 9 });
						bootbox.alert(data.alert, function() {
							setTimeout(function(){
								$('.z-index').removeAttr('style');
							}, 700);
						});
					}
				}
			});
		}, 'json').error(function(xhr, ajaxOptions, thrownError) {
			$("body > .rs-loading").remove();
		});
		return false;
	});
});

function downloadDocument(docID)
{
	$("body > .rs-loading").remove();		
	$("body").append('<div class="rs-loading"></div>');
	$.post(site_ajax + 'ajax/download', { id: docID, _nonce : $.cookie('_csrf_cookie') }, function(data) {
		$('.rs-loading').delay(100).animate({
			"opacity" : "0"
		}, 500).promise().done(function(){
			$(this).remove();
			if(data.complete != undefined){
				
				if(data.alert != undefined){
					$('.z-index').css({ zIndex: 9 });
					bootbox.alert(data.alert, function() {
						if(data.reload != undefined){
							location.reload();
						}else{
							window.location.href = data.location;
						}
					});
				}else{
					if(data.reload != undefined){
						location.reload();
					}else{
						window.location.href = data.location;
					}
				}
			}else{
				if(data.alert != undefined){
					$('.z-index').css({ zIndex: 9 });
					bootbox.alert(data.alert, function() {
						setTimeout(function(){
							$('.z-index').removeAttr('style');
						}, 700);
					});
				}
			}
		});
	}, 'json').error(function(xhr, ajaxOptions, thrownError) {
		$("body > .rs-loading").remove();
	});
	return false;
}


	function logout() {
		$("body > .rs-loading").remove();		
		$("body").append('<div class="rs-loading"></div>');
		$.post(site_ajax + 'member/logout', { _nonce : $.cookie('_csrf_cookie') }, function(data) {
			$('.rs-loading').delay(100).animate({
				"opacity" : "0"
			}, 500).promise().done(function(){
				$(this).remove();
				if(data.complete != undefined){
					window.location.href = data.location;
				}
			});
		}, 'json').error(function(xhr, ajaxOptions, thrownError) {
			$("body > .rs-loading").remove();
		});
		return false;
	}


