/*
 * WIMF
 * Written by Andrew
 *
 */
#include <string.h>

#include "Logging.h"
#include "WiFly.h"

WiFlyDevice WiFly;

char ssid[] = "UCSD-GUEST";
char auth_phrase[] = "";
// char ssid[] = "Cult$of$Chaos";
// char auth_phrase[] = "pumpinglemma";

// Remote server settings
char remote_url[] = "igert4.ucsd.edu";
int remote_port = 8788;

// FSR Code
#define NUM_SENSORS 4
#define SENSOR_CHECK_DELAY 500
#define CHANGE_THRESHOLD 20
int previous[NUM_SENSORS];
int current[NUM_SENSORS];

void setup() {
    // Print out a nice welcome message
    Serial.begin( 9600 );
    Serial.println( "\n\rWhat's In My Fridge, A LADL Production" );
    
    previous[0] = 0;
    previous[1] = 0;
    previous[2] = 0;
    previous[3] = 0;
  
    // Initialize and join our network
    WiFly.begin();        
    WiFly.join( ssid, auth_phrase );
    
    connect_to_server();
    // 
    // do_request();
}

void loop() {
    
    // Loop through each sensor and check it's status
    for( int i = 0; i < NUM_SENSORS; i++ ) {
        current[ i ] = analogRead( i );

        // If the delta change in this sensor is larger than our threshold, 
        // note as a change!
        int delta = abs( current[i] - previous[ i ] );    
        if( delta > CHANGE_THRESHOLD ) {
            char data_str[64];
            
            // Print out debug info!
            sprintf( data_str, "Sensor #%d changed! Previous: %d, Current: %d", i, previous[i], current[i] );
            DEBUG_LOG( data_str );
            
            // Attempt to send data to server
            sprintf( data_str, "%d,%d,%d", i, previous[i], current[i] );
            send_data( data_str );
            
            previous[ i ] = current[i];
        }
    }
    
    delay( SENSOR_CHECK_DELAY );

    //WiFly.terminal();
    
    // Collect data from force sensors
    
    // Make HTTP Request
    //do_request();
}

void connect_to_server() {
    // Exit command mode if we haven't already
    WiFly.println( "" );
    WiFly.println( "exit" );
    delay(500);

    // Enter command mode 
    WiFly.print( "$$$" );
    delay(500);
    
    WiFly.printf( "open %s %d", remote_url, remote_port );
    Serial.print( "Opening connection to " );
    Serial.println( remote_url );
    delay(500);
    WiFly.flush();    
}

void close_server() {
    // Enter command mode 
    WiFly.print( "$$$" );
    WiFly.flush();
    delay(500);
     
    // Enter command mode 
    WiFly.print( "close" );
    WiFly.flush();
    delay(500);
}

void send_data( char* msg ) {
    SERVER_OUT( msg );
    DEBUG_LOG( "Attemping to send data" );
    WiFly.flush();      
}

// Helper methods
void SERVER_OUT( char* data ) {
    WiFly.printf( "%s", data );
}

// Write <data> to THR of SC16IS750 followed by a delay
void HTML_print(char *data) {
    WiFly.println( data );
    delay(30);
}

// Check if we're connected to a client
// char Have_Client(void) {
//     // Wait for characters from a connection
//     if(SPI_Uart_ReadByte(LSR) & 0x01) {
//         
//         Serial.println("Client request..."); 
//         Flush_RX();
//         return 1; 
//     } else { 
//         return 0; 
//     } 
// }



