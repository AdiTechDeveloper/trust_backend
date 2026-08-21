<!DOCTYPE html>
<html>
<head>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; }
    .header { text-align: center; border-bottom: 2px solid #d97706; padding-bottom: 10px; margin-bottom: 20px; }
    .header h1 { color: #1e3a5f; margin: 0; font-size: 20px; }
    .header p { margin: 2px 0; font-size: 11px; }
    .receipt-title { text-align: center; font-size: 16px; font-weight: bold; margin: 15px 0; text-decoration: underline; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    td { padding: 6px 4px; vertical-align: top; }
    .label { font-weight: bold; width: 35%; }
    .amount-box { border: 1px solid #999; padding: 10px; margin: 15px 0; background: #fdf6e3; }
    .footer { margin-top: 40px; display: flex; justify-content: space-between; }
    .stamp { text-align: right; margin-top: 60px; }
    .note { font-size: 10px; color: #666; margin-top: 20px; border-top: 1px solid #ccc; padding-top: 8px; }
</style>
</head>
<body>
    <div class="header">
        <h1>Shree Sidhh Rudreshwar Mahadev Temple Trust</h1>
        <p>Registered Address: [Your trust address here]</p>
        <p>PAN: [Trust PAN] &nbsp;|&nbsp; 80G Registration No: [80G Reg No] &nbsp;|&nbsp; 12A Reg No: [12A Reg No]</p>
    </div>

    <div class="receipt-title">Donation Receipt (Section 80G)</div>

    <table>
        <tr>
            <td class="label">Receipt No.</td>
            <td>{{ $donation->receipt_number }}</td>
            <td class="label">Date</td>
            <td>{{ $donation->created_at->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="label">Donor Name</td>
            <td colspan="3">{{ $donation->is_anonymous ? 'Anonymous Donor' : $user->name }}</td>
        </tr>
        <tr>
            <td class="label">Mobile</td>
            <td>{{ $user->mobile }}</td>
            <td class="label">Email</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td class="label">PAN</td>
            <td colspan="3">{{ $donation->pan_number ?? 'Not Provided (80G deduction cannot be claimed without PAN)' }}</td>
        </tr>
        <tr>
            <td class="label">Purpose / Category</td>
            <td colspan="3">{{ $donation->category?->title ?? 'General Donation' }}</td>
        </tr>
        <tr>
            <td class="label">Payment Reference</td>
            <td colspan="3">{{ $donation->razorpay_payment_id }}</td>
        </tr>
    </table>

    <div class="amount-box">
        <strong>Amount Donated: ₹{{ number_format($donation->amount, 2) }}</strong><br>
        In Words: {{ ucfirst($amountInWords) }} Rupees Only
    </div>

    <p>This is to certify that the above amount has been received by Shree Sidhh Rudreshwar Mahadev Temple Trust and is eligible for deduction under Section 80G of the Income Tax Act, 1961, subject to the provisions of the Act, and reporting via Form 10BD/10BE where PAN is provided.</p>

    <div class="stamp">
        <p>For Shree Rudreshwar Mahadev Temple Trust</p>
        <br><br>
        <p>Authorized Signatory</p>
    </div>

    <div class="note">
        This is a system-generated receipt. Donations made without a valid PAN may not be reflected in Form 10BE and may not be eligible for 80G deduction as per Income Tax Department reporting requirements.
    </div>
</body>
</html>