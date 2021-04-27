//-------------------- initialisation des variables ---------------------------------//

var container, stats;
var camera, scene, renderer, projector, control;

var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;
projector = new THREE.Projector();
var intersects = [];
var INTERSECTED ;

init();
animate();

//-------------------- fonction init() de three.js = initialisation de la scène ---------------------------------//

function init() {

	//----- bloc et position ------//
		
	container = document.createElement( 'div' );		//création d'un div 'container'
	document.body.appendChild( container );				//ajout du div au body (index.php)

	//----- Caméras ------//

	camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );	//création d'une caméra
	camera.position.z = 200;									//postition z de la caméra
	camera.position.y = 100;									//position y de la caméra
        camera.position.x = 100;

	//----- Contrôle de la caméra ------//

	controls = new THREE.TrackballControls( camera );						//création de contrôles	(manière de manipuler la caméra)
	controls.rotateSpeed = 1.0;									//vitesse de rotation
	controls.zoomSpeed = 1.2;									//vitesse de zoom
	controls.panSpeed = 0.8;									//vitesse de translation
	controls.noZoom = false;									//autorisation de zoom
	controls.noPan = false;										//autorisation translation
	controls.staticMoving = false;									//
	controls.dynamicDampingFactor = 0.3;								//
        
 

	//----- Création de la scène ------//	
			
	scene = new THREE.Scene();									//nouvelle scène
	scene.fog = new THREE.Fog( 0xffffff, 1000, 5000 );			//ajout de brouillard
	scene.fog.color.setHSL( 0.6, 0, 1 );						//couleur du brouillard 

	//----- Lumières ------//

	// lights selon les axes x, y et z

				light = new THREE.DirectionalLight( 0xffcc99 );
				light.position.set( 0, 0, 1 );
				scene.add( light );

				light = new THREE.DirectionalLight( 0xffcc99 );
				light.position.set( 0, 0, -1 );
				scene.add( light );
                                
                light = new THREE.DirectionalLight( 0xffcc99 );
				light.position.set( 1, 0, 0 );
				scene.add( light );
                                
                light = new THREE.DirectionalLight( 0xffcc99 );
				light.position.set( -1, 0, 0 );
				scene.add( light );

				light = new THREE.AmbientLight( 0xffcc99 );
				scene.add( light );

       
        	                      

	//----- Affichage WebGL ------//
				
	renderer = new THREE.WebGLRenderer( { antialias: true } );			//création de l'affichage (=renderer)
	renderer.setSize( window.innerWidth, window.innerHeight );			//mise à la bonne taille
	container.appendChild( renderer.domElement );						//ajout de l'affichage à la page
	renderer.setClearColor( scene.fog.color, 1 );						//en cas de rien à l'écran... 
	renderer.gammaInput = true;											//activation du gamma de l'input
	renderer.gammaOutput = true;										//activation du gamma de l'output
	renderer.shadowMapEnabled = true;									//activation des ombres
	renderer.shadowMapCullFace = THREE.CullFaceBack;				
				
	

	//----- divers ------//
        
	//document.addEventListener('mouseover', onMouseOver, false);			
	
		//----- Statistiques ------//

	stats = new Stats();								//création de statistiques sur la scène
	stats.domElement.style.position = 'absolute';		//position du module de stats
	stats.domElement.style.top = '0px';					//collé au haut de la page
	stats.domElement.style.zIndex = 100;				//zindex pour le mettre devant
	container.appendChild( stats.domElement );			//ajout de l'icone stats à la page
						
	
	
	
}	//fin de la fonction init()

window.addEventListener( 'resize', onWindowResize, false );	    //'surveilleur' de zoom chargé de redimmensionner la visualisation en fonction de la taille de la fenêtre
        
         //----- définition de la fonction animate ------//
       
         function animate() {									//fonction qui gère l'animation (au mouvement de l'objet)	
		requestAnimationFrame(animate);				
		stats.update();
		render();
	}
                                                                                                                                                                    
	

        function render() {										//fonction qui gère le rendu utilisateur et génère la scène
		controls.update();
                camera.lookAt( scene.position );
		renderer.render( scene, camera );
	}
        
        
	function onWindowResize() {									//fonction appelée lorsque la fenêtre est redimensionnée -> gère l'affichage
		camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();

                renderer.setSize( window.innerWidth, window.innerHeight );
	}


