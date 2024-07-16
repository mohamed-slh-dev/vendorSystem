<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>


    @foreach ($shipments as $ship)
        <div style="overflow-x: auto; text-align: right;direction: rtl;">
            <table class="table table-hover my-0">
                <thead class="thead-dark">
                    <tr>

                        <th>رقم الشحنة</th>
                        <th> المورد</th>
                        <th> التاريخ</th>
                        <th> البييان</th>
                        <th> الكمية</th>
                        <th> الكمية المتبيقة</th>

                        <th> سعر الفاتورة</th>
                        <th style="background: #e9907a; color: black">قيمة الفاتورة</th>
                        <th style="background: #e9907a; color: black">سعر الفاتورة SA</th>
                        <th style="background: #e9907a; color: black">قيمة الفاتورة SA</th>
                        <th style="background: #e9907a; color: black"> الإجمالي</th>

                        <th style="background: #fdfd62; color: black"> تاريخ اخر تعديل</th>


                        <th style="background: #fdfd62; color: black"> العميل</th>
                        <th style="background: #fdfd62; color: black">الكمية المباعة</th>
                        <th style="background: #fdfd62; color: black"> التالف</th>
                        <th style="background: #fdfd62; color: black"> فرق الكميات</th>
                        <th style="background: #fdfd62; color: black"> السعر</th>
                        <th style="background: #fdfd62; color: black"> المبيعات</th>
                        <th style="background: #fdfd62; color: black"> الصافي</th>

                        <th style="background: #fdfd62; color: black"> رقم الفاتورة</th>



                    </tr>
                </thead>
                <tbody>

                    @php

                        $sum_value = 0;
                        $sum_price_sar = 0;
                        $sum_value_sar = 0;
                        $sum_sell = 0;

                    @endphp




                    @foreach ($ship->shipmentItmes as $item)
                        @php

                            $sum_value += $item->invoice_total;
                            $sum_price_sar += $item->invoice_price_sa;
                            $sum_value_sar += $item->invoice_total_sa;

                        @endphp

                        {{-- shipment rows --}}

                        <tr>




                            <td>{{ $ship->number }}</td>
                            <td>{{ $ship->supplier }}</td>
                            <td>{{ $ship->date }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td @if ($item->remaining_quantity <= 0) style= "background-color : #3bff3b;" @endif>
                                {{ $item->quantity }}
                            </td>
                            <td>{{ $item->remaining_quantity }}</td>

                            <td>{{ number_format($item->invoice_price, 3, '.', ',') }}</td>

                            <td style="background: #e9907a; color: black">
                                {{ number_format($item->invoice_total, 3, '.', ',') }}
                            </td>
                            <td style="background: #e9907a; color: black">
                                {{ number_format($item->invoice_price_sa, 3, '.', ',') }}
                            </td>
                            <td style="background: #e9907a; color: black">
                                {{ number_format($item->invoice_total_sa, 3, '.', ',') }}
                            </td>
                            <td style="background: #e9907a; color: black">
                                {{ number_format($item->total, 3, '.', ',') }}
                            </td>


                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>


                        </tr>



                        @php

                            $sum_selling_quantity = 0;

                        @endphp
                        @foreach ($item->itemSells as $sell)
                            @php
                                $sum_sell += $sell->selling;
                                $sum_selling_quantity += $sell->quantity + $sell->damaged;
                            @endphp

                            {{-- selling rows --}}
                            <tr>



                                <td>{{ $ship->number }}</td>
                                <td>{{ $ship->supplier }}</td>
                                <td>{{ $sell->date }}</td>
                                <td>{{ $item->product->name }}</td>

                                <td></td>
                                <td></td>


                                <td></td>


                                <td style="background: #e9907a; color: black">

                                </td>
                                <td style="background: #e9907a; color: black">

                                </td>
                                <td style="background: #e9907a; color: black">

                                </td>
                                <td style="background: #e9907a; color: black">

                                </td>

                                <td style="background: #fdfd62;">
                                    {{ date('Y-m-d H:i:s', strtotime($sell->updated_at . ' +3 hours')) }}
                                </td>



                                <td style="background: #fdfd62;">{{ $sell->client }}</td>
                                <td style="background: #fdfd62;">{{ $sell->quantity }}</td>
                                <td style="background: #fdfd62;">{{ $sell->damaged }}</td>
                                <td style="background: #fdfd62;">{{ $item->quantity - $sum_selling_quantity }}
                                </td>
                                <td style="background: #fdfd62;">
                                    {{ number_format($sell->price, 3, '.', ',') }}</td>
                                <td style="background: #fdfd62;">
                                    {{ number_format($sell->selling, 3, '.', ',') }}</td>

                                <td style="background: #fdfd62;">
                                    {{ number_format($sum_sell - $item->total, 3, '.', ',') }} </td>

                                <td style="background: #fdfd62;">{{ $sell->bill_number }}</td>

                            </tr>
                        @endforeach
                    @endforeach

                    {{-- total bill row --}}
                    <tr style="background-color: #fdfd62">
                        <td></td>


                        <td style="font-weight: bold">إجمالي الفاتورة</td>
                        <td></td>



                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>


                        <td style="font-weight: bold">
                            @php
                                echo number_format($sum_value, 3, '.', ',');
                            @endphp
                        </td>

                        <td style="font-weight: bold">
                            @php
                                echo number_format($sum_price_sar, 3, '.', ',');
                            @endphp
                        </td>


                        <td style="font-weight: bold">
                            @php

                                echo number_format($sum_value_sar, 3, '.', ',');

                            @endphp
                        </td>


                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                        <td style="font-weight: bold">

                            @php

                                echo number_format($sum_sell, 3, '.', ',');

                            @endphp
                        </td>
                        <td style="font-weight: bold">
                            @php
                                echo number_format($sum_sell - $sum_value_sar, 3, '.', ',');
                            @endphp

                        </td>
                        <td></td>

                    </tr>


                    @php
                        $sum_exp = 0;
                        $sum_others = 0;
                        $sum_delivery = 0;
                        $sum_jordan = 0;

                    @endphp

                    @foreach ($ship->otherTransactions as $exp)
                        @php
                            $sum_exp += $exp->customs_price;
                            $sum_others += $exp->others_price;

                            $sum_delivery += $exp->delivery_price;
                            $sum_jordan += $exp->jordan_price;

                        @endphp

                        {{-- delivery --}}
                        <tr>
                            <td></td>
                            <td></td>

                            <td style="font-weight: bold">الشحن</td>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td style="font-weight: bold">
                                {{ number_format($exp->delivery_price, 3, '.', ',') }}</td>

                        </tr>


                        {{-- customes --}}
                        <tr>
                            <td></td>
                            <td></td>

                            <td style="font-weight: bold">التخليص</td>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td style="font-weight: bold">
                                {{ number_format($exp->customs_price, 3, '.', ',') }}</td>

                        </tr>

                        {{-- jordan expenses --}}
                        <tr>
                            <td></td>
                            <td></td>

                            <td style="font-weight: bold">منصرفات الأردن </td>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="font-weight: bold">
                                {{ number_format($exp->jordan_price, 3, '.', ',') }}</td>

                        </tr>


                        {{-- other expenses --}}
                        <tr>
                            <td></td>
                            <td></td>


                            <td style="font-weight: bold">منصرفات اخرى </td>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td>( {{ $exp->desc }} )</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>

                            <td style="font-weight: bold">
                                {{ number_format($exp->others_price, 3, '.', ',') }}</td>

                        </tr>
                    @endforeach

                    {{-- total shipment final number  --}}

                    <tr>
                        <td></td>
                        <td></td>

                        <td style="font-weight: bold">إجمالي تكلفة الشحن</td>

                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold">
                            @php
                                echo number_format(
                                    $sum_value_sar + $sum_exp + $sum_others + $sum_delivery + $sum_jordan,
                                    3,
                                    '.',
                                    ',',
                                );
                            @endphp

                        </td>

                        <td></td>
                        <td></td>


                        <td style="font-weight: bold">
                            @php

                                echo number_format(
                                    $sum_sell - ($sum_value_sar + $sum_exp + $sum_others + $sum_delivery + $sum_jordan),
                                    3,
                                    '.',
                                    ',',
                                );
                            @endphp


                        </td>

                    </tr>

                </tbody>
            </table>
        </div>

        <!--Table Head Dark End-->
    @endforeach

</body>

</html>
