<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $administrador = Role::create(['name' => 'administrador']);
        $cliente = Role::create(['name' => 'cliente']);
        $vendedor = Role::create(['name' => 'vendedor']);
        $repartidor = Role::create(['name' => 'repartidor']);
        $permission1 = Permission::create(['name' => 'Crear.producto'])->syncRoles([$administrador]);
        $permission2 = Permission::create(['name' => 'Ver.producto'])->syncRoles([$administrador]);
        $permission3 = Permission::create(['name' => 'Editar.producto'])->syncRoles([$administrador]);
        $permission4 = Permission::create(['name' => 'Eliminar.producto'])->syncRoles([$administrador]);
        $permission5 = Permission::create(['name' => 'Crear.familia'])->syncRoles([$administrador]);
        $permission6 = Permission::create(['name' => 'Editar.familia'])->syncRoles([$administrador]);
        $permission7 = Permission::create(['name' => 'Eliminar.familia'])->syncRoles([$administrador]);
        $permission8 = Permission::create(['name' => 'Crear.subfamilia'])->syncRoles([$administrador]);
        $permission9 = Permission::create(['name' => 'Editar.subfamilia'])->syncRoles([$administrador]);
        $permission10 = Permission::create(['name' => 'Eliminar.subfamilia'])->syncRoles([$administrador]);
        $permission11 = Permission::create(['name' => 'Crear.tipo'])->syncRoles([$administrador]);
        $permission12 = Permission::create(['name' => 'Editar.tipo'])->syncRoles([$administrador]);
        $permission13 = Permission::create(['name' => 'Eliminar.tipo'])->syncRoles([$administrador]);
        $permission14 = Permission::create(['name' => 'Crear.ingrediente'])->syncRoles([$administrador]);
        $permission15 = Permission::create(['name' => 'Editar.ingrediente'])->syncRoles([$administrador]);
        $permission16 = Permission::create(['name' => 'Eliminar.ingrediente'])->syncRoles([$administrador]);
        $permission17 = Permission::create(['name' => 'Crear.usuario'])->syncRoles([$administrador]);
        $permission18 = Permission::create(['name' => 'Editar.usuario'])->syncRoles([$administrador]);
        $permission19 = Permission::create(['name' => 'Eliminar.usuario'])->syncRoles([$administrador]);
        $permission20 = Permission::create(['name' => 'Crear.permiso'])->syncRoles([$administrador]);
        $permission21 = Permission::create(['name' => 'Editar.permiso'])->syncRoles([$administrador]);
        $permission22 = Permission::create(['name' => 'Eliminar.permiso'])->syncRoles([$administrador]);
        $permission23 = Permission::create(['name' => 'Crear.rol'])->syncRoles([$administrador]);
        $permission24 = Permission::create(['name' => 'Editar.rol'])->syncRoles([$administrador]);
        $permission25 = Permission::create(['name' => 'Eliminar.rol'])->syncRoles([$administrador]);
        $permission26 = Permission::create(['name' => 'Crear.cupon'])->syncRoles([$administrador]);
        $permission27 = Permission::create(['name' => 'Editar.cupon'])->syncRoles([$administrador]);
        $permission28 = Permission::create(['name' => 'Eliminar.cupon'])->syncRoles([$administrador]);
        $permission29 = Permission::create(['name' => 'Crear.local'])->syncRoles([$administrador]);
        $permission30 = Permission::create(['name' => 'Editar.local'])->syncRoles([$administrador]);
        $permission31 = Permission::create(['name' => 'Eliminar.local'])->syncRoles([$administrador]);
        $permission32 = Permission::create(['name' => 'Ver.pedidos'])->syncRoles([$administrador, $vendedor, $repartidor]);
        User::create([
            'rut' => 202566685,
            'name' => 'fernando',
            'password' => Hash::make('fernando'),
            'email' => 'fernando@gmail.com',
            'direccion' => 'Pasaje 6-a 472, Concepción, Chile',
            'latitud' => -36.699861545399095, 
            'longitud' => -71.89413665275617,
            'entrega' => 'Pasaje 6-a 472, Concepción, Chile',
            'celular' => 996151633,
            'telefono' => 412993823,
            'imagen' => NULL
        ])->assignRole($administrador);
        
        User::create([
            'rut' => 192515221,
            'name' => 'luxo',
            'password' => Hash::make('luxopz'),
            'email' => 'luxopz@gmail.com',
            'direccion' => 'Bulgaria 3814, Hualpén, Chile',
            'latitud' => -36.699861545399095, 
            'longitud' => -71.89413665275617,
            'entrega' => 'Bulgaria 3814, Hualpén, Chile',
            'celular' => 993136175,
            'telefono' => 41299313,
            'imagen' => NULL
            
        ])->assignRole($administrador);
        
        User::create([
            'rut' => 195316538,
            'name' => 'jeremy',
            'password' => Hash::make('jeremy'),
            'email' => 'jeremy@gmail.com',
            'direccion' => 'Juan de La Cruz Tapia 365, Talcahuano, Chile',
            'latitud' => -36.699861545399095, 
            'longitud' => -71.89413665275617,
            'entrega' => 'Juan de La Cruz Tapia 365, Talcahuano, Chile',
            'celular' => 930312331,
            'telefono' => 412943618,
            'imagen' => NULL
        ])->assignRole($administrador);

        DB::table('local')->insert([
            'nombre' => 'Bulnes',
            'direccion' => 'Por determinar',
            'celular' => 937609488,
            'horario_a' => "14:00",
            'horario_c' => "22:00",
            'abierto' => true,
            'latitud' => -36.74081338645681,
            'longitud' => -72.30300910811113,
            'area' => '{"lat":"-36.734676715900626","lng":"-72.29064790058594"} ,{"lat":"-36.748952788245035","lng":"-72.28481141376953"} ,{"lat":"-36.747439765018164","lng":"-72.30592866230468"} ,{"lat":"-36.731099765864876","lng":"-72.31056351948241"} ,'
        ]);

        DB::table('local')->insert([
            'nombre' => 'Coihueco',
            'direccion' => 'Calle comercio #1757',
            'celular' => 981351797,
            'horario_a' => "14:00",
            'horario_c' => "22:00",
            'abierto' => false,
            'latitud' => -36.62582375343787, 
            'longitud' => -71.83056755281794,
            'area' => '{"lat":"-36.62014615721112","lng":"-71.82303284845212"} ,{"lat":"-36.637154640024214","lng":"-71.82153167054885"} ,{"lat":"-36.63263586549184","lng":"-71.84362165466314"} ,{"lat":"-36.61663683168984","lng":"-71.83433847163701"} ,'
        ]);
        // Cupones
        DB::table('cupon')->insert([
            'nombre' => 'Dia del padre',
            'codigo' => 'DIADELPADRE2022',
            'descuento' => 20,
            'descripcion' => '20% dscto en tu proxima compra, no acumulable con el resto de cupones. Valido solo por el 19 de Junio del 2022.',
            'fecha_inicio' => '2022-06-19',
            'fecha_final' => '2022-06-19',
            'id_usuario' => 1
        ]);

        DB::table('cupon')->insert([
            'nombre' => 'Dulce o truco Evyta Sushi',
            'codigo' => 'HALLOWEEN2022',
            'descuento' => 15,
            'descripcion' => 'Aprovecha un 15% de dscto en pizzas, cupon valido la primera vez de uso por cliente, no acumulable al resto de promociones. Valido del 31 de Octubre al 01 de Noviembre',
            'fecha_inicio' => '2022-10-31',
            'fecha_final' => '2022-11-01',
            'id_usuario' => 1
        ]);

        DB::table('cupon')->insert([
            'nombre' => 'Ho Ho Ho Feliz navidad',
            'codigo' => 'NAVIDADEVYTA2022',
            'descuento' => 25,
            'descripcion' => 'Estas navidades Evyta Sushi las quiere celebrar contigo dandote un 25% de dscto en tu siguiente compra. Promocion no acumulable con el resto de promociones, valida del 25 al 31 de Diciembre.',
            'fecha_inicio' => '2022-12-25',
            'fecha_final' => '2022-12-31',
            'id_usuario' => 1
        ]);

        DB::table('cupon')->insert([
            'nombre' => 'Dia del amor y amistad en Evyta',
            'codigo' => 'SANVALENTIN2022',
            'descuento' => 50,
            'descripcion' => 'Para las parejas, tenemos un 2x1 en todo sushi. Promocion valida por el 14 de Febrero, no acumulable al resto de promociones.',
            'fecha_inicio' => '2023-02-14',
            'fecha_final' => '2023-02-14',
            'id_usuario' => 1
        ]);

        DB::table('ingrediente')->insert([
            'nombre' => 'Pollo'
        ]);
        DB::table('ingrediente')->insert([
            'nombre' => 'Palta'
        ]);
        DB::table('ingrediente')->insert([
            'nombre' => 'Queso'
        ]);
        DB::table('ingrediente')->insert([
            'nombre' => 'Camaron'
        ]);
        DB::table('ingrediente')->insert([
            'nombre' => 'Cebollin'
        ]);
        DB::table('ingrediente')->insert([
            'nombre' => 'Pollo teriyaki'
        ]);
        DB::table('ingrediente')->insert([
            'nombre' => 'Champiñon'
        ]);
        DB::table('ingrediente')->insert([
            'nombre' => 'Kanikama'
        ]);
        DB::table('ingrediente')->insert([
            'nombre' => 'Ciboulette'
        ]);
        DB::table('tipo')->insert([
            'nombre' => 'Premium'
        ]);
        DB::table('tipo')->insert([
            'nombre' => 'Vip'
        ]);
        DB::table('tipo')->insert([
            'nombre' => 'Mixto'
        ]);
        DB::table('familia')->insert([ //  id:1 Sushi Frito
            'nombre' => 'Sushi Frito'
        ]);
        DB::table('familia')->insert([ // id:2 Pizza
            'nombre' => 'Pizza'
        ]);
        DB::table('familia')->insert([ // id:3 Handroll
            'nombre' => 'Handroll'
        ]);
        DB::table('familia')->insert([ // id:4 Promocion
            'nombre' => 'Promocion'
        ]);
        DB::table('subfamilia')->insert([
            'nombre' => 'Frito'
        ]);
        DB::table('subfamilia')->insert([
            'nombre' => 'Envuelto'
        ]);
        DB::table('subfamilia')->insert([
            'nombre' => 'Al horno'
        ]);
        DB::table('subfamilia')->insert([
            'nombre' => 'Mixto'
        ]);
        DB::table('familia_subfamilia')->insert([
            'id_familia' => 1,
            'id_subfamilia' => 1
        ]);
        DB::table('familia_subfamilia')->insert([
            'id_familia' => 2,
            'id_subfamilia' => 3
        ]);
        DB::table('familia_subfamilia')->insert([
            'id_familia' => 3,
            'id_subfamilia' => 1
        ]);
        DB::table('familia_subfamilia')->insert([
            'id_familia' => 3,
            'id_subfamilia' => 2
        ]);
        DB::table('familia_subfamilia')->insert([
            'id_familia' => 4,
            'id_subfamilia' => 4
        ]);
        DB::table('familia_tipo')->insert([
            'id_familia' => 1,
            'id_tipo' => 1
        ]);
        DB::table('familia_tipo')->insert([
            'id_familia' => 2,
            'id_tipo' => 3
        ]);
        DB::table('familia_tipo')->insert([
            'id_familia' => 3,
            'id_tipo' => 2
        ]);
        DB::table('familia_tipo')->insert([
            'id_familia' => 4,
            'id_tipo' => 3
        ]);
        \App\Models\ProductoModel::factory()->count(50)->create();
    }
}