document.addEventListener('mousedown', onMouseDown, true);		//'surveilleur' des mouvements de la souris

		
function onMouseDown(event) {							//foncion déclenchée au mouvement de la souris 
        
        event.preventDefault();
        
	mouseX = event.clientX;								//détection de la position en X de l'utilisateur en temps réel
        mouseY = event.clientY;							//détection de la position en Y de l'utilisateur en temps réel

	var vectorMouse = new THREE.Vector3();				//création d'un vecteur 3 dimensions 
	vectorMouse.x = (mouseX/window.innerWidth)*2-1;		//coordonnées x du vecteur
	vectorMouse.y = -(mouseY/window.innerHeight)*2+1;	//coordonnées y du vecteur
	vectorMouse.z = 0.5;								//coordonnées z du vecteur
	vectorMouse.unproject(camera);	 	    			//on "déprojette" l'objet 

	var raycaster = new THREE.Raycaster(camera.position, vectorMouse.sub(camera.position).normalize());	//céation d'un vecteur entre la position de la caméra et le curseur
        var intersects = raycaster.intersectObjects( objects,true );									//création de la variable intersects qui contient les objets intersectés 
                                                                                                         //par le curseur de l'utilisateur
	
        
	if ( intersects.length > 0 ) {								//détection des intersections (longueur positive)	
		if ( INTERSECTED != intersects[ 0 ].object ) {			//si la variable INTERSECTED est différent du premier objet intersecté
			if ( INTERSECTED ) INTERSECTED.material.color.setHex( INTERSECTED.currentHex ); //si la texture de l'élément n'est pas modifiée
				INTERSECTED = intersects[ 0 ].object;										//variable intersected = 1er objet intersecté
				INTERSECTED.currentHex = INTERSECTED.material.color.getHex();				//changer la couleur de cet objet
				INTERSECTED.material.color.setHex( 0xffffff );								//créer de la surbrillance blanche
				for (var i = 0; i < objects.length; i=i+1) {								//boucle de détection de l'objet sélectionné
					if (  objects[i].name == intersects[ 0 ].object.parent.name ) {			//si le nom de l'objet i du tableau des objets est égal au nom de l'objet intersecté
						var selection=objects[i].name;										//définir la variable selection par le nom de cet objet
						document.getElementById("id").innerHTML = selection ;				//envoyer ce nom dans le bloc id à destination de l'utilisateur
						document.getElementById("champ_select").value = selection ;			//envoyer ce nom dans un champ invisible pour une récupération ultérieure
						document.getElementById("searchForm").onclick("SubmitForm()");  	//valider le formulaire caché (déclenchement de fonction ajax)
					}	
				}

			} else {																		//sinon

		if ( INTERSECTED ) INTERSECTED.material.color.setHex( INTERSECTED.currentHex );		//si la couleur de l'objet intersecté n'a pas changé
			INTERSECTED = null;																//variable INTERSECTED null
		}
	}
        render();
}	
		
//------------------fonctions de désactivation des contrôles-------------------------//

//S'il y a un ascenseur dans la fenêtre du menu le fait de descendre l'ascenseur fait bouger la caméra.
//il faut donc désactiver les contrôles de three.js lorsque l'utilisateur clique dans les différents menus.

		
document.getElementById('menu').onmouseover = function () {			//décelenchement de la fonction lorsque la souris survole le div menu
	controls.enabled = false;										//la fonction désactive les controles de three.js
};

document.getElementById('menu').onmouseout = function () {			//déclenchement de la fonction lorsque la souris quitte le div menu
	controls.enabled = true;										//la fonction active les contrôles de three.js
};

document.getElementById('menuprinc').onmouseover = function () {	//décelenchement de la fonction lorsque la souris survole le div menu
	controls.enabled = false;										//la fonction désactive les controles de three.js
};

document.getElementById('menuprinc').onmouseout = function () {		//décelenchement de la fonction lorsque la souris survole le div menu
	controls.enabled = true;										//la fonction active les controles de three.js
};


			

		
