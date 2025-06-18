<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $booking->id }}</title>
    <style>
        /* Reset and Base Styles */
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }
        
        /* Container */
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #eee;
        }
        
        /* Header Styles */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            border-bottom: 2px solid #4e73df;
            padding-bottom: 20px;
        }
        
        .company-info {
            text-align: left;
        }
        
        .company-info h2 {
            margin: 0;
            color: #4e73df;
            font-size: 24px;
        }
        
        .company-info p {
            margin: 5px 0;
            color: #666;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-info h1 {
            margin: 0;
            color: #4e73df;
            font-size: 28px;
        }
        
        .invoice-info p {
            margin: 5px 0;
            color: #666;
        }
        
        /* Customer and Service Info */
        .info-sections {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .customer-info, .service-info {
            width: 48%;
        }
        
        .info-title {
            font-size: 16px;
            font-weight: bold;
            color: #4e73df;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        .info-content {
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }
        
        /* Service Details Table */
        .service-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .service-details th {
            background-color: #4e73df;
            color: white;
            padding: 10px;
            text-align: left;
        }
        
        .service-details td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        
        /* Total Section */
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        
        .subtotal-row, .tax-row {
            margin-bottom: 5px;
        }
        
        .subtotal-label, .tax-label, .total-label {
            display: inline-block;
            width: 150px;
            text-align: right;
            margin-right: 20px;
        }
        
        .total-row {
            font-size: 18px;
            font-weight: bold;
            color: #4e73df;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #eee;
        }
        
        /* Payment Info */
        .payment-info {
            margin-top: 40px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        .payment-title {
            font-size: 16px;
            font-weight: bold;
            color: #4e73df;
            margin-bottom: 10px;
        }
        
        /* Footer */
        .invoice-footer {
            margin-top: 50px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #f6c23e;
            color: #fff;
        }
        
        .status-completed {
            background-color: #1cc88a;
            color: #fff;
        }
        
        .status-cancelled {
            background-color: #e74a3b;
            color: #fff;
        }
        
        .status-in_progress {
            background-color: #4e73df;
            color: #fff;
        }
        
        /* Utility Classes */
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .mb-20 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h2>{{ config('app.name', 'Service App') }}</h2>
                <p>Jl. Raya Servis No. 123</p>
                <p>Jakarta Selatan, Indonesia</p>
                <p>Phone: +62 812-3456-7890</p>
                <p>Email: info@serviceapp.com</p>
            </div>
            <div class="invoice-info">
                <h1>INVOICE</h1>
                <p><strong>Invoice #:</strong> INV-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Date:</strong> {{ now()->format('d M Y') }}</p>
                <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                <p>
                    <span class="status-badge status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </p>
            </div>
        </div>
        
        <!-- Customer and Service Info -->
        <div class="info-sections">
            <div class="customer-info">
                <div class="info-title">Customer Information</div>
                <div class="info-content">
                    <span class="info-label">Name:</span> {{ $booking->user->name }}
                </div>
                <div class="info-content">
                    <span class="info-label">Email:</span> {{ $booking->user->email }}
                </div>
                <div class="info-content">
                    <span class="info-label">Phone:</span> {{ $booking->user->phone_number ?? '-' }}
                </div>
                @if($booking->address)
                <div class="info-content">
                    <span class="info-label">Address:</span> {{ $booking->address }}
                </div>
                @endif
            </div>
            
            <div class="service-info">
                <div class="info-title">Service Information</div>
                <div class="info-content">
                    <span class="info-label">Service:</span> {{ $booking->service->name }}
                </div>
                <div class="info-content">
                    <span class="info-label">Date:</span> {{ $booking->scheduled_at->format('d M Y') }}
                </div>
                <div class="info-content">
                    <span class="info-label">Time:</span> {{ $booking->scheduled_at->format('H:i') }}
                </div>
                <div class="info-content">
                    <span class="info-label">Type:</span> {{ ucfirst($booking->service_type ?? 'Standard') }}
                </div>
            </div>
        </div>
        
        <!-- Service Details Table -->
        <table class="service-details">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="50%">Description</th>
                    <th width="15%">Quantity</th>
                    <th width="15%" class="text-right">Unit Price</th>
                    <th width="15%" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $booking->service->name }}</td>
                    <td>1</td>
                    <td class="text-right">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</td>
                </tr>
                
                @if(isset($booking->components) && count($booking->components) > 0)
                    @foreach($booking->components as $index => $component)
                    <tr>
                        <td>{{ $index + 2 }}</td>
                        <td>{{ $component->name }} (Component)</td>
                        <td>1</td>
                        <td class="text-right">Rp {{ number_format($component->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($component->price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                @endif
                
                @if($booking->service_type === 'pickup' || $booking->service_type === 'onsite')
                <tr>
                    <td>{{ isset($booking->components) ? count($booking->components) + 2 : 2 }}</td>
                    <td>{{ $booking->service_type === 'pickup' ? 'Pickup & Delivery Fee' : 'On-site Service Fee' }}</td>
                    <td>1</td>
                    <td class="text-right">Rp {{ number_format(50000, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format(50000, 0, ',', '.') }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        
        <!-- Total Section -->
        <div class="total-section">
            <div class="subtotal-row">
                <span class="subtotal-label">Subtotal:</span>
                <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="tax-row">
                <span class="tax-label">Tax (0%):</span>
                <span>Rp 0</span>
            </div>
            <div class="total-row">
                <span class="total-label">TOTAL:</span>
                <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Payment Info -->
        <div class="payment-info">
            <div class="payment-title">Payment Information</div>
            <p>Please make payment to the following bank account:</p>
            <p><strong>Bank:</strong> Bank Central Asia (BCA)</p>
            <p><strong>Account Number:</strong> 1234567890</p>
            <p><strong>Account Name:</strong> PT Service App Indonesia</p>
            
            @if($booking->payment_proof)
                <p><strong>Payment Status:</strong> <span style="color: #1cc88a; font-weight: bold;">Payment Proof Uploaded</span></p>
            @else
                <p><strong>Payment Status:</strong> <span style="color: #e74a3b; font-weight: bold;">Awaiting Payment</span></p>
            @endif
        </div>
        
        <!-- Notes -->
        @if($booking->description)
        <div class="mb-20">
            <div class="info-title">Notes</div>
            <p>{{ $booking->description }}</p>
        </div>
        @endif
        
        <!-- Footer -->
        <div class="invoice-footer">
            <p>Thank you for choosing our service!</p>
            <p>If you have any questions concerning this invoice, please contact our customer service.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Service App') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>