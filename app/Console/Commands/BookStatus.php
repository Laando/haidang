<?php

/*
 *Auto Change Completed Status For Book If Date Passed
 *@Author: Giang
 *
 */
namespace App\Console\Commands;

use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Order;

class BookStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Change Completed Status For Book If Date Passed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time_expired = Carbon::now();
        $orders = Order::where('status', '2')->get();
        foreach ($orders as $order) {
            $startdate = $order->startdate->startdate;
            $expired = Carbon::parse($startdate);
            if($expired->lt($time_expired)){
                Order::find($order->id)->update(['status' => 3]);
            }
        }
        return true;
    }
}
