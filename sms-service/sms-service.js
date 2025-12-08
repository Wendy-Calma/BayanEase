// sms-service.js - Complete GSM Module Integration
const express = require('express');
const { SerialPort } = require('serialport');
const { ReadlineParser } = require('@serialport/parser-readline');

const app = express();
app.use(express.json());

// ===== CONFIGURATION =====
const PORT_NAME = 'COM9';  // Windows: COM3, COM4, etc. | Linux: /dev/ttyUSB0 | Mac: /dev/cu.usbserial-*
const BAUD_RATE = 9600;
const SERVER_PORT = 3001;

// ===== GLOBAL VARIABLES =====
let port;
let parser;
let isModuleReady = false;
let currentResponse = '';

// ===== INITIALIZE GSM MODULE =====
function initializeGSM() {
    console.log('🚀 Starting SMS Service...');
    console.log(`📡 Attempting to connect to ${PORT_NAME}`);
    
    try {
        port = new SerialPort({
            path: PORT_NAME,
            baudRate: BAUD_RATE,
            autoOpen: false
        });

        parser = port.pipe(new ReadlineParser({ delimiter: '\r\n' }));

        // Open port
        port.open((err) => {
            if (err) {
                console.error('❌ Failed to open port:', err.message);
                console.log('\n💡 Troubleshooting:');
                console.log('1. Check if module is plugged in');
                console.log('2. Verify COM port in Device Manager');
                console.log('3. Make sure no other program is using the port');
                console.log('4. Try unplugging and replugging the module');
                return;
            }
            console.log('✅ Serial Port Opened Successfully!');
            setupModule();
        });

        // Handle incoming data
        parser.on('data', (data) => {
            console.log('📱 Module:', data);
            currentResponse += data + '\n';
            
            // Check for success responses
            if (data.includes('OK')) {
                isModuleReady = true;
            }
            if (data.includes('ERROR')) {
                console.log('⚠️  Module returned ERROR');
            }
            if (data.includes('+CMGS:')) {
                console.log('✅ SMS Sent Successfully!');
            }
        });

        // Handle port errors
        port.on('error', (err) => {
            console.error('❌ Serial Port Error:', err.message);
        });

        port.on('close', () => {
            console.log('🔌 Serial Port Closed');
            isModuleReady = false;
        });

    } catch (error) {
        console.error('❌ Initialization Error:', error.message);
    }
}

// ===== SETUP MODULE WITH AT COMMANDS =====
function setupModule() {
    console.log('⚙️  Configuring GSM Module...');
    
    // Test communication
    setTimeout(() => {
        sendATCommand('AT', 'Testing connection...');
    }, 1000);

    // Check SIM card
    setTimeout(() => {
        sendATCommand('AT+CPIN?', 'Checking SIM card...');
    }, 2000);

    // Check network registration
    setTimeout(() => {
        sendATCommand('AT+CREG?', 'Checking network...');
    }, 3000);

    // Set SMS text mode
    setTimeout(() => {
        sendATCommand('AT+CMGF=1', 'Setting SMS text mode...');
    }, 4000);

    // Set character set
    setTimeout(() => {
        sendATCommand('AT+CSCS="GSM"', 'Setting character set...');
    }, 5000);

    // Check signal strength
    setTimeout(() => {
        sendATCommand('AT+CSQ', 'Checking signal strength...');
    }, 6000);

    setTimeout(() => {
        console.log('\n✅ GSM Module Ready!');
        console.log('📱 You can now send SMS messages');
        console.log(`🌐 API available at http://localhost:${SERVER_PORT}\n`);
        isModuleReady = true;
    }, 7000);
}

// ===== SEND AT COMMAND =====
function sendATCommand(command, description = '') {
    return new Promise((resolve, reject) => {
        if (!port || !port.isOpen) {
            reject(new Error('Serial port not open'));
            return;
        }

        if (description) {
            console.log(`📤 ${description}`);
        }
        console.log(`   Sending: ${command}`);
        
        currentResponse = '';
        
        port.write(command + '\r\n', (err) => {
            if (err) {
                console.log('   ❌ Error:', err.message);
                reject(err);
            } else {
                setTimeout(() => resolve(currentResponse), 1000);
            }
        });
    });
}

