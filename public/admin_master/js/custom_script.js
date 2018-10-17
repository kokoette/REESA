$(document).ready(function() {

	$('#dltInbx').click(function() {
		var chkarr = []
		$('input.msgChkbx:checkbox:checked').each(function() {
			chkarr.push($(this).val());
		});
		urLoctn = document.location.href.match(/[^\/]+$/)[0];
		if(chkarr != '') {
			$.post("ajx.php", {
				msgKiste: chkarr,
				page: urLoctn
			}, function(data) {
				$('ul.message-list').html(data);
				// $('.inbx_cnt').text('10');
			});

			$.post("ajx_msg_cnt.php", {
				inbxCount: 'morgens'
			}, function(data) {
				$('.inbx_cnt').text(data);
			});
		}
	});

	$('#mrkUnRd').click(function() {
		var chkarr = []
		$('input.msgChkbx:checkbox:checked').each(function() {
			chkarr.push($(this).val());
		});
		urLoctn = document.location.href.match(/[^\/]+$/)[0];
		if(chkarr != '') {
			$.post("ajx.php", {
				msgMrkUnrd: chkarr,
				page: urLoctn
			}, function(data) {
				$('ul.message-list').html(data);
			});

			$.post("ajx_msg_cnt.php", {
				inbxCount: 'morgens'
			}, function(data) {
				$('.inbx_cnt').text(data);
			});

		}
	});




	$('#uPrTxtbx').keyup(function() {
		prptYears = $('#upPYSlct').val();
		prPriceTxt = $('#uPrTxtbx').val();
		prPriceTxt = parseFloat(prPriceTxt);
		if(prPriceTxt != '' && prptYears != '') {
			mnthPrcTxt = prPriceTxt / (prptYears * 12);
			mnthPrcTxt = mnthPrcTxt.toLocaleString(undefined, { minimumFractionDigits: 2 });
		}
		$('#upPaMntClc').text(mnthPrcTxt);
	});

	$('#upPYSlct').change(function() {
		prptYears = $(this).val();
		prPrice = $('#uPrTxtbx').val();
		prPrice = parseFloat(prPrice);

		if(prPrice != '') {
			mnthPrc = prPrice / (prptYears * 12);
			mnthPrc = mnthPrc.toLocaleString(undefined, { minimumFractionDigits: 2 });
		}
		$('#upPaMntClc').text(mnthPrc);
	});

	$('.amenity').click(function() {
		var arr = []
		$('input.amenity:checkbox:checked').each(function() {
			arr.push($(this).val());
		});
		locatn = document.location.href.match(/[^\/]+$/)[0];
		window.location = locatn + '&amenities=' + arr;
	});

	$('.state').change(function() {
		state_val = $(this).val();
		locatn = document.location.href.match(/[^\/]+$/)[0];
		window.location = locatn + '&state=' + state_val;
	});

	$('.sale_rent').click(function() {
			sale_rent = $(this).val();
			locatn = document.location.href.match(/[^\/]+$/)[0];
			window.location = locatn + '&sale_rent=' + sale_rent;
	});

});	

    function erfolg(msg) {
        toastr.success(msg,'',{
                    "positionClass": "toast-top-center",
                    timeOut: 5000,
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": false,
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    "tapToDismiss": true
                });
    }

    function fehler(msg) {
	    toastr.error(msg,'',{
	        "positionClass": "toast-top-center",
	        timeOut: 5000,
	        "closeButton": true,
	        "debug": false,
	        "newestOnTop": true,
	        "progressBar": false,
	        "preventDuplicates": true,
	        "onclick": null,
	        "showDuration": "300",
	        "hideDuration": "1000",
	        "extendedTimeOut": "1000",
	        "showEasing": "swing",
	        "hideEasing": "linear",
	        "showMethod": "fadeIn",
	        "hideMethod": "fadeOut",
	        "tapToDismiss": false

	    })
	}


					// var fruits = ["banana", 'apple'];
					// var n = fruits.includes("banana");

					//varName.unshift("lemonade");
					//varName.split("")
					///---- checkbox
											// $('input:checkbox.class').each(function() {
											// 	var sThisVal = (this.checked ? $(this).val() : "");
											// });

											// var checkedVals = $('.theClass:checkbox:checked').map(function() {
											// 	return this.value;
											// }).get();
											// alert(checkedVals.join(","));

											// //-------
											// $('input.yourClass:checkbox:checked').each(function() {
											// 	var sThisVal = $(this).val();
											// });

											// //---------

											// let myArray = (function() {
											// 	let a = [];
											// 	$(".checkboxes:checked").each(function() {
											// 		a.push(this.value);
											// 	});
											// 	return a;
											// });//})()

											// $('input.myclass[type=checkbox]').each(function() {
											// 	var sThisVal = (this.checked ? $(this).val() : "");
											// });

											// <input class="yourClass" type="checkbox">
											// <input class="yourClass" type="checkbox">

											// $(".yourClass:checkbox").filter(":checked");
											// /*


											// */