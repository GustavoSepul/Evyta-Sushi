<?php

namespace App\Imports;

use App\Models\Cupon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\Importable;
use Throwable;

class CuponImport implements ToCollection, WithHeadingRow, SkipsOnError, WithValidation
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Cupon::create([
                'id_usuario' => auth()->user()->id,
                // 'nombre' => $row[0],
                // 'codigo' => $row[1],
                // 'descuento' => $row[2],
                // 'descripcion' => $row[3],
                // 'fecha_inicio' => $row[4],
                // 'fecha_final' => $row[5],
                'nombre' => 'cupondeprueba',
                'codigo' => 'cupondeprueba',
                'descuento' => 20,
                'descripcion' => 'cupondeprueba',
                'fecha_inicio' => '2022-07-16',
                'fecha_final' => '2022-07-18',
            ]);
        }
    }

    // public function headingRow(): int
    // {
    //     return 2;
    // }

    public function rules(): array {
        return [
            ".nombre" => ['required', 'string'],
            ".codigo" => ['required','string'],
            ".descuento" => ['required'],
            ".descripcion" => ['required'],
            ".fecha_inicio" => ['required'],
            ".fecha_final" => ['required'],
        ];
    }
}
