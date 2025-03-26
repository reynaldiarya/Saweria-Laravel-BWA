@component('mail::message')
    # Halo, {{ $donation->name ?? null }}

    Terima kasih atas donasi Anda. Berikut adalah detail invoice:

    @component('mail::panel')
        - **Nomor Transaksi:** {{ $paymentData->payment_id }}
        - **Jumlah Donasi:** Rp{{ number_format($donation->amount, 0, ',', '.') }}
        - **Status:** {{ ucfirst($paymentData->status) }}
    @endcomponent

    Silakan klik tombol di bawah ini untuk melanjutkan pembayaran atau melihat status transaksi Anda.:

    @component('mail::button', ['url' => $paymentData->payment_url])
        Lihat Transaksi
    @endcomponent

    Terima kasih atas dukungan Anda!

    Salam,<br>
    {{ config('app.name') }}
@endcomponent
