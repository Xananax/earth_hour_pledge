jQuery(function($){

	var states = {
		'lang':null
	,	'form':null
	}
	,	currentHash = ''
	,	listenToHash = true
	,	$LanguageChooser = $('#Language-Chooser')
	,	$Main = $('#Main')
	,	$FormsContainer = $('#Forms')
	,	$FormChooser = $('#Form-Chooser')
	,	$forms = $('.form',$FormsContainer).hide()
	,	$HTML = $('html')
	,	$Window = $(window)
	,	$Pane = $('html,body')
	,	propSep = '/'
	,	valueSep = '-'
	,	$urlsInputs = $('form input[name="url"]');
	;

	function parseHash(hash){
		if(!hash){return false;}
		var loc = hash.split(propSep)
		,	i = 0
		,	l = loc.length
		,	part
		,	name
		,	value
		,	props = {}
		;
		for(i;i<l;i++){
			part = loc[i].split(valueSep);
			name = part.shift();
			value = part.shift();
			props[name] = value;
		}
		return props;
	}

	function objToHash(obj){
		var props = [];
		for(var n in obj){
			props.push(n+valueSep+obj[n]);
		}
		return props.join(propSep);
	}

	function route(hash){
		//currentHash = currentHash ? currentHash + '/' + hash : hash;
		var loc = parseHash(hash)
		,	name
		,	changed = {}
		,	isChanged = false
		;
		for(name in loc){
			if(states[name]!=loc[name]){
				states[name] = changed[name] = loc[name];
				isChanged = true;
			}
		}
		if(!isChanged){return;}

		for(name in changed){
			setState(name,changed[name]);
		}
		var curr = parseHash(currentHash) || {};
		curr = $.extend(curr,changed)
		currentHash = objToHash(curr);
		if('#'+currentHash!==location.hash){
			listenToHash = false;
			$urlsInputs.val(currentHash);
			location.hash = currentHash;
		}
	}

	function setState(name,val){
		switch(name.toLowerCase()){
			case 'lang':
				return changeLang(val);
				break;
			case 'form':
				return changeForm(name+valueSep+val);
				break;
			default:
				break;
		}
	}

	function changeLang(lang){
		if(!lang){
			$HTML.attr('lang','').attr('dir','')
			$LanguageChooser.addClass('active');
			$Main.hide();
			$Forms.hide();
			return;
		}
		$LanguageChooser.removeClass('active');
		var $links = $('a',$LanguageChooser);
		var $link = $links.filter('a[href="#lang'+valueSep+lang+'"]');
		$links.not($link.addClass('active')).removeClass('active');
		$link.siblings().removeClass('active')
		changeForm()
		$HTML.attr('lang',lang).attr('dir',(lang=='en'?'ltr':'rtl'))
	}

	function changeForm(form){
		if(!form){
			$FormChooser.addClass('active');
			return;
		}
		var $form = $('#'+form);
		var $links = $('a',$FormChooser);
		var $link = $links.filter('a[href="#'+form+'"]');
		$links.not($link.addClass('active')).removeClass('active');
		$FormChooser.removeClass('active');
		var callback = function(){
			var offset = $form.offset();
			offset.top-=60;
			console.log(offset);
			$Pane.animate({
				scrollTop: offset.top,
				scrollLeft: offset.left
			});
		}
		$forms.not($form.slideDown('fast',callback)).slideUp();
	}

	$Window.on('hashchange',function(){
		if(listenToHash){
			route(location.hash.slice(1));
		}else{
			listenToHash = true;
		}
		return false;
	}).trigger('hashchange');

})