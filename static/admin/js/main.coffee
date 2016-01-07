#**********************#
#*Donat Gorbachev 2013*#
#**********************#

delitel = '*** ';
check_interval = 15 * 1000;

admin = {}
edit_products = {}
upload = {}
edit_users = {}
edit_sauces = {}
login = {}

LOGTIME = new Date()

$().ready () ->
	LOGTIME = new Date()
	log 'DOM started.'
	return

log = (text) ->
	a = new Date()
	ah = a.getHours()
	am = a.getMinutes()
	as = a.getSeconds()
	if(ah<10)
		ah = '0' + ah
	if(am<10)
		am = '0' + am
	if(as<10)
		as = '0' + as
	console.log '(%s:%s:%s) [%s] >>> %s'   , ah, am, as, ((a-LOGTIME)/1000), text
	return

login.ready = () ->
	return

admin.ready = () ->
	$('#chCodeBut').click () ->
		tx = $('#chCodeInp').val()
		if(tx!='')
			document.location.href = base_url + 'admin/check_code/' + content + '/' + tx
		return
	$('#crCodeBut').click () ->
		tx = $('#chCodeInp').val()
		if(tx!='')
			document.location.href = base_url + 'admin/create_code/' + content + '/' + tx
		return
	admin.checkframe();
	admin.search()
	if $('#table-products').exists()
		$('.prod_sauces').click () ->
			a = new Btn 'a', 'Закрыть', '', true
			at = $(@).attr('d-sauces').split ' '
			console.log at
			pk = randId()
			s = '<ul id="'+pk+'">'+$('#sauces_all').html()+'</ul>'
			b = new Modal 'Дополнения', s, [a], true, 200
			b.create()
			$('#'+pk+' li').each () ->
				if($.inArray($(@).attr('d-id').toString(), at)==-1)
					$(@).remove()
				return
			b.show()
			return
	$('.prod_img').click () ->
		console.log 1
		a = new Btn 'a', 'Закрыть', '', true
		s = $(@).attr 'd-img'
		img = '<img src="'+static_url+'uploads/image/'+s+'" alt="'+s+'" class="prod-img-show">';
		b = new Modal 'Изображение', img, [a], true, 200
		b.create()
		b.show()
		return
	if $('.orders_div').exists()
		setInterval checkOrders, check_interval
	return

admin.checkframe = () ->
	c = content
	$('#top-menu a').each () ->
		if $(@).attr('d-val')==content
			$(@).parent().addClass 'active'
			$('title').html $(@).html()+' | Shop-admin'
	return

admin.search = () ->
	if $('#searchButE').exists()
		$('#searchButE').click ()->
			$('#table-products tbody tr').show()
			$('#searchBut').addClass 'searchButSimple'
			$(@).hide()
			$('#searchInp').val ''
			return
		$('#searchInp').keyup ()->
			te = $('#searchInp').val()
			if te != ''
				$('#searchButE').show()
				$('#searchBut').removeClass 'searchButSimple'
			else
				$('#table-products tbody tr').show()
				$('#searchButE').hide()
				$('#searchBut').addClass 'searchButSimple'
			return

	if $('#searchInp').exists()
		$('#searchInp').keyup admin.obj_search
		$('#searchBut').click admin.obj_search
	return

admin.obj_search = ()->
	te = $('#searchInp').val()
	if (content=='products' || content=='sauces') && te != ''
		$('#table-products tbody tr').show()
		$('#table-products tbody tr').each ()->
			if ($(@).attr('d-title')+' '+$(@).attr('d-name')).toUpperCase().indexOf(te.toUpperCase()) == -1
				$(@).hide()
	if (content=='users')
		$('#table-products tbody tr').show()
		$('#table-products tbody tr').each ()->
			if $(@).attr('d-username').toUpperCase().indexOf(te.toUpperCase()) == -1
				$(@).hide()
	return

$.fn.exists = () ->
	return @length>0

randId = () ->
    while true
        num = (Math.random()*1000).toString().replace '.', '_'
        if not $('#id_'+num).exists()
            return 'id_'+num

class Btn
	constructor: (tag, text, aclass, close= false) ->
		@str = ''
		a = ''
		@id = randId()
		if close
			a = ' data-dismiss="modal" aria-hidden="true"'
		if tag == 'a'
			@str = '<a href="#" class="btn '+aclass+'"'+a+'>'+text+'</a>'
		else
			@str = '<button type="button" id="'+@id+'" class="btn '+aclass+'"'+a+'>'+text+'</button>'
		return @

	getHtml: () ->
		return @str

	setOnclick: (fun) ->
		$('#'+@id).click () ->
			fun.call()
			return


