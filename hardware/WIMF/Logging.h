#ifndef __DEBUG_H__
#define __DEBUG_H__

#define DEBUG 1

#ifndef DEBUG
#define DEBUG_LOG(message)
#else
#define DEBUG_LOG(message) \
    Serial.print( "DEBUG: " );\
    Serial.println( message );
#endif

#endif

