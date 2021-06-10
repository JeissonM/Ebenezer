<?php


namespace App\Export;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Sheet;

class ExportData implements FromCollection, WithTitle, ShouldAutoSize, WithEvents //, FromArray//, WithMapping //, WithColumnFormatting
{

    use Exportable;

    protected $data;
    protected $name;
    protected $head;

    public function __construct($name, $head, $data) {
        $this->name = $name;
        $this->head = $head;
        if(gettype($data)=='array'){
            $this->data = collect($data);
        }else{
            $this->data = $data;
        }
    }


    public function collection() {
        return $this->data ?: null;
    }

//    public function headings(): array {
//        return $this->head;
//    }

    public function title(): string {
        return $this->name;
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W7'; // header
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }


//    public function array(): array {
////        dd('aq');
//        return $this->data ?: [];
//    }
}
