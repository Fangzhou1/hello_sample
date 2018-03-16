function tableeditanddelete(field,editlink,flag) {


    this.tem={};
    this.field=field;
    this.editlink=editlink;
    this.update=update;
    this.cancel=cancel;
    this.flag=flag||0;


  function update(obj) {
    var tbody=$(obj).parents('tbody');
    if(!$.isEmptyObject(this.tem))
    {
      $(obj).parents('table').unwrap('form');

      for(var key in this.field)
        if(this.field[key]!='id')
          tbody.find('.editable').find("."+this.field[key]).html(this.tem[this.field[key]]);
      tbody.find('.editable').find(".action").html('<a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp<a data-whatever="'+this.tem.id+'" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>');
      tbody.find(".editable").removeClass("editable");
    }
    $(obj).parents('tr').addClass("editable");
    for(var key in this.field){
      this.tem[this.field[key]]=$(obj).parents('tr').find("."+this.field[key]).text();
    }

    $(obj).parents('table').wrapAll('<form method="POST" action="'+this.editlink+this.tem.id+'">');
    $(obj).parents('tr').find(".id").append('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">');
    for(var key in this.field)
      if(this.field[key]!='id')
        $(obj).parents('tr').find("."+this.field[key]).html('<input type="text" name="'+this.field[key]+'" class="form-control input-sm" value='+this.tem[this.field[key]]+'>');
    $(obj).parents('tr').find(".action").html('<input class="btn btn-default btn-xs" type="submit" value="提交">&nbsp<a onclick="tableeditanddelete.cancel(this)" class="btn btn-default btn-xs" href="javascript:;" role="button">取消</a>');
   }




     function cancel(obj)
     {
       flag=flag||0;
       var tbody=$(obj).parents('tbody');
       $(obj).parents('table').unwrap('form');
       for(var key in this.field)
        if(this.field[key]!='id')
         tbody.find('.editable').find("."+this.field[key]).html(this.tem[this.field[key]]);
       tbody.find('.editable').find(".action").html('<a class="update" title="编辑" onclick="tableeditanddelete.update(this)" href="javascript:;" role="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp&nbsp<a data-whatever="'+this.tem.id+'" data-toggle="modal" data-target="#myModal" title="删除" id="delete" href="javascript:;" role="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp&nbsp</td>');
       if(this.flag){
         tbody.find('.editable').find(".action").append('<a class="update" title="分配权限" href="/roles/permissionstorolepage/'+this.tem.id+'" role="button"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a>')
       }
       tbody.find(".editable").removeClass("editable");
       this.tem={};

     }

}
