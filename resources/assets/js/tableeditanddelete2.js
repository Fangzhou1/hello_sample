class tableeditanddelete {

  constructor(field,cs) {
    this.tem={};
    this.field=field
    this.cs=cs;
  }

  update(obj) {
    console.log($('#cs').attr('content'));
    if(!$.isEmptyObject(this.tem))
    {
      $(obj).parents('table').unwrap('form');

      for(let key in this.field)
        $(obj).parents('tbody').find('.editable').find(".${key}").html(this.tem[key]);
      $(obj).parents('tbody').find('.editable').find(".action").html('<a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp<a data-whatever="'+tem.id+'" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>');
      $(obj).parents('tbody').find(".editable").removeClass("editable");
    }
    $(obj).parents('tr').addClass("editable");
    for(let key in this.field)
      this.tem[key]=$(obj).parents('tr').find(".${key}").text();

    $(obj).parents('table').wrapAll('<form method="POST" action="/rreturns/rowupdate/'+this.tem.id+'">');
    $(obj).parents('tr').find(".id").append(this.cs);
    for(let key in this.field)
      $(obj).parents('tr').find(".${key}").html('<input type="text" name="${key}" class="form-control input-sm" value='+this.tem[key]+'>');
    $(obj).parents('tr').find(".action").html('<input class="btn btn-default btn-xs" type="submit" value="提交">&nbsp<a onclick="tableeditanddelete.cancel(this)" class="btn btn-default btn-xs" href="javascript:;" role="button">取消</a>');
   }

     cancel(obj)
     {
       $(obj).parents('table').unwrap('form');
       for(let key in this.field)
         $(obj).parents('tbody').find('.editable').find(".${key}").html(this.tem[key]);
       $(obj).parents('tbody').find('.editable').find(".action").html('<a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp<a data-whatever="'+tem.id+'" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>');
       $(obj).parents('tbody').find(".editable").removeClass("editable");
     }

}
