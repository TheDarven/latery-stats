var page = 1, nbrPage = 1, taillePage = 15;
function sortTable(n) {
	var table, rows, th, sort = 0;
	table = document.getElementById("myTable");
	rows = table.rows;

	th = rows[0].getElementsByTagName("th");
	for(i=0; i<th.length; i++){
		th[i].classList.remove("before");
		th[i].classList.remove("after");
		if(i == n){
			if(th[i].dataset.sort == "0"){
				th[i].dataset.sort = "1";
				sort = 1;
				th[i].classList.add("before");
			}else{
				th[i].dataset.sort = "0";
				th[i].classList.add("after");
			}
		}else{
			th[i].dataset.sort = "0";
		}
	}
	if(rows.length > 2){
		for(i=2; i<rows.length; i++){
			for(j=i; j<rows.length; j++){
				if(sort == 1){
					if(rows[i].getElementsByTagName("td")[n].innerHTML.toLowerCase() < rows[j].getElementsByTagName("td")[n].innerHTML.toLowerCase()){
						rows[i].parentNode.insertBefore(rows[j], rows[i]);
					}
				}else{
					if(rows[i].getElementsByTagName("td")[n].innerHTML.toLowerCase() > rows[j].getElementsByTagName("td")[n].innerHTML.toLowerCase()){
						rows[i].parentNode.insertBefore(rows[j], rows[i]);
					}
				}
			}
		}
		reloadTable();
	}
}

function reloadTable(){
	var table, rows, min, max;
	table = document.getElementById("myTable");
	rows = table.rows;
	min = 2+((page-1)*taillePage);
	max = 2+(page*taillePage);

	if(rows.length > 2){
		for(i=2; i<rows.length; i++){
			rows[i].getElementsByTagName("td")[0].innerHTML = i-1;
			if(i >= min && i < max){
				rows[i].style.display = "table-row";
			}else{
				rows[i].style.display = "none";
			}
		}
	}
}

function changePage(n){
	var table, rows, min, max, ul, li;
	table = document.getElementById("myTable");
	rows = table.rows;
	if(rows.length > 2){
		min = 2+((n-1)*taillePage);
		max = 2+(n*taillePage);
		if(max > rows.length){
			max = rows.length;
		}
		for(i=2; i<rows.length; i++){
			if(i >= min && i<max){
				rows[i].style.display = "table-row";
			}else{
				rows[i].style.display = "none";
			}
		}
	}

	ul = document.getElementById("myPagination");
	li = ul.getElementsByTagName("li");
	li[page].classList.remove("active");
	li[n].classList.add("active");
	page = n;

	if(page != 1){
		li[0].setAttribute("onClick","changePage("+(page-1)+")");
	}else{
		li[0].setAttribute("onClick","changePage("+1+")");
	}
	if(page != nbrPage){
		li[nbrPage+1].setAttribute("onClick","changePage("+(page+1)+")");
	}else{
		li[nbrPage+1].setAttribute("onClick","changePage("+nbrPage+")");
	}
}

window.onload = function(){
	var ul, li, newli, table, rows, taille;
	ul = document.getElementById("myPagination");
	li = ul.getElementsByTagName("li");
	
	table = document.getElementById("myTable");
	rows = table.rows;
	taille = rows.length-2;
	nbrPage = (taille-(taille%taillePage))/taillePage;
	if(taille%taillePage != 0){
		nbrPage++;
	}
	if(nbrPage > 1){
		for(i=2; i<nbrPage+1; i++){
			newli = document.createElement('li');
            newli.setAttribute('class','page-item');
            newli.innerHTML = "<span class=\"page-link\">"+i+"</span>";
            newli.setAttribute('onClick','changePage('+i+')');

            ul.insertBefore(newli,ul.children[(i)]);
		}
		ul.getElementsByTagName("li")[nbrPage+1].setAttribute("onClick","changePage(2)");
	}
}