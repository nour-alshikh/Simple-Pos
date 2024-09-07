<div id="print-area">


    <table class="table  table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>@lang('site.name')</th>
                <th>@lang('site.quantity')</th>
                <th>@lang('site.products_count')</th>
            </tr>
        </thead>
        <tbody>

            @php
            $i = 0;
            @endphp
            @if ($products->count() > 0)
            @foreach ($products as $product)
            @php
            $i++;
            @endphp
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>{{ number_format($product->pivot->quantity * $product->sell_price , 2) }}</td>


            </tr>
            @endforeach

            @endif
        </tbody>
    </table>

    <h3>Total : {{ number_format($order->total_price ,2) }}</h3>

</div>
<button type="button" id="print-btn" class="btn btn-primary d-block w-100">Print</button>
