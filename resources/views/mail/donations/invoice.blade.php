<x-mail::message>
# Halo, {{ $donation->name ?? 'Donatur' }}

Terima kasih atas donasi Anda. Berikut adalah detail invoice:

<x-mail::panel>
- **Nomor Transaksi:** {{ $paymentData->payment_id ?? 'N/A' }}
- **Jumlah Donasi:** Rp{{ number_format($donation->amount ?? 0, 0, ',', '.') }}
- **Status:** {{ ucwords($paymentData->status ?? 'Pending') }}
</x-mail::panel>

@if (!empty($paymentData->payment_url))
Silakan klik tombol di bawah ini untuk melanjutkan pembayaran atau melihat status transaksi Anda:
<x-mail::button :url="$paymentData->payment_url">
    Lihat Transaksi
</x-mail::button>
@endif

Terima kasih atas dukungan Anda!

Salam,
{{ config('app.name') }}
</x-mail::message>
