@extends('layout.template')
@section('title', 'Inscritos por Carrera')

@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-text">
                        <h2>Inscritos por Carrera</h2>
                        <div class="div-dec"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Select de Periodo -->
                        <label for="periodo-select">Periodo:</label>
                        <select name="periodo" id="periodo-select" class="form-control">
                            <option value="2020-1">2020-1</option>
                            <option value="2019-2">2019-2</option>
                            <option value="2019-1">2019-1</option>
                        </select>

                        <!-- Select de Modalidad -->
                        <label for="modalidad-select">Modalidad:</label>
                        <select name="modalidad" id="modalidad-select" class="form-control">
                            <option value="">TODOS</option>
                            <option value="PRESENCIAL">PRESENCIAL</option>
                            <option value="VIRTUAL">VIRTUAL</option>
                            <option value="DISTANCIA">DISTANCIA</option>
                        </select>


                        <!-- Select de Facultad -->
                        <label for="fac-select">Facultad:</label>
                        <select name="fac" id="fac-select" class="form-control">
                            <option value="">Seleccione una facultad</option>
                            <option value="2">POLITECNICA</option>
                            <option value="1">INTEGRAL DEL CHACO</option>
                            <option value="14">INTEGRAL DE LOS VALLES</option>
                            <option value="18">INGENIERIA EN CIENCIAS DE LA
                                COMPUTACIÓN</option>
                            <option value="8">HUMANIDADES</option>
                            <option value="7">CIENCIAS VETERINARIAS</option>
                            <option value="6">CIENCIAS JURIDICAS</option>
                            <option value="10">CIENCIAS FARMACEUTICAS</option>
                            <option value="5">CIENCIAS EXACTAS Y TECNOLOGIA</option>
                            <option value="4">CIENCIAS ECONOMICAS</option>
                            <option value="11">CIENCIAS DEL HABITAT</option>
                            <option value="9">CIENCIAS DE LA SALUD</option>
                            <option value="3">CIENCIAS AGRICOLAS</option>
                            <option value="12">AUDITORIA FINANCIERA</option>
                            <!-- Agregar más facultades según sea necesario -->
                        </select>

                        <!-- Botón para actualizar datos -->
                        <button id="update-data" class="btn btn-primary mt-3">Actualizar Datos</button>
                    </div>

                    <!-- Tabla de Inscritos -->
                    <div class="card-body">
                        <table class="table table-striped" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Carrera</th>
                                    <th>Inscritos</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($inscritos as $ins)
                                    <tr>
                                        <td>{{ $ins->nombre_carrera }}</td>
                                        <td>{{ $ins->total_inscritos }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Gráfico -->
            <div class="col-md-6">
                <div class="card">
                    <div style="height: 500px;">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        // Inicializar gráfico
        let chartInstance = null;

        function initChart(carreras, totales) {
            const ctx = document.getElementById('myChart').getContext('2d');

            if (chartInstance) {
                chartInstance.destroy(); // Destruir gráfico existente si ya hay uno
            }

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: carreras,
                    datasets: [{
                        label: '# de Inscritos',
                        data: totales,
                        backgroundColor: carreras.map(() => '#' + Math.floor(Math.random() * 16777215)
                            .toString(16)),
                        borderWidth: 1
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Estudiantes Inscritos por Carrera'
                        },
                    },
                }
            });
        }

        // Inicializar gráfico con datos iniciales (desde la carga de la página)
        initChart(@json($carreras), @json($totales));

        // Actualizar datos al presionar el botón
        $('#update-data').on('click', function() {
            const periodo = $('#periodo-select').val();
            const facultad = $('#fac-select').val();
            const modalidad = $('#modalidad-select').val(); // Obtener el valor de la modalidad

            $.ajax({
                url: '{{ route('inscritos-carrera-facultad') }}', // Asegúrate de que esta es la ruta correcta
                method: 'GET',
                data: {
                    periodo: periodo,
                    fac: facultad,
                    modalidad: modalidad // Enviar la modalidad en la solicitud
                },
                success: function(response) {
                    // Actualizar tabla
                    let tableBody = $('#table-body');
                    tableBody.empty();
                    response.carreras.forEach((carrera, index) => {
                        tableBody.append(
                            `<tr><td>${carrera}</td><td>${response.totales[index]}</td></tr>`
                        );
                    });

                    // Actualizar gráfico
                    initChart(response.carreras, response.totales);
                }
            });
        });
    </script>
@endsection
