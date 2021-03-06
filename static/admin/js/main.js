// Generated by CoffeeScript 1.4.0
var Btn, FileUploader, LOGTIME, Modal, admin, beep, editFilter, checkOrders, check_interval, delCategory, delOrder, del_product, del_user, delitel, edit_products, edit_users, log, login, openOrderText, orderNow, randId, show_error, upload;

delitel = '*** ';

check_interval = 15 * 1000;

admin = {};

edit_products = {};

edit_category = {};

upload = {};

edit_users = {};

login = {};

LOGTIME = new Date();

$().ready(function() {
  LOGTIME = new Date();
});

log = function(text) {
  var a, ah, am, as;
  a = new Date();
  ah = a.getHours();
  am = a.getMinutes();
  as = a.getSeconds();
  if (ah < 10) {
    ah = '0' + ah;
  }
  if (am < 10) {
    am = '0' + am;
  }
  if (as < 10) {
    as = '0' + as;
  }
  console.log('(%s:%s:%s) [%s] >>> %s', ah, am, as, (a - LOGTIME) / 1000, text);
};

login.ready = function() {};

admin.ready = function() {
  $('#chCodeBut').click(function() {
    var tx;
    tx = $('#chCodeInp').val();
    if (tx !== '') {
      document.location.href = base_url + 'admin/check_code/' + content + '/' + tx;
    }
  });
  $('#crCodeBut').click(function() {
    var tx;
    tx = $('#chCodeInp').val();
    if (tx !== '') {
      document.location.href = base_url + 'admin/create_code/' + content + '/' + tx;
    }
  });
  admin.checkframe();
  admin.search();
  $('.prod_img').click(function() {
    var a, b, img, s;
    a = new Btn('a', 'Закрыть', '', true);
    s = $(this).attr('d-img');
    img = '<img src="' + static_url + 'uploads/image/high/' + s + '" alt="' + s + '" class="prod-img-show">';
    b = new Modal('Изображение', img, [a], true, 200);
    b.create();
    b.show();
  });
  if ($('.orders_div').exists()) {
    setInterval(checkOrders, check_interval);
  }
  if (localStorage.getItem('column-left') == 'active') {
    $('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');
    $('#column-left').addClass('active');
    $('#menu li.active').has('ul').children('ul').addClass('collapse in');
    $('#menu li').not('.active').has('ul').children('ul').addClass('collapse');
  } else {
    $('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');
    $('#menu li li.active').has('ul').children('ul').addClass('collapse in');
    $('#menu li li').not('.active').has('ul').children('ul').addClass('collapse');
  }
  $('#button-menu').on('click', function() {
    if ($('#column-left').hasClass('active')) {
      localStorage.setItem('column-left', '');
      $('#button-menu i').replaceWith('<i class="fa fa-indent fa-lg"></i>');

      $('#column-left').removeClass('active');

      $('#menu > li > ul').removeClass('in collapse');
      $('#menu > li > ul').removeAttr('style');
    } else {
      localStorage.setItem('column-left', 'active');
      $('#button-menu i').replaceWith('<i class="fa fa-dedent fa-lg"></i>');
      $('#column-left').addClass('active');
      $('#menu li.open').has('ul').children('ul').addClass('collapse in');
      $('#menu li').not('.open').has('ul').children('ul').addClass('collapse');
    }
  });
};

admin.checkframe = function() {
  var c;
  c = content;
  $('#menu a').each(function() {
    if ($(this).attr('d-val') === content) {
      $(this).parent().addClass('active');
      return $('title').html($(this).children('span').html() + ' | Shop-admin');
    }
  });
};

admin.search = function() {
  if ($('#searchButE').exists()) {
    $('#searchButE').click(function() {
      $('#table-products tbody tr').show();
      $('#searchBut').addClass('searchButSimple');
      $(this).hide();
      $('#searchInp').val('');
    });
    $('#searchInp').keyup(function() {
      var te;
      te = $('#searchInp').val();
      if (te !== '') {
        $('#searchButE').show();
        $('#searchBut').removeClass('searchButSimple');
      } else {
        $('#table-products tbody tr').show();
        $('#searchButE').hide();
        $('#searchBut').addClass('searchButSimple');
      }
    });
  }
  if ($('#searchInp').exists()) {
    $('#searchInp').keyup(admin.obj_search);
    $('#searchBut').click(admin.obj_search);
  }
};

