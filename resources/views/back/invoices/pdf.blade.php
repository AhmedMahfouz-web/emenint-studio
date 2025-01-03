<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invoice->client->name }} - Invoice {{ $invoice->invoice_number }}</title>
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
</head>

<body>
    <div class="invoice">
        <img class="watermark" src="{{ url('images/Logo-Watermark.png') }}" alt="">
        <div class="header-bar"></div>
        <div class="main">
            <div class="header">
                <div class="logo-container">
                    <img src="{{ url('images/Logo-top.png') }}" class="logo" alt="Eminent Studio">
                </div>
                <div class="invoice-details">
                    <div>
                        <h1>Invoice Number</h1>
                        <h3>{{ $invoice->invoice_number }}</h3>
                    </div>
                    <div>
                        <h1>Payment method</h1>
                        <h3>{{ $invoice->payment_method }}</h3>
                    </div>
                    <div>
                        <h1>Amount due</h1>
                        <h3>{{ $invoice->total . ' ' . $invoice->currancy }}</h3>
                    </div>
                    <div>
                        <h1>Date</h1>
                        <h3>{{ $invoice->invoice_date }}</h3>
                    </div>
                </div>
            </div>

            <h1 class="main-title">Invoice</h1>

            <div class="client-details">
                <h2>Quote to:</h2>
                <p><span>Name: </span>{{ $invoice->client->name }}</p>
                <p><span>Company: </span>{{ $invoice->client->company }}</p>
                <p><span>Mobile: </span>{{ $invoice->client->phone }}</p>
                <p><span>Country: </span>{{ $invoice->client->country }}</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Rate</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->total . ' ' . $invoice->currancy }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="invoice-summary">
                <div class="notes">
                    <p>{{ $invoice->first_note }}
                    </p>
                    <p class="notes-2">{{ $invoice->second_note }}
                    </p>
                </div>
                <div class="totals">
                    <div>
                        <span class="total-title">Subtotal</span>
                        <span>{{ $invoice->subtotal . ' ' . $invoice->currancy }}</span>
                    </div>
                    <div>
                        <span class="total-title">Taxes ({{ $invoice->tax_percentage }}%)</span>
                        <span>{{ $invoice->tax_amount . ' ' . $invoice->currancy }}</span>
                    </div>
                    <div>
                        <span class="total-title">Discount</span>
                        <span>{{ $invoice->discount . ' ' . $invoice->currancy }}</span>
                    </div>
                    <div class="total">
                        <span class="total-title">Total</span>

                        <span>{{ $invoice->total . ' ' . $invoice->currancy }}</span>
                    </div>

                    <div class="signature">
                        <p>Proposal writien by</p>
                        <img src="{{ url('images/' . $invoice->signature) }}" alt="Signature" class="signature-image">
                    </div>
                </div>
            </div>

            <div class="footer-contact">
                <h1>For more info please feel free to contact us</h1>
                <div class="main">
                    <div class="contact-info">
                        <p>For more info please feel free to contact me</p>
                        <div class="contact-details">
                            <p><img src="{{ url('images/phone-icon.png') }}" alt="phone"> +20 103 373 9707</p>
                            <p><img src="{{ url('images/email-icon.png') }}" alt="email"> info@eminent-studio.com
                            </p>
                            <p><img src="{{ url('images/web-icon.png') }}" alt="web"> www.eminent-studio.com</p>
                        </div>
                    </div>
                    <div class="footer-divider"></div>
                    <img src="{{ url('images/Logo-bottom.png') }}" class="footer-logo" alt="Eminent Studio">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
