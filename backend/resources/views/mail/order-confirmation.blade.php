<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Funnel+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Sikeres rendelés leadás - BuzzShop</title>
</head>

<body style="margin: 0; padding: 0; font-family: 'Funnel Sans', Arial, sans-serif; font-weight: 400;">
    <div style="min-height: 100vh; width: 100%; background-color: skyblue; padding: 4rem 0;">
        <div style="width: 80%; max-width: 1000px; margin: auto; position: relative; padding: 0 20px;">
            <div
                style="width: 75%; font-size: 1.2rem; margin: -20px auto 0; padding: 24px 40px; background-color: whitesmoke; border: 8px solid rgb(12, 74, 110); border-radius: 12px; text-align: justify; position: relative;">
                <p style="margin-bottom: 12px; font-size: 1.4rem; color: darkcyan; font-weight: bold;">Kedves
                    {{ $order->shipping_name }}!</p>
                <p style="margin: 12px 0; font-weight: bold;">
                    Köszönjük megrendelésedet. A rendelésedet számítógépes rendszerünk eltárolta, a rendelés
                    feldolgozását
                    munkatársaink mihamarabb megkezdik.
                </p>

                <div>
                    <p style="margin-bottom: 16px;">
                        Amennyiben lenne olyan termék, ami már nincs készleten (méret, íz vagy szín-hiány, stb.), abban
                        az esetben munkatársaink erről <u><i>e-mailben</i></u> értesítenek, megadva azt is, hogy
                        előreláthatólag mennyi időt venne igénybe az adott termék raktárunkba érkezése.
                    </p>

                    <p style="margin-bottom: 16px;">
                        A rendeléseddel kapcsolatban információt telefonon a +36303333666-os számon, vagy emailben az
                        info@buzzshop.hu címen, üzenetben is fordulhatsz hozzánk.
                    </p>
                </div>

                <div style="margin: auto; width: 100%;">
                    <p
                        style="text-transform: uppercase; font-weight: bold; font-size: 1.25rem; text-decoration: underline; text-underline-offset: 4px; color: rgb(12, 74, 110);">
                        A rendelésed részletei:</p>

                    <div style="min-height: 300px; width: 100%; color: rgb(15, 23, 42);">
                        <!-- Rendelési azonosító -->
                        <p style="margin-bottom: 8px;">
                            <strong>Rendelési
                                azonosító:</strong> #{{ $order->created_at->format('Ymd#Hi') }}#{{ $order->id }}
                        </p>

                        <!-- Rendelés dátuma -->
                        <p style="margin-bottom: 16px;">
                            <strong>Rendelés dátuma:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
                        </p>
                        <!-- Rendelt termékek -->
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th style="text-align: left; border-bottom: 1px solid #ddd; padding: 8px;">Termék
                                    </th>
                                    <th style="text-align: center; border-bottom: 1px solid #ddd; padding: 8px;">
                                        Mennyiség</th>
                                    <th style="text-align: right; border-bottom: 1px solid #ddd; padding: 8px;">Ár</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items ?? [] as $item)
                                    <tr>
                                        <td style="padding:8px; border-bottom:1px solid #eee;">
                                            {{ $item->product_name }}
                                        </td>
                                        <td style="padding:8px; text-align:center; border-bottom:1px solid #eee;">
                                            {{ $item->quantity }}
                                        </td>
                                        <td style="padding:8px; text-align:right; border-bottom:1px solid #eee;">
                                            {{ number_format($item->price, 0, ',', ' ') }} Ft
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>

                                <tr>
                                    <td colspan="2" style="text-align: right; padding: 8px; font-weight: bold;">
                                        Részösszeg <i>(áfa - 27%)</i>:</td>
                                    <td style="text-align: right; padding: 8px;">
                                        {{ number_format(round($order->totalamount * 0.27) - 1200, 0, ',', ' ') }} Ft
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right; padding: 8px; font-weight: bold;">
                                        Részösszeg <i>(nettó)</i>:</td>
                                    <td style="text-align: right; padding: 8px;">
                                        {{ number_format(round($order->totalamount * 0.73), 0, ',', ' ') }} Ft
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right; padding: 8px; font-weight: bold;">
                                        Szállítási költség:</td>
                                    <td style="text-align: right; padding: 8px;">{{ number_format(1200, 0, ',', ' ') }}
                                        Ft</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right; padding: 8px; font-weight: bold;">
                                        Összesen:</td>
                                    <td style="text-align: right; padding: 8px; font-weight: bold; font-size: 1.1em;">
                                        {{ number_format($order->totalamount, 0, ',', ' ') }} Ft</td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Szállítási információk -->
                        <div style="margin-bottom: 20px; width:100%;">
                            <p
                                style="margin-bottom: 12px; font-weight: bold; font-size: 1.5em;padding:0.5rem;background-color:skyblue;color:white;text-align:center;">
                                Szállítási adatok</p>

                            <!-- Minden adatpár egy külön div-ben, ami egy sorként viselkedik -->
                            <div style="display: flex; justify-content: space-between; margin: 4px 0;">
                                <div style="font-weight: 500; width: 30%;font-weight:bold;">Név:</div>
                                <div style="width: 70%; text-align: right;">
                                    {{ $order->shipping_name }}</div>
                            </div>

                            <div style="display: flex; justify-content: space-between; margin: 4px 0;">
                                <div style="font-weight: 500; width: 30%;font-weight:bold;font-weight:bold;">
                                    Telefonszám:</div>
                                <div style="width: 70%; text-align: right;">
                                    {{ $order->shipping_phone }}</div>
                            </div>

                            <div style="display: flex; justify-content: space-between; margin: 4px 0;">
                                <div style="font-weight: 500; width: 30%;font-weight:bold;">Ország:</div>
                                <div style="width: 70%; text-align: right;">
                                    {{ $order->shipping_country }}</div>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin: 4px 0;">
                                <div style="font-weight: 500; width: 30%;font-weight:bold;">Város / Megye</div>
                                <div style="width: 70%; text-align: right;">
                                    {{ $order->shipping_city }},
                                    {{ $order->shipping_zip }}</div>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin: 4px 0;">
                                <div style="font-weight: 500; width: 30%;font-weight:600;">Utca / Házszám</div>
                                <div style="width: 70%; text-align: right;">
                                    {{ $order->shipping_street_name }}
                                    {{ $order->shipping_street_type }} {{ $order->shipping_street_number }}</div>
                            </div>

                            <div style="display: flex; justify-content: space-between; margin: 4px 0;">
                                <div style="font-weight: 500; width: 30%;font-weight:600;">Emelet / Ajtó</div>
                                <div style="width: 70%; text-align: right;">
                                    {{ $order->shipping_floor }}</div>
                            </div>
                        </div>

                        <!-- Fizetési mód -->
                        <div style="display: flex; justify-content: center;flex-direction:column; margin: 4px 0;">
                            <p style="margin-bottom: 8px;margin:auto;text-align:center;">
                                <strong>Fizetési mód:</strong>
                            </p>
                            <p style="color:#696969;margin:auto;text-align:center;font-style:italic;margin-top:0.5rem;">Utánvét -
                                helyszínen
                                készpénz/bankkártya.</p>
                        </div>
                    </div>
                </div>

                <!-- Promóciós szekció -->
                <div style="margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px;">
                    <p style="font-weight: bold; margin-bottom: 10px;">Népszerű termékeink, amik érdekelhetnek:</p>
                    <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <div style="width: 22%; text-align: center; margin-bottom: 15px;">
                            {{-- Ide majd bevághatunk pl: 4 kis kártya (képpel, vmi standard kép+név+ár+link majd) --}}
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div style="margin-top: 30px; border-top: 1px solid #ddd; padding-top: 20px; text-align: center;">
                    <img src="{{ asset('banners/banner.png') }}" alt="BuzzShop Logo" {{-- Majd ide valami logo képet készítek, vagy a BaseHeader-ből jön a szöveg ide. --}}
                        style="max-width: 150px; margin-bottom: 10px;">
                    <p style="margin: 0;">© {{ date('Y') }} BuzzShop - Minden jog fenntartva.</p>
                    <p style="margin: 5px 0;">Ha kérdésed van, keress minket a +36303333666 telefonszámon vagy az
                        info@buzzshop.hu email címen!</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
