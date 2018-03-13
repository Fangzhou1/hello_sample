<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          结算审计
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse {{(strpos($current_url,'settlements'))?"in":""}}" role="tabpanel" aria-labelledby="headingOne">
      <div class="list-group">
        <a class="list-group-item {{($current_url==route('settlements.index'))?"active":""}}" href="{{route('settlements.index')}}">结算审计主页</a>
        <a class="list-group-item {{($current_url==route('settlements.importpage'))?"active":""}}" href="{{route('settlements.importpage')}}">导入Excel表</a>
        <a class="list-group-item {{($current_url==route('settlements.smsmail'))||($current_url==route('settlements.smsmaildetail'))?"active":""}}" href="{{route('settlements.smsmail')}}">邮件短信催办</a>
        <a class="list-group-item {{($current_url==route('settlements.statistics'))?"active":""}}" href="{{route('settlements.statistics')}}">详细统计信息</a>
      </div>
    </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a  role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          决算审计
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse {{(strpos($current_url,'rreturns'))?"in":""}}" role="tabpanel" aria-labelledby="headingTwo">

        <ul class="list-group">
          <a class="list-group-item {{($current_url==route('rreturns.index'))?"active":""}}" href="{{route('rreturns.index')}}">决算审计主页</a>
          <a class="list-group-item {{($current_url==route('rreturns.importpage'))?"active":""}}" href="{{route('rreturns.importpage')}}">导入Excel表</a>
          <a class="list-group-item {{($current_url==route('rreturns.smsmail'))||($current_url==route('rreturns.smsmaildetail'))?"active":""}}" href="{{route('rreturns.smsmail')}}">邮件短信催办</a>
          <a class="list-group-item {{($current_url==route('rreturns.statistics'))?"active":""}}" href="{{route('rreturns.statistics')}}">详细统计信息</a>

        </ul>
      </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a  role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          权限管理
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse {{(strpos($current_url,'permissions'))?"in":""}}" role="tabpanel" aria-labelledby="headingThree">

        <ul class="list-group">
          <a class="list-group-item {{($current_url==route('permissions.index'))?"active":""}}" href="{{route('permissions.index')}}">设置权限</a>
          <a class="list-group-item {{($current_url==route('rreturns.importpage'))?"active":""}}" href="{{route('rreturns.importpage')}}">设置角色</a>
          <a class="list-group-item {{($current_url==route('rreturns.statistics'))?"active":""}}" href="{{route('rreturns.statistics')}}">分配角色</a>

        </ul>
      </div>
  </div>



</div>