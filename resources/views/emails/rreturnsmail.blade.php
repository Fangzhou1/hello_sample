<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>决算审计情况</title>
</head>
<body>
  <h1>{{$querytoarray['manager']}},你好！您的决算审计情况如下：</h1>

  <h3>你总共有{{$querytoarray['project_num']}}个项目：
<p>未送审：{{$querytoarray['未送审'] or 0}}个，</p>
<p>被退回：{{$querytoarray['被退回'] or 0}}个，</p>
<p>审计中：{{$querytoarray['审计中'] or 0}}个，</p>
<p>已出报告：{{$querytoarray['已出报告'] or 0}}个。</p>
<p>请加快完成审计进度，详细情况请见附件。</p>



</body>
</html>