admin.obj_search = function() {
  var te;
  te = $('#searchInp').val();
  if ((content === 'products' || content === 'category') && te !== '') {
    $('#table-products tbody tr').show();
    $('#table-products tbody tr').each(function() {
      if (($(this).attr('d-title') + ' ' + $(this).attr('d-name')).toUpperCase().indexOf(te.toUpperCase()) === -1) {
        return $(this).hide();
      }
    });
  }
  if (content === 'users') {
    $('#table-products tbody tr').show();
    $('#table-products tbody tr').each(function() {
      if ($(this).attr('d-username').toUpperCase().indexOf(te.toUpperCase()) === -1) {
        return $(this).hide();
      }
    });
  }
};

$.fn.exists = function() {
  return this.length > 0;
};

randId = function() {
  var num;
  while (true) {
    num = (Math.random() * 1000).toString().replace('.', '_');
    if (!$('#id_' + num).exists()) {
      return 'id_' + num;
    }
  }
};

Btn = (function() {

  function Btn(tag, text, aclass, close) {
    var a;
    if (close == null) {
      close = false;
    }
    this.str = '';
    a = '';
    this.id = randId();
    if (close) {
      a = ' data-dismiss="modal" aria-hidden="true"';
    }
    if (tag === 'a') {
      this.str = '<a href="#" class="btn btn-default ' + aclass + '"' + a + '>' + text + '</a>';
    } else {
      this.str = '<button type="button" id="' + this.id + '" class="btn btn-default ' + aclass + '"' + a + '>' + text + '</button>';
    }
    return this;
  }

  Btn.prototype.getHtml = function() {
    return this.str;
  };

  Btn.prototype.setOnclick = function(fun) {
    return $('#' + this.id).click(function() {
      fun.call();
    });
  };

  return Btn;

})();

Modal = (function() {

  function Modal(title, html, btn, adelete, pause) {
    var i, _i, _len;
    if (adelete == null) {
      adelete = true;
    }
    if (pause == null) {
      pause = 200;
    }
    this["delete"] = adelete;
    this.title = title;
    this.html = html;
    this.pause = pause;
    this.id = '';
    this.btn = '';
    for (_i = 0, _len = btn.length; _i < _len; _i++) {
      i = btn[_i];
      this.btn += i.getHtml();
    }
    return;
  }

  Modal.prototype.create = function() {
    var m, mbody, mfooter, mhead, self;
    this.id = randId();
    mfooter = $('<div></div>').addClass('modal-footer');
    $(mfooter).append(this.btn);
    mbody = $('<div></div>').addClass('modal-body');
    $(mbody).append('<p>' + this.html + '</p>');
    mhead = $('<div></div>').addClass('modal-header');
    $(mhead).append('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3>' + this.title + '</h3>');
    m = $('<div></div>', {
      id: this.id
    }).addClass('modal fade');
    md = $('<div></div>', {
      class: 'modal-dialog'
    });
    mc = $('<div></div>', {
      class: 'modal-content'
    });
    mc.append(mhead);
    mc.append(mbody);
    mc.append(mfooter);
    $('body').append(m.append(md.append(mc)));
    if (this["delete"]) {
      self = this;
      $('#' + this.id).on('hide', function() {
        setTimeout(function() {
          $('#' + self.id).remove();
        }, self.pause);
      });
    }
  };

  Modal.prototype.show = function() {
    $('#' + this.id).modal('show');
  };

  Modal.prototype.remove = function() {
    $('#' + this.id).modal('hide');
    $('#' + this.id).remove();
  };

  return Modal;

})();

