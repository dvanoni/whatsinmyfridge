#ifndef __SPI_H__
#define __SPI_H__

#include <pins_arduino.h>

// SC16IS750 Register definitions
#define THR        0x00 << 3
#define RHR        0x00 << 3
#define IER        0x01 << 3
#define FCR        0x02 << 3
#define IIR        0x02 << 3
#define LCR        0x03 << 3
#define MCR        0x04 << 3
#define LSR        0x05 << 3
#define MSR        0x06 << 3
#define SPR        0x07 << 3
#define TXFIFO     0x08 << 3
#define RXFIFO     0x09 << 3
#define DLAB       0x80 << 3
#define IODIR      0x0A << 3
#define IOSTATE    0x0B << 3
#define IOINTMSK   0x0C << 3
#define IOCTRL     0x0E << 3
#define EFCR       0x0F << 3

#define DLL        0x00 << 3
#define DLM        0x01 << 3
#define EFR        0x02 << 3
#define XON1       0x04 << 3  
#define XON2       0x05 << 3
#define XOFF1      0x06 << 3
#define XOFF2      0x07 << 3

// SPI Pin definitions
#define CS         10
#define MOSI       11
#define MISO       12
#define SCK        13

// SC16IS750 register values
struct SPI_UART_cfg
{
  char DivL,DivM,DataFormat,Flow;
};

void select(void);
void deselect(void);

// Initialize and test SC16IS750
char SPI_Uart_Init(void);

// Write <data> byte to SC16IS750 register <address>
void SPI_Uart_WriteByte(char address, char data);

// Write string to SC16IS750
long int SPI_Write(char* srcptr, long int length);

// Write string to SC16IS750 THR
void SPI_Uart_WriteArray(char *data, long int NumBytes);

// Read byte from SC16IS750 register at <address>
char SPI_Uart_ReadByte(char address);

// Flush characters from SC16IS750
void Flush_RX(void);

// Wait for incoming char number <num> and return it
char Wait_On_Response_Char(char num);

// Write array to SC16IS750 followed by a carriage return
void SPI_Uart_printf( char* fmt, ... );
void SPI_Uart_println(char *data);
// Routine to write array to SC16IS750 using strlen instead of hardcoded length
void SPI_Uart_print(char *data);

char spi_transfer(volatile char data);

#endif
