<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation {{ $quotation->quotation_number }}</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body>
    <div id="invoice" class="invoice">
        <img class="watermark" src="{{ asset('images/Logo-Watermark.png') }}" alt="">
        <!-- Header Template -->
        <div id="header-template" class="header-section">
            <div class="header-bar"></div>
            <div class="main">
                <div class="header">
                    <div class="logo-container">
                        <img src="{{ asset('images/Logo-top.png') }}" class="logo" alt="Eminent Studio">
                    </div>
                    <div class="invoice-details">
                        <div>
                            <h1>Quotation Number</h1>
                            <h3>{{ $quotation->quotation_number }}</h3>
                        </div>
                        <div>
                            <h1>Status</h1>
                            <h3>{{ $quotation->status }}</h3>
                        </div>
                        <div>
                            <h1>Amount</h1>
                            <h3>{{ $quotation->total . ' ' . $quotation->currancy }}</h3>
                        </div>
                        <div>
                            <h1>Date</h1>
                            <h3>{{ $quotation->quotation_date }}</h3>
                        </div>
                    </div>
                </div>

                <h1 class="main-title">Quotation</h1>

                <div class="client-details">
                    <h2>Quote to:</h2>
                    <p><span>Name: </span>{{ $quotation->client->name }}</p>
                    <p><span>Company: </span>{{ $quotation->client->company }}</p>
                    <p><span>Mobile: </span>{{ $quotation->client->phone }}</p>
                    <p><span>Country: </span>{{ $quotation->client->country }}</p>
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
                    @foreach ($quotation->items as $item)
                        <tr class="invoice-item">
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->total . ' ' . $quotation->currancy }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="invoice-summary">
                <div class="notes">
                    <p>{{ $quotation->first_note }}</p>
                    <p class="notes-2">{{ $quotation->second_note }}</p>
                </div>
                <div class="totals">
                    <div>
                        <span class="total-title">Subtotal</span>
                        <span>{{ $quotation->subtotal . ' ' . $quotation->currancy }}</span>
                    </div>
                    <div>
                        <span class="total-title">Taxes ({{ $quotation->tax_percentage }}%)</span>
                        <span>{{ $quotation->tax_amount . ' ' . $quotation->currancy }}</span>
                    </div>
                    <div>
                        <span class="total-title">Discount</span>
                        <span>{{ $quotation->discount . ' ' . $quotation->currancy }}</span>
                    </div>
                    <div class="total">
                        <span class="total-title">Total</span>
                        <span>{{ $quotation->total . ' ' . $quotation->currancy }}</span>
                    </div>

                    <div class="signature">
                        <p>Proposal written by</p>
                        <img src="{{ asset('images/' . $quotation->signature) }}" alt="Signature" class="signature-image">
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
                    const ITEMS_PER_PAGE = 12;
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
                    pdf.save('Quotation-{{ $quotation->quotation_number }}.pdf');

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
