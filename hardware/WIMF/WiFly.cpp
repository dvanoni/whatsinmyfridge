#include "WiFly.h"

#include <WProgram.h>
#include <pins_arduino.h>

#include "Logging.h"
#include "_Spi.h"

WiFlyDevice::WiFlyDevice() {
    clr = 0;
    auth_level = 4;
}

// Enter command mode 
void WiFlyDevice::_commandMode() {
    print( "$$$" );
    delay(500);
}

// Do exit command
void WiFlyDevice::_exitCommandMode() {
    println( "" );
    println( "exit" );
    delay(500);
}

void WiFlyDevice::begin() {
    // Initialize SPI pins
    pinMode( MOSI, OUTPUT );
    pinMode( MISO, INPUT );
    pinMode( SCK, OUTPUT );
    pinMode( CS, OUTPUT );
    digitalWrite( CS, HIGH ); //disable device 

    SPCR = (1<<SPE)|(1<<MSTR)|(1<<SPR1)|(1<<SPR0);
    clr = SPSR;
    clr = SPDR;
    delay(10); 
    
    // Initialize and test SC16IS750
    if( SPI_Uart_Init() ) {
        DEBUG_LOG( "Bridge initialized successfully!" );
    } else { 
        DEBUG_LOG( "Could not initalize bridge, locking up!" ); 
        while(1); 
    }
}

void WiFlyDevice::join( char* ssid, char* passphrase ) {
    // Enter command mode
    _exitCommandMode();
    _commandMode();

    // Reboot to get device into known state
    DEBUG_LOG( "Rebooting device" );
    reboot();

    // Enter command mode
    _commandMode();

    // Turn off WiFly UART connection indicators
    SPI_Uart_println("set comm remote 0");
    delay(500);
    SPI_Uart_println("set comm open 0");
    delay(500);
    SPI_Uart_println("set comm close 0");
    delay(500);  

    // Set authorization level to <auth_level>
    printf( "set w a %d", auth_level );
    delay(500);
    
    // Set ssid to <ssid>
    printf( "set w s %s", ssid );
    delay(500);

    // Set passphrase to <auth_phrase>
    printf( "set w p %s", passphrase );
    delay(500);

    // Join wifi network <ssid>
    SPI_Uart_println( "join" );
    delay( ASSOCIATE_TIMEOUT );
    Flush_RX();
    
    // Check if we're associated
    delay( 2000 );
    SPI_Uart_println( "show c" );    
    if( Wait_On_Response_Char( 13 ) != '0' ) {
        Serial.print( "Failed to associate with '" );
        Serial.print( ssid );
        Serial.println( "'\n\rRetrying..." );
        Flush_RX();
        // Attempt to reconnect
        join( ssid, passphrase );
    } else {
        DEBUG_LOG( "Associated!" );
        Flush_RX();
    }
}

void WiFlyDevice::flush() {
    Flush_RX();
}

void WiFlyDevice::print( char* msg ) {
    SPI_Uart_print( msg );
}

void WiFlyDevice::println( char* msg ) {
    SPI_Uart_println( msg );
}

void WiFlyDevice::printf( char* fmt, ... ) {
    // Format and save the string
    va_list argptr;
    va_start( argptr, fmt );
    vsprintf( buffer, fmt, argptr );
    va_end( argptr );

    DEBUG_LOG( buffer );
    
    SPI_Uart_println( buffer );
}

void WiFlyDevice::reboot() {
    SPI_Uart_println( "reboot" );
    delay( 3000 );
}

void WiFlyDevice::terminal() {
    // Check for incoming data
    if( SPI_Uart_ReadByte( LSR ) & 0x01 ) { 
        is_polling = 1;
    
        while( is_polling ) {
            
            if( ( SPI_Uart_ReadByte( LSR ) & 0x01 ) ) {
                char data_buffer = SPI_Uart_ReadByte( RHR );
                Serial.print( data_buffer, BYTE );
            } else {
                is_polling = 0;
            }
            
        }
    // Outgoing data    
    } else if( Serial.available() ) {
        select();
        
        // Transmit command
        spi_transfer( 0x00 );
        spi_transfer( Serial.read() );
        
        deselect();
    }
}