class Modal
	constructor: (title, html, btn, adelete=true, pause=200) ->
		@delete = adelete
		@title = title
		@html = html
		@pause = pause
		@id = ''
		@btn = ''
		for i in btn
			@btn += i.getHtml()
		return

	create: () ->
		@id = randId()
		mfooter = $('<div></div>').addClass 'modal-footer'
		$(mfooter).append @btn
		mbody = $('<div></div>').addClass 'modal-body'
		$(mbody).append '<p>'+@html+'</p>'
		mhead = $('<div></div>').addClass 'modal-header'
		$(mhead).append '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>'+@title+'</h3>'
		m = $('<div></div>', {id: @id}).addClass('modal hide fade')
		m.append mhead
		m.append mbody
		m.append mfooter
		$('body').append m
		if @delete
			self = @
			$('#'+@id).on 'hide', ()->
				setTimeout ()->
					$('#'+self.id).remove()
					return 
				, self.pause
				return
		return

	show: () ->
		$('#'+@id).modal 'show'
		return

	remove: () ->
		$('#'+@id).modal 'hide'
		$('#'+@id).remove()
		return


class FileUploader
	constructor: (inp, inp2, width='', background='#f5f5f5') ->
		@val = $(inp2).val()
		@id = randId()
		if width == ''
			width = $(inp).width
		else
			width = width
		self = @
		$(inp).append $('<iframe></iframe>', {id: @id, src: base_url+'upload'}).addClass('upload-iframe').attr('scrolling', 'no').css('width', width)
		$('#'+@id).load () ->
			$('#'+@id).contents().find('body').css 'background', background
			if not $('#'+@id).contents().find('form').exists()
				data = $.parseJSON $('#'+@id).contents().find('pre').html()+''
				if data['error'] != ''
					show_error data['error']
					$('.loaded-img-xclose').remove()
					$(inp).find('img').show()
					$(inp).find('.loaded-img-div').remove()
					$(inp2).val self.val
					$('#'+self.id).hide()
					document.getElementById(self.id).src = base_url+'upload'
				else
					$('#'+@id).hide()
					$(inp).find('img').hide()
					$(inp).find('.now-loaded').remove()
					img = $('<img></img>', {src: static_url+'uploads/image/'+data['name'], alt: data['name']}).addClass('now-loaded loaded-img').css('width', width+'px').load () ->
						$('.loaded-img-xclose').css({left: width-34+'px', top: -$(@).height()+'px'}).show()
						return
					d = $('<div></div>').addClass('loaded-img-div').css 'width', width
					xclose = $('<button></button>', {type: 'button'}).addClass('btn loaded-img-xclose btn-inverse').click () ->
						$(@).remove()
						$(inp).find('img').show()
						$(inp).find('.loaded-img-div').remove()
						$(inp2).val self.val
						$('#'+self.id).hide()
						document.getElementById(self.id).src = base_url+'upload'
						return
					$(xclose).append '&times;'
					$(d).append img
					$(d).append xclose
					$(inp).append d
					$(inp2).val data['name']
			else
				$('#'+self.id).show()
				$('#'+@id).contents().find('form').submit () ->
					$(@).hide()
					$('#'+@id).contents().find('#progBar').hide()
					return
				$('#'+@id).contents().find('#userfile').change () ->
					v = ($(@).val()+'').split('/').pop().split('\\').pop()
					console.log v
					if v != ''
						$('#'+self.id).contents().find('#btnSubmit').show().animate {opacity: 1}, 400
					else
						$('#'+self.id).contents().find('#btnSubmit').animate {opacity: 0}, 400, () ->
							$(@).hide()
							return
					return
			return
		return



edit_products.ready = () ->
	$('#price').css 'width', ($('#price').width()-25)+'px'
	v = $('#sauces').val()
	$('#for_sauces option').each () ->
		if $.inArray($(@).val().toString(), v.split(' '))>-1
			$(@).attr 'selected', 'selected'
		return
	$('#for_sauces').change () ->
		temp = []
		$('#for_sauces option:selected').each () ->
			temp = temp.concat [$(@).val()]
			return
		$('#sauces').val temp.join(' ')
		return
	$('#for_category').change () ->
		$('#category').val $('#for_category').val()
		return
	v = $('#category').val()
	$('#for_category option').each () ->
		if $(@).val() == v
			$(@).attr 'selected', 'selected'
		return
	$('#for_sauces').css('width', $('#for_sauces').width()+'px').select2()
	$('#for_category').css('width', $('#for_category').width()+'px').select2()

	a = new FileUploader $('#for_img_loader'), $('#img'), 366
	#a = new FileUploader base_url+'upload', () ->
		#a.choiseFile()
		#a.postFile()
	#	return
	return


edit_sauces.ready = () ->
	$('#price').css 'width', ($('#price').width()-25)+'px'
	$('#for_category').change () ->
		$('#category').val $('#for_category').val()
		return
	v = $('#category').val()
	$('#for_category option').each () ->
		if $(@).val() == v
			$(@).attr 'selected', 'selected'
		return
	$('#for_category').css('width', $('#for_category').width()+'px').select2()
	a = new FileUploader $('#for_img_loader'), $('#img'), 366
	return

del_product = (id, name) ->
	a = new Btn 'a', 'Отмена', '', true
	b = new Btn 'button', 'Удалить', 'btn-info', false
	c = new Modal 'Внимание!!!', 'Вы точно хотите удалить "'+name+'"?', [a, b], true, 200
	c.create()
	c.show()
	b.setOnclick () ->
		console.log 2
		document.location.href = base_url+'admin/delete_product/'+id+'/'
		return
	return

