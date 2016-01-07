API = {}
API.site_url
API.base_url
API.BAG
$().ready () ->
	API.drawBag()
	return

API.addProduct = (idArray) ->
	url = API.site_url + '/shop/add_product'
	data = ''
	for i in idArray
		data += 'DATA[]=' + i + '&'
	$.ajax {
		url: url,
		type: 'GET',
		data: data,
		dataType: 'json',
		success: (resp) ->
			API.BAG = resp
			API.drawBag()
			return
		} 
	return

API.addSauce = (objectId, sauceId) ->
	url = API.site_url + '/shop/add_sauce/' + objectId + '/' + sauceId
	$.get url, (resp) ->
		API.BAG = resp
		API.drawBag()
		return
	}
	return

API.removeProduct = (idArray) ->
	url = API.site_url + '/shop/rem_product'
	data = ''
	for i in idArray
		data += 'DATA[]=' + i + '&'
	$.ajax {
		url: url,
		type: 'GET',
		data: data,
		dataType: 'json',
		success: (resp) ->
			API.BAG = resp
			API.drawBag()
			return
		} 
	return

API.removeSauce = (objectId, sauceId) ->
	url = API.site_url + '/shop/rem_sauce/' + objectId + '/' + sauceId
	$.ajax {
		url: url,
		type: 'GET',
		data: '',
		dataType: 'json',
		success: (resp) ->
			API.BAG = resp
			API.drawBag()
			return
	}
	return

API.clearBag = () ->
	url = API.site_url + '/shop/remove_all_products'
	$.get url, (resp) ->
		API.BAG = resp
		API.drawBag()
		return
	return

API.reloadBag = () ->
	url = API.site_url + '/shop/reload_bag'
	$.get url, (resp) ->
		API.BAG = resp
		API.drawBag()
		return
	return

API.createOrder = ($codeCont, $saleCont) ->
	url = API.site_url + '/shop/create_order'
	$.get url, (resp) ->
		if(resp['result']=='success')
			API.BAG = []
			API.drawBag()
			$codeCont.html resp['code']
			$saleCont.html resp['per']
		return
	return