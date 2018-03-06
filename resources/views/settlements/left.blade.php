<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          结算审计
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="list-group">
        <a class="list-group-item {{($current_url==route('settlements.index'))?"active":""}}" href="{{route('settlements.index')}}">审计主页</a>
        <a class="list-group-item {{($current_url==route('importpage'))?"active":""}}" href="{{route('importpage')}}">导入Excel表</a>
        <a class="list-group-item {{($current_url==route('settlements.smsmail'))||($current_url==route('settlements.smsmaildetail'))?"active":""}}" href="{{route('settlements.smsmail')}}">邮件短信催办</a>
        <a class="list-group-item {{($current_url==route('settlements.statistics'))?"active":""}}" href="{{route('settlements.statistics')}}">详细统计信息</a>
      </div>


    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          决算审计
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">

        <ul class="list-group">
          <li class="list-group-item"><a href="#">Cras justo odio</a></li>
          <li class="list-group-item"><a href="#">Dapibus ac facilisis in</a></li>
          <li class="list-group-item"><a href="#">Morbi leo risus</a></li>
          <li class="list-group-item"><a href="#">Porta ac consectetur ac</a></li>
          <li class="list-group-item"><a href="#">Vestibulum at eros</a></li>
        </ul>

    </div>
  </div>

</div>
