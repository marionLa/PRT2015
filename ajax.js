function SubmitForm() {						//fonction qui affiche le menu au survol
var selected = $("#champ_select").val();	//définition de la variable selected qui correspond à la valeur de l'objet survolé
//var selected = "cathedrale_0005";
$.ajax({									//définition de la fonction ajax
   type: "POST",							//type de formulaire
   url: "submit.php",						//appel du code contenu dans submit.php
   data:'selected=' + selected,				//affichage des résultats
	 success : function(code_html, statut){	//affichage du code de submit.php dans le div menu
           $("#menu").html(code_html);
      		 },
   });
};

