<div class="table-responsive ">
    <table class="table table-striped text-xs">
        <thead>
            <tr>
                <th>Index</th>
                <th style="cursor:pointer" >
                  

                    Order
                </th>

                <th style="cursor:pointer">

                    Fecha


                </th>



                <th>email</th>
                <th>WhatsApp</th>
                <th>Facebook</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($membership->ordersAprroved as $order)
            <tr class=" {{$order->active==0 ? 'table-danger':''}} ">
                <td>{{$loop->index+1}} </td>
                <td>{{ $order->id }}</td>

                <td>{{date_format($order->created_at, 'd-M-Y g:i a')}}</td>


                <td>
                    {{ $order->user->email }}
                </td>

                <td>
                    {{ $order->user->whatsapp }}
                </td>
                <td>
                    {{ $order->user->facebook }}
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>