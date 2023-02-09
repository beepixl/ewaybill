<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use App\Models\InvoicePayments;
use Livewire\Component;

class InvoicePaymentCrud extends Component
{
    public $payment;
    public $paymentId;
    public $action;
    public $amount;
    public $rec_date;
    public $remarks;
    public $button;
    public $order_id;
    public $paymentSum;
    public $inv;

    protected function getRules()
    {
        $rules = [
            'amount' => ['required', 'numeric', function ($attribute, $value, $fail) {
            //     dd(is_numeric('regreg'));
            //    dd( ((float)$value) > ((float)$this->inv->totInvValue - $this->paymentSum) );
                if (!is_numeric($value) || $value <= 0 || ((float)$value) > ((float)$this->inv->totInvValue - $this->paymentSum)) {
                    $fail("The :attribute must be less then or equal to " . (number_format($this->inv->totInvValue - $this->paymentSum, 2)));
                }
                // if ((($this->paymentSum + (is_numeric($value) ? $value : 0)) >  $this->inv->totInvValue) || $value <= 0) {
                //     $fail("The :attribute must be less then or equal to " . (number_format($this->inv->totInvValue - $this->paymentSum, 2)));
                // }
            }],
            'rec_date' => 'required|date',
        ];

        return  $rules;
    }

    public function createPayment()
    {
        $this->resetErrorBag();
        $this->validate();

        // if (($this->paymentSum + $this->amount) > $this->inv->totInvValue) {
        //     Session::flash('status', 'error');
        //     Session::flash('message', 'error');
        //     return back();
        // }

        //  dd('dd');

        $payment =  new  InvoicePayments();
        $payment->order_id = $this->order_id;
        $payment->amount = $this->amount;
        $payment->rec_date = $this->rec_date;
        $payment->user = auth()->user()->id;
        $payment->remarks = $this->remarks;
        $payment->save();

        // dd($this->paymentSum == $this->inv->totInvValue || $this->paymentSum > $this->inv->totInvValue);

        if ($this->paymentSum == $this->inv->totInvValue)
            $this->inv->status = 1;
        elseif ($this->paymentSum < $this->inv->totInvValue)
            $this->inv->status = 2;
        else
            $this->inv->status = 0;

        $this->inv->update();

        $this->emit('saved');
        $this->reset('payment');
        return redirect()->route('showInv', [$this->order_id]);
    }


    public function mount()
    {
        if (!$this->payment && $this->paymentId) {
            $this->payment = InvoicePayments::find($this->paymentId);
        }

        $this->order_id = request()->invId;
        $this->paymentSum =   InvoicePayments::where('order_id', $this->order_id)->sum('amount');
        $this->inv =  Invoice::with('customer')->find($this->order_id);
        $this->rec_date = date('Y-m-d');
        $this->button = create_button($this->action, "Payment");
    }

    public function render()
    {

        return view('livewire.invoice-payment-crud');
    }
}
