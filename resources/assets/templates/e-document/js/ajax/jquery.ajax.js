(function($){

	$.fn.wzUI = function(user_setting){
        var m_default = {
            method: '',
            formAction: {
                action: '',
                field_load: '',
                submit: false,
                event_submit: '',
                event_error: '',
                event_complete: '',
                loading: false
            }
		};
        var m_settings = $.extend({}, m_default, user_setting);
		

        return $(this).each(function() {
            var _t = $(this);
            switch (m_settings.method) {
                case 'formAction':
				{
					
					if (m_settings.formAction.submit) {
						// Neu thuc hien submit form luon
					}else{
						// Submit qua form submit

							_t.submit(formActionHandle);
							_t.find('input[type=submit]').click(formActionHandle);
							_t.find('[_autocheck]').change(ajaxFormAutoCheckHandle);
					
					}
					break;
				}
                default:
                {
                        alert("Không tìm thấy thuộc tính: " + m_settings.method);
                        break;
                }	
			}
			
			function test(){
				alert('test');
			}
			
            /**
             * Form Action
             */
			function formActionHandle(){
				

                // Neu form dang xu ly thi bo qua
                if (m_settings.formAction.loading) {

                    return false;
                }
				
                // Set trang thai loading
                m_settings.formAction.loading = true;

                // Hien thi loader
                loader('show', m_settings.formAction.field_load);

                // Tao event submit
                if (typeof m_settings.formAction.event_submit == "function") {
                    m_settings.formAction.event_submit.call(this, m_settings.formAction);
                }
				
                // Lay action va params
                var action = m_settings.formAction.action;
                action = (!action) ? _t.attr('action') : action;
                action = (action == undefined || action == '') ? window.location.href : action;
				csrf_cookie = '';
				if($.cookie('_csrf_cookie')){
					csrf_cookie = '&_nonce=' + $.cookie('_csrf_cookie');
				}
				
				/* Checkbox */
	
				var moreinfo = '';
		
				$('input[type=checkbox]').each(function() {     
					if (!this.checked) {
						moreinfo += '&'+this.name+'=0';
					}
				});
				var special_params = '';
				var check_params = '';
				_t.find('[data-important="true"]').each(function( index ) {
					var name = $( this ).attr('name');
				  special_params += ',' + $( this ).attr('name');
				  if($('[name="'+ name + '"]').val()){
					  check_params = 1;
				  }
				});
				var special_params = jQuery.parseJSON('{"special": "' + special_params + '"}');
				console.log(check_params + ': '+ special_params);
				
                var params = '_submit=true&' + _t.formSerialize() + moreinfo + csrf_cookie;

							console.log('oday');
							$.post(action, params, function(data) {
								formActionResultHandle(data);
							}, 'json')
							.error(function(xhr, ajaxOptions, thrownError) {
								if(xhr.status == '403'){
									location.reload(true);
								}else{
									formActionResultHandle();
								}

							console.log('ERROR:' + thrownError);
							});
			
				
                return false;
			}

            function formActionResultHandle(data) {
                // Reset trang thai loading
                m_settings.formAction.loading = false;

                // An loader
                loader('hide', m_settings.formAction.field_load);
				
                // Neu ajax bi loi
                if (data == undefined) {
					$('.z-index').css({ zIndex: 9 });
					bootbox.alert("Hệ thống đã xảy ra lỗi, vui lòng liên hệ Quản trị viên để khắc phục lỗi!", function() {
						setTimeout(function(){ $('.menu-profiles').removeAttr('style'); }, 1000);
					});
                    return;
                }
				

                // Reset cac thong bao loi cu
               $(".alert").hide();
				
				

				
				if(data.complete){
					$('input[type="submit"]').prop('disabled', true);
                    // Tao event complete
                    if (typeof m_settings.formAction.event_complete == "function") {
                        m_settings.formAction.event_complete.call(this, data, m_settings.formAction);
                    }else{

						// Chuyen trang neu duoc khai bao
						if(data.alert != undefined){
							$('.z-index').css({ zIndex: 9 });
							bootbox.alert(data.alert, function() {
								setTimeout(function(){
		                        if (data.location) {
		                            window.parent.location = data.location;
		                        } else {
		                            window.location.reload();
		                        }
								$('.z-index').removeAttr('style');
								}, 700);
							});
						}else{
	                        if (data.location) {
	                            window.parent.location = data.location;
	                        } else {
	                            window.location.reload();
	                        }
						}

                    }
					
				}else{
					if(data.global_msg){
						$(".alert-danger").html(data.global_msg);
						$(".alert-danger").show();
						if(_t.find('.alert-danger').length){
							$('html, body').animate({
										scrollTop: _t.find('.alert-danger').first().offset().top-12
									}, 2000);
						}
						
						if(data.reload){
							if(data.settimeout){
								setTimeout(function(){ location.reload(); }, data.settimeout);
							}else{
								location.reload();
							}
							
						}
					}else if(data.alert != undefined){
							$('.z-index').css({ zIndex: 9 });
							bootbox.alert(data.alert, function() {
								setTimeout(function(){
										if (data.location != undefined) {
											window.parent.location = data.location;
										} else if (data.reload != undefined) {
											window.location.reload();
										}
										$('.z-index').removeAttr('style');
								}, 700);
							});
					}else if(data.dialog != undefined){
						bootbox.dialog({
							message: data.dialog,
							title: data.title,
							className: "my-modal",
						});
						$('.select2').select2();
					}else{
						// Hien thi thong bao loi hien tai
						$.each(data, function(param, value) {
							$('#qtip-'+ param).remove();
							$( "[name='" + param + "']" ).parents('.form-group').removeClass('has-success has-error');
							 $( "[name='" + param + "']" ).parents('.form-group').addClass('has-error');
							 $( "[name='" + param + "']" ).parents('.form-group').find('.tooltips').attr('title', value);
							 $( "[name='" + param + "']" ).parents('.form-group').find('.fa').addClass('fa-times');
							 $( "[name='" + param + "']" ).qtip({
								id: name,
								position: {
									my: "top left",
									at: "bottom left",
									viewport: $(window),
								  corner: {
									 target: 'topRight',
									 tooltip: 'bottomLeft'
								  }
								},
								hide: {
									effect: function () { $(this).slideUp(5, function () { $(this).dequeue(); }); }
								},
								style: {
									classes: "qtip-bootstrap"
								}
							 });
							 
							// if(param == 'wz_error_global'){
								// _t.prepend('<div class="wz_error_global"><div name="' + param + '_error" class="wz-frm-error">' + value + '</div></div>').show();
							// }
						});
						if(_t.find('.has-error').length){
							$('html, body').animate({
										scrollTop: _t.find('.has-error').first().offset().top-12
									}, 2000);
						}
					}
					
					

					

		
					// setTimeout ( function () {
						// var ts_height = $('.ts-height').outerHeight( true );
						// $('.content-common').css({'height': ts_height +'px'});
					// }, 500);


                    if (typeof m_settings.formAction.event_error == "function") {
                        m_settings.formAction.event_error.call(this, data, m_settings.formAction);
                    }

				}


			}
			
			
            /**
             * Ajax Form Auto Check
             */
            function ajaxFormAutoCheckHandle() {
				var _f = $(this);
								var name = _f.attr('name');
								if (!name) return;
								$('.qtip').remove();
								
								var value = _f.val();
								value = (!value) ? '' : value;
								
								
								// Lay action va params
								var action = m_settings.formAction.action;
								action = (!action) ? _t.attr('action') : action;
								action = (action == undefined || action == '') ? window.location.href : action;
								csrf_cookie = '';
								if($.cookie('_csrf_cookie')){
									csrf_cookie = '&_nonce=' + $.cookie('_csrf_cookie');
								}
								
								// Lay method
								var method = _t.attr('method');
								method = (!method) ? 'POST' : method;
				
								var autocheck = $('[name="' + name + '"]').parents('.form-group');

								
								$('[name="' + name + '"]').attr('readonly', true);
								autocheck.find('.input-icon > i').removeClass('fa-warning fa-check fa-times floading');
								autocheck.removeClass('has-error has-warning has-success');
								autocheck.find('.input-icon > i').addClass('floading');
								// Load du lieu va xu ly
								$.post(action, 'page=register&_autocheck=' + name + '&' + _t.serialize() + csrf_cookie, function(data) {
									
									$('[name="' + name + '"]').attr('readonly', false);
									autocheck.find('.input-icon > i').removeClass('has-error');
									autocheck.find('.input-icon > i').removeClass('fa-warning fa-check floading fa-times');
									//var id = $('.qtip').qtip('id');
									
									if (data.accept) {
											autocheck.addClass('has-success');
											autocheck.find('.fa').addClass('fa-check');
											autocheck.find('.tooltips').qtip('disable');
											
									}else{
										/* IF ALERT */
										if(data.alert){
											autocheck.addClass('has-warning');
											autocheck.find('.tooltips').attr('title', data.alert);
											autocheck.find('.fa').addClass('fa-warning');
										}else{
											autocheck.addClass('has-error');
											autocheck.find('.tooltips').attr('title', data.error);
											autocheck.find('.fa').addClass('fa-times');
										}

										/* CALL TOOLTIPS */
										autocheck.find('.tooltips').qtip({
											id: name,
											position: {
												my: "top left",
												at: "bottom left",
												viewport: $(window),
											  corner: {
												 target: 'topRight',
												 tooltip: 'bottomLeft'
											  }
											},
											hide: {
												effect: function () { $(this).slideUp(5, function () { $(this).dequeue(); }); }
											},
											show: { ready: true },
											style: {
												classes: "qtip-bootstrap"
											},
											events: {
												render: function () {
													console.log(2);
												}
											}
										 });
									}
								}, 'json')
								.error(function(xhr, ajaxOptions, thrownError) {
									if(xhr.status == '403'){
										$('.overlay').hide();
										location.reload(true);
									}else if(xhr.status == '200'){
										//location.reload(true);
									}else{
										console.log(xhr.status);
									}
								});
            }

			
            /**
             * Loader handle
             */
            function loader(action, field, data) {
                switch (action) {
                    case 'show':
                        {
                            if (!field) {
								$("body > .rs-loading").remove();
                                $('body').append('<div class="rs-loading"></div>');
                                //$('#overlay, #preloader').hide().fadeIn('slow');
                            } else {
                                $("#" + field).html('<div id="loader"></div>').hide().fadeIn('fast');
                            }
                            break;
                        }
                    case 'hide':
                        {
                            if (!field) {
								// jQuery("body > .rs-loading").remove()
                                $('.rs-loading').fadeOut('slow', function() {
                                    $(this).remove()
                                });
                            } else {
                                $("#" + field).fadeOut('slow');
                            }
                            break;
                        }
                    case 'result':
                        {
                            if (!field) return;
                            $("#" + field).html(data).show();
                            break;
                        }
                    case 'error':
                        {
                            if (!field) return;
                            $("#" + field).html('KhĂ´ng tĂ¬m tháº¥y liĂªn káº¿t: <b>' + data + '</b>').hide().fadeIn('fast');
                            break;
                        }
                }
            }
			
			function show_message(title, msg)
			{
				html = '';
				html += '<div class="modal fade" id="myModal" role="dialog">';
				html += '<div class="modal-dialog">';
					  html += '<!-- Modal content-->';
					  html += '<div class="modal-content">';
						html += '<div class="modal-header">';
						 html +=  '<button type="button" class="close" data-dismiss="modal">&times;</button>';
						  html += '<h4 class="modal-title">' + title + '</h4>';
						html += '</div>';
						html += '<div class="modal-body">';
						  html += '<p>' + msg + '</p>';
						html += '</div>';

					  html += '</div>';
					html += '</div>';
				  html += '</div>';
				$("body").append(html);
			}
			
			
			
		});
	}
}(jQuery));


