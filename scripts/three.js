let scene, camera, renderer, model;

function init() {
    //New scene
    scene = new THREE.Scene();
    
    //Camera (PerspectiveCamera)
    camera = new THREE.PerspectiveCamera(30, window.innerWidth / window.innerHeight, 0.1, 1000);
    
    //Canvas
    renderer = new THREE.WebGLRenderer({ canvas: document.getElementById("myCanvas") });
    renderer.setSize(window.innerWidth, window.innerHeight,);

    //background color
    scene.background = new THREE.Color(0x00052e);
    
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
        animate(); // Start the animation loop
    }, undefined, function(error) {
        console.error(error);
    });

    // Adjust camera position
    camera.position.z = 4.5;
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