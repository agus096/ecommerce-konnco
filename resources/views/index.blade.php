<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>

<body>

    <div class="site-wrap">


        @include('navbar')


        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="title-section mb-5 col-12">
                        <h2 class="text-uppercase">Popular Products</h2>
                    </div>
                </div>
                <div class="row">
                    @forelse($products as $product)
                    @if ($product->status === 'aktif')
                        <div class="col-lg-4 col-md-6 item-entry mb-4">
                            <a href="#" class="product-item md-height bg-gray d-block">
                                <img src="{{ asset('fotos/' . $product->foto) }}" alt="{{ $product->name }}" class="img-fluid">
                            </a>
                            <h2 class="item-title">
                                <a href="#">{{ $product->name }}</a>
                            </h2>
                            @if ($product->stock > 0)
                                <button class="btn btn-primary" onclick="buyProduct('{{ $product->id }}', '{{ $product->name }}', {{ $product->price }})">Beli</button>
                            @else
                                <button class="btn btn-secondary" disabled>Stok Habis</button>
                            @endif
                        </div>
                    @endif
                @empty
                    <p>Tidak ada produk tersedia.</p>
                @endforelse                
                </div>
            </div>
        </div>
        @include('footer')
    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        function buyProduct(productId, productName, productPrice) {
            fetch('/create-transaction', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        product_name: productName,
                        amount: productPrice,
                        name: 'Nama Pelanggan',
                        email: 'email@pelanggan.com'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    snap.pay(data.token, {
                        onSuccess: function(result) {
                            console.log('Payment Success:', result);
                        },
                        onPending: function(result) {
                            console.log('Payment Pending:', result);
                        },
                        onError: function(result) {
                            console.log('Payment Error:', result);
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

</body>

</html>
