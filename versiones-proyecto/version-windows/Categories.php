<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Lector de noticias RSS - Categorías</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="./css/styles.css" rel="stylesheet" />
    <link href="./css/styles_front.css" rel="stylesheet" />
    <style>
        .letters-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }
        #letters-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .letter {
            cursor: pointer;
            padding: 10px;
            margin: 5px;
        }
        .selected {
            font-weight: bold;
        }
        #selected-letter {
            text-align: center;
            font-size: 30px;
        }

        /* CSS para pantallas pequeñas */
        @media (max-width: 768px) {
            .letters-container {
                flex-direction: column;
                align-items: center;
            }
            #letters-bar {
                margin-bottom: 0;
            }
            .letter {
                padding: 5px;
                margin: 3px;
            }
        }
    </style>
</head>
<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Lector de noticias RSS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="views/feed.php">Añadir Feeds</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="Categories.php">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link " href="views/about.php">Acerca de</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="py-5">
        <div class="container px-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xxl-6">
                    <div class="my-5 text-white">
                        <h1 class="fw-bolder text-center mb-3">Lector de Noticias RSS</h1>
                        <p class="lead text-center fw-normal mb-4">
                            Revisa tus categorías favoritas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>
        
    <section class="py-5 bg-light">
        <!-- Aquí se añadirá la barra de selección de letras y la sección de contenido -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xxl-6">
                    <div class="letters-container">
                        <div id="letters-bar">
                            <!-- Las letras de la A a la Z se generarán aquí -->
                        </div>
                        <div class="d-flex flex-column">
                            <div id="selected-letter" class="text-center mb-4">Selecciona una letra</div>
                            <div id="categories-container" class="mt-4">
                                <!-- Aquí se mostrarán las categorías -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Optimización de Aplicaciones Web 2023.</p></div>
    </footer>

    <!-- JavaScript para cargar el lector de RSS y obtener las categorías -->
    <script>
        // Función para generar las letras de la A a la Z
        function generateLetters() {
            const lettersBar = document.getElementById('letters-bar');
            const screenWidth = window.innerWidth;
            const letterSize = screenWidth <= 768 ? '4vw' : '1rem'; // Tamaño de letra ajustado para pantallas pequeñas

            for (let i = 65; i <= 90; i++) {
                const letter = String.fromCharCode(i);
                const div = document.createElement('div');
                div.textContent = letter;
                div.classList.add('letter');
                div.setAttribute('data-letter', letter);
                div.style.fontSize = letterSize; // Aplicar tamaño de letra
                div.addEventListener('click', selectLetter);
                lettersBar.appendChild(div);
            }
        }

        // Función para seleccionar una letra
        function selectLetter(event) {
            const selectedLetter = event.target.getAttribute('data-letter');
            const letterElements = document.querySelectorAll('.letter');
            letterElements.forEach(letter => {
                if (letter.getAttribute('data-letter') === selectedLetter) {
                    letter.classList.add('selected');
                } else {
                    letter.classList.remove('selected');
                }
            });
            document.getElementById('selected-letter').textContent = `Letra seleccionada: ${selectedLetter}`;
            
            // Realizar una solicitud al servidor para obtener las categorías que comiencen con la letra seleccionada
            fetch(`controllers/rss_letter_search.php?letter=${selectedLetter}`)
                .then(response => response.text())
                .then(data => {
                    const categoriesContainer = document.getElementById('categories-container');
                    categoriesContainer.innerHTML = data; // Mostrar las categorías obtenidas
                })
                .catch(error => {
                    console.error('Error al obtener las categorías:', error);
                });
        }

        // Llamar a la función para generar las letras
        generateLetters();
    </script>
</body>
</html>







