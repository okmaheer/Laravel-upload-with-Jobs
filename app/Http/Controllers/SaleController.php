<?php

namespace App\Http\Controllers;

use App\Jobs\SalesCsvProcess;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class SaleController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
    public function upload()
    {
        if (request()->has('mycsv')) {
           
            $data   =   file(request()->mycsv);
            $header=[];
            $chunks = array_chunk($data, 1000);
           $batch = Bus::batch([])->dispatch(); 
            foreach($chunks as $key => $chunk){
                $data = array_map('str_getcsv',$chunk);
               if($key == 0){
                   $header = $data[0];
                   unset($data[0]);
               }


               $batch->add(new SalesCsvProcess($data,$header));
              
              
            }
            return $batch;
         

           
        }

        return 'please upload file';
    }
    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }
    // public function upload()
    // {
    //     if (request()->has('mycsv')) {
    //         // $data   =   array_map('str_getcsv',file(request()->mycsv));
    //         $data   =   file(request()->mycsv);
    //         // $header = $data[0];
    //         // unset($data[0]);
    //         $path = resource_path('temp');
    //         $chunks = array_chunk($data, 1000);
    //         // return getcwd();
    //         foreach($chunks as $key => $chunk){
    //             $name= "/tmp{$key}.csv";
      
    //             // return $path . $name;
    //             file_put_contents($path . $name, $chunk);
    //         }
    //         // foreach($data as $value){
    //         //     $saleData = array_combine($header,$value);
    //         //     Sale::create($saleData);
    //         // }
           

            
    //         $files =glob("$path/*.csv");
    //         $header=[];
    //         foreach($files as $key => $file){
    //            $data = array_map('str_getcsv',file($file));
    //            if($key == 0){
    //                $header = $data[0];
    //                unset($data[0]);
    //            }
    //            SalesCsvProcess::dispatch($data,$header);
              
    
    //            unlink($file);
    //         }
    //         return 'Done';
         

           
    //     }

    //     return 'please upload file';
    // }


}
