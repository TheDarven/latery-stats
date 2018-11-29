function changeMemberList() {
	var input, filter, container, content, pseudo, i;
	input = document.getElementById('playerName');
	filter = input.value.toUpperCase();
	container = document.getElementById("playerList");
	content = container.getElementsByTagName('div');
	for (i = 0; i < content.length; i++) {
		pseudo = content[i].dataset.pseudo;
		if(pseudo != undefined){
			if (pseudo.toUpperCase().indexOf(filter) > -1) {
				content[i].style.display = "";
			} else {
				content[i].style.display = "none";
			}	
		}
	}
}