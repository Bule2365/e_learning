<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            overflow: hidden;
            background: linear-gradient(135deg, #0a4d68 0%, #0a8f9e 50%, #a8edea 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            position: absolute;
            text-align: center;
            color: #2d3436;
            max-width: 600px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(10, 77, 104, 0.15);
        }

        .error-code {
            font-size: 8rem;
            font-weight: 900;
            background: linear-gradient(45deg, #0a4d68, #0a8f9e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(10, 77, 104, 0.3);
        }

        .error-message {
            font-size: 2.5rem;
            margin: 20px 0;
            color: #0a4d68;
            text-shadow: 1px 1px 2px rgba(10, 77, 104, 0.1);
        }

        .error-description {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #34495e;
            line-height: 1.6;
        }

        .btn-back {
            background: linear-gradient(45deg, #0a4d68, #0a8f9e);
            border: none;
            padding: 14px 45px;
            border-radius: 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(10, 77, 104, 0.3);
        }

        .btn-back:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(10, 77, 104, 0.4);
        }

        /* Three.js Canvas Overlay */
        #3d-container {
            position: absolute;
            z-index: -1;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.3;
        }
    </style>
</head>

<body>
    <!-- Three.js Canvas -->
    <div id="3d-container"></div>

    <!-- Error Message Container -->
    <div class="error-container">
        <div class="error-code">403</div>
        <div class="error-message">Akses Ditolak</div>
        <div class="error-description">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Silakan kembali ke halaman utama atau hubungi administrator.
        </div>
        <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-back">
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Three.js & Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Three.js Scene Setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(
            75,
            window.innerWidth / window.innerHeight,
            0.1,
            1000
        );
        const renderer = new THREE.WebGLRenderer({
            antialias: true,
            alpha: true
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0x0a4d68, 0.05);
        document.getElementById('3d-container').appendChild(renderer.domElement);

        // Create 3D Objects
        const geometry = new THREE.IcosahedronGeometry(1.5, 0);
        const material = new THREE.MeshPhongMaterial({
            color: 0x0a8f9e,
            shininess: 100,
            specular: 0xa8edea,
            transparent: true,
            opacity: 0.7
        });
        const shape = new THREE.Mesh(geometry, material);
        scene.add(shape);

        // Add Lighting
        const pointLight = new THREE.PointLight(0xffffff, 1.5);
        pointLight.position.set(5, 5, 5);
        scene.add(pointLight);

        const ambientLight = new THREE.AmbientLight(0x0a4d68, 0.1);
        scene.add(ambientLight);

        // Position Camera
        camera.position.z = 1.8;

        // Animation Loop
        function animate() {
            requestAnimationFrame(animate);

            // Rotate Object
            shape.rotation.x += 0.003;
            shape.rotation.y += 0.003;

            renderer.render(scene, camera);
        }

        // Handle Window Resize
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        animate();
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\e_learning\resources\views/errors/403.blade.php ENDPATH**/ ?>