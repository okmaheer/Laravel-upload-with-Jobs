<?php

namespace App\Jobs;

use App\Models\Sale;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SalesCsvProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
     public $data;
     public $header;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$header)
    {
       $this->data=$data;
       $this->header=$header;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->data as $sale){
            $saleData = array_combine($this->header,$sale);

            Sale::create($saleData);
        }

        
    }
}
