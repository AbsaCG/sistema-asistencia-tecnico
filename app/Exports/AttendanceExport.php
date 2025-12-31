<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data['attendances']);
    }

    public function headings(): array
    {
        return [
            '#',
            'Estudiante',
            'DNI',
            'Código',
            'Carrera',
            'Fecha',
            'Hora',
            'Estado',
            'Fuente'
        ];
    }

    public function map($attendance): array
    {
        static $index = 0;
        $index++;

        $statusLabels = [
            'present' => 'Presente',
            'absent' => 'Ausente',
            'late' => 'Tarde',
            'justified' => 'Justificado',
        ];

        $sourceLabels = [
            'public' => 'Web',
            'gate' => 'Portal',
            'manual' => 'Manual',
        ];

        return [
            $index,
            $attendance['student_name'],
            $attendance['student_dni'],
            $attendance['student_code'],
            $attendance['career'],
            $attendance['date_formatted'],
            $attendance['time'],
            $statusLabels[$attendance['status']] ?? $attendance['status'],
            $sourceLabels[$attendance['source']] ?? $attendance['source'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
