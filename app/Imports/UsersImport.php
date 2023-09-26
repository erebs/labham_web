<?php
namespace App\Imports;
use App\Products;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsHeadingRow;


class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Products([
        
         'id'  => $row['id'],
         'cat_id'   => $row['cat_id'],
         'subcat_id'   => $row['subcat_id'],
         'brand_id'   => $row['brand_id'],
         'stock_avalible'    => $row['stock_avalible'],
         'name'  => $row['name'],
         'desc'   => $row['desc'],
         'price'  => $row['price'],
         'offerprice'   => $row['offerprice'],
         'best_seller'  => $row['best_seller'],
         'featured'   => $row['featured'],
         'trending'  => $row['trending'],
         'status'   => $row['status'],
         'image'  => $row['image'],
         'image2'   => $row['image2'],
         'image3'  => $row['image3'],
         'image4'   => $row['image4'],
         'delstatus'   => $row['delstatus'],
        ]);



    }

    public function skippedRows($rows, $headingRow, $headingIndexes)
{
    // This method is called when the heading row is encountered
    // Return the number of rows to skip (usually 1 for the heading row)
    return 1;
}

}