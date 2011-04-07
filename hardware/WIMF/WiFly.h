#ifndef __WIFLY_H__
#define __WIFLY_H__

#define ASSOCIATE_TIMEOUT 10000

class WiFlyDevice {
    private:
        char clr;               // Not sure
        char buffer[256];       // Used to hold commands before being sent out
        
        int auth_level;
        
        // Terminal handling vars
        int is_polling;
        
        void _commandMode();
        void _exitCommandMode();
        
    public: 
        WiFlyDevice();
           
        // Initialize and connect to device
        void begin();
        
        // Join a network
        void join( char* ssid, char* passphrase );
        
        // Printing utilities
        void flush();
        void print( char * msg );
        void println( char * msg );
        void printf( char* fmt, ... );
        
        // Software reboot
        void reboot();    
        
        // Allows you to send/recv messages to/from the WiFly device
        // through the serial connection
        void terminal();
};

#endif
