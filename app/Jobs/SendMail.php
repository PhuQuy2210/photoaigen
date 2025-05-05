<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $phone;
    protected $address;
    protected $totalProducts;
    protected $totalAmount;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $name
     * @param string $phone
     * @param string $address
     * @param int $totalProducts
     * @param float $totalAmount
     * @return void
     */
    public function __construct($email, $name, $phone, $address, $totalProducts, $totalAmount)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
        $this->totalProducts = $totalProducts;
        $this->totalAmount = $totalAmount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Gửi email với các thông tin đã được truyền vào
        Mail::to($this->email)->send(new OrderShipped(
            $this->name,
            $this->phone,
            $this->address,
            $this->totalProducts,
            $this->totalAmount
        ));
    }
}