/*!
 * jQuery WallForm Plugin
 * version: 2.84 (22-AUG-2011)
 * @requires jQuery v1.3.3 or later
 *
 * Examples and documentation at: http://malsup.com/jquery/form/
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 * Modified by Arun Sekar http://9lessons.info 
 */
;(function($) {



/**
 * ajaxSubmit() provides a mechanism for immediately submitting
 * an HTML form using AJAX.
 */
$.fn.ajaxSubmit = function(options) {
	// fast fail if nothing selected (http://dev.jquery.com/ticket/2752)
	if (!this.length) {
		log('ajaxSubmit: skipping submit process - no element selected');
		return this;
	}
	
	var method, action, url, $form = this;

	if (typeof options == 'function') {
		options = { success: options };
	}

	method = this.attr('method');
	action = this.attr('action');
	url = (typeof action === 'string') ? $.trim(action) : '';
	url = url || window.location.href || '';
	if (url) {
		// clean url (don't include hash vaue)
		url = (url.match(/^([^#]+)/)||[])[1];
	}

	options = $.extend(true, {
		url:  url,
		success: $.ajaxSettings.success,
		type: method || 'GET',
		iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank'
	}, options);

	// hook for manipulating the form data before it is extracted;
	// convenient for use with rich editors like tinyMCE or FCKEditor
	var veto = {};
	this.trigger('form-pre-serialize', [this, options, veto]);
	if (veto.veto) {
		log('ajaxSubmit: submit vetoed via form-pre-serialize trigger');
		return this;
	}

	// provide opportunity to alter form data before it is serialized
	if (options.beforeSerialize && options.beforeSerialize(this, options) === false) {
		log('ajaxSubmit: submit aborted via beforeSerialize callback');
		return this;
	}

	var n,v,a = this.formToArray(options.semantic);
	if (options.data) {
		options.extraData = options.data;
		for (n in options.data) {
			if( $.isArray(options.data[n]) ) {
				for (var k in options.data[n]) {
					a.push( { name: n, value: options.data[n][k] } );
				}
			}
			else {
				v = options.data[n];
				v = $.isFunction(v) ? v() : v; // if value is fn, invoke it
				a.push( { name: n, value: v } );
			}
		}
	}

	// give pre-submit callback an opportunity to abort the submit
	if (options.beforeSubmit && options.beforeSubmit(a, this, options) === false) {
		log('ajaxSubmit: submit aborted via beforeSubmit callback');
		return this;
	}

	// fire vetoable 'validate' event
	this.trigger('form-submit-validate', [a, this, options, veto]);
	if (veto.veto) {
		log('ajaxSubmit: submit vetoed via form-submit-validate trigger');
		return this;
	}

	var q = $.param(a);

	if (options.type.toUpperCase() == 'GET') {
		options.url += (options.url.indexOf('?') >= 0 ? '&' : '?') + q;
		options.data = null;  // data is null for 'get'
	}
	else {
		options.data = q; // data is the query string for 'post'
	}

	var callbacks = [];
	if (options.resetForm) {
		callbacks.push(function() { $form.resetForm(); });
	}
	if (options.clearForm) {
		callbacks.push(function() { $form.clearForm(); });
	}

	// perform a load on the target only if dataType is not provided
	if (!options.dataType && options.target) {
		var oldSuccess = options.success || function(){};
		callbacks.push(function(data) {
			var fn = options.replaceTarget ? 'replaceWith' : 'html';
			$(options.target)[fn](data).each(oldSuccess, arguments);
		});
	}
	else if (options.success) {
		callbacks.push(options.success);
	}

	options.success = function(data, status, xhr) { // jQuery 1.4+ passes xhr as 3rd arg
		var context = options.context || options;   // jQuery 1.4+ supports scope context 
		for (var i=0, max=callbacks.length; i < max; i++) {
			callbacks[i].apply(context, [data, status, xhr || $form, $form]);
		}
	};

	// are there files to upload?
	var fileInputs = $('input:file', this).length > 0;
	var mp = 'multipart/form-data';
	var multipart = ($form.attr('enctype') == mp || $form.attr('encoding') == mp);

	// options.iframe allows user to force iframe mode
	// 06-NOV-09: now defaulting to iframe mode if file input is detected
   if (options.iframe !== false && (fileInputs || options.iframe || multipart)) {
	   // hack to fix Safari hang (thanks to Tim Molendijk for this)
	   // see:  http://groups.google.com/group/jquery-dev/browse_thread/thread/36395b7ab510dd5d
	   if (options.closeKeepAlive) {
		   $.get(options.closeKeepAlive, function() { fileUpload(a); });
		}
	   else {
		   fileUpload(a);
		}
   }
   else {
		// IE7 massage (see issue 57)
		if ($.browser.msie && method == 'get') { 
			var ieMeth = $form[0].getAttribute('method');
			if (typeof ieMeth === 'string')
				options.type = ieMeth;
		}
		$.ajax(options);
   }

	// fire 'notify' event
	this.trigger('form-submit-notify', [this, options]);
	return this;


	// private function for handling file uploads (hat tip to YAHOO!)
	function fileUpload(a) {
		var form = $form[0], el, i, s, g, id, $io, io, xhr, sub, n, timedOut, timeoutHandle;
        var useProp = !!$.fn.prop;

        if (a) {
        	// ensure that every serialized input is still enabled
          	for (i=0; i < a.length; i++) {
                el = $(form[a[i].name]);
                el[ useProp ? 'prop' : 'attr' ]('disabled', false);
          	}
        }

		if ($(':input[name=submit],:input[id=submit]', form).length) {
			// if there is an input with a name or id of 'submit' then we won't be
			// able to invoke the submit fn on the form (at least not x-browser)
			alert('Error: Form elements must not have name or id of "submit".');
			return;
		}
		
		s = $.extend(true, {}, $.ajaxSettings, options);
		s.context = s.context || s;
		id = 'jqFormIO' + (new Date().getTime());
		if (s.iframeTarget) {
			$io = $(s.iframeTarget);
			n = $io.attr('name');
			if (n == null)
			 	$io.attr('name', id);
			else
				id = n;
		}
		else {
			$io = $('<iframe name="' + id + '" src="'+ s.iframeSrc +'" />');
			$io.css({ position: 'absolute', top: '-1000px', left: '-1000px' });
		}
		io = $io[0];


		xhr = { // mock object
			aborted: 0,
			responseText: null,
			responseXML: null,
			status: 0,
			statusText: 'n/a',
			getAllResponseHeaders: function() {},
			getResponseHeader: function() {},
			setRequestHeader: function() {},
			abort: function(status) {
				var e = (status === 'timeout' ? 'timeout' : 'aborted');
				log('aborting upload... ' + e);
				this.aborted = 1;
				$io.attr('src', s.iframeSrc); // abort op in progress
				xhr.error = e;
				s.error && s.error.call(s.context, xhr, e, status);
				g && $.event.trigger("ajaxError", [xhr, s, e]);
				s.complete && s.complete.call(s.context, xhr, e);
			}
		};

		g = s.global;
		// trigger ajax global events so that activity/block indicators work like normal
		if (g && ! $.active++) {
			$.event.trigger("ajaxStart");
		}
		if (g) {
			$.event.trigger("ajaxSend", [xhr, s]);
		}

		if (s.beforeSend && s.beforeSend.call(s.context, xhr, s) === false) {
			if (s.global) {
				$.active--;
			}
			return;
		}
		if (xhr.aborted) {
			return;
		}

		// add submitting element to data if we know it
		sub = form.clk;
		if (sub) {
			n = sub.name;
			if (n && !sub.disabled) {
				s.extraData = s.extraData || {};
				s.extraData[n] = sub.value;
				if (sub.type == "image") {
					s.extraData[n+'.x'] = form.clk_x;
					s.extraData[n+'.y'] = form.clk_y;
				}
			}
		}
		
		var CLIENT_TIMEOUT_ABORT = 1;
		var SERVER_ABORT = 2;

		function getDoc(frame) {
			var doc = frame.contentWindow ? frame.contentWindow.document : frame.contentDocument ? frame.contentDocument : frame.document;
			return doc;
		}
		
		// take a breath so that pending repaints get some cpu time before the upload starts
		function doSubmit() {
			// make sure form attrs are set
			var t = $form.attr('target'), a = $form.attr('action');

			// update form attrs in IE friendly way
			form.setAttribute('target',id);
			if (!method) {
				form.setAttribute('method', 'POST');
			}
			if (a != s.url) {
				form.setAttribute('action', s.url);
			}

			// ie borks in some cases when setting encoding
			if (! s.skipEncodingOverride && (!method || /post/i.test(method))) {
				$form.attr({
					encoding: 'multipart/form-data',
					enctype:  'multipart/form-data'
				});
			}

			// support timout
			if (s.timeout) {
				timeoutHandle = setTimeout(function() { timedOut = true; cb(CLIENT_TIMEOUT_ABORT); }, s.timeout);
			}
			
			// look for server aborts
			function checkState() {
				try {
					var state = getDoc(io).readyState;
					log('state = ' + state);
					if (state.toLowerCase() == 'uninitialized')
						setTimeout(checkState,50);
				}
				catch(e) {
					log('Server abort: ' , e, ' (', e.name, ')');
					cb(SERVER_ABORT);
					timeoutHandle && clearTimeout(timeoutHandle);
					timeoutHandle = undefined;
				}
			}

			// add "extra" data to form if provided in options
			var extraInputs = [];
			try {
				if (s.extraData) {
					for (var n in s.extraData) {
						extraInputs.push(
							$('<input type="hidden" name="'+n+'" />').attr('value',s.extraData[n])
								.appendTo(form)[0]);
					}
				}

				if (!s.iframeTarget) {
					// add iframe to doc and submit the form
					$io.appendTo('body');
	                io.attachEvent ? io.attachEvent('onload', cb) : io.addEventListener('load', cb, false);
				}
				setTimeout(checkState,15);
				form.submit();
			}
			finally {
				// reset attrs and remove "extra" input elements
				form.setAttribute('action',a);
				if(t) {
					form.setAttribute('target', t);
				} else {
					$form.removeAttr('target');
				}
				$(extraInputs).remove();
			}
		}

		if (s.forceSync) {
			doSubmit();
		}
		else {
			setTimeout(doSubmit, 10); // this lets dom updates render
		}

		var data, doc, domCheckCount = 50, callbackProcessed;

		function cb(e) {
			if (xhr.aborted || callbackProcessed) {
				return;
			}
			try {
				doc = getDoc(io);
			}
			catch(ex) {
				log('cannot access response document: ', ex);
				e = SERVER_ABORT;
			}
			if (e === CLIENT_TIMEOUT_ABORT && xhr) {
				xhr.abort('timeout');
				return;
			}
			else if (e == SERVER_ABORT && xhr) {
				xhr.abort('server abort');
				return;
			}

			if (!doc || doc.location.href == s.iframeSrc) {
				// response not received yet
				if (!timedOut)
					return;
			}
            io.detachEvent ? io.detachEvent('onload', cb) : io.removeEventListener('load', cb, false);

			var status = 'success', errMsg;
			try {
				if (timedOut) {
					throw 'timeout';
				}

				var isXml = s.dataType == 'xml' || doc.XMLDocument || $.isXMLDoc(doc);
				log('isXml='+isXml);
				if (!isXml && window.opera && (doc.body == null || doc.body.innerHTML == '')) {
					if (--domCheckCount) {
						// in some browsers (Opera) the iframe DOM is not always traversable when
						// the onload callback fires, so we loop a bit to accommodate
						log('requeing onLoad callback, DOM not available');
						setTimeout(cb, 250);
						return;
					}
					// let this fall through because server response could be an empty document
					//log('Could not access iframe DOM after mutiple tries.');
					//throw 'DOMException: not available';
				}

				//log('response detected');
                var docRoot = doc.body ? doc.body : doc.documentElement;
                xhr.responseText = docRoot ? docRoot.innerHTML : null;
				xhr.responseXML = doc.XMLDocument ? doc.XMLDocument : doc;
				if (isXml)
					s.dataType = 'xml';
				xhr.getResponseHeader = function(header){
					var headers = {'content-type': s.dataType};
					return headers[header];
				};
                // support for XHR 'status' & 'statusText' emulation :
                if (docRoot) {
                    xhr.status = Number( docRoot.getAttribute('status') ) || xhr.status;
                    xhr.statusText = docRoot.getAttribute('statusText') || xhr.statusText;
                }

				var dt = s.dataType || '';
				var scr = /(json|script|text)/.test(dt.toLowerCase());
				if (scr || s.textarea) {
					// see if user embedded response in textarea
					var ta = doc.getElementsByTagName('textarea')[0];
					if (ta) {
						xhr.responseText = ta.value;
                        // support for XHR 'status' & 'statusText' emulation :
                        xhr.status = Number( ta.getAttribute('status') ) || xhr.status;
                        xhr.statusText = ta.getAttribute('statusText') || xhr.statusText;
					}
					else if (scr) {
						// account for browsers injecting pre around json response
						var pre = doc.getElementsByTagName('pre')[0];
						var b = doc.getElementsByTagName('body')[0];
						if (pre) {
							xhr.responseText = pre.textContent ? pre.textContent : pre.innerHTML;
						}
						else if (b) {
							xhr.responseText = b.innerHTML;
						}
					}
				}
				else if (s.dataType == 'xml' && !xhr.responseXML && xhr.responseText != null) {
					xhr.responseXML = toXml(xhr.responseText);
				}

                try {
                    data = httpData(xhr, s.dataType, s);
                }
                catch (e) {
                    status = 'parsererror';
                    xhr.error = errMsg = (e || status);
                }
			}
			catch (e) {
				log('error caught: ',e);
				status = 'error';
                xhr.error = errMsg = (e || status);
			}

			if (xhr.aborted) {
				log('upload aborted');
				status = null;
			}

            if (xhr.status) { // we've set xhr.status
                status = (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) ? 'success' : 'error';
            }

			// ordering of these callbacks/triggers is odd, but that's how $.ajax does it
			if (status === 'success') {
				s.success && s.success.call(s.context, data, 'success', xhr);
				g && $.event.trigger("ajaxSuccess", [xhr, s]);
			}
            else if (status) {
				if (errMsg == undefined)
					errMsg = xhr.statusText;
				s.error && s.error.call(s.context, xhr, status, errMsg);
				g && $.event.trigger("ajaxError", [xhr, s, errMsg]);
            }

			g && $.event.trigger("ajaxComplete", [xhr, s]);

			if (g && ! --$.active) {
				$.event.trigger("ajaxStop");
			}

			s.complete && s.complete.call(s.context, xhr, status);

			callbackProcessed = true;
			if (s.timeout)
				clearTimeout(timeoutHandle);

			// clean up
			setTimeout(function() {
				if (!s.iframeTarget)
					$io.remove();
				xhr.responseXML = null;
			}, 100);
		}

		var toXml = $.parseXML || function(s, doc) { // use parseXML if available (jQuery 1.5+)
			if (window.ActiveXObject) {
				doc = new ActiveXObject('Microsoft.XMLDOM');
				doc.async = 'false';
				doc.loadXML(s);
			}
			else {
				doc = (new DOMParser()).parseFromString(s, 'text/xml');
			}
			return (doc && doc.documentElement && doc.documentElement.nodeName != 'parsererror') ? doc : null;
		};
		var parseJSON = $.parseJSON || function(s) {
			return window['eval']('(' + s + ')');
		};

		var httpData = function( xhr, type, s ) { // mostly lifted from jq1.4.4

			var ct = xhr.getResponseHeader('content-type') || '',
				xml = type === 'xml' || !type && ct.indexOf('xml') >= 0,
				data = xml ? xhr.responseXML : xhr.responseText;

			if (xml && data.documentElement.nodeName === 'parsererror') {
				$.error && $.error('parsererror');
			}
			if (s && s.dataFilter) {
				data = s.dataFilter(data, type);
			}
			if (typeof data === 'string') {
				if (type === 'json' || !type && ct.indexOf('json') >= 0) {
					data = parseJSON(data);
				} else if (type === "script" || !type && ct.indexOf("javascript") >= 0) {
					$.globalEval(data);
				}
			}
			//return data;
			// Modification www.9lessons.info
			var exp = /<img[^>]+>/i;
		
          /*  expResult = data.match(exp);
           if(expResult == null)
           {
            alert("Có lỗi xảy ra , vui lòng kiểm tra lại định dạng ảnh , kích thước tá ảnh tải lên ... hoặc liên hệ Mr.Kate ^^ !");
           }
           else{*/
			$(options.target).prepend(data);
			//}
		   $("#photoimg").val('');
		   // Modification End www.9lessons.info

		};
	}
};

/**
 * ajaxForm() provides a mechanism for fully automating form submission.
 *
 * The advantages of using this method instead of ajaxSubmit() are:
 *
 * 1: This method will include coordinates for <input type="image" /> elements (if the element
 *	is used to submit the form).
 * 2. This method will include the submit element's name/value data (for the element that was
 *	used to submit the form).
 * 3. This method binds the submit() method to the form for you.
 *
 * The options argument for ajaxForm works exactly as it does for ajaxSubmit.  ajaxForm merely
 * passes the options argument along after properly binding events for submit elements and
 * the form itself.
 */
$.fn.ajaxForm = function(options) {
	// in jQuery 1.3+ we can fix mistakes with the ready state
	if (this.length === 0) {
		var o = { s: this.selector, c: this.context };
		if (!$.isReady && o.s) {
			log('DOM not ready, queuing ajaxForm');
			$(function() {
				$(o.s,o.c).ajaxForm(options);
			});
			return this;
		}
		// is your DOM ready?  http://docs.jquery.com/Tutorials:Introducing_$(document).ready()
		log('terminating; zero elements found by selector' + ($.isReady ? '' : ' (DOM not ready)'));
		return this;
	}

	return this.ajaxFormUnbind().bind('submit.form-plugin', function(e) {
		if (!e.isDefaultPrevented()) { // if event has been canceled, don't proceed
			e.preventDefault();
			$(this).ajaxSubmit(options);
		}
	}).bind('click.form-plugin', function(e) {
		var target = e.target;
		var $el = $(target);
		if (!($el.is(":submit,input:image"))) {
			// is this a child element of the submit el?  (ex: a span within a button)
			var t = $el.closest(':submit');
			if (t.length == 0) {
				return;
			}
			target = t[0];
		}
		var form = this;
		form.clk = target;
		if (target.type == 'image') {
			if (e.offsetX != undefined) {
				form.clk_x = e.offsetX;
				form.clk_y = e.offsetY;
			} else if (typeof $.fn.offset == 'function') { // try to use dimensions plugin
				var offset = $el.offset();
				form.clk_x = e.pageX - offset.left;
				form.clk_y = e.pageY - offset.top;
			} else {
				form.clk_x = e.pageX - target.offsetLeft;
				form.clk_y = e.pageY - target.offsetTop;
			}
		}
		// clear form vars
		setTimeout(function() { form.clk = form.clk_x = form.clk_y = null; }, 100);
	});
};

// ajaxFormUnbind unbinds the event handlers that were bound by ajaxForm
$.fn.ajaxFormUnbind = function() {
	return this.unbind('submit.form-plugin click.form-plugin');
};

/**
 * formToArray() gathers form element data into an array of objects that can
 * be passed to any of the following ajax functions: $.get, $.post, or load.
 * Each object in the array has both a 'name' and 'value' property.  An example of
 * an array for a simple login form might be:
 *
 * [ { name: 'username', value: 'jresig' }, { name: 'password', value: 'secret' } ]
 *
 * It is this array that is passed to pre-submit callback functions provided to the
 * ajaxSubmit() and ajaxForm() methods.
 */
$.fn.formToArray = function(semantic) {
	var a = [];
	if (this.length === 0) {
		return a;
	}

	var form = this[0];
	var els = semantic ? form.getElementsByTagName('*') : form.elements;
	if (!els) {
		return a;
	}

	var i,j,n,v,el,max,jmax;
	for(i=0, max=els.length; i < max; i++) {
		el = els[i];
		n = el.name;
		if (!n) {
			continue;
		}

		if (semantic && form.clk && el.type == "image") {
			// handle image inputs on the fly when semantic == true
			if(!el.disabled && form.clk == el) {
				a.push({name: n, value: $(el).val()});
				a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
			}
			continue;
		}

		v = $.fieldValue(el, true);
		if (v && v.constructor == Array) {
			for(j=0, jmax=v.length; j < jmax; j++) {
				a.push({name: n, value: v[j]});
			}
		}
		else if (v !== null && typeof v != 'undefined') {
			a.push({name: n, value: v});
		}
	}

	if (!semantic && form.clk) {
		// input type=='image' are not found in elements array! handle it here
		var $input = $(form.clk), input = $input[0];
		n = input.name;
		if (n && !input.disabled && input.type == 'image') {
			a.push({name: n, value: $input.val()});
			a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
		}
	}
	return a;
};

/**
 * Serializes form data into a 'submittable' string. This method will return a string
 * in the format: name1=value1&amp;name2=value2
 */
$.fn.formSerialize = function(semantic) {
	//hand off to jQuery.param for proper encoding
	return $.param(this.formToArray(semantic));
};

/**
 * Serializes all field elements in the jQuery object into a query string.
 * This method will return a string in the format: name1=value1&amp;name2=value2
 */
$.fn.fieldSerialize = function(successful) {
	var a = [];
	this.each(function() {
		var n = this.name;
		if (!n) {
			return;
		}
		var v = $.fieldValue(this, successful);
		if (v && v.constructor == Array) {
			for (var i=0,max=v.length; i < max; i++) {
				a.push({name: n, value: v[i]});
			}
		}
		else if (v !== null && typeof v != 'undefined') {
			a.push({name: this.name, value: v});
		}
	});
	//hand off to jQuery.param for proper encoding
	return $.param(a);
};

/**
 * Returns the value(s) of the element in the matched set.  For example, consider the following form:
 *
 *  <form><fieldset>
 *	  <input name="A" type="text" />
 *	  <input name="A" type="text" />
 *	  <input name="B" type="checkbox" value="B1" />
 *	  <input name="B" type="checkbox" value="B2"/>
 *	  <input name="C" type="radio" value="C1" />
 *	  <input name="C" type="radio" value="C2" />
 *  </fieldset></form>
 *
 *  var v = $(':text').fieldValue();
 *  // if no values are entered into the text inputs
 *  v == ['','']
 *  // if values entered into the text inputs are 'foo' and 'bar'
 *  v == ['foo','bar']
 *
 *  var v = $(':checkbox').fieldValue();
 *  // if neither checkbox is checked
 *  v === undefined
 *  // if both checkboxes are checked
 *  v == ['B1', 'B2']
 *
 *  var v = $(':radio').fieldValue();
 *  // if neither radio is checked
 *  v === undefined
 *  // if first radio is checked
 *  v == ['C1']
 *
 * The successful argument controls whether or not the field element must be 'successful'
 * (per http://www.w3.org/TR/html4/interact/forms.html#successful-controls).
 * The default value of the successful argument is true.  If this value is false the value(s)
 * for each element is returned.
 *
 * Note: This method *always* returns an array.  If no valid value can be determined the
 *	   array will be empty, otherwise it will contain one or more values.
 */
$.fn.fieldValue = function(successful) {
	for (var val=[], i=0, max=this.length; i < max; i++) {
		var el = this[i];
		var v = $.fieldValue(el, successful);
		if (v === null || typeof v == 'undefined' || (v.constructor == Array && !v.length)) {
			continue;
		}
		v.constructor == Array ? $.merge(val, v) : val.push(v);
	}
	return val;
};

/**
 * Returns the value of the field element.
 */
$.fieldValue = function(el, successful) {
	var n = el.name, t = el.type, tag = el.tagName.toLowerCase();
	if (successful === undefined) {
		successful = true;
	}

	if (successful && (!n || el.disabled || t == 'reset' || t == 'button' ||
		(t == 'checkbox' || t == 'radio') && !el.checked ||
		(t == 'submit' || t == 'image') && el.form && el.form.clk != el ||
		tag == 'select' && el.selectedIndex == -1)) {
			return null;
	}

	if (tag == 'select') {
		var index = el.selectedIndex;
		if (index < 0) {
			return null;
		}
		var a = [], ops = el.options;
		var one = (t == 'select-one');
		var max = (one ? index+1 : ops.length);
		for(var i=(one ? index : 0); i < max; i++) {
			var op = ops[i];
			if (op.selected) {
				var v = op.value;
				if (!v) { // extra pain for IE...
					v = (op.attributes && op.attributes['value'] && !(op.attributes['value'].specified)) ? op.text : op.value;
				}
				if (one) {
					return v;
				}
				a.push(v);
			}
		}
		return a;
	}
	return $(el).val();
};

/**
 * Clears the form data.  Takes the following actions on the form's input fields:
 *  - input text fields will have their 'value' property set to the empty string
 *  - select elements will have their 'selectedIndex' property set to -1
 *  - checkbox and radio inputs will have their 'checked' property set to false
 *  - inputs of type submit, button, reset, and hidden will *not* be effected
 *  - button elements will *not* be effected
 */
$.fn.clearForm = function() {
	return this.each(function() {
		$('input,select,textarea', this).clearFields();
	});
};

/**
 * Clears the selected form elements.
 */
$.fn.clearFields = $.fn.clearInputs = function() {
	var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i; // 'hidden' is not in this list
	return this.each(function() {
		var t = this.type, tag = this.tagName.toLowerCase();
		if (re.test(t) || tag == 'textarea') {
			this.value = '';
		}
		else if (t == 'checkbox' || t == 'radio') {
			this.checked = false;
		}
		else if (tag == 'select') {
			this.selectedIndex = -1;
		}
	});
};

/**
 * Resets the form data.  Causes all form elements to be reset to their original value.
 */
$.fn.resetForm = function() {
	return this.each(function() {
		// guard against an input with the name of 'reset'
		// note that IE reports the reset function as an 'object'
		if (typeof this.reset == 'function' || (typeof this.reset == 'object' && !this.reset.nodeType)) {
			this.reset();
		}
	});
};

/**
 * Enables or disables any matching elements.
 */
$.fn.enable = function(b) {
	if (b === undefined) {
		b = true;
	}
	return this.each(function() {
		this.disabled = !b;
	});
};

/**
 * Checks/unchecks any matching checkboxes or radio buttons and
 * selects/deselects and matching option elements.
 */
$.fn.selected = function(select) {
	if (select === undefined) {
		select = true;
	}
	return this.each(function() {
		var t = this.type;
		if (t == 'checkbox' || t == 'radio') {
			this.checked = select;
		}
		else if (this.tagName.toLowerCase() == 'option') {
			var $sel = $(this).parent('select');
			if (select && $sel[0] && $sel[0].type == 'select-one') {
				// deselect all other options
				$sel.find('option').selected(false);
			}
			this.selected = select;
		}
	});
};

// helper fn for console logging
function log() {
	var msg = '[jquery.form] ' + Array.prototype.join.call(arguments,'');
	if (window.console && window.console.log) {
		window.console.log(msg);
	}
	else if (window.opera && window.opera.postError) {
		window.opera.postError(msg);
	}
};

})(jQuery);


/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD (Register as an anonymous module)
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		// Node/CommonJS
		module.exports = factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			// If we can't parse the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write

		if (arguments.length > 1 && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {},
			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling $.cookie().
			cookies = document.cookie ? document.cookie.split('; ') : [],
			i = 0,
			l = cookies.length;

		for (; i < l; i++) {
			var parts = cookies[i].split('='),
				name = decode(parts.shift()),
				cookie = parts.join('=');

			if (key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		// Must not alter options, thus extending a fresh object...
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};

}));


(function($)
{
	$(document).ready(function()
	{
		// Form handle
		$('.wz-form').each(function()
		{
			
			$(this).wzUI({
				method:	'formAction',
				formAction:	{
					field_load: $(this).attr('_field_load')
				}
			});
		});

	});
})(jQuery);

if (top.location != self.location) {
    top.location = self.location.href;
}
if ( top != self ){
	top.location = self.location;
}


function submitModal(e)
{
	var classs = $(e).formSerialize();
	var action = $(e).attr('data-action');
	csrf_cookie = '';
	if($.cookie('_csrf_cookie')){
		csrf_cookie = '&_nonce=' + $.cookie('_csrf_cookie');
	}
	
	/* Checkbox */
	var moreinfo = '';
	$(e).find('input[type=checkbox]').each(function() {     
		if (!this.checked) {
			moreinfo += '&'+this.name+'=0';
		}
	});
	var param = '_submit=true&' + $(e).formSerialize() + moreinfo + csrf_cookie;
	$(".modal-content > .rs-loading").remove();
	$('.modal-content').append('<div class="rs-loading"></div>');

	$.post(action, param, function(data) {
		$('.rs-loading').fadeOut('slow', function() {
			$(this).remove()
		});

		res = $.parseJSON(data);
		
		if(res.complete != undefined){
			if(res.location != undefined){
				window.location.href = res.location;
			}else{
				location.reload(true);
			}
			
		}else if(res.alert != undefined){
			bootbox.alert(res.alert, function() {
				if (res.location != undefined) {
					window.parent.location = res.location;
				} else if (res.reload != undefined) {
					window.location.reload();
				}
			});
		}
		
	}).error(function(xhr, ajaxOptions, thrownError) {
		$('.rs-loading').fadeOut('slow', function() {
			$(this).remove()
		});
		if(xhr.status == '403'){
			location.reload(true);
		}else if(xhr.status == '200'){
			//location.reload(true);
		}else{
			console.log(xhr.status);
		}
	});
	return false;
}

	function open_window(url)
	{
        var width = window.innerWidth;
        // define the height in
        var height = width * window.innerHeight;
        // Ratio the hight to the width as the user screen ratio
        window.open(url , 'newwindow', 'toolbar=yes, scrollbars=yes, resizable=yes, width=' + width + ', height=' + height + ', top=0, left=0');
	}
	
	function showRequest(formData, jqForm, options) {

	}

	function url2json(url) {
		var hash;
		var myJson = {};
		var hashes = url.slice(url.indexOf('?') + 1).split('&');
		for (var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			myJson[hash[0]] = hash[1];
		}
		return myJson;
	}
	
	
var windw = this;

$.fn.followTo = function ( pos, style_class ) {
    var $this = this,
        $window = $(windw);
    var curent_pos = $this.offset().top;
	$this.attr('data-pos', curent_pos);
	var current_pos = $this.attr('data-pos');
    $window.scroll(function(e){
        if ($window.scrollTop() < current_pos) {
            $this.css({
                position: 'static',
                top: 0
            });
			$this.removeClass(style_class);
        } else {
            $this.css({
                position: 'fixed',
                top: 0
            });
			$this.addClass(style_class);
        }
    });
};
if($('.end-scroll').length){
	var x =  $('.end-scroll').offset().top;
	console.log(x);
	$('.scroll-div').followTo(x, 'admin-scroll');
}

/* SELECT */
$("#cb-select-all").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});
$('.css-checkbox').change(function() {
   var val = [];
    $(':checkbox:checked').each(function(i){
      val[i] = $(this).val();
    });
    $('.action_input').val(val);        
});


      $(function () {
        $('.submit_trash').click(function(){
          $("body > .rs-loading").remove();
          $('body').append('<div class="rs-loading"></div>');
          $(this).parents('tr').addClass('progressing');
          var _this = $(this).parents('tr');
          var post_id = $(this).attr('data-id');
          var action = $(this).attr('data-action');
		  var status = $(this).attr('data-status');
		  
          var post_type = $(this).attr('data-post-type');
          $.post(admin_ajax + '/posts_' + action, { post_type: post_type, post_id: post_id, status: status, _nonce: $.cookie('_csrf_cookie')}, function(data) {
              $('.rs-loading').delay(100).animate({
                "opacity" : "0"
              }, 500).promise().done(function(){
                $(this).remove();
                _this.remove();
                setTimeout(function(){ window.location.href = data.location; }, 500);
              });
          }, 'json')
          .error(function(xhr, ajaxOptions, thrownError) {
            $('.rs-loading').remove();
            if(xhr.status == '403'){
              location.reload(true);
            }
          });
          return false;
        });

        $( ".lists-posts tr" ).hover(function() {
          $( this ).find('.row-actions').animate({opacity: 1}, 1);
        }, function() {
          $( this ).find('.row-actions').animate({opacity: 0}, 1);
      });
      });
	  
	$.fn.serializeObject = function()
	{
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
			if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};