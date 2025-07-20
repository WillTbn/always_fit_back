<?php

namespace App\Enums;

enum LevelsTrainingEnum: string
{
    case BEGINNER = 'Iniciante';
    case INTERMEDIATE = 'Intermediário';
    case ADVANCED = 'Avançado';

    public static function forSelectName(): array
    {
       return array_combine(
          array_column(self::cases(), 'name'),
          array_column(self::cases(), 'value'),
      );
    }
}
