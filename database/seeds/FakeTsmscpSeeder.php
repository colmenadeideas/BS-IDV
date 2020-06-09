<?php

use Illuminate\Database\Seeder;

class FakeTsmscpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $idSchedule = DB::table('schedule')->insertGetId(
                [
                    'name' => "Materia 1 Horario de la Seccion A", 
                    'json_data'  =>'Json del horarios'
                ]);
        $idSchedule2 = DB::table('schedule')->insertGetId(
                [
                    'name' => "Materia 2 Horario de la Seccion A", 
                    'json_data'  =>'Json del horarios'
                ]);        
        $idSchedule3 = DB::table('schedule')->insertGetId(
                [
                    'name' => "Materia 3 Horario de la Seccion A", 
                    'json_data'  =>'Json del horarios'
                ]);

        $idClassroom = DB::table('classroom')->insertGetId(
                [
                    'name' => "Aula 1", 
                    'description'  =>'Laboratorio',
                    'location'  =>'Av. Bolivar'
                ]);
        $idPeriod = DB::table('period')->insertGetId(
                [
                    'status' => "active", 
                    'start_date'  => now(),
                    'end_date'  => now(),
                    'code'  =>'20201'
                ]);

         DB::table('all-have-tsmscp')->insert(
                [
                    'id_teacher' => 5, 
                    'id_section'  => 1,
                    'id_matter'  => 13,
                    'id_schedule'  => $idSchedule,
                    'id_classroom'  => $idClassroom,
                    'id_period'  =>$idPeriod
                ]);         
         DB::table('all-have-tsmscp')->insert(
                [
                    'id_teacher' => 5, 
                    'id_section'  => 1,
                    'id_matter'  => 22,
                    'id_schedule'  => $idSchedule2,
                    'id_classroom'  => $idClassroom,
                    'id_period'  =>$idPeriod
                ]);        
        DB::table('all-have-tsmscp')->insert(
                [
                    'id_teacher' => 5, 
                    'id_section'  => 1,
                    'id_matter'  => 29,
                    'id_schedule'  => $idSchedule3,
                    'id_classroom'  => $idClassroom,
                    'id_period'  =>$idPeriod
                ]);

	}
}