del_sauce = (id, name) ->
	a = new Btn 'a', 'Отмена', '', true
	b = new Btn 'button', 'Удалить', 'btn-info', false
	c = new Modal 'Внимание!!!', 'Вы точно хотите удалить "'+name+'"?', [a, b], true, 200
	c.create()
	c.show()
	b.setOnclick () ->
		console.log 2
		document.location.href = base_url+'admin/delete_sauce/'+id+'/'
		return
	return

del_user = (id, name) ->
	a = new Btn 'a', 'Отмена', '', true
	b = new Btn 'button', 'Удалить', 'btn-info', false
	c = new Modal 'Внимание!!!', 'Вы точно хотите удалить "'+name+'"?', [a, b], true, 200
	c.create()
	c.show()
	b.setOnclick () ->
		console.log 2
		document.location.href = base_url+'admin/delete_user/'+id+'/'
		return
	return


edit_users.ready = () ->
	v = $('#rank-select').attr 'd-val'
	if v == ''
		v = 0
	$('#rank-select').css('width', '366px').select2().select2 'val', v
	return



upload.ready = () ->
	return

show_error = (er) ->
	console.log er 
	return

orderNow = (id) ->
	document.location.href = base_url + 'admin/check_order/' + id;
	return

showOrder = (price, orderText, sale) ->
	a = new Btn 'a', 'Закрыть', '', true
	txtData = "<ul class=\"oder-info\">"
	for i in orderText.split(delitel)
		txtData += "<li>" + i + "</li>"
	txtData += "</ul>"
	
	if sale != '0'
		newPrice = parseInt(price/100*(100-parseInt(sale)))
		txtData += "<br>"+newPrice+"руб. ("+price+"руб. - "+sale+"%)"
		c = new Modal 'Просмотр заказа (Скидка ' + sale + '%)', txtData, [a], true, 200
	else
		txtData += "<br>"+price+"руб."
		c = new Modal 'Просмотр заказа', txtData, [a], true, 200
	c.create()
	c.show()
	return

orderBack = () ->
	a = new Btn 'a', 'Отмена', '', true
	b = new Btn 'button', 'Вернутья к заказам', 'btn-info', false
	c = new Modal 'Внимание!!!', 'Вы точно хотите вернуться к активным заказам. Если вы покините данную страницу, то не сможете вернуться назад!', [a, b], true, 200
	c.create()
	c.show()
	b.setOnclick () ->
		document.location.href = base_url+'admin/orders'
		return
	return

checkOrders = () ->
	url = base_url+'admin/get_active'
	log 'New orders loaded right now.'
	$.get url, (data) ->
		$('#in-in').html data
		if($('.order_tr').exists())
			beep()
		return
	return

changeSubname = (id, name) ->
	a = new Btn 'a', 'Отмена', '', true
	b = new Btn 'button', 'Изменить', 'btn-info', false
	c = new Modal 'Ссылка - '+name, '<input type="text" value="'+name+'" placeholder="Новое название для ссылки" id="changeCategorySubname_input">', [a, b], true, 200
	c.create()
	c.show()
	b.setOnclick () ->
		document.location.href = base_url+'admin/category_change_subname/'+id+'/'+$('#changeCategorySubname_input').val()
		return
	return

changeCategoryNum = (id, num) ->
	a = new Btn 'a', 'Отмена', '', true
	b = new Btn 'button', 'Изменить', 'btn-info', false
	c = new Modal 'Номер - '+num, '<input type="text" value="'+num+'" placeholder="Новый номер" id="changeCategoryNum_input">', [a, b], true, 200
	c.create()
	c.show()
	b.setOnclick () ->
		document.location.href = base_url+'admin/category_change_num/'+id+'/'+$('#changeCategoryNum_input').val()
		return
	return

delCategory = (id, name) ->
	a = new Btn 'a', 'Отмена', '', true
	b = new Btn 'button', 'Удалить', 'btn-info', false
	c = new Modal 'Внимание!!!', 'Удаление категории <strong>"'+name+'"</strong> приведет к удалению <strong>ВСЕХ</strong> продуктов данной категории.', [a, b], true, 200
	c.create()
	c.show()
	b.setOnclick () ->
		document.location.href = base_url+'admin/delete_category/'+id
		return
	return

delOrder = (id) ->
	a = new Btn 'a', 'Нет', '', true
	b = new Btn 'button', 'Да', 'btn-info', false
	c = new Modal 'Внимание!!!', 'Вы точно хотите отменить заказ?', [a, b], true, 200
	c.create()
	c.show()
	b.setOnclick () ->
		document.location.href = base_url+'admin/del_order/'+id
		return
	return

beep = () ->
	log 'There are some new orders!!!'
	return

openOrderText = (text) ->
	text = text.replace /\*\*\*/g, '<br>'
	text = text.replace /\*\*\:/g, '<strong>'
	text = text.replace /\:\*\*/g, '</strong>'
	a = new Btn 'a', 'Ок', '', true
	c = new Modal 'Товар', text, [a], true, 200
	c.create()
	c.show()
	return