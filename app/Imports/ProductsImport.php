<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {

            $productCheck = Product::where("ean", $row["ean"])
            ->orWhere("article_number", $row["article_number"])->first();

            $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $row["name"]);
            $url = str_replace([" ", "_"], "-", $url);

            if($productCheck == null){
                $newProduct = new Product;
                $newProduct->catalog_id = $row["catalog"];
                $newProduct->brand = $row["brand"];
                $newProduct->name = $row["name"];
                $newProduct->url = $url;
                $newProduct->ean = $row["ean"];
                $newProduct->article_number = $row["article_number"];
                $newProduct->short_description = $row["short_description"];
                $newProduct->description = $row["description"];
                $newProduct->price = $row["price"];
                $newProduct->qty = $row["qty"];
                $newProduct->status = $row["status"];
                $newProduct->shipping = $row["shipping"];
                $newProduct->save();
            }
            else if($productCheck->ean == $row["ean"]){
                $Product = Product::find($productCheck->id);
                $Product->catalog_id = $row["catalog"];
                $Product->brand = $row["brand"];
                $Product->name = $row["name"];
                $Product->url = $url;
                $Product->ean = $row["ean"];
                $Product->article_number = $row["article_number"];
                $Product->short_description = $row["short_description"];
                $Product->description = $row["description"];
                $Product->price = $row["price"];
                $Product->qty = $row["qty"];
                $Product->status = $row["status"];
                $Product->shipping = $row["shipping"];
                $Product->save();
            }
            
        }
    }
}
