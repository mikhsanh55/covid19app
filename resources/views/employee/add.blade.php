<!DOCTYPE html>
<html>
<head>
	<title>Add Employee</title>
</head>
<body>
	<div class="container">
		<h1>Add Employee</h1>

		<form action="/employee/insert" method="post">
			<input type="hidden" name="_token" value="<?= csrf_token(); ?>">
			<label>Name</label>
			<input type="text" name="name">
			<button type="submit">Add</button>
		</form>
	</div>
</body>
</html>