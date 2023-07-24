<?php

namespace App\Exports;

use App\Models\User;
use App\Models\DeliveryMan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

// class UsersExport implements FromCollection,WithMapping
class UsersExport implements FromView,WithColumnWidths,WithStyles,WithEvents
// class UsersExport implements FromCollection, WithColumnWidths, WithStyles, WithProperties, WithDrawings, WithHeadings
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return User::all();
    // }

    public function columnWidths(): array
    {
        return [
            'A' => 55,
            'B' => 45,            
            'C' => 45,            
        ];
    }

    public function styles(Worksheet $sheet) {
        $count = count($this->collection());
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getStyle('A4:C4')->getFont()->setBold(true);
        $sheet->getStyle('A1:C1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_DOTTED,
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

    // public function properties(): array
    // {
    //     return [
    //         'creator'        => 'Patrick Brouwers',
    //         'lastModifiedBy' => 'Patrick Brouwers',
    //         'title'          => 'Invoices Export',
    //         'description'    => 'Latest Invoices',
    //         'subject'        => 'Invoices',
    //         'keywords'       => 'invoices,export,spreadsheet',
    //         'category'       => 'Invoices',
    //         'manager'        => 'Patrick Brouwers',
    //         'company'        => 'Maatwebsite',
    //     ];
    // }

    public function collection()
    {
        return DeliveryMan::get();
        
    }

    public function setImage($workSheet) {
        $this->collection()->each(function($employee,$index) use($workSheet) {
            $drawing = new Drawing();
            $drawing->setName($employee->f_name);
            $drawing->setDescription($employee->f_name);
            $drawing->setPath(is_file(storage_path('app/public/delivery-man/'.$employee->image))?storage_path('app/public/delivery-man/'.$employee->image):public_path('/assets/admin/img/logo2.png'));
            $drawing->setHeight(40);
            $index+=5;
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
    // public function headings(): array
    // {
    //     return [
    //        '1'
    //     ];
    // }

    public function view(): View
    {
        return view('user-export', [
            'users' => DeliveryMan::all()
        ]);
    }

    // public function map($user): array
    // {
    //     // This example will return 3 rows.
    //     // First row will have 2 column, the next 2 will have 1 column
    //     return [
    //         [
    //             $user->name,
    //             $user->email,
    //         ],
    //         [
    //             $user->name,
    //         ],
    //         [
    //             $user->email,
    //         ]
    //     ];
    // }
}
