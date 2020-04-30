<!DOCTYPE html>
<html>
<head>
	<title>Employee of Book Store</title>
</head>
<body>
	<div class="container">
		<h1>List of Employee</h1>
		<a href="/employee/add">Add Employee</a>
		<ul>
			@foreach($employees as $employee)
				<li>{{$employee}}</li>
			@endforeach	
		</ul>
	</div>
</body>
</html>