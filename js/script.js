// -------------------- Submit form & retrive with ajax (avoid refreshing) ----------------------
// --------------------------- Comment box show JS ----------------------

$(document).ready(function(){
	$('.commentVisible').click(function(){
		$($(this).data('target')).toggle(200);

		var len=$(this).data('target');
		var i=len.match(/\d+/)[0];
		i=parseInt(i);

		displayComments();

		$('.postComment'+i).click(function(){
			var uId=$('.cUserId'+i).val();
			var pId=$('.cPostId'+i).val();
			var com=$('.cUserComment'+i).val();

			if(com.length>0){
				$('.comment-error'+i).fadeOut(200);
				$.ajax({
					url: '../controllers/usersPost.php',
					type: 'POST',
					async: false,
					data:{
						'commentPosted': 1,
						'userId': uId,
						'postId': pId,
						'comment': com
					},
					success: function(action){
						displayComments();
						$('.cUserComment'+i).val('');
					}
				});
			}
			else{
				$('.comment-error'+i).fadeIn(200);
			}
			// else{
			// 	$('.comment-error'+i).fadeIn(200, function(){
			// 		$(this).css({'background':'blue', 'transition':'all 2s'}).delay(3000).queue(function(next){
			// 			$(this).css({'background':'#FFF', 'transition':'all 2s'});
			// 			next();
			// 		});
			// 	});
			// }
		});

		// ------------------------ All comments display -------------------
		function displayComments(){
			$.ajax({
				url: '../controllers/usersPost.php',
				type: 'POST',
				async: false,
				data:{
					'commentDisplay': 1,
					'id': i
				},
				success: function(data){
					$('.allComments'+i).hide().html(data).fadeIn(300);
				}
			});
		}
	});

	// -------------------- fadeIn transition for modal ----------------------
	var path='button.quizModal, '
			+'button.attendaceModal, '
			+'button.midtermModal, '
			+'button.hwModal, '
			+'button.finalModal';

	$(path).click(function(){
		$($(this).data('target')).fadeIn(700);
	});


	// ----------------------- Dependable input field (for max) ---------------------------
	$('#quizModalForm #totalMark').change(function(){
		$('#quizModalForm .form-control:not(#totalMark)').prop('max', this.value);
	});

	$('#midtermModalForm #totalMark').change(function(){
		$('#midtermModalForm .form-control:not(#totalMark)').prop('max', this.value);
	});

	$('#hwModalForm #totalMark').change(function(){
		$('#hwModalForm .form-control:not(#totalMark)').prop('max', this.value);
	});

	$('#finalModalForm #totalMark').change(function(){
		$('#finalModalForm .form-control:not(#totalMark)').prop('max', this.value);
	});

});
