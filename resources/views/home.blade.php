<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnos Online | Automatizá la agenda de tu negocio</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-white text-gray-800">

    <!-- NAV -->
    <header class="sticky top-0 bg-white shadow z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <span class="text-xl font-bold text-indigo-600">TurnosOnline</span>

            <nav class="space-x-6 text-sm">
                <a href="#beneficios" class="hover:text-indigo-600">Beneficios</a>
                <a href="#funciona" class="hover:text-indigo-600">Cómo funciona</a>
                <a href="#planes" class="hover:text-indigo-600">Planes</a>
                <a href="{{ route('login') }}" class="hover:text-indigo-600">Ingresar</a>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
                    Probar gratis
                </a>
            </nav>
        </div>
    </header>

    <!-- HERO -->
    <section class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-700 text-white">
        <div class="max-w-7xl mx-auto px-6 py-32 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                Tu agenda, organizada<br>sin errores
            </h1>

            <p class="text-lg md:text-xl mb-10 max-w-2xl mx-auto">
                Un sistema de turnos online pensado para negocios reales
                que quieren ahorrar tiempo y verse profesionales.
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-semibold">
                    Crear mi agenda gratis
                </a>
                <a href="#beneficios" class="border border-white px-8 py-4 rounded-xl">
                    Ver cómo funciona
                </a>
            </div>
        </div>
    </section>

    <!-- RUBROS -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="mt-12 text-4xl font-semibold">
                Usado por negocios como
            </p>

            <div class="mt-16 grid grid-cols-2 md:grid-cols-5 gap-6 text-gray-700">
                <div class="mt-6 font-semibold">Peluquerías</div>
                <div class="mt-6 font-semibold">Consultorios</div>
                <div class="mt-6 font-semibold">Gimnasios</div>
                <div class="mt-6 font-semibold">Talleres</div>
                <div class="mt-6 font-semibold">Estéticas</div>
            </div>
        </div>
    </section>

    <!-- BENEFICIOS -->
    <section id="beneficios" class="py-24">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-12">
                Diseñado para simplificar tu día
            </h2>

            <div class="grid md:grid-cols-3 gap-12">

                <!-- Card 1 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden
                       transition-all duration-300 ease-out
                       hover:shadow-2xl hover:-translate-y-1
                       ring-1 ring-transparent hover:ring-indigo-500">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold mb-3">
                            Menos interrupciones
                        </h3>
                        <p class="text-gray-600">
                            Tus clientes reservan solos, sin llamadas ni mensajes.
                        </p>
                    </div>

                    <div class="bg-gray-100 px-8 py-4 text-sm text-gray-500">
                        Ahorra tiempo todos los días
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden
                       transition-all duration-300 ease-out
                       hover:shadow-2xl hover:-translate-y-1
                       ring-1 ring-transparent hover:ring-indigo-500">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold mb-3">
                            Agenda inteligente
                        </h3>
                        <p class="text-gray-600">
                            Calcula duraciones, evita superposiciones y errores.
                        </p>
                    </div>

                    <div class="bg-gray-100 px-8 py-4 text-sm text-gray-500">
                        Sin solapamientos
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden
                       transition-all duration-300 ease-out
                       hover:shadow-2xl hover:-translate-y-1
                       ring-1 ring-transparent hover:ring-indigo-500">
                    <div class="p-8">
                        <h3 class="text-lg font-semibold mb-3">
                            Control total
                        </h3>
                        <p class="text-gray-600">
                            Servicios, clientes, empleados y horarios en un solo lugar.
                        </p>
                    </div>

                    <div class="bg-gray-100 px-8 py-4 text-sm text-gray-500">
                        Todo centralizado
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ANTES / DESPUÉS -->
    <section class="bg-gray-100 py-24">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-16">
                Antes y después de usar TurnosOnline
            </h2>

            <div class="grid md:grid-cols-2 gap-10">
                <div class="bg-red-200 p-8 rounded-xl">
                    <h3 class="font-semibold mb-4">❌ Antes</h3>
                    <ul class="space-y-2 text-gray-900">
                        <li class="mt-4 font-semibold">Llamadas todo el día</li>
                        <li class="mt-4 font-semibold">Turnos anotados a mano</li>
                        <li class="mt-4 font-semibold">Errores y confusiones</li>
                    </ul>
                </div>

                <div class="bg-green-200 p-8 rounded-xl">
                    <h3 class="font-semibold mb-4">✅ Después</h3>
                    <ul class="space-y-2 text-gray-900">
                        <li class="mt-4 font-semibold">Reservas automáticas</li>
                        <li class="mt-4 font-semibold">Agenda clara y ordenada</li>
                        <li class="mt-4 font-semibold">Imagen profesional</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- COMO FUNCIONA -->
    <section id="funciona" class="py-24">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-16">
                Empezar es muy simple
            </h2>

            <div class="grid md:grid-cols-3 gap-10">
                <div>
                    <span class="text-4xl">1️⃣</span>
                    <p class="mt-4 font-semibold">Creás tu negocio</p>
                </div>
                <div>
                    <span class="text-4xl">2️⃣</span>
                    <p class="mt-4 font-semibold">Configurás horarios y servicios</p>
                </div>
                <div>
                    <span class="text-4xl">3️⃣</span>
                    <p class="mt-4 font-semibold">Los clientes reservan solos</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PLANES -->
    <section id="planes" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-4xl font-bold text-center mb-4">
                Planes simples para negocios reales
            </h2>
            <p class="text-center text-gray-600 mb-16">
                Empezá gratis y escalá cuando tu negocio crezca
            </p>

            <div class="grid md:grid-cols-3 gap-10">

                <!-- GRATIS -->
                <div
                    class="bg-white rounded-xl shadow-md p-8 text-center
                       transition-all duration-300
                       hover:shadow-2xl hover:-translate-y-1
                       ring-1 ring-transparent hover:ring-indigo-500">
                    <h3 class="text-xl font-semibold mb-2">Gratis</h3>
                    <p class="text-gray-500 mb-6">Para empezar sin compromiso</p>

                    <div class="text-4xl font-bold mb-6">
                        ARS 0
                    </div>

                    <ul class="space-y-3 text-gray-600 mb-8 text-left">
                        <li>✔ 1 negocio</li>
                        <li>✔ 1 empleado</li>
                        <li>✔ Agenda básica</li>
                        <li>✔ Reservas online 24/7</li>
                    </ul>

                    <a href="{{ route('register') }}"
                        class="block bg-indigo-500 text-white py-3 rounded-lg font-semibold hover:bg-indigo-600">
                        Empezar gratis
                    </a>
                </div>

                <!-- PRO (DESTACADO) -->
                <div
                    class="bg-indigo-600 text-white rounded-xl shadow-2xl p-10 text-center
                       scale-105 relative">

                    <span
                        class="absolute -top-4 left-1/2 -translate-x-1/2
                           bg-white text-indigo-600 text-sm font-semibold
                           px-4 py-1 rounded-full shadow">
                        Más elegido
                    </span>

                    <h3 class="text-2xl font-bold mb-2">Pro</h3>
                    <p class="text-indigo-100 mb-6">
                        Ideal para negocios activos
                    </p>

                    <div class="text-4xl font-bold mb-6">
                        ARS 10.990
                        <span class="text-base font-normal">/ mes</span>
                    </div>

                    <ul class="space-y-3 mb-8 text-left">
                        <li>✔ Negocios ilimitados</li>
                        <li>✔ Empleados ilimitados</li>
                        <li>✔ Agenda inteligente (sin huecos)</li>
                        <li>✔ Recordatorios automáticos</li>
                        <li>✔ Gestión de clientes</li>
                    </ul>

                    <a href="{{ route('register') }}"
                        class="block bg-white text-indigo-600 py-3 rounded-lg font-semibold hover:bg-gray-100">
                        Probar Pro
                    </a>
                </div>

                <!-- AVANZADO -->
                <div
                    class="bg-white rounded-xl shadow-md p-8 text-center
                       transition-all duration-300
                       hover:shadow-2xl hover:-translate-y-1
                       ring-1 ring-transparent hover:ring-indigo-500">
                    <h3 class="text-xl font-semibold mb-2">Avanzado</h3>
                    <p class="text-gray-500 mb-6">
                        Para equipos que quieren control total
                    </p>

                    <div class="text-4xl font-bold mb-6">
                        ARS 19.990
                        <span class="text-base font-normal">/ mes</span>
                    </div>

                    <ul class="space-y-3 text-gray-600 mb-8 text-left">
                        <li>✔ Todo lo del plan Pro</li>
                        <li>✔ Roles y permisos avanzados</li>
                        <li>✔ Reportes de turnos avanzados</li>
                        <li>✔ Control y estadísticas detalladas</li>
                    </ul>

                    <a href="{{ route('register') }}"
                        class="block border border-indigo-500 text-indigo-500 py-3 rounded-lg font-semibold hover:bg-indigo-50">
                        Elegir Avanzado
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-indigo-600 text-white py-24">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">
                Organizá tu negocio hoy
            </h2>

            <p class="mb-10 text-lg">
                Probalo gratis y sentí la diferencia desde el primer día.
            </p>

            <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-10 py-4 rounded-xl font-semibold">
                Empezar ahora
            </a>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-sm">
        © {{ date('Y') }} TurnosOnline · Hecho para negocios reales
    </footer>

</body>

</html>
