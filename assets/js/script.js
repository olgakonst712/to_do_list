// Object AJAX
class Ajax {
	constructor(){
		this.ajaxUrl = '/Todo/core/request.php';
	};
	// Method Post : action sur la bdd, callback tjr le même: Si Ok, relance l'app!
	post(request){
		return this.connect(request,'POST');
	};
	// Method Get : lecture base de donné
	get(){
		return this.connect('','GET');
	};
	// Method Connect : Execute un GET ou un POST.
	connect(request,method){
		var ajax = new XMLHttpRequest();
		ajax.open(method, this.ajaxUrl, true);
		if (method=='POST') ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send(request);
		ajax.onreadystatechange = function() {
			if (ajax.readyState == 4 && ajax.status == 200) {
				// CallBack App.LoadTasks
				// @param la réponse du serveur en format Ajax
				 App.loadTasks(JSON.parse(this.responseText));
			}
		};
	};
}


App = {
	data : [],
	db: new Ajax('/Todo/core/request.php'),
	filter: '', // 'todo' / 'done' / 'late' / ''
	sortBy: 'status', // 'status' / 'date'
	paneStatus: "closed",
	optionsStatus: "closed",
	record(data){
		this.data = data.tasks;
	},
	renderTasks(){
		// Le template contient l'html de base de chaque Item de la Liste.
		let template = document.querySelector('.template');
		//Boucle dans toutes les tâches
		for (var i = 0; i < this.data.length; i++) {
			// Pour faciliter, on appelle la variable: task.
			let task = this.data[i];
			// Determine la section de la tache actuelle
			let section = task.task_ended_on==null?'todo':(task.task_ended_on<task.task_end?'done':'late');
			if (this.filter != section && this.filter != '') {
				continue;
			}
			// Clone le template et enlève la class template
			let clone = template.cloneNode(true);
			clone.classList.remove('template');

			// Crée un identifiant unique pour chaque tache (afin de faciliter la TREE TRAVERSIAL)
			let uniqueID = "ti"+task.task_id;
			clone.setAttribute("id", uniqueID);

			// AJOUT Text / Data-Toggle / Click AU TITRE DE CHAQUE TACHE
			clone.querySelector('.task-name').innerHTML = task.task_title;
			clone.querySelector('.task-name').setAttribute('data-toggle', uniqueID);
			clone.querySelector('.task-name').classList.add(section+'-task');
			clone.querySelector('.task-name').addEventListener('click',this.onTaskTitleClick);
			// AJOUT Click sur Delete
			clone.querySelector('.delete-task').setAttribute('data-delete', uniqueID);
			clone.querySelector('.delete-task').addEventListener('click',this.onTaskDeleteClick);
			// AJOUT Click sur FINISHED TASK
			clone.querySelector('.complete-task').setAttribute('data-complete', uniqueID);
			clone.querySelector('.complete-task').classList.add(section+'-task');
			clone.querySelector('.complete-task').addEventListener('click',this.onTaskCompleteClick);
			clone.querySelector('.task-check').setAttribute('data-complete', uniqueID);
			clone.querySelector('.task-check').classList.add(section+'-task');
			clone.querySelector('.task-check').addEventListener('click',this.onTaskCompleteClick);
			// AJOUT Click sur Edit
			clone.querySelector('.edit-task').setAttribute('data-edit', uniqueID);
			clone.querySelector('.edit-task').addEventListener('click',this.onTaskEditClick);
			// Ajout Description
			clone.querySelector('.desc').innerHTML = task.task_description;
			// Ajout Date de Création
			clone.querySelector('.created').innerHTML = this.pretty_date(task.task_created_on);
			if (task.task_ended_on) {
				clone.querySelector('.completed').innerHTML = " - End time: "+ this.pretty_date(task.task_ended_on);
			}			
			// Ajout du clone dans la section voulu
			if (this.sortBy == 'status') {
				document.getElementById(section).insertBefore(clone,document.getElementById(section).firstChild);
			} else {
				document.getElementById('ul-by-date').insertBefore(clone,document.getElementById('ul-by-date').firstChild);
			}
		}
	},
	pretty_date(timestamp){
		var date = new Date(timestamp*1000);
		return date.getDate()+"/"+date.getMonth()+"/"+date.getFullYear()+" "+date.getHours()+":"+(date.getMinutes()<10?'0':'') + date.getMinutes();
	},
	onTaskEditClick(e){
		// CLICK SUR LE BOUTON EDIT
		for (var i=0; i < App.data.length; i++){
			if (App.data[i]['task_id'] == this.dataset.edit.split('ti')[1]){
				var task = App.data[i];
			}
		}
		console.log(task);
		document.querySelector('.next-container').querySelector('#task_id').value = task.task_id;
		document.querySelector('.next-container').querySelector('#title').value = task.task_title;
		document.querySelector('.next-container').querySelector('#description').value = task.task_description;
		App.thestart.setDate(task.task_created_on*1000);
		App.theend.setDate(task.task_end*1000);
		App.toggleSidePane();
	},
	onTaskDeleteClick(e){
		// CLICK SUR LE BOUTON DELETE
		e.preventDefault();
		var req = "action=delete&task_id="+this.dataset.delete.split('ti')[1];
		App.db.post(req);
	},
	onTaskCompleteClick(e){
		e.preventDefault();
		id = this.dataset.complete.split('ti')[1];
		if(this.classList.contains('todo-task')){
			var req = "action=complete&task_id="+id;
		} else {
			var req = "action=uncomplete&task_id="+id;
		};
		App.db.post(req);
	},
	loadTasks(data){
		App.record(data);
		App.clearTasks();
		App.renderTasks();
	},
	clearTasks(){
		let uls = document.getElementsByClassName('task-list');
		for (var i = 0; i < uls.length; i++) {
			while (uls[i].firstChild) {
			    uls[i].removeChild(uls[i].firstChild);
			}
		}
	},
	onTaskTitleClick(e){
		e.preventDefault();
		let detail = document.querySelector("#" + this.dataset.toggle + " .details");
		let actions = document.querySelector("#" + this.dataset.toggle + " .task-actions");

		if ( detail.dataset.status == "hide" ) {
			App.animate( .5, 0, 110, (n)=>{
					detail.style.height = n+"px";
					actions.firstElementChild.style.width = (110-n)+"%";
			},function(){
					actions.firstElementChild.style.display = "none";
			});
			detail.dataset.status = "show";
		} else {
			actions.firstElementChild.style.display = "block";
			App.animate( .5, 0, 110, function(n){
				detail.style.height = (110-n)+"px";
					actions.firstElementChild.style.width = n+"%";
			});
			detail.dataset.status = "hide";
		};
	},
	formClear(){
		document.getElementById('title').value = "";
		document.getElementById('description').value = "";
		document.getElementById('thestart').value = '' //Clear the input value attribute.
		this.thestart.refresh();
		document.getElementById('theend').value = '' //Clear the input value attribute.
		this.theend.refresh();
		document.getElementById('task_id').value = "";
	},
	onFormSubmit(){
		let title = document.getElementById('title').value;
		let description = document.getElementById('description').value;
		let start = Math.round(this.thestart.getDate('T')/1000);
		let deadline = Math.round(this.theend.getDate('T')/1000);
		let id = document.getElementById('task_id').value;
		let action = id ? 'update' : 'add';

		var req = "action="+action+"&task_title="+title+"&task_description="+description+"&task_created_on="+ start +"&task_end="+ deadline;
		if (id) req += ("&task_id="+id)
		App.db.post(req);
	},
	animate(duree,initial,final,animation,callback=null){
  		var frameNb = duree * 25;
		var t = 0;
		var n = 0;

		var projecteur = setInterval(function(){
			if (t/frameNb > 1) {
				typeof callback === 'function' && callback();
				return clearInterval(projecteur);
			};
			n = App.easeInOutQuad(t/frameNb) * final;
			animation(n)
			t++;
		},25);
	},
	toggleSidePane(){
		if ( App.paneStatus == "closed" ) {
			App.paneStatus = "opened";
			App.animate( 1, 0, 100, function(n){
				document.querySelector('.next-container').style.left = (100-n)+"%";
				document.querySelector('.sort-button').style.right = ((50-n)*40/100)+"px";
				document.getElementById('side-foot').style.left = (n-100)+"%";
				document.getElementById('main-foot').style.left = n+"%";
			});
		} else {
			App.paneStatus = "closed";
			App.animate( 1, 0, 100, function(n){
				document.querySelector('.next-container').style.left = n+"%";
				document.querySelector('.sort-button').style.right = (-(50-n)*40/100)+"px";
				document.getElementById('side-foot').style.left = (-n)+"%";
				document.getElementById('main-foot').style.left = (100-n)+"%";
			});
		}

		// document.getElementById('side-foot').classList.toggle('hide');
		// document.getElementById('main-foot').classList.toggle('hide');
		document.querySelector('.add-button').classList.toggle('chosen');
	},
	toggleOptionsPane(){
		if ( this.optionsStatus == "closed" ) {
			this.animate( .5, 0, 100, function(n){
				document.querySelector('.options').style.top = n+"px";
				bit = Math.round((n+50)*255/100);
				document.querySelector('.sort-button svg').style.fill = 'rgb('+bit+','+bit+','+bit+')';
			});
			this.optionsStatus = "opened";
		} else {
			this.animate( .5, 0, 100, function(n){
				document.querySelector('.options').style.top = (100-n)+"px";
				bit = Math.round((150-n)*255/100);
				document.querySelector('.sort-button svg').style.fill = 'rgb('+bit+','+bit+','+bit+')';
			});
			this.optionsStatus = "closed";
		}
	},
	easeInOutQuad: function (t) { return t<.5 ? 2*t*t : -1+(4-2*t)*t },
	toggleSorting(sortBy){
		this.sortBy = sortBy;
		this.clearTasks();
		this.renderTasks();
	},
	start(){
		// INIT des Date Pickers:
		this.thestart = new DateTimePicker('#thestart', {
			timePicker: true,
			timePickerFormat:24,
			format: 'd/m/Y à H:i',
			allowEmpty:true,
			minuteIncrement:15,
			positionOffset: {x:0,y:-300}
		});
		this.theend = new DateTimePicker('#theend', {
			timePicker: true,
			timePickerFormat:24,
			format: 'd/m/Y à H:i',
			allowEmpty:true,
			minuteIncrement:15,
			positionOffset: {x:0,y:-300}
		});
		// Premier chargement des donnees.
		this.db.get();
		// SUBMIT TASK
		document.getElementById('saveTask').addEventListener('click',function(e){
			e.preventDefault;
			App.onFormSubmit();
			App.paneStatus = "closed";
			App.animate( .5, 0, 100, function(n){
				document.querySelector('.next-container').style.left = n+"%";
			});
		});
		// SUBMIT TASK and GET READY FOR ANOTHER ONE
		document.getElementById('saveAndNew').addEventListener('click',function(e){
			e.preventDefault;
			App.onFormSubmit();
			App.formClear();
		});
		// CLICK SUR LE BOUTON (+)
		document.getElementById('plus').addEventListener('click',function(e){
			e.preventDefault();
			App.formClear();
			if (App.optionsStatus=="opened") App.toggleOptionsPane();
			App.toggleSidePane();
		});
		// CLICK SUR CLEAR
		document.getElementById('clear').addEventListener('click',function(e){
			e.preventDefault();
			App.formClear();
		});
		// CLICK SUR LE BOUTON SETTINGS
		document.getElementById('settings').addEventListener('click',function(e){
			e.preventDefault();
			App.toggleOptionsPane();
		});
		// CLICK SUR l'un des sortings
		let sortings = document.getElementsByClassName('sorting');
		for (var i = 0; i < sortings.length; i++) {
			sortings[i].addEventListener('click',function(e){
				e.preventDefault();
				for (var j = 0; j < sortings.length; j++) {
					sortings[j].classList.remove('actif');
				}
				this.classList.add('actif');
				App.toggleSorting(this.dataset.sort);
				App.toggleOptionsPane();
				App.optionsStatus = "closed";
			});
		}
		// CLICK SUR LES FILTRES 
		let filters = document.getElementsByClassName('filters');
		for (var i = 0; i < filters.length; i++) {
			filters[i].addEventListener('click',function(e){
				e.preventDefault();
				for (var j = 0; j < filters.length; j++) {
					filters[j].classList.remove('actif');
				}
				this.classList.add('actif');
				App.filter = this.dataset.filter;
				App.clearTasks();
				App.renderTasks();
			});
		}
	}
}

App.start();
