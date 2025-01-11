<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Invoice Download</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
</head>
<body>
    @foreach($invoices as $invoice)
        <div id="invoice-{{ $invoice->id }}" class="invoice" style="page-break-after: always;">
            <img class="watermark" src="{{ asset('images/Logo-Watermark.png') }}" alt="">
            <div class="header-bar"></div>
            <div class="main">
                <div class="header">
                    <div class="logo-container">
                        <img src="{{ asset('images/Logo-top.png') }}" class="logo" alt="Eminent Studio">
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
                        <p>{{ $invoice->first_note }}</p>
                        <p class="notes-2">{{ $invoice->second_note }}</p>
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
                            <p>Proposal written by</p>
                            <img src="{{ asset('images/' . $invoice->signature) }}" alt="Signature" class="signature-image">
                        </div>
                    </div>
                </div>

                <div class="footer-contact">
                    <h1>For more info please feel free to contact us</h1>
                    <div class="main">
                        <div class="contact-info">
                            <p>For more info please feel free to contact me</p>
                            <div class="contact-details">
                                <p><img src="{{ asset('images/phone-icon.png') }}" alt="phone"> +20 103 373 9707</p>
                                <p><img src="{{ asset('images/email-icon.png') }}" alt="email"> info@eminent-studio.com</p>
                                <p><img src="{{ asset('images/web-icon.png') }}" alt="web"> www.eminent-studio.com</p>
                            </div>
                        </div>
                        <div class="footer-divider"></div>
                        <img src="{{ asset('images/Logo-bottom.png') }}" class="footer-logo" alt="Eminent Studio">
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        window.onload = function() {
            // Give the page a moment to fully render
            setTimeout(async function() {
                const zip = new JSZip();
                const invoices = document.querySelectorAll('[id^="invoice-"]');
                
                // Configure html2pdf options
                const opt = {
                    margin: 0,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { 
                        scale: 2,
                        useCORS: true,
                        letterRendering: true
                    },
                    jsPDF: { 
                        unit: 'mm', 
                        format: 'a4', 
                        orientation: 'portrait' 
                    }
                };

                // Generate PDFs for each invoice
                for (const invoice of invoices) {
                    const pdfBlob = await html2pdf().set(opt).from(invoice).output('blob');
                    const invoiceNumber = invoice.id.replace('invoice-', '');
                    zip.file(`Invoice-${invoiceNumber}.pdf`, pdfBlob);
                }

                // Generate and download zip file
                zip.generateAsync({type: "blob"}).then(function(content) {
                    saveAs(content, "invoices.zip");
                    // Close the window after download
                    window.close();
                });
            }, 1000);
        };
    </script>
</body>
</html>
