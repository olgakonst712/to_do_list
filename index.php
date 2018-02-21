<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>ToDo List</title>
		<link rel="stylesheet" href="vendor/datetimepicker/datetimepicker.css">

		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
		<div class="main">
			<div class="viewport">
				<div class="main-header">
					<div class="add-button"><a href="#" id="plus"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>plus</title><path d="M31 12h-11v-11c0-0.552-0.448-1-1-1h-6c-0.552 0-1 0.448-1 1v11h-11c-0.552 0-1 0.448-1 1v6c0 0.552 0.448 1 1 1h11v11c0 0.552 0.448 1 1 1h6c0.552 0 1-0.448 1-1v-11h11c0.552 0 1-0.448 1-1v-6c0-0.552-0.448-1-1-1z"></path></svg></a></div>
					<h1>TODOLIST</h1>
					<div class="sort-button"><a href="#" id="settings"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>cog</title><path d="M29.181 19.070c-1.679-2.908-0.669-6.634 2.255-8.328l-3.145-5.447c-0.898 0.527-1.943 0.829-3.058 0.829-3.361 0-6.085-2.742-6.085-6.125h-6.289c0.008 1.044-0.252 2.103-0.811 3.070-1.679 2.908-5.411 3.897-8.339 2.211l-3.144 5.447c0.905 0.515 1.689 1.268 2.246 2.234 1.676 2.903 0.672 6.623-2.241 8.319l3.145 5.447c0.895-0.522 1.935-0.82 3.044-0.82 3.35 0 6.067 2.725 6.084 6.092h6.289c-0.003-1.034 0.259-2.080 0.811-3.038 1.676-2.903 5.399-3.894 8.325-2.219l3.145-5.447c-0.899-0.515-1.678-1.266-2.232-2.226zM16 22.479c-3.578 0-6.479-2.901-6.479-6.479s2.901-6.479 6.479-6.479c3.578 0 6.479 2.901 6.479 6.479s-2.901 6.479-6.479 6.479z"></path></svg></a></div>
				</div>
				<div class="options">
					<ul>
						<li><a href="#" class="sorting actif" data-sort="status">Sort By Status</a></li>
						<li><a href="#" class="sorting" data-sort="date">Sort By Date</a></li>
					</ul>
				</div>
				<div id="main-pane" class="main-container">
					<div id="by-status">
						<ul class="task-list" id="todo">
						</ul>
						<ul class="task-list" id="done">
						</ul>
						<ul class="task-list" id="late">
						</ul>
					</div>
					<div id="by-date">
						<ul class="task-list" id="ul-by-date">
							
						</ul>
					</div>
					<ul class="hide">
						<li class="task-item template">
							<div class="task">
								<span class="task-heading">
									<a href="#" class="task-check"></a>
									<a href="#" data-opened="false" class="task-name"></a>
								</span>
								<ul class="task-actions" data-status="hide">
									<li class="mirage"></li>
									<li><a href="#" class="complete-task"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>checkmark2</title><path d="M12.42 28.678l-12.433-12.238 6.168-6.071 6.265 6.167 13.426-13.214 6.168 6.071-19.594 19.285zM3.372 16.441l9.048 8.905 16.208-15.953-2.782-2.739-13.426 13.214-6.265-6.167-2.782 2.739z"></path></svg></a></li>
									<li><a href="#" class="edit-task"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>pencil</title><path d="M27 0c2.761 0 5 2.239 5 5 0 1.126-0.372 2.164-1 3l-2 2-7-7 2-2c0.836-0.628 1.874-1 3-1zM2 23l-2 9 9-2 18.5-18.5-7-7-18.5 18.5zM22.362 11.362l-14 14-1.724-1.724 14-14 1.724 1.724z"></path></svg></a></li>
									<li><a href="#" class="delete-task"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><title>bin</title><path d="M4 10v20c0 1.1 0.9 2 2 2h18c1.1 0 2-0.9 2-2v-20h-22zM10 28h-2v-14h2v14zM14 28h-2v-14h2v14zM18 28h-2v-14h2v14zM22 28h-2v-14h2v14z"></path><path d="M26.5 4h-6.5v-2.5c0-0.825-0.675-1.5-1.5-1.5h-7c-0.825 0-1.5 0.675-1.5 1.5v2.5h-6.5c-0.825 0-1.5 0.675-1.5 1.5v2.5h26v-2.5c0-0.825-0.675-1.5-1.5-1.5zM18 4h-6v-1.975h6v1.975z"></path></svg></a></li>
								</ul>
							</div>
							<div class="details" data-status="hide">
								<p class="desc"></p>
								<p class="time-info">
									Started on: <span class="created"></span><span class="completed"></span>
								</p>
							</div>
						</li>
					</ul>
				</div>
				<div id="side-pane" class="next-container">
					<div class="clear">
						<a href="#" id="clear">Clear</a>
					</div>
					<div class="form">
						<form action="" method="post" id="addform">
							<input type="hidden" id="task_id" name="task_id">
							<h3>TITLE</h3>
							<input class="input" id="title" name="title" type="text" placeholder="My todo title">
							<h3>DESCRIPTION</h3>
							<textarea class="input" id="description" name="description" rows="4" placeholder="My todo description"></textarea>
							<h3>STARTED AT</h3>
							<input class="input" id="thestart" type="text" placeholder="Start">
							<h3>DEADLINE</h3>
							<input class="input" id="theend" type="text" placeholder="Deadline">
						</form>
					</div>

				</div>
				<div class="main-footer">
					<ul id="main-foot">
						<li><a class="filters actif" href="#" data-filter="">All tasks</a></li>
						<li><a class="filters" href="#" data-filter="todo">Todo Tasks</a></li>
						<li><a class="filters" href="#" data-filter="done">Done Tasks</a></li>
					</ul>
					<ul id="side-foot" class="">
						<li><a href="#" id="saveTask">Add Task</a></li>
						<li><a href="#" id="saveAndNew">Add &amp; Create</a></li>
					</ul>
				</div>
			</div>
		</div>

		<script src="vendor/datetimepicker/datetimepicker.min.js"></script>
		<script src="assets/js/script.js"></script>
	</body>
</html>