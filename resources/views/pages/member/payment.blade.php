@extends('layouts.base-layout')

@section('title', 'Payment ' . $onePayment['transaction_id'])
@section('content')
    <div class="container mx-auto">
        @include('components.header')
        <div class="pb-16">
            <div class="flex flex-col justify-center gap-2 p-4 m-4 bg-gray-800 text-white rounded">
                <span class="text-center text-sm">VA Number</span>
                <h4 class="text-center font-bold text-xl">{{ $onePayment['va_number'] }}</h4>
            </div>
            <div class="py-4 text-center text-lg font-bold text-error">
                <p>Expired in <span id="countdown"></span></p>
            </div>
            <div class="px-4 w-1/3 mx-auto">
                <table class="table w-full">
                    <tbody>
                        <tr>
                            <td>Bank</td>
                            <td>: {{ $onePayment['bank'] }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: {{ $onePayment['transaction_status'] }}</td>
                        </tr>
                        <tr>
                            <td>Invoice</td>
                            <td><a href="{{ url('orders/' . $onePayment['invoice']) }}"
                                    class="items-center hover:text-primary">{{ ':' . ' ' . $onePayment['invoice'] }}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button id="done" class="btn btn-small btn-success w-full text-white my-4">Done!</button>
            </div>
        </div>
    </div>
    <script>
        function startCountdown(expiryTime) {
            var now = new Date().getTime();

            var expiry = new Date(expiryTime).getTime();

            var distance = expiry - now;

            var countdownInterval = setInterval(function() {
                var now = new Date().getTime();

                var distance = expiry - now;

                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("countdown").innerHTML = minutes + "m " + seconds + "s ";

                if (distance < 0) {
                    clearInterval(countdownInterval);
                    document.getElementById("countdown").innerHTML = "Expired";
                    window.location.reload();
                }
            }, 1000);
        }

        startCountdown('{{ $onePayment->expiry_time }}');

        document.getElementById("done").addEventListener("click", function() {
            window.location.reload();
        });
    </script>
@endsection
