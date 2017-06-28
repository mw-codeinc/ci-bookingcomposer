var Login = function () {

	var handleLogin = function() {

		$('.login-form input').keypress(function (e) {
			if (e.which == 13) {
				if ($('.login-form').validate().form()) {
					$('.login-form').submit();
				}
				return false;
			}
		});
	}

	var handleForgetPassword = function () {
		$('.forget-form input').keypress(function (e) {
			if (e.which == 13) {
				if ($('.forget-form').validate().form()) {
					$('.forget-form').submit();
				}
				return false;
			}
		});

		jQuery('#forget-password').click(function () {
			jQuery('.login-form').hide();
			jQuery('.forget-form').show();
		});

		jQuery('#back-btn').click(function () {
			jQuery('.login-form').show();
			jQuery('.forget-form').hide();
		});

	}

	var handleRegister = function () {

		function format(state) {
			if (!state.id) return state.text;
			return "<img class='flag' src='../../img/flags/" + state.element[0]['attributes'][0]['value'].toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
		}


		$("#countrySelect").select2({
			placeholder: '<i class="fa fa-flag"></i>&nbsp;Wybierz kraj',
			allowClear: true,
			formatResult: format,
			formatSelection: format,
			escapeMarkup: function (m) {
				return m;
			}
		});

		$('#countrySelect').change(function () {
			$('.register-form').validate().element($(this));
		});

		$('.register-form input').keypress(function (e) {
			if (e.which == 13) {
				if ($('.register-form').validate().form()) {
					$('.register-form').submit();
				}
				return false;
			}
		});

		jQuery('#register-btn').click(function () {
			jQuery('.login-form').hide();
			jQuery('.register-form').show();
		});

		jQuery('#register-back-btn').click(function () {
			jQuery('.login-form').show();
			jQuery('.register-form').hide();
		});
	}

	return {
		init: function () {

			handleLogin();
			handleForgetPassword();
			handleRegister();

			$.backstretch([
					"../img/login/bg/1.jpg",
					"../img/login/bg/2.jpg",
					"../img/login/bg/3.jpg",
					"../img/login/bg/4.jpg"
				], {
					fade: 1000,
					duration: 8000
				}
			);
		}
	};

}();

jQuery(document).ready(function() {
	Login.init();
});