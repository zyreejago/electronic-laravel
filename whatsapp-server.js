const express = require('express');
const { Client, LocalAuth } = require('whatsapp-web.js');
const qrcode = require('qrcode-terminal');

const app = express();
app.use(express.json());

// Create WhatsApp client
const client = new Client({
    authStrategy: new LocalAuth()
});

// Generate QR Code
client.on('qr', (qr) => {
    console.log('QR Code received:');
    qrcode.generate(qr, { small: true });
});

// When client is ready
client.on('ready', () => {
    console.log('WhatsApp client is ready!');
});

// Initialize client
client.initialize();

// API endpoint to send message
app.post('/send-message', async (req, res) => {
    try {
        const { phone, message } = req.body;
        
        // Format phone number
        const formattedPhone = phone.includes('@c.us') ? phone : `${phone}@c.us`;
        
        // Send message
        const response = await client.sendMessage(formattedPhone, message);
        
        res.json({
            success: true,
            message: 'Message sent successfully',
            data: response
        });
    } catch (error) {
        console.error('Error sending message:', error);
        res.status(500).json({
            success: false,
            message: 'Failed to send message',
            error: error.message
        });
    }
});

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
}); 