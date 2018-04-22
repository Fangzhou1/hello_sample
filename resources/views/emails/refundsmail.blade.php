<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>物资退库情况</title>
</head>
<body>
  <h1>{{$querytoarray['project_manager']}},你好！您的物资退库情况如下：</h1>

  <h3>你总共有{{$querytoarray['project_num']}}项目：
<p>应退库：{{$querytoarray['construction_should_refund_total'] or 0}}元，</p>
<p>实物已退库：{{$querytoarray['thing_refund_total'] or 0}}个，</p>
<p>现金已退库：{{$querytoarray['cash_refund_total'] or 0}}个，</p>
<p>直接用于其他工程（有登记）：{{$querytoarray['direct_yes_total'] or 0}}个，</p>
<p>直接用于其他工程（未登记）：{{$querytoarray['direct_no_total'] or 0}}个，</p>
<p>未退库：{{$querytoarray['unrefund_cost_total'] or 0}}个。</p>
<p>请加快完成物资退库，详细情况请见附件。</p>



</body>
</html>
