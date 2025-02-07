let scene, camera, renderer, model;

function init() {
    //New scene
    scene = new THREE.Scene();
    
    //Camera (PerspectiveCamera)
    camera = new THREE.PerspectiveCamera(30, window.innerWidth / window.innerHeight, 0.1, 1000);
    
    //Canvas
    renderer = new THREE.WebGLRenderer({ canvas: document.getElementById("myCanvas") });
    renderer.setSize(window.innerWidth, window.innerHeight,);
    renderer.setPixelRatio(window.devicePixelRatio);

    //background
    const loaderBackground = new THREE.TextureLoader();
    loaderBackground.load('assets/models/Spitfire/background/hangar.jpg', function(texture) {
        scene.background = texture;
    });

    
    //lighting
    const light = new THREE.AmbientLight(0x404040, 9);  // Ambient light
    scene.add(light);
    
    //directional light
    const directionalLight = new THREE.DirectionalLight(0xeeeeee, 6);
    directionalLight.position.set(10, 5, 5).normalize();
    scene.add(directionalLight);
    
    // Load GLTF model
    const loader = new THREE.GLTFLoader();
    loader.load('assets/models/Spitfire/scene.gltf', function(gltf) {
        model = gltf.scene;
        scene.add(model);
        model.rotation.x = 0.5;
        model.position.set(0, 0, 0);
        resizeModel();
        animate(); // Start the animation loop
    }, undefined, function(error) {
        console.error(error);
    });

    // Adjust camera position
    camera.position.z = 4.5;

    window.addEventListener("resize", onWindowResize);
}

// Handle window resize
function onWindowResize() {
    // Update camera aspect ratio
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();

    // Update renderer size
    renderer.setSize(window.innerWidth, window.innerHeight);
    
    // Resize model
    resizeModel();
}

//Window rezise based on screen size
function resizeModel() {
    if (model) {
        let scaleFactor = Math.min(window.innerWidth / 800, window.innerHeight / 600);
        let maxScale = 1.0;
        let minScale = 0.3;

        scaleFactor = Math.max(minScale, Math.min(scaleFactor, maxScale));
        model.scale.set(scaleFactor, scaleFactor, scaleFactor);
    }
}

// Animation loop to rotate the model
function animate() {
    requestAnimationFrame(animate);

    if (model) {
        model.rotation.y += 0.001; // Spin on Y-axis
    }

    renderer.render(scene, camera);
}

// Initialize the scene
init();