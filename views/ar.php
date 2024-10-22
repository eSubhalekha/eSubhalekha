<!DOCTYPE html>
<head>
	<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<title>Hello, world!</title>
	<script src='<?= assets("ar/js/three.js") ?>'></script>
	<script src='<?= assets("ar/jsartoolkit5/artoolkit.min.js") ?>'></script>
	<script src='<?= assets("ar/jsartoolkit5/artoolkit.api.js") ?>'></script>
	<script src='<?= assets("ar/threex/threex-artoolkitsource.js") ?>'></script>
	<script src='<?= assets("ar/threex/threex-artoolkitcontext.js") ?>'></script>
	<script src='<?= assets("ar/threex/threex-arbasecontrols.js") ?>'></script>
	<script src='<?= assets("ar/threex/threex-armarkercontrols.js") ?>'></script>
</head>

<body style='margin : 0px; overflow: hidden; font-family: Monospace;'>


    <video id="video" autoplay loop playsinline muted style="display:none; background:transparent;">
        <source src="<?= assets("ar/video/birthday.mp4") ?>" type='video/mp4'>
    </video>
    
<script>

var scene, camera, renderer, clock, deltaTime, totalTime;

var arToolkitSource, arToolkitContext;

var markerRoot1;

var mesh1;

var directionalLight, ambientLight;

initialize();
animate();

function initialize()
{
	scene = new THREE.Scene();

	// Ambient light with adjustable intensity
	ambientLight = new THREE.AmbientLight( 0xcccccc, 0.8 ); 
	scene.add( ambientLight );

	// Directional light to simulate sunlight or spotlight
	directionalLight = new THREE.DirectionalLight( 0xffffff, 1 ); 
	directionalLight.position.set(1, 1, 1).normalize();
	scene.add( directionalLight );
				
	camera = new THREE.Camera();
	scene.add(camera);

	renderer = new THREE.WebGLRenderer({
		antialias : true,
		alpha: true
	});
	renderer.setClearColor(new THREE.Color('lightgrey'), 0)
	renderer.setSize( 1920 , 1080 );
	renderer.domElement.style.position = 'absolute'
	renderer.domElement.style.top = '0px'
	renderer.domElement.style.left = '0px'
	document.body.appendChild( renderer.domElement );

	clock = new THREE.Clock();
	deltaTime = 0;
	totalTime = 0;
	
	arToolkitSource = new THREEx.ArToolkitSource({
		sourceType : 'webcam',
	});

	function onResize()
	{
		arToolkitSource.onResize()	
		arToolkitSource.copySizeTo(renderer.domElement)	
		if ( arToolkitContext.arController !== null )
		{
			arToolkitSource.copySizeTo(arToolkitContext.arController.canvas)	
		}	
	}

	arToolkitSource.init(function onReady(){
		onResize()
	});
	
	window.addEventListener('resize', function(){
		onResize()
	});
	
	arToolkitContext = new THREEx.ArToolkitContext({
		cameraParametersUrl: '<?= assets("ar/data/camera_para.dat") ?>',
		detectionMode: 'mono'
	});
	
	arToolkitContext.init( function onCompleted(){
		camera.projectionMatrix.copy( arToolkitContext.getProjectionMatrix() );
	});

	markerRoot1 = new THREE.Group();
	scene.add(markerRoot1);
	let markerControls1 = new THREEx.ArMarkerControls(arToolkitContext, markerRoot1, {
		type: 'pattern', patternUrl: "<?= assets('ar/birthday.patt') ?>",
        minConfidence: .001
	})

	let geometry1 = new THREE.PlaneBufferGeometry(4, 3, 10, 10);

	let video = document.querySelector( 'video' );
	let texture = new THREE.VideoTexture( video );
	texture.minFilter = THREE.LinearFilter;
	texture.magFilter = THREE.LinearFilter;
	texture.format = THREE.RGBAFormat;
	let material1 = new THREE.MeshBasicMaterial( { map: texture, transparent: true  } );
	
	mesh1 = new THREE.Mesh( geometry1, material1 );
	mesh1.rotation.x = -Math.PI/2;
	
    markerRoot1.add( mesh1 );
    
    video.addEventListener('loadeddata', function() {
        video.play();
    }, false);
        video.play();
        

  
    
    // Automatically unmute and update button when AR marker is detected
    markerControls1.addEventListener('markerFound', function() {
        video.muted = false; // Unmute the video
    });
}

function updateLightingConditions() {
    const lightIntensity = arToolkitSource.domElement.clientWidth > 1024 ? 1 : 0.5; // Example dynamic light adjustment
    ambientLight.intensity = lightIntensity;
    directionalLight.intensity = lightIntensity + 0.2;
}

function update()
{
	if ( arToolkitSource.ready !== false )
		arToolkitContext.update( arToolkitSource.domElement );
	
    updateLightingConditions();  // Adjust lighting dynamically
}

function render()
{
	renderer.render( scene, camera );
}

function animate()
{
	requestAnimationFrame(animate);
	deltaTime = clock.getDelta();
	totalTime += deltaTime;
	update();
	render();
}

</script>


</body>
</html>
