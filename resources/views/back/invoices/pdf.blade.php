<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
            }
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }
        #invoice {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            position: relative;
            box-sizing: border-box;
        }
        @media screen and (max-width: 1024px) {
            body {
                background: white;
            }
            #invoice {
                margin: 0;
                padding: 0;
                transform-origin: top left;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div id="invoice" class="invoice">
        <img class="watermark" src="{{ asset('images/Logo-Watermark.png') }}" alt="">
        <!-- Header Template -->
        <div id="header-template" class="header-section">

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
                            <h3>{{ $invoice->invoice_date->format('Y-m-d') }}</h3>
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
            </div>
        </div>

        <!-- Content Section -->
        <div id="content" class="content-section">
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
                        <tr class="invoice-item">
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
        </div>

        <!-- Footer Template -->
        <div id="footer-template" class="footer-section">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.jsPDF = window.jspdf.jsPDF;

            setTimeout(async function() {
                try {
                    const ITEMS_PER_PAGE = 13;
                    const items = Array.from(document.querySelectorAll('.invoice-item'));
                    const totalPages = Math.ceil(items.length / ITEMS_PER_PAGE);

                    // Create PDF with A4 dimensions
                    const pdf = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4'
                    });

                    // Get templates
                    const header = document.getElementById('header-template');
                    const footer = document.getElementById('footer-template');
                    const content = document.getElementById('content');

                    // Hide all items initially
                    items.forEach(item => item.style.display = 'none');

                    // Process each page
                    for (let currentPage = 0; currentPage < totalPages; currentPage++) {
                        if (currentPage > 0) {
                            pdf.addPage();
                        }

                        // Show only current page's items
                        const startIdx = currentPage * ITEMS_PER_PAGE;
                        const endIdx = Math.min(startIdx + ITEMS_PER_PAGE, items.length);

                        items.forEach((item, idx) => {
                            item.style.display = (idx >= startIdx && idx < endIdx) ? '' : 'none';
                        });

                        // Hide summary if not last page
                        const summary = document.querySelector('.invoice-summary');
                        summary.style.display = (currentPage === totalPages - 1) ? '' : 'none';

                        // Capture the entire invoice
                        const canvas = await html2canvas(document.getElementById('invoice'), {
                            scale: 2,
                            useCORS: true,
                            allowTaint: true,
                            logging: true,
                            backgroundColor: '#ffffff'
                        });

                        // Add to PDF
                        const imgData = canvas.toDataURL('image/jpeg', 1.0);
                        pdf.addImage(imgData, 'JPEG', 0, 0, 210, 297);
                    }

                    // Show all items again
                    items.forEach(item => item.style.display = '');
                    document.querySelector('.invoice-summary').style.display = '';

                    // Save the PDF
                    pdf.save('Invoice-{{ $invoice->invoice_number }}.pdf');

                    // Close window after a short delay
                    setTimeout(() => {
                        // window.close();
                    }, 1000);

                } catch (error) {
                    console.error('Error generating PDF:', error);
                    alert('Error generating PDF. Please check console for details.');
                }
            }, 2000);
        });
    </script>
</body>
</html>
