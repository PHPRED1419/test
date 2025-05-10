<?php

namespace Modules\Product\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Product\Entities\Product;

class ProductEnquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $enquiry;

    public function __construct(Product $product, array $enquiry)
    {
        $this->product = $product;
        $this->enquiry = $enquiry;
    }

    public function build()
    {
        return $this->subject('New Product Enquiry: ' . $this->product->product_name)
            ->view('product::emails.enquiry');
    }
}