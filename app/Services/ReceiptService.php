<?php

namespace App\Services;

use App\Models\Donation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ReceiptService
{
    public function __construct(
        private ReceiptNumberService $receiptNumberService
    ) {}

    public function generate(Donation $donation): Donation
    {
        $receiptNumber = $this->receiptNumberService->generate();

        $amountInWords = $this->numberToWords($donation->amount);

        $pdf = Pdf::loadView('receipts.donation-80g', [
            'donation' => $donation,
            'user' => $donation->user,
            'amountInWords' => $amountInWords,
        ]);

        $fileName = 'receipts/'.str_replace('/', '-', $receiptNumber).'.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());

        $donation->update([
            'receipt_number' => $receiptNumber,
            'receipt_path' => $fileName,
            'receipt_generated_at' => now(),
        ]);

        return $donation;
    }

    private function numberToWords(float $amount): string
    {
        $amount = (int) $amount;

        if ($amount === 0) {
            return 'Zero';
        }

        $ones = [
            '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
            'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
            'Seventeen', 'Eighteen', 'Nineteen',
        ];

        $tens = [
            '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety',
        ];

        $convertBelowThousand = function (int $num) use ($ones, $tens): string {
            $str = '';
            if ($num >= 100) {
                $str .= $ones[intdiv($num, 100)].' Hundred ';
                $num %= 100;
            }
            if ($num >= 20) {
                $str .= $tens[intdiv($num, 10)].' ';
                $num %= 10;
            }
            if ($num > 0) {
                $str .= $ones[$num].' ';
            }

            return trim($str);
        };

        $crore = intdiv($amount, 10000000);
        $amount %= 10000000;

        $lakh = intdiv($amount, 100000);
        $amount %= 100000;

        $thousand = intdiv($amount, 1000);
        $amount %= 1000;

        $hundred = $amount;

        $result = '';

        if ($crore > 0) {
            $result .= $convertBelowThousand($crore).' Crore ';
        }
        if ($lakh > 0) {
            $result .= $convertBelowThousand($lakh).' Lakh ';
        }
        if ($thousand > 0) {
            $result .= $convertBelowThousand($thousand).' Thousand ';
        }
        if ($hundred > 0) {
            $result .= $convertBelowThousand($hundred);
        }

        return trim($result);
    }
}
