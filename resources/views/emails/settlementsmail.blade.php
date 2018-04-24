<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>结算审计情况</title>
</head>
<body>
  <h1>{{$querytoarray['project_manager']}}，您好！您的结算审计情况如下：</h1>

  <h3>你总共有{{$querytoarray['project_num']}}个项目，涉及到{{$querytoarray['order_num']}}个订单：
<p>未送审：{{$querytoarray['未送审'] or 0}}个，</p>
<p>被退回：{{$querytoarray['被退回'] or 0}}个，</p>
<p>审计中：{{$querytoarray['审计中'] or 0}}个，</p>
<p>已出报告：{{$querytoarray['已出报告'] or 0}}个。</p>
<p>请加快完成审计进度，详细情况请见附件。</p>



</body>
</html>
