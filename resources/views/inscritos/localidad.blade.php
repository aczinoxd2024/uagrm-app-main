@extends('layout.template')
@section('title', 'Inscritos por Localidad')
@section('content')
    <div class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-text">
                        <h2>Inscritos por localidad</h2>
                        <div class="div-dec"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.bootstrap4.css">

    <!-- Nueva fila con dos columnas para las cards -->
    <div class="container">
        <div class="row">
            <!-- Card de la izquierda con opciones -->
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

                        <!-- Select de Facultad -->
                        <label for="fac-select">Facultad:</label>
                        <select name="fac" id="fac-select" class="form-control">
                            <option value="">Seleccione una facultad</option>
                            <option value="2">POLITECNICA</option>
                            <option value="1">INTEGRAL DEL CHACO</option>
                            <option value="14">INTEGRAL DE LOS VALLES</option>
                            <option value="18">INGENIERIA EN CIENCIAS DE LA COMPUTACIÓN</option>
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
                        </select>

                        <!-- Botón para actualizar datos -->
                        <button id="update-data" class="btn btn-primary mt-3">Actualizar Datos</button>
                    </div>

                    <!-- Tabla de Inscritos -->
                    <div class="card-body">
                        <table class="table table-striped" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Localidad</th>
                                    <th>Inscritos</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($inscritos as $ins)
                                    <tr>
                                        <td>{{ $ins->localidad }}</td>
                                        <td>{{ $ins->total_inscritos }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p>Total de inscritos en todas las localidades: {{ $total }}</p>
                    </div>
                </div>
            </div>

            <!-- Card de la derecha con el gráfico -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div style="height: 500px;">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.bootstrap4.js"></script>

    <script>
        const ctx = document.getElementById('myChart');
        let chartInstance = null;

        function initChart(localidades, totales) {
            if (chartInstance) {
                chartInstance.destroy(); // Destruir gráfico existente si ya hay uno
            }

            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: localidades, // Usar las localidades como etiquetas
                    datasets: [{
                        label: '# de Inscritos',
                        data: totales, // Usar el total de inscritos como datos
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
                            text: 'Estudiantes Inscritos por Localidad'
                        },
                    },
                }
            });
        }

        // Inicializar gráfico con datos iniciales (desde la carga de la página)
        initChart(@json($localidades), @json($totales));

        // Inicializar DataTables
        let tableInstance = $('#usersTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [
                [1, 'desc']
            ], // Ordenar por la 2da columna (Inscritos)
            language: {
                lengthMenu: "Mostrar _MENU_ registros por página",
                zeroRecords: "Nada encontrado - disculpa",
                info: "Mostrando la página _PAGE_ de _PAGES_",
                infoEmpty: "No hay registros disponibles",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                search: "Buscar:",
                paginate: {
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });

        // Actualizar datos al presionar el botón
        $('#update-data').on('click', function() {
            const periodo = $('#periodo-select').val();
            const facultad = $('#fac-select').val();

            $.ajax({
                url: '{{ route('inscritos-localidad') }}', // Ruta hacia el controlador
                method: 'GET',
                data: {
                    periodo: periodo,
                    fac: facultad
                },
                success: function(response) {
                    // Actualizar tabla
                    let tableBody = $('#table-body');
                    tableBody.empty(); // Limpiar la tabla antes de insertar nuevas filas
                    response.localidades.forEach((localidad, index) => {
                        tableBody.append(
                            `<tr><td>${localidad}</td><td>${response.totales[index]}</td></tr>`
                        );
                    });

                    // Actualizar DataTables
                    tableInstance.clear();
                    tableInstance.rows.add($('#table-body').find('tr')); // Añadir nuevas filas
                    tableInstance.draw(); // Redibujar la tabla

                    // Actualizar gráfico
                    initChart(response.localidades, response.totales);
                }
            });
        });
    </script>
@endsection
