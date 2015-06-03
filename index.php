<?php

include_once('cgi/config.php');
include_once('cgi/common.php');
db_init();

$samples = get_rows('samples');

?>

<html>
<head>
<title>Sample App!</title>
</head>
<body>
<h1>Welcome to Sample App!</h1>

<form action="/cgi/run.php" method="post">
<div>To create random samples, specify sample size below and click on Run!</div>
<div>
<label>Sample Size:</label>
<input type="text" size="20" name="size"/>
</div>

<div>
<input type="submit" value="Run"/>
</div>
</form>

<br/>
<div>Total samples (so far): <b><?php print count($samples); ?></b></div>
<br/>
<div style="overflow-y: auto;height: 400px;">
<table border="1">
<tr>
<th>ID</th>
<th>Value</th>
<th>Created At</th>
</tr>
<?php foreach ($samples as $sample): ?>
<tr>
<td><?php print $sample['id']; ?></td>
<td><?php print $sample['value']; ?></td>
<td><?php print $sample['created_at']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>

</body>
</html>