/*
 Validator jQuery Plugin
 Validator is a JQuery validation plugin for forms.
 version 1.4, Jan 31th, 2014
 by Ingi P. Jacobsen

 The MIT License (MIT)

 Copyright (c) 2014 Faroe Media

 Permission is hereby granted, free of charge, to any person obtaining a copy of
 this software and associated documentation files (the "Software"), to deal in
 the Software without restriction, including without limitation the rights to
 use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 the Software, and to permit persons to whom the Software is furnished to do so,
 subject to the following conditions:

 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

Validator = {
	elementErrorClass: 'error',
	language: 'fo',
	languages: {
		'fo': {
			textbox: {
				required: 'Hetta økið er kravt',
				min: 'Hetta økið skal í minsta lagi vera {characters} stavir',
				max: 'Hetta økið skal í mesta lagi vera {characters} stavir',
				email: 'Teldupost adressan er ikki gildig',
				url: 'Vev adressan er ikki gildig',
				number: 'Bert tøl eru loyvd',
				digits: 'Bert tøl eru loyvd'
			},
			password: {
				required: 'Hetta økið er kravt',
				min: 'Hetta økið skal í minsta lagi vera {characters} stavir',
				max: 'Hetta økið skal í mesta lagi vera {characters} stavir',
				match: 'Loyniorðini eru ikki líka'
			},
			radio: {
			},
			checkbox: {
				required: 'Hesin avkrossingarteigur er kravdur'
			},
			select: {
				required: 'Vel eitt virði í hesum vallista'
			},
			textarea: {
				required: 'Hetta økið er kravt',
				min: 'Hetta økið skal í minsta lagi vera {characters} stavir',
				max: 'Hetta økið skal í mesta lagi vera {characters} stavir',
				url: 'Vev adressan er ikki gildig'
			}
		},
		'da': {
			textbox: {
				required: 'Dette felt skal udfyldes',
				min: 'Dette felt skal være mindst {characters} tegn',
				max: 'Dette felt skal være højst {characters} tegn',
				email: 'Denne email er ugyldig',
				url: 'Denne webside er ugyldigt',
				number: 'Kun tal',
				digits: 'Kun tal'
			},
			password: {
				required: 'Dette felt skal udfyldes',
				min: 'Dette felt skal være mindst {characters} tegn',
				max: 'Dette felt skal være højst {characters} tegn',
				match: 'Kodeordene er ikke ens'
			},
			radio: {
			},
			checkbox: {
				required: 'Denne checkbox skal checkes'
			},
			select: {
				required: 'Vælg et felt i listen'
			},
			textarea: {
				required: 'Dette felt skal udfyldes',
				min: 'Dette felt skal være mindst {characters} tegn',
				max: 'Dette felt skal være højst {characters} tegn',
				url: 'Denne webside er ugyldigt'
			}
		},
		'en': {
			textbox: {
				required: 'This field is required',
				min: 'This field must contain at least {characters} characters',
				max: 'This field must not contain more than {characters} characters',
				email: 'Email is not valid',
				url: 'Website is not valid',
				number: 'Only numbers',
				digits: 'Only numbers'
			},
			password: {
				required: 'This field is required',
				min: 'This field must contain at least {characters} characters',
				max: 'This field must not contain more than {characters} characters',
				match: 'The passwords do not match'
			},
			radio: {
			},
			checkbox: {
				required: 'This checkbox is required'
			},
			select: {
				required: 'Choose a field from the list'
			},
			textarea: {
				required: 'This field is required',
				min: 'This field must contain at least {characters} characters',
				max: 'This field must not contain more than {characters} characters',
				url: 'Website is not valid'
			}
		}
	}, 
	showError: function (element, text) {
		if (!$(element).hasClass(Validator.elementErrorClass)) {
			var error = document.createElement('div');
			$(error).addClass('validator-error').html(text);
			
			if ($(element).attr('data-error-position') == undefined) {
				var errorPosition = 'before';
				if ($(this).is('input') && $(this).attr('type') == 'checkbox') {
					 errorPosition = 'before label';
				}
			} else {
				errorPosition = $(element).attr('data-error-position');
			}
			var attrValue = errorPosition.split(' ');
			var targetElementForError;
			if (attrValue[1] == undefined) {
				targetElementForError = element;
			} else {
				targetElementForError = $(element).closest(attrValue[1])[0];
			}
			if (attrValue[0] == 'before') {
				$(targetElementForError).before(error);
			} else if (attrValue[0] == 'after') {
				$(targetElementForError).after(error);
			}
			$(targetElementForError).addClass(Validator.elementErrorClass);
				
			if ($(element).attr('data-match') != undefined) {
				$('#' + $(element).attr('data-match')).addClass(Validator.elementErrorClass);
			}
		}
	},
	validate: function (form) {
		var hasErrors = false;
		var firstErrorElement = null;

		Validator.removeErrors(form);

		$(form).find('input, select, textarea').each(function () {
			var regex = null;
			// Input[type=text]
			if ($(this).is('input') && ($(this).attr('type') == 'text' || $(this).attr('type') == undefined)) {
				// required
				if ($(this).attr('data-required') != undefined && $(this).val() == '' && $(this).attr('data-required-if') == undefined) {
					Validator.showError(this, Validator.languages[Validator.language].textbox.required);
					hasErrors = true;
				}
				// required-if & required-if-value
				if ($(this).attr('data-required-if') != undefined && $(this).val() == '' && (($(this).attr('data-required-if-value') == undefined && $('#' + $(this).attr('data-required-if')).is(':checked')) || ($(this).attr('data-required-if-value') != undefined && $('#' + $(this).attr('data-required-if')).val() == $(this).attr('data-required-if-value')))) {
					Validator.showError(this, Validator.languages[Validator.language].textbox.required);
					hasErrors = true;
				}
				// min
				if ($(this).attr('data-min') != undefined && $(this).val().length < parseFloat($(this).attr('data-min')) && $(this).val().length != 0) {
					Validator.showError(this, Validator.languages[Validator.language].textbox.min.replace('{characters}', $(this).attr('data-min')));
					hasErrors = true;
				}
				// max
				if ($(this).attr('data-max') != undefined && $(this).val().length > parseFloat($(this).attr('data-max'))) {
					Validator.showError(this, Validator.languages[Validator.language].textbox.max.replace('{characters}', $(this).attr('data-min')));
					hasErrors = true;
				}

				// patterns
				if ($(this).attr('data-type') != undefined) {
					switch ($(this).attr('data-type')) {
						case 'email':
							regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
							if (!regex.test($(this).val()) && $(this).val() != '') {
								Validator.showError(this, Validator.languages[Validator.language].textbox.email);
								hasErrors = true;
							}
							break;
						case 'url':
							regex = /^(https?:\/\/)?((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|((\d{1,3}\.){3}\d{1,3}))(\:\d+)?(\/[-a-z\d%_.~+]*)*(\?[;&a-z\d%_{},.~+=-]*)?(\#[-a-z\d_]*)?$/i;
							if (!regex.test($(this).val().replace('_', '')) && $(this).val() != '') {
								Validator.showError(this, Validator.languages[Validator.language].textbox.url);
								hasErrors = true;
							}
							break;
						case 'number':
							regex = /^\s*(\+|-)?((\d+([\.,]\d+)?)|([\.,]\d+))\s*$/;
							if (!regex.test($(this).val()) && $(this).val() != '') {
								Validator.showError(this, Validator.languages[Validator.language].textbox.number);
								hasErrors = true;
							}
							break;
						case 'digits':
							regex = /^\s*\d+\s*$/;
							if (!regex.test($(this).val()) && $(this).val() != '') {
								Validator.showError(this, Validator.languages[Validator.language].textbox.digits);
								hasErrors = true;
							}
							break;
					}
				}
			}

			// Input[type=password]
			if ($(this).is('input') && $(this).attr('type') == 'password') {
				// required
				if ($(this).attr('data-required') != undefined && $(this).val() == '' && $(this).attr('data-required-if') == undefined) {
					Validator.showError(this, Validator.languages[Validator.language].password.required);
					hasErrors = true;
				}
				// required-if & required-if-value
				if ($(this).attr('data-required-if') != undefined && $(this).val() == '' && (($(this).attr('data-required-if-value') == undefined && $('#' + $(this).attr('data-required-if')).is(':checked')) || ($(this).attr('data-required-if-value') != undefined && $('#' + $(this).attr('data-required-if')).val() == $(this).attr('data-required-if-value')))) {
					Validator.showError(this, Validator.languages[Validator.language].password.required);
					hasErrors = true;
				}
				// min
				if ($(this).attr('data-min') != undefined && $(this).val().length < parseFloat($(this).attr('data-min')) && $(this).val().length != 0) {
					Validator.showError(this, Validator.languages[Validator.language].password.min.replace('{characters}', $(this).attr('data-min')));
					hasErrors = true;
				}
				// max
				if ($(this).attr('data-max') != undefined && $(this).val().length > parseFloat($(this).attr('data-max'))) {
					Validator.showError(this, Validator.languages[Validator.language].password.max.replace('{characters}', $(this).attr('data-min')));
					hasErrors = true;
				}
				// match
				if ($(this).attr('data-match') != undefined && $(this).val() != $('#' + $(this).attr('data-match')).val()) {
					Validator.showError(this, Validator.languages[Validator.language].password.match);
					hasErrors = true;
				}
			}

			// Input[type=radio]
			if ($(this).is('input') && $(this).attr('type') == 'radio') {
			}

			// Input[type=checkbox]
			if ($(this).is('input') && $(this).attr('type') == 'checkbox') {
				// required
				if ($(this).attr('data-required') != undefined && !$(this).is(':checked') && $(this).attr('data-required-if') == undefined) {
					Validator.showError(this, Validator.languages[Validator.language].checkbox.required);
					hasErrors = true;
				}
				// required-if & required-if-value
				if ($(this).attr('data-required-if') != undefined && $(this).val() == '' && (($(this).attr('data-required-if-value') == undefined && $('#' + $(this).attr('data-required-if')).is(':checked')) || ($(this).attr('data-required-if-value') != undefined && $('#' + $(this).attr('data-required-if')).val() == $(this).attr('data-required-if-value')))) {
					Validator.showError(this, Validator.languages[Validator.language].checkbox.required);
					hasErrors = true;
				}
			}

			// Select
			if ($(this).is('select')) {
				// required
				if ($(this).attr('data-required') != undefined && $(this).val() == '' && $(this).attr('data-required-if') == undefined) {
					Validator.showError(this, Validator.languages[Validator.language].select.required);
					hasErrors = true;
				}
				// required-if & required-if-value
				if ($(this).attr('data-required-if') != undefined && $(this).val() == '' && (($(this).attr('data-required-if-value') == undefined && $('#' + $(this).attr('data-required-if')).is(':checked')) || ($(this).attr('data-required-if-value') != undefined && $('#' + $(this).attr('data-required-if')).val() == $(this).attr('data-required-if-value')))) {
					Validator.showError(this, Validator.languages[Validator.language].select.required);
					hasErrors = true;
				}

			}

			// Textarea
			if ($(this).is('textarea')) {
				// required
				if ($(this).attr('data-required') != undefined && $(this).val() == '' && $(this).attr('data-required-if') == undefined) {
					Validator.showError(this, Validator.languages[Validator.language].textarea.required);
					hasErrors = true;
				}
				// required-if & required-if-value
				if ($(this).attr('data-required-if') != undefined && $(this).val() == '' && (($(this).attr('data-required-if-value') == undefined && $('#' + $(this).attr('data-required-if')).is(':checked')) || ($(this).attr('data-required-if-value') != undefined && $('#' + $(this).attr('data-required-if')).val() == $(this).attr('data-required-if-value')))) {
					Validator.showError(this, Validator.languages[Validator.language].textarea.required);
					hasErrors = true;
				}
				// min
				if ($(this).attr('data-min') != undefined && $(this).val().length < parseFloat($(this).attr('data-min')) && $(this).val().length != 0) {
					Validator.showError(this, Validator.languages[Validator.language].textarea.min.replace('{characters}', $(this).attr('data-min')));
					hasErrors = true;
				}
				// max
				if ($(this).attr('data-max') != undefined && $(this).val().length > parseFloat($(this).attr('data-max'))) {
					Validator.showError(this, Validator.languages[Validator.language].textarea.max.replace('{characters}', $(this).attr('data-min')));
					hasErrors = true;
				}
				// patterns
				if ($(this).attr('data-type') != undefined) {
					switch ($(this).attr('data-type')) {
						case 'url':
							regex = /^(https?:\/\/)?((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|((\d{1,3}\.){3}\d{1,3}))(\:\d+)?(\/[-a-z\d%_.~+]*)*(\?[;&a-z\d%_{},.~+=-]*)?(\#[-a-z\d_]*)?$/i;
							if (!regex.test($(this).val()) && $(this).val() != '') {
								Validator.showError(this, Validator.languages[Validator.language].textarea.url);
								hasErrors = true;
							}
							break;
					}
				}
			}

			// Focus first element with error
			if (hasErrors && firstErrorElement == null) {
				firstErrorElement = this;
				$(this).focus();
			}
		});
		return !hasErrors;
	},
	removeErrors: function (form) {
		// Remove all error text divs
		$(form).find('.validator-error').each(function () {
			$(this).remove();
		});
		$(form).find('.error').each(function () {
			$(this).removeClass('error');
		});

		// Reset error classes
		$(form).find('input[type=text], input[type=password], input[type=radio], input[type=checkbox], select, textarea').each(function () {
			if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
				$(this).closest('label').removeClass(Validator.elementErrorClass);
			} else {
				$(this).removeClass(Validator.elementErrorClass);
			}
		});

	}
};

$(function () {
	$('form.validator').each(function () {
		$(this).submit(function () {
			return Validator.validate(this);
		});
	});
});