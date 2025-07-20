<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vinkla\Hashids\Facades\Hashids;

class TrainingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainings = [
            [
                'hash_id' => Hashids::encode(1),
                'name' => 'Supino',
                'subname' => 'Reto',
                'description' => 'Supino reto (4x6-8) - Treino focado em aumentar a força muscular.',
                'equipment' => 'Halteres, Barra, Banco',
                'meta_days' => 25,
                'level' => 'intermediário',
            ],
            [
                'hash_id' => Hashids::encode(2),
                'name' => 'Supino',
                'subname' => 'Inclinado',
                'description' => 'Supino inclinado (4x6-8) - Treino para melhorar a resistência cardiovascular.',
                'equipment' => 'Halteres, Barra, Banco Inclinado',
                'meta_days' => 25,
                'level' => 'intermediário',
            ],
            [
                'hash_id' => Hashids::encode(3),
                'name' => 'Desenvolvimento Militar',
                'description' => 'Desenvolvimento militar (4x6-8) - Exercício para ombros e tríceps.',
                'equipment' => 'Halteres, Barra',
                'meta_days' => 25,
                'level' => 'intermediário',
            ],
            [
                'hash_id' => Hashids::encode(4),
                'name' => 'Elevação Lateral',
                'description' => 'Elevação lateral (3x8-10) - Exercício para deltoides laterais.',
                'equipment' => 'Halteres',
                'meta_days' => 25,
                'level' => 'iniciante',
            ],
            [
                'hash_id' => Hashids::encode(5),
                'name' => 'Tríceps Francês',
                'description' => 'Tríceps francês (3x8-10) - Exercício para tríceps.',
                'equipment' => 'Halteres',
                'meta_days' => 25,
                'level' => 'iniciante',
            ],
            [
                'hash_id' => Hashids::encode(6),
                'name' => 'Tríceps Corda',
                'description' => 'Tríceps corda (3x8-10) - Exercício para tríceps.',
                'equipment' => 'Corda, Polia',
                'meta_days' => 25,
                'level' => 'iniciante',
            ],
            [
                'hash_id' => Hashids::encode(7),
                'name' => 'Agachamento Livre',
                'description' => 'Agachamento livre (5x5) - Exercício avançado para força e hipertrofia de membros inferiores.',
                'equipment' => 'Barra, Rack',
                'meta_days' => 30,
                'level' => 'avançado',
            ],
            [
                'hash_id' => Hashids::encode(8),
                'name' => 'Levantamento Terra',
                'description' => 'Levantamento terra (5x5) - Exercício avançado para força total e posterior de coxa.',
                'equipment' => 'Barra, Anilhas',
                'meta_days' => 30,
                'level' => 'avançado',
            ],
            [
                'hash_id' => Hashids::encode(9),
                'name' => 'Barra Fixa',
                'description' => 'Barra fixa (4x8-10) - Exercício avançado para dorsais e bíceps.',
                'equipment' => 'Barra Fixa',
                'meta_days' => 30,
                'level' => 'avançado',
            ],
        ];

        foreach ($trainings as $training) {
            Training::create($training);
        }
    }
}
