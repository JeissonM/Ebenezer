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

class ExportData implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithEvents//, WithMapping //, WithColumnFormatting
{

    use Exportable;

    protected $data;
    protected $name;
    protected $head;
    protected $filtos;

    public function __construct($name, $head, $data,$filtros) {
        $this->name = $name;
        $this->head = $head;
        $this->data = $data;
        $this->filtos = $filtros;
    }


    public function collection() {
        return $this->data ?: null;
    }

    public function headings(): array {
        return $this->head;
    }

    public function title(): string {
        return $this->name;
    }

    public function filtros(){
        return $this->filtos;
    }

    public function registerEvents(): array {
        $f=$this->filtos;
        return [
//            AfterSheet::class => function(AfterSheet $event)use($f) {
//            $event->sheet->appendRows($this,$this->filtos);
//            },
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // header
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }




}
