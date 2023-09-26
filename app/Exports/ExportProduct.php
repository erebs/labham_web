<?php

namespace App\Exports;

use App\Products;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportProduct implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Products::all();
    }

     public function headings(): array
    {
        // Define the column titles here
        return [
            'id',
            'cat_id',
            'subcat_id',
            'brand_id',
            'stock_avalible',
            'name',
            'desc',
            'price',
            'offerprice',
            'best_seller',
            'featured',
            'trending',
            'status',
            'image',
            'image2',
            'image3',
            'image4',
            'delstatus',
            
            // Add more column headers as needed
        ];
    }
}