FileUploader = (function() {

  function FileUploader(inp, inp2, width, background) {
    var self;
    if (width == null) {
      width = '';
    }
    if (background == null) {
      background = '#f5f5f5';
    }
    this.val = $(inp2).val();
    this.id = randId();
    if (width === '') {
      width = $(inp).width;
    } else {
      width = width;
    }
    self = this;
    $(inp).append($('<iframe></iframe>', {
      id: this.id,
      src: base_url + 'upload'
    }).addClass('upload-iframe').attr('scrolling', 'no').css('width', width));
    $('#' + this.id).load(function() {
      var d, data, img, xclose;
      $('#' + this.id).contents().find('body').css('background', background);
      if (!$('#' + this.id).contents().find('form').exists()) {
        data = $.parseJSON($('#' + this.id).contents().find('pre').html() + '');
        if (data['error'] !== '') {
          show_error(data['error']);
          $('.loaded-img-xclose').remove();
          $(inp).find('img').show();
          $(inp).find('.loaded-img-div').remove();
          $(inp2).val(self.val);
          $('#' + self.id).hide();
          document.getElementById(self.id).src = base_url + 'upload';
        } else {
          $('#' + this.id).hide();
          $(inp).find('img').hide();
          $(inp).find('.now-loaded').remove();
          img = $('<img></img>', {
            src: static_url + 'uploads/image/high/' + data['name'],
            alt: data['name']
          }).addClass('now-loaded loaded-img').css('width', width + 'px').load(function() {
            $('.loaded-img-xclose').css({
              left: $(this).width() - 34 + 'px',
              top: -$(this).height() + 'px'
            }).show();
          });
          d = $('<div></div>').addClass('loaded-img-div').css('width', width);
          xclose = $('<button></button>', {
            type: 'button'
          }).addClass('btn loaded-img-xclose btn-default').click(function() {
            $(this).remove();
            $(inp).find('img').show();
            $(inp).find('.loaded-img-div').remove();
            $(inp2).val(self.val);
            $('#' + self.id).hide();
            document.getElementById(self.id).src = base_url + 'upload';
          });
          $(xclose).append('&times;');
          $(d).append(img);
          $(d).append(xclose);
          $(inp).append(d);
          $(inp2).val(data['name']);
        }
      } else {
        $('#' + self.id).show();
        $('#' + this.id).contents().find('form').submit(function() {
          $(this).hide();
          $('#' + this.id).contents().find('#progBar').hide();
        });
        $('#' + this.id).contents().find('#userfile').change(function() {
          var v;
          v = ($(this).val() + '').split('/').pop().split('\\').pop();
          if (v !== '') {
            $('#' + self.id).contents().find('#btnSubmit').show().animate({
              opacity: 1
            }, 400);
          } else {
            $('#' + self.id).contents().find('#btnSubmit').animate({
              opacity: 0
            }, 400, function() {
              $(this).hide();
            });
          }
        });
      }
    });
    return;
  }

  return FileUploader;

})();

edit_products.ready = function() {
  var a, v;
  $('#for_category').change(function() {
    $('#category').val($('#for_category').val());
  });
  v = $('#category').val();
  $('#for_category option').each(function() {
    if ($(this).val() === v) {
      $(this).attr('selected', 'selected');
    }
  });
  $('#for_category').select2().select2('val', v);
  a = new FileUploader($('#for_img_loader'), $('#img'));
};

edit_category.ready = function() {
  var v;
  v = $('#filters').val();
  $('#for_filters option').each(function() {
    if ($.inArray($(this).val().toString(), v.split(',')) > -1) {
      $(this).attr('selected', 'selected');
    }
  });
  $('#for_filters').change(function() {
    var temp;
    temp = [];
    $('#for_filters option:selected').each(function() {
      temp = temp.concat([$(this).val()]);
    });
    $('#filters').val(temp.join(','));
  });
  $('#for_parent_id').change(function() {
    $('#parent_id').val($('#for_parent_id').val());
  });
  v = $('#parent_id').val();
  $('#for_parent_id option').each(function() {
    if ($(this).val() === v) {
      $(this).attr('selected', 'selected');
    }
  });
  $('#for_filters').select2();
  $('#for_parent_id').select2().select2('val', v);
};

edit_users.ready = function() {
  var v;
  v = $('#rank-select').attr('d-val');
  if (v === '') {
    v = 0;
  }
  $('#rank-select').select2().select2('val', v);
};

del_category = function(id, name) {
  var a, b, c;
  a = new Btn('a', 'Отмена', '', true);
  b = new Btn('button', 'Удалить', 'btn-danger', false);
  c = new Modal('Внимание!!!', 'Вы точно хотите удалить "' + name + '"?', [a, b], true, 200);
  c.create();
  c.show();
  b.setOnclick(function() {
    document.location.href = base_url + 'admin/delete_category/' + id + '/';
  });
};

del_product = function(id, name) {
  var a, b, c;
  a = new Btn('a', 'Отмена', '', true);
  b = new Btn('button', 'Удалить', 'btn-danger', false);
  c = new Modal('Внимание!!!', 'Вы точно хотите удалить "' + name + '"?', [a, b], true, 200);
  c.create();
  c.show();
  b.setOnclick(function() {
    document.location.href = base_url + 'admin/delete_product/' + id + '/';
  });
};

del_user = function(id, name) {
  var a, b, c;
  a = new Btn('a', 'Отмена', '', true);
  b = new Btn('button', 'Удалить', 'btn-danger', false);
  c = new Modal('Внимание!!!', 'Вы точно хотите удалить "' + name + '"?', [a, b], true, 200);
  c.create();
  c.show();
  b.setOnclick(function() {
    document.location.href = base_url + 'admin/delete_user/' + id + '/';
  });
};

