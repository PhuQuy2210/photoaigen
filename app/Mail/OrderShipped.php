<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $phone;
    protected $address;
    protected $totalProducts;
    protected $totalAmount;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $phone
     * @param string $address
     * @param int $totalProducts
     * @param float $totalAmount
     * @return void
     */
    public function __construct($name, $phone, $address, $totalProducts, $totalAmount)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
        $this->totalProducts = $totalProducts;
        $this->totalAmount = $totalAmount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.success')
                    ->with([
                        'name' => $this->name,
                        'phone' => $this->phone,
                        'address' => $this->address,
                        'totalProducts' => $this->totalProducts,
                        'totalAmount' => $this->totalAmount,
                    ]);
    }
}
