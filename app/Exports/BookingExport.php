<?php
namespace App\Exports;
use App\Http\Resources\BookingDatatableResource;
use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BookingExport implements FromCollection, withMapping, WithHeadings, ShouldAutoSize, WithEvents {

    use Exportable;
    private $group,$dateFrom,$dateTo;
    function __construct($group,$dateFrom,$dateTo)
    {
        $this->group = $group;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection()
    {
        $booking = Booking::with(['bookType'])->where("group",$this->group)->where(function ($q){
            if ($this->dateFrom && $this->dateTo) {
                $q->where('date','>=',date('Y-m-d',strtotime($this->dateFrom)));
                $q->where('date','<=',date('Y-m-d',strtotime($this->dateTo)));
            } elseif ($this->dateFrom && $this->dateTo == '') {
                $q->where('date',date('Y-m-d',strtotime($this->dateFrom)));
            } elseif ($this->dateFrom == '' && $this->dateTo) {
                $q->where('date',date('Y-m-d',strtotime($this->dateTo)));
            }
        })->orderBy('id','desc')->get();

        $booking = BookingDatatableResource::collection($booking);

        return $booking;
    }

    public function map($booking): array
    {
        return [
            $booking->name,
            $booking->phone,
            date('Y-m-d',strtotime($booking->date)),
            $booking->bookType->name,
            $booking->description
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'Date',
            'Book Type',
            'Description'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
            },
        ];
    }
}