upload.ready = function() {};

show_error = function(er) {
  console.log(er);
};

showOrder = function(price, orderText) {
  var a, c, i, newPrice, txtData, _i, _len, _ref;
  a = new Btn('a', 'Закрыть', '', true);
  txtData = "<ul class=\"oder-info\">";
  _ref = orderText.split(delitel);
  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
    i = _ref[_i];
    txtData += "<li>" + i + "</li>";
  }
  txtData += "</ul>";
  txtData += "<br>" + price + "руб.";
  c = new Modal('Просмотр заказа', txtData, [a], true, 200);
  c.create();
  c.show();
};

checkOrders = function() {
  var url;
  url = base_url + 'admin/get_active';
  $.get(url, function(data) {
    $('#in-in').html(data);
    if ($('.order_tr').exists()) {
      beep();
    }
  });
};

delCategory = function(id, name) {
  var a, b, c;
  a = new Btn('a', 'Отмена', '', true);
  b = new Btn('button', 'Удалить', 'btn-danger', false);
  c = new Modal('Внимание!!!', 'Удаление категории <strong>"' + name + '"</strong> приведет к удалению <strong>ВСЕХ</strong> дочерних категорий и продуктов данных категорий.', [a, b], true, 200);
  c.create();
  c.show();
  b.setOnclick(function() {
    document.location.href = base_url + 'admin/delete_category/' + id;
  });
};

delOrder = function(id) {
  var a, b, c;
  a = new Btn('a', 'Нет', '', true);
  b = new Btn('button', 'Да', 'btn-danger', false);
  c = new Modal('Внимание!!!', 'Вы точно хотите отменить заказ?', [a, b], true, 200);
  c.create();
  c.show();
  b.setOnclick(function() {
    document.location.href = base_url + 'admin/del_order/' + id;
  });
};

beep = function() {
  log('There are some new orders!!!');
};

openOrderText = function(text) {
  var a, c;
  text = text.replace(/\*\*\*/g, '<br>');
  text = text.replace(/\*\*\:/g, '<strong>');
  text = text.replace(/\:\*\*/g, '</strong>');
  a = new Btn('a', 'Ок', '', true);
  c = new Modal('Товар', text, [a], true, 200);
  c.create();
  c.show();
};

createFilter = function() {
  var a, b, c;
  a = new Btn('a', 'Отмена', '', true);
  b = new Btn('button', 'Создать', 'btn-primary', false);
  c = new Modal('Создание фильтра','<div class="form-group"><div class="col-xs-8"><label for="filter_name">Название</label><input type="text" placeholder="Название" class="form-control" id="filter_name"></div><div class="col-xs-4"><label for="filter_atr">Атрибут</label><input type="text" placeholder="Атрибут" class="form-control" id="filter_atr"></div></div><br><br>', [a, b], true, 200);
  c.create();
  c.show();
  b.setOnclick(function() {
    document.location.href = base_url + 'admin/create_filter?name=' + $('#filter_name').val()+'&atr=' + $('#filter_atr').val();
  });
};

editFilter = function(id,name,atr) {
  var a, b, c, d;
  a = new Btn('a', 'Отмена', '', true);
  b = new Btn('button', 'Изменить', 'btn-primary', false);
  c = new Btn('button', 'Удалить', 'btn-danger', false);
  d = new Modal('Управление фильтром','<div class="form-group"><div class="col-xs-8"><label for="filter_name">Название</label><input type="text" value="' + name + '" placeholder="Название" class="form-control" id="filter_name"></div><div class="col-xs-4"><label for="filter_atr">Атрибут</label><input type="text" value="' + atr + '" placeholder="Атрибут" class="form-control" id="filter_atr"></div></div><br><br>', [a, b, c], true, 200);
  d.create();
  d.show();
  b.setOnclick(function() {
    document.location.href = base_url + 'admin/update_filter?id=' + id + '&name=' + $('#filter_name').val() + '&atr=' + $('#filter_atr').val();
  });
  c.setOnclick(function() {
    document.location.href = base_url + 'admin/delete_filter/' + id;
  });
};
/*
<div class="form-group"><div class="col-xs-12"><label for="type">Тип</label><br><div class="btn-group" data-toggle="buttons"><label class="btn btn-warning active"><input type="radio" name="type" id="checkbox" value="0" checked>Чекбоскс</label><label class="btn btn-warning"><input type="radio" name="type" id="range" value="1">Диапазон</label><label class="btn btn-warning"><input type="radio" name="type" id="radio" value="2">Радио</label></div></div></div>
*/