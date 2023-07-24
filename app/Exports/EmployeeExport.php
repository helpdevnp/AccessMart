<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithStyles {
    function __construct(protected $query){

    }
    public function headings(): array
    {
        return [
            'Full Name',
            'Phone Number',
        ];
    }

    public function map($item): array
    {
        return [
            [
                $item->f_name,
                $item->email,
            ],
            [
                $item->phone,
            ]
        ];
    }

    public function collection()
    {
        return $this->query->get();
        
    }

    public function setImage($workSheet) {
        $this->collection()->each(function($employee,$index) use($workSheet) {
            $drawing = new Drawing();
            $drawing->setName($employee->f_name);
            $drawing->setDescription($employee->f_name);
            $drawing->setPath(is_file(storage_path('app/public/delivery-man/'.$employee->image))?storage_path('app/public/delivery-man/'.$employee->image):public_path('/assets/admin/img/logo2.png'));
            $drawing->setHeight(40);
            $index+=2;
            $drawing->setCoordinates("C$index");
            $drawing->setWorksheet($workSheet);
        });
    }

    public function registerEvents():array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDefaultRowDimension()->setRowHeight(60);
                $workSheet = $event->sheet->getDelegate();
                $this->setImage($workSheet);
            },
        ];
    }
    public function styles(Worksheet $sheet) {
        $count = count($this->query->get());
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getStyle('A1:C1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],

        ]);

        $sheet->getStyle('A1:C1')->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => '8D4019'],
        ]);
    }
}