// ===== SEND SMS FUNCTION =====
async function sendSMS(phoneNumber, message) {
    try {
        if (!isModuleReady) {
            throw new Error('GSM Module not ready. Please wait...');
        }

        // Format phone number for Philippines
        if (!phoneNumber.startsWith('+')) {
            if (phoneNumber.startsWith('0')) {
                phoneNumber = '+63' + phoneNumber.substring(1);
            } else if (!phoneNumber.startsWith('63')) {
                phoneNumber = '+63' + phoneNumber;
            } else {
                phoneNumber = '+' + phoneNumber;
            }
        }

        console.log('\n📨 ===== SENDING SMS =====');
        console.log(`📞 To: ${phoneNumber}`);
        console.log(`💬 Message: ${message}`);
        console.log('========================\n');

        // Set SMS text mode
        await sendATCommand('AT+CMGF=1', 'Setting text mode');
        await sleep(500);

        // Set phone number
        await sendATCommand(`AT+CMGS="${phoneNumber}"`, 'Setting recipient');
        await sleep(1000);

        // Send message content
        console.log('📤 Sending message content...');
        port.write(message);
        await sleep(500);

        // Send Ctrl+Z to indicate end of message (ASCII 26)
        port.write(Buffer.from([0x1A]));
        console.log('✅ Message queued for delivery');
        
        await sleep(3000); // Wait for delivery confirmation

        return { 
            success: true, 
            message: 'SMS sent successfully',
            recipient: phoneNumber
        };

    } catch (error) {
        console.error('❌ SMS Send Error:', error.message);
        return { 
            success: false, 
            error: error.message 
        };
    }
}

// ===== HELPER FUNCTION =====
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// ===== API ENDPOINTS =====

// Send SMS endpoint
app.post('/send-sms', async (req, res) => {
    try {
        const { phone_number, document_name, tracking_number, recipient_name } = req.body;

        if (!phone_number) {
            return res.status(400).json({ 
                success: false, 
                error: 'Phone number is required' 
            });
        }

        // Compose message
        const message = `Good day, ${recipient_name || 'Valued Customer'}!

Your document "${document_name || 'requested document'}" (Tracking #: ${tracking_number || 'N/A'}) is now ready for pickup.

Please proceed to our office during business hours to claim your document.

Thank you!
- Bayan EASE`;

        const result = await sendSMS(phone_number, message);
        
        res.json(result);

    } catch (error) {
        console.error('API Error:', error);
        res.status(500).json({ 
            success: false, 
            error: error.message 
        });
    }
});

// Simple test endpoint
app.post('/send-test-sms', async (req, res) => {
    try {
        const { phone_number, message } = req.body;

        if (!phone_number || !message) {
            return res.status(400).json({ 
                success: false, 
                error: 'Phone number and message are required' 
            });
        }

        const result = await sendSMS(phone_number, message);
        res.json(result);

    } catch (error) {
        res.status(500).json({ 
            success: false, 
            error: error.message 
        });
    }
});

// Health check endpoint
app.get('/status', (req, res) => {
    res.json({ 
        status: isModuleReady ? 'ready' : 'initializing',
        port: PORT_NAME,
        message: isModuleReady ? 'SMS service is operational' : 'Please wait, module initializing...'
    });
});

// ===== START SERVER =====
app.listen(SERVER_PORT, () => {
    console.log('\n╔════════════════════════════════════════╗');
    console.log('║   BAYAN EASE - SMS SERVICE             ║');
    console.log('╚════════════════════════════════════════╝\n');
    console.log(`🚀 Server running on port ${SERVER_PORT}`);
    console.log(`📡 COM Port: ${PORT_NAME}`);
    console.log(`🔧 Baud Rate: ${BAUD_RATE}\n`);
    
    // Initialize GSM module
    initializeGSM();
});

// ===== GRACEFUL SHUTDOWN =====
process.on('SIGINT', () => {
    console.log('\n\n🛑 Shutting down SMS Service...');
    if (port && port.isOpen) {
        port.close(() => {
            console.log('✅ Serial port closed');
            console.log('👋 Goodbye!\n');
            process.exit(0);
        });
    } else {
        process.exit(0);
    }
});

// ===== ERROR HANDLING =====
process.on('uncaughtException', (error) => {
    console.error('❌ Uncaught Exception:', error.message);
});

process.on('unhandledRejection', (error) => {
    console.error('❌ Unhandled Rejection:', error.message);
});