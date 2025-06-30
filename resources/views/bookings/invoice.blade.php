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
        
        /* Payment Method Styles */
        .payment-method {
            display: inline-block;
            padding: 3px 8px;
            background-color: #4e73df;
            color: white;
            border-radius: 10px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
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
                @php $itemNumber = 1; @endphp
                
                <!-- Service Base -->
                <tr>
                    <td>{{ $itemNumber++ }}</td>
                    <td>{{ $booking->service->name }}</td>
                    <td>1</td>
                    <td class="text-right">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</td>
                </tr>
                
                <!-- Service Components -->
                @if(isset($booking->components) && count($booking->components) > 0)
                    @foreach($booking->components as $component)
                    <tr>
                        <td>{{ $itemNumber++ }}</td>
                        <td>{{ $component->name }} (Component)</td>
                        <td>1</td>
                        <td class="text-right">Rp {{ number_format($component->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($component->price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                @endif
                
                <!-- Spare Parts -->
                @if($booking->spareparts && count($booking->spareparts) > 0)
                    @foreach($booking->spareparts as $sparepart)
                    <tr>
                        <td>{{ $itemNumber++ }}</td>
                        <td>
                            {{ $sparepart->sparepart_name }} (Spare Part)
                            @if($sparepart->description)
                                <br><small style="color: #666;">{{ $sparepart->description }}</small>
                            @endif
                        </td>
                        <td>{{ $sparepart->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($sparepart->unit_price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($sparepart->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                @endif
                
                <!-- Service Type Fee -->
                @if($booking->service_type === 'pickup' || $booking->service_type === 'onsite')
                <tr>
                    <td>{{ $itemNumber++ }}</td>
                    <td>{{ $booking->service_type === 'pickup' ? 'Pickup & Delivery Fee' : 'On-site Service Fee' }}</td>
                    <td>1</td>
                    <td class="text-right">Rp {{ number_format(50000, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format(50000, 0, ',', '.') }}</td>
                </tr>
                @endif
                
                <!-- Emergency Fee -->
                @if($booking->is_emergency)
                <tr>
                    <td>{{ $itemNumber++ }}</td>
                    <td>Emergency Service Fee</td>
                    <td>1</td>
                    <td class="text-right">Rp {{ number_format(100000, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format(100000, 0, ',', '.') }}</td>
                </tr>
                @endif
                
                <!-- Loyalty Points Discount -->
                @if($booking->loyalty_points_used > 0)
                <tr>
                    <td>{{ $itemNumber++ }}</td>
                    <td>Loyalty Points Discount ({{ $booking->loyalty_points_used }} points)</td>
                    <td>1</td>
                    <td class="text-right">-Rp {{ number_format($booking->loyalty_points_used * 100, 0, ',', '.') }}</td>
                    <td class="text-right">-Rp {{ number_format($booking->loyalty_points_used * 100, 0, ',', '.') }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        
        <!-- Total Section -->
        <div class="total-section">
            @php
                $servicePrice = $booking->service->price;
                $componentsPrice = 0;
                $sparepartsPrice = 0;
                $inventoryPrice = 0; // Add this line
                $deliveryFee = 0;
                $emergencyFee = 0;
                $loyaltyDiscount = 0;
                
                // Calculate components price
                if(isset($booking->components) && count($booking->components) > 0) {
                    foreach($booking->components as $component) {
                        $componentsPrice += $component->price;
                    }
                }
                
                // Calculate spareparts price
                if($booking->spareparts && count($booking->spareparts) > 0) {
                    foreach($booking->spareparts as $sparepart) {
                        $sparepartsPrice += $sparepart->total_price;
                    }
                }
                
                // Calculate inventory price
                if($booking->inventoryUsages && count($booking->inventoryUsages) > 0) {
                    foreach($booking->inventoryUsages as $usage) {
                        $inventoryPrice += $usage->quantity_used * $usage->inventoryItem->unit_price;
                    }
                }
                
                // Calculate delivery fee
                if($booking->service_type === 'pickup' || $booking->service_type === 'onsite') {
                    $deliveryFee = 50000;
                }
                
                // Calculate emergency fee
                if($booking->is_emergency) {
                    $emergencyFee = 100000;
                }
                
                // Calculate loyalty discount
                if($booking->loyalty_points_used > 0) {
                    $loyaltyDiscount = $booking->loyalty_points_used * 100;
                }
                
                $subtotal = $servicePrice + $componentsPrice + $sparepartsPrice + $inventoryPrice + $deliveryFee + $emergencyFee - $loyaltyDiscount;
            @endphp
            
            <!-- Breakdown Section -->
            <div style="margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
                <div style="font-weight: bold; color: #4e73df; margin-bottom: 10px; font-size: 16px;">Price Breakdown</div>
                
                <div class="subtotal-row">
                    <span class="subtotal-label">Base Service ({{ $booking->service->name }}):</span>
                    <span>Rp {{ number_format($servicePrice, 0, ',', '.') }}</span>
                </div>
                
                @if($componentsPrice > 0)
                <div class="subtotal-row">
                    <span class="subtotal-label">Service Components:</span>
                    <span>Rp {{ number_format($componentsPrice, 0, ',', '.') }}</span>
                </div>
                @endif
                
                @if($sparepartsPrice > 0 || ($booking->inventoryUsages && count($booking->inventoryUsages) > 0))
                <!-- Spare Parts & Inventory Usage Breakdown Table -->
                <div style="margin: 15px 0;">
                    <div style="font-weight: bold; margin-bottom: 10px; color: #333;">Spare Parts & Inventory Usage Details:</div>
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px; background-color: white; border-radius: 3px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <thead>
                            <tr style="background-color: #4e73df; color: white;">
                                <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 13px;">#</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 13px;">Nama Item</th>
                                <th style="padding: 8px; text-align: left; border: 1px solid #ddd; font-size: 13px;">Tipe</th>
                                <th style="padding: 8px; text-align: center; border: 1px solid #ddd; font-size: 13px;">Qty</th>
                                <th style="padding: 8px; text-align: right; border: 1px solid #ddd; font-size: 13px;">Harga Satuan</th>
                                <th style="padding: 8px; text-align: right; border: 1px solid #ddd; font-size: 13px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $itemIndex = 1; @endphp
                            
                            {{-- Spare Parts --}}
                            @if($booking->spareparts && count($booking->spareparts) > 0)
                                @foreach($booking->spareparts as $sparepart)
                                <tr style="{{ $itemIndex % 2 == 0 ? 'background-color: #f8f9fa;' : 'background-color: white;' }}">
                                    <td style="padding: 8px; border: 1px solid #ddd; font-size: 12px;">{{ $itemIndex }}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; font-size: 12px;">
                                        <div style="font-weight: bold;">{{ $sparepart->sparepart_name }}</div>
                                        @if($sparepart->description)
                                            <div style="color: #666; font-size: 11px; margin-top: 2px;">{{ $sparepart->description }}</div>
                                        @endif
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #ddd; font-size: 12px;">
                                        <span style="background-color: #28a745; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">SPARE PART</span>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: center; font-size: 12px;">{{ $sparepart->quantity }}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right; font-size: 12px;">Rp {{ number_format($sparepart->unit_price, 0, ',', '.') }}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right; font-size: 12px; font-weight: bold;">Rp {{ number_format($sparepart->total_price, 0, ',', '.') }}</td>
                                </tr>
                                @php $itemIndex++; @endphp
                                @endforeach
                            @endif
                            
                            {{-- Inventory Usage --}}
                            @if($booking->inventoryUsages && count($booking->inventoryUsages) > 0)
                                @foreach($booking->inventoryUsages as $usage)
                                @php
                                    $itemTotal = $usage->quantity_used * ($usage->inventoryItem ? $usage->inventoryItem->unit_price : 0);
                                @endphp
                                <tr style="{{ $itemIndex % 2 == 0 ? 'background-color: #f8f9fa;' : 'background-color: white;' }}">
                                    <td style="padding: 8px; border: 1px solid #ddd; font-size: 12px;">{{ $itemIndex }}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; font-size: 12px;">
                                        <div style="font-weight: bold;">{{ $usage->inventoryItem ? $usage->inventoryItem->name : 'Item tidak ditemukan' }}</div>
                                        @if($usage->inventoryItem && $usage->inventoryItem->description)
                                            <div style="color: #666; font-size: 11px; margin-top: 2px;">{{ $usage->inventoryItem->description }}</div>
                                        @endif
                                        @if($usage->notes)
                                            <div style="color: #666; font-size: 11px; margin-top: 2px; font-style: italic;">Catatan: {{ $usage->notes }}</div>
                                        @endif
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #ddd; font-size: 12px;">
                                        <span style="background-color: #17a2b8; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">INVENTORY</span>
                                    </td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: center; font-size: 12px;">{{ $usage->quantity_used }}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right; font-size: 12px;">Rp {{ number_format($usage->inventoryItem ? $usage->inventoryItem->unit_price : 0, 0, ',', '.') }}</td>
                                    <td style="padding: 8px; border: 1px solid #ddd; text-align: right; font-size: 12px; font-weight: bold;">Rp {{ number_format($itemTotal, 0, ',', '.') }}</td>
                                </tr>
                                @php $itemIndex++; @endphp
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            @php
                                $totalItemsCost = $sparepartsPrice + $inventoryPrice;
                            @endphp
                            <tr style="background-color: #e9ecef; font-weight: bold;">
                                <td colspan="5" style="padding: 8px; border: 1px solid #ddd; text-align: right; font-size: 12px;">Total Spare Parts & Inventory:</td>
                                <td style="padding: 8px; border: 1px solid #ddd; text-align: right; font-size: 12px; color: #4e73df;">Rp {{ number_format($totalItemsCost, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endif
                
                @if($deliveryFee > 0)
                <div class="subtotal-row">
                    <span class="subtotal-label">{{ $booking->service_type === 'pickup' ? 'Pickup & Delivery Fee' : 'On-site Service Fee' }}:</span>
                    <span>Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                </div>
                @endif
                
                @if($emergencyFee > 0)
                <div class="subtotal-row">
                    <span class="subtotal-label">Emergency Service Fee:</span>
                    <span>Rp {{ number_format($emergencyFee, 0, ',', '.') }}</span>
                </div>
                @endif
                
                @if($loyaltyDiscount > 0)
                <div class="subtotal-row">
                    <span class="subtotal-label">Loyalty Points Discount:</span>
                    <span style="color: #e74a3b;">-Rp {{ number_format($loyaltyDiscount, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>
            
            <div class="subtotal-row">
                <span class="subtotal-label">Subtotal:</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
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
        
        <!-- Spare Parts Detail Section (if any) -->
        @if($booking->spareparts && count($booking->spareparts) > 0)
        <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
            <div style="font-weight: bold; color: #4e73df; margin-bottom: 15px; font-size: 16px;">📋 Spare Parts Details</div>
            
            @foreach($booking->spareparts as $index => $sparepart)
            <div style="margin-bottom: 10px; padding: 10px; background-color: white; border-radius: 3px; border-left: 4px solid #4e73df;">
                <div style="font-weight: bold;">{{ $index + 1 }}. {{ $sparepart->sparepart_name }}</div>
                @if($sparepart->description)
                    <div style="color: #666; font-size: 13px; margin: 5px 0;">{{ $sparepart->description }}</div>
                @endif
                <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                    <span>Quantity: <strong>{{ $sparepart->quantity }}</strong></span>
                    <span>Unit Price: <strong>Rp {{ number_format($sparepart->unit_price, 0, ',', '.') }}</strong></span>
                    <span>Total: <strong>Rp {{ number_format($sparepart->total_price, 0, ',', '.') }}</strong></span>
                </div>
                @if($sparepart->used_at)
                    <div style="color: #666; font-size: 12px; margin-top: 5px;">Used on: {{ $sparepart->used_at->format('d M Y H:i') }}</div>
                @endif
            </div>
            @endforeach
            
            <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #ddd; text-align: right;">
                <strong>Total Spare Parts Cost: Rp {{ number_format($sparepartsPrice, 0, ',', '.') }}</strong>
            </div>
        </div>
        @endif
        
        <!-- Payment Info -->
        <div class="payment-info">
            <div class="payment-title">Payment Information</div>
            
            @if($booking->ewallet_type)
                <!-- E-Wallet Payment -->
                <p><strong>Payment Method:</strong> 
                    <span class="payment-method">{{ strtoupper($booking->ewallet_type) }}</span>
                </p>
                
                @switch($booking->ewallet_type)
                    @case('ovo')
                        <p><strong>OVO Number:</strong> 0812-3456-7890</p>
                        <p><strong>Account Name:</strong> PT Service App Indonesia</p>
                        @break
                    @case('dana')
                        <p><strong>DANA Number:</strong> 0812-3456-7890</p>
                        <p><strong>Account Name:</strong> PT Service App Indonesia</p>
                        @break
                    @case('gopay')
                        <p><strong>GoPay Number:</strong> 0812-3456-7890</p>
                        <p><strong>Account Name:</strong> PT Service App Indonesia</p>
                        @break
                    @case('spay')
                        <p><strong>ShopeePay Number:</strong> 0812-3456-7890</p>
                        <p><strong>Account Name:</strong> PT Service App Indonesia</p>
                        @break
                @endswitch
                
                <p><strong>Instructions:</strong></p>
                <ol>
                    <li>Open your {{ strtoupper($booking->ewallet_type) }} app</li>
                    <li>Select "Transfer" or "Send Money"</li>
                    <li>Enter the number above</li>
                    <li>Enter amount: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></li>
                    <li>Add note: "Invoice #INV-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}"</li>
                    <li>Complete the payment</li>
                    <li>Upload payment proof in your booking page</li>
                </ol>
            @else
                <!-- Bank Transfer (Default) -->
                <p><strong>Payment Method:</strong> <span class="payment-method">Bank Transfer</span></p>
                <p><strong>Bank:</strong> Bank Central Asia (BCA)</p>
                <p><strong>Account Number:</strong> 1234567890</p>
                <p><strong>Account Name:</strong> PT Service App Indonesia</p>
                
                <p><strong>Instructions:</strong></p>
                <ol>
                    <li>Transfer to the bank account above</li>
                    <li>Amount: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></li>
                    <li>Add note: "Invoice #INV-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}"</li>
                    <li>Upload payment proof in your booking page</li>
                </ol>
            @endif
            
            @if($booking->payment_proof)
                <p><strong>Payment Status:</strong> <span style="color: #1cc88a; font-weight: bold;">✓ Payment Proof Uploaded</span></p>
                @if($booking->is_paid)
                    <p><strong>Verification Status:</strong> <span style="color: #1cc88a; font-weight: bold;">✓ Payment Verified</span></p>
                @else
                    <p><strong>Verification Status:</strong> <span style="color: #f6c23e; font-weight: bold;">⏳ Awaiting Verification</span></p>
                @endif
            @else
                <p><strong>Payment Status:</strong> <span style="color: #e74a3b; font-weight: bold;">✗ Awaiting Payment</span></p>
            @endif
        </div>
        
        <!-- Spare Parts Summary (if any) -->
        @if($booking->spareparts && count($booking->spareparts) > 0)
        <div class="mb-20">
            <div class="info-title">Spare Parts Used</div>
            @foreach($booking->spareparts as $sparepart)
                <div class="info-content">
                    <strong>{{ $sparepart->sparepart_name }}</strong> 
                    - Qty: {{ $sparepart->quantity }} 
                    - Rp {{ number_format($sparepart->total_price, 0, ',', '.') }}
                    @if($sparepart->description)
                        <br><small style="color: #666; margin-left: 20px;">{{ $sparepart->description }}</small>
                    @endif
                </div>
            @endforeach
        </div>
        @endif
        
        <!-- Notes -->
        @if($booking->description)
        <div class="mb-20">
            <div class="info-title">Service Notes</div>
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