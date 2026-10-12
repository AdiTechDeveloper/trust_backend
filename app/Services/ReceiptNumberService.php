<?php

namespace App\Services;

use App\Models\Donation;
use Carbon\Carbon;

class ReceiptNumberService
{
    public function generate(): string
    {
        $now = Carbon::now();

        // Indian financial year: Apr-Mar
        $fyStart = $now->month >= 4 ? $now->year : $now->year - 1;
        $fyEnd = $fyStart + 1;
        $fyLabel = substr($fyStart, 2).'-'.substr($fyEnd, 2); // e.g. 26-27

        $lastReceipt = Donation::whereNotNull('receipt_number')
            ->where('receipt_number', 'like', "SSRT/{$fyLabel}/%")
            ->orderByDesc('id')
            ->first();

        $nextSeq = 1;
        if ($lastReceipt) {
            $parts = explode('/', $lastReceipt->receipt_number);
            $nextSeq = (int) end($parts) + 1;
        }

        return "SSRT/{$fyLabel}/".str_pad($nextSeq, 4, '0', STR_PAD_LEFT);
        // Example: SSRT/26-27/0001
    }
}
