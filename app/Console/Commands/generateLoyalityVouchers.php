<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class generateLoyalityVouchers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:loyality:vouchers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command generates loyality vouchers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private $generated = 0;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Order::whereNull('generated_voucher')->get();
        foreach($orders as $order) {
            if(Carbon::now()->diffInMinutes($order->created_at) >= 15) {
                if($order->user->generatedLoyalityCoupons() === 0) {
                    $coupon = Coupon::create(
                        [
                            'name'  =>  'Loyality $5 Off',
                            'code'  =>  '5OFF',
                            'type'  =>  'fixed',
                            'uses'  =>  0,
                            'max_uses'  =>  1,
                            'value' =>  5,
                            'user_id'=> $order->user_id
                        ]
                    );
                    if($coupon->wasRecentlyCreated) {
                        $order->update(['generated_voucher'=>$coupon->id]);
                        $this->generated++;
                    }
                }
            }
        }
        $this->output->write("<info>$this->generated coupon(s) generated</info>");
        return Command::SUCCESS;
    }
}
