<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbicacionSeeder extends Seeder
{
    public function run(): void
    {
        $ubicaciones = [
            ['nombre' => 'Universidad de Córdoba',       'descripcion' => 'Campus principal en Montería, Colombia.',                    'latitud' => 8.7504,  'longitud' => -75.8795, 'imagen' => 'img/logo.jpeg'],
            ['nombre' => 'Bloque A - Rectoría',          'descripcion' => 'Oficinas administrativas y rectoría.',                       'latitud' => 8.7512,  'longitud' => -75.8828, 'imagen' => 'img/Rectoria.jpg'],
            ['nombre' => 'Biblioteca Central',           'descripcion' => 'Centro de recursos académicos y salas de estudio.',           'latitud' => 8.7495,  'longitud' => -75.8808, 'imagen' => 'img/Biblioteca.jpg'],
            ['nombre' => 'Cafetería Auditorio',          'descripcion' => 'Zona de alimentación y servicios.',                          'latitud' => 8.7490,  'longitud' => -75.8820, 'imagen' => 'img/Cafeteria Auditorio.jpg'],
            ['nombre' => 'Auditorio Cultural',           'descripcion' => 'Espacio para eventos académicos y culturales.',               'latitud' => 8.7485,  'longitud' => -75.8832, 'imagen' => 'img/auditorio.jpg'],
            ['nombre' => 'Bienestar Universitario',      'descripcion' => 'Servicios de salud, psicología y bienestar estudiantil.',    'latitud' => 8.7475,  'longitud' => -75.8752, 'imagen' => 'img/Bienestar.jpg'],
            ['nombre' => 'Enfermería',                   'descripcion' => 'Servicio médico y de enfermería del campus.',                 'latitud' => 8.7468,  'longitud' => -75.8748, 'imagen' => 'img/Enfermeria.jpg'],
            ['nombre' => 'Edificio Bioclimático',        'descripcion' => 'Edificio de diseño sostenible y eficiencia energética.',      'latitud' => 8.7465,  'longitud' => -75.8732, 'imagen' => 'img/Bioclimatico.jpg'],
            ['nombre' => 'Edificio de Informática',      'descripcion' => 'Facultad de Ciencias Básicas e Ingeniería - Informática.',   'latitud' => 8.7460,  'longitud' => -75.8740, 'imagen' => 'img/informatica.jpg'],
            ['nombre' => 'Edificio Postgrados',          'descripcion' => 'Sede de programas de posgrado y maestrías.',                  'latitud' => 8.7455,  'longitud' => -75.8718, 'imagen' => 'img/Postgrado.jpg'],
            ['nombre' => 'Estadio Universitario',        'descripcion' => 'Campo de fútbol y pista atlética universitaria.',             'latitud' => 8.7442,  'longitud' => -75.8722, 'imagen' => 'img/Estadio.jpg'],
            ['nombre' => 'Estadio de Futsal',            'descripcion' => 'Cancha cubierta para futsal y deportes.',                    'latitud' => 8.7448,  'longitud' => -75.8742, 'imagen' => 'img/EstadioFutsal.jpg'],
            ['nombre' => 'Estanque Piscícola',           'descripcion' => 'Área de investigación en acuicultura y piscicultura.',        'latitud' => 8.7542,  'longitud' => -75.8835, 'imagen' => 'img/piscina.jpg'],
            ['nombre' => 'Bloque 23',                    'descripcion' => 'Aulas de clase y laboratorios.',                             'latitud' => 8.7520,  'longitud' => -75.8775, 'imagen' => 'img/b23.jpg'],
            ['nombre' => 'Bloque 26',                    'descripcion' => 'Aulas de clase y laboratorios.',                             'latitud' => 8.7515,  'longitud' => -75.8785, 'imagen' => 'img/b26.jpg'],
            ['nombre' => 'Bloque 30',                    'descripcion' => 'Aulas de clase sede ASPU-SINTRAUNICOL.',                     'latitud' => 8.7518,  'longitud' => -75.8768, 'imagen' => 'img/b33.jpg'],
            ['nombre' => 'Bloque 39',                    'descripcion' => 'Aulas de clase y oficinas docentes.',                        'latitud' => 8.7528,  'longitud' => -75.8792, 'imagen' => 'img/b42.jpg'],
            ['nombre' => 'Bloque 42',                    'descripcion' => 'Aulas de clase y laboratorios.',                             'latitud' => 8.7508,  'longitud' => -75.8762, 'imagen' => 'img/b42.jpg'],
            ['nombre' => 'Bloque 43',                    'descripcion' => 'Aulas de clase y laboratorios.',                             'latitud' => 8.7505,  'longitud' => -75.8770, 'imagen' => 'img/b43.jpg'],
            ['nombre' => 'Bloque 44',                    'descripcion' => 'Aulas de clase y laboratorios.',                             'latitud' => 8.7510,  'longitud' => -75.8778, 'imagen' => 'img/b44.jpg'],
            ['nombre' => 'Zona Agronomía',               'descripcion' => 'Facultad de Ciencias Agrícolas - área de cultivos.',         'latitud' => 8.7535,  'longitud' => -75.8752, 'imagen' => 'img/agronomia.jpg'],
            ['nombre' => 'Zona de Educación',            'descripcion' => 'Facultad de Educación y Ciencias Humanas.',                  'latitud' => 8.7500,  'longitud' => -75.8745, 'imagen' => 'img/zona educacion.jpg'],
            ['nombre' => 'Zona de Informática',          'descripcion' => 'Área de laboratorios de sistemas e ingeniería.',             'latitud' => 8.7462,  'longitud' => -75.8728, 'imagen' => 'img/zona informatica.jpg'],
            ['nombre' => 'Zona Tamarindo',               'descripcion' => 'Área recreativa y de descanso universitaria.',               'latitud' => 8.7480,  'longitud' => -75.8760, 'imagen' => 'img/zona tamarindo.jpg'],
            ['nombre' => 'Cafetería Central',            'descripcion' => 'Cafetería principal del campus universitario.',              'latitud' => 8.7488,  'longitud' => -75.8755, 'imagen' => 'img/central.jpg'],
            ['nombre' => 'Cancha de Tenis / Tamarindo',  'descripcion' => 'Canchas deportivas zona tamarindo.',                         'latitud' => 8.7477,  'longitud' => -75.8765, 'imagen' => 'img/cancha tamarindo.jpg'],
            ['nombre' => 'Microfútbol',                  'descripcion' => 'Canchas de microfútbol universitarias.',                     'latitud' => 8.7450,  'longitud' => -75.8735, 'imagen' => 'img/microfut.jpg'],
            ['nombre' => 'Laboratorio de Microbiología', 'descripcion' => 'Laboratorio especializado en microbiología.',                'latitud' => 8.7472,  'longitud' => -75.8757, 'imagen' => 'img/micro.jpg'],
            ['nombre' => 'Piscina Universitaria',        'descripcion' => 'Piscina olímpica para natación y actividades acuáticas.',    'latitud' => 8.7438,  'longitud' => -75.8728, 'imagen' => 'img/picina.jpg'],
            ['nombre' => 'Egresados',                    'descripcion' => 'Oficina de egresados y alumni universitario.',               'latitud' => 8.7492,  'longitud' => -75.8798, 'imagen' => 'img/egresado.jpg'],
        ];

        DB::table('ubicaciones')->insert(array_map(function ($u) {
            return array_merge($u, ['created_at' => now(), 'updated_at' => now()]);
        }, $ubicaciones));
    }
}
