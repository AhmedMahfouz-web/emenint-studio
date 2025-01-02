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
                        <h3>00001</h3>
                    </div>
                    <div>
                        <h1>Payment method</h1>
                        <h3>Western Union</h3>
                    </div>
                    <div>
                        <h1>Amount due</h1>
                        <h3>$440</h3>
                    </div>
                    <div>
                        <h1>Date</h1>
                        <h3>01-12-2023</h3>
                    </div>
                </div>
            </div>

            <h1 class="main-title">Invoice</h1>

            <div class="client-details">
                <h2>Quote to:</h2>
                <p><span>Name: </span>Mostafa Mohamed Al Ansary</p>
                <p><span>Company: </span>Eminent Studio</p>
                <p><span>Mobile: </span>+201006104925</p>
                <p><span>Country: </span>Riyadh, Saudi Arabia</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Description</th>
                        <th>Rate</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Brand Identity</td>
                        <td></td>
                        <td>500$</td>
                        <td>1</td>
                        <td>500$</td>
                    </tr>
                    <tr>
                        <td>Printings</td>
                        <td></td>
                        <td>200$</td>
                        <td>5</td>
                        <td>200$</td>
                    </tr>
                    <tr>
                        <td>Social Media</td>
                        <td></td>
                        <td>220$</td>
                        <td>2</td>
                        <td>40$</td>
                    </tr>
                    <tr>
                        <td>Website</td>
                        <td></td>
                        <td>50,000$</td>
                        <td>2</td>
                        <td>40$</td>
                    </tr>
                    <tr>
                        <td>Photography</td>
                        <td></td>
                        <td>20$</td>
                        <td>2</td>
                        <td>40$</td>
                    </tr>
                    <tr>
                        <td>3D Booth</td>
                        <td></td>
                        <td>10$</td>
                        <td>2</td>
                        <td>40$</td>
                    </tr>
                </tbody>
            </table>

            <div class="invoice-summary">
                <div class="notes">
                    <p>
                        <span>Kindly Note</span> that all pricing, denominated in USD currency, is
                        structured into two payment installments. The initial
                        payment amounts to 70% of the total cost, and the final 30%
                        payment is to be made upon receiving the completed work.
                        ** We offer a guarantee that this work will be accessible with
                        lifetime access upon request.
                        Quotation avaliable for one week
                    </p>
                    <p class="notes-2">
                        If you have any inquiries concerning pricing details,
                        please don't hesitate to reach out to us. We would be
                        delighted to provide further clarification and ensure
                        a more precise understanding, even if it's solely for
                        the purpose of clarity. Your trust from the outset is
                        greatly appreciated, and We’re here to assist you.
                        Thank you
                    </p>
                </div>
                <div class="totals">
                    <div>
                        <span class="total-title">Subtotal</span>
                        <span>$400</span>
                    </div>
                    <div>
                        <span class="total-title">Taxes (10%)</span>
                        <span>0$</span>
                    </div>
                    <div>
                        <span class="total-title">Discount</span>
                        <span>0$</span>
                    </div>
                    <div class="total">
                        <span class="total-title">Total</span>

                        <span>$440</span>
                    </div>

                    <div class="signature">
                        <p>Proposal writien by</p>
                        <img src="{{ url('images/Sign.png') }}" alt="Signature" class="signature-image">
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
