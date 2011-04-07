#include "_Spi.h"

#include <WProgram.h>
#include <string.h>

struct SPI_UART_cfg SPI_Uart_config = {
  0x50,0x00,0x03,0x10};

char TX_Fifo_Address = THR; 

// Global vars
char incoming_data; 

void select(void)
{
  digitalWrite(CS,LOW);
}

void deselect(void)
{
  digitalWrite(CS,HIGH);
}

char SPI_Uart_Init(void) // Initialize and test SC16IS750
{
  char data = 0;

  SPI_Uart_WriteByte(LCR,0x80); // 0x80 to program baudrate
  SPI_Uart_WriteByte(DLL,SPI_Uart_config.DivL); //0x50 = 9600 with Xtal = 12.288MHz
  SPI_Uart_WriteByte(DLM,SPI_Uart_config.DivM); 

  SPI_Uart_WriteByte(LCR, 0xBF); // access EFR register
  SPI_Uart_WriteByte(EFR, SPI_Uart_config.Flow); // enable enhanced registers
  SPI_Uart_WriteByte(LCR, SPI_Uart_config.DataFormat); // 8 data bit, 1 stop bit, no parity
  SPI_Uart_WriteByte(FCR, 0x06); // reset TXFIFO, reset RXFIFO, non FIFO mode
  SPI_Uart_WriteByte(FCR, 0x01); // enable FIFO mode

  // Perform read/write test to check if UART is working
  SPI_Uart_WriteByte(SPR,'H');
  data = SPI_Uart_ReadByte(SPR);

  if(data == 'H'){ 
    return 1; 
  }
  else{ 
    return 0; 
  }

}

void SPI_Uart_WriteByte(char address, char data) 
// Write <data> byte to SC16IS750 register <address>
{
  long int length;
  char senddata[2];
  senddata[0] = address;
  senddata[1] = data;

  select();
  length = SPI_Write(senddata, 2);
  deselect();
}

long int SPI_Write(char* srcptr, long int length)
// Write string to SC16IS750
{
  for(long int i = 0; i < length; i++)
  {
    spi_transfer(srcptr[i]);
  }
  return length; 
}

void SPI_Uart_WriteArray(char *data, long int NumBytes)
// Write string to SC16IS750 THR
{
  long int length;
  select();
  length = SPI_Write(&TX_Fifo_Address,1);

  while(NumBytes > 16)
  {
    length = SPI_Write(data,16);
    NumBytes -= 16;
    data += 16;
  }
  length = SPI_Write(data,NumBytes);

  deselect();
}

char SPI_Uart_ReadByte(char address)
// Read byte from SC16IS750 register at <address>
{
  char data;

  address = (address | 0x80);

  select();
  spi_transfer(address);
  data = spi_transfer(0xFF);
  deselect();
  return data;  
}


void Flush_RX(void)
// Flush characters from SC16IS750
{
  int j = 0;
  while(j < 1000)
  {
    if((SPI_Uart_ReadByte(LSR) & 0x01))
    {
      incoming_data = SPI_Uart_ReadByte(RHR);
    }  
    else
    {
      j++;
    }
  }
}

// Wait for incoming char number <num> and return it
char Wait_On_Response_Char( char num ) {
    int i = 1;
    while(1) {
        if( ( SPI_Uart_ReadByte(LSR) & 0x01 ) ) {
            incoming_data = SPI_Uart_ReadByte(RHR);
            Serial.print( incoming_data, BYTE );
        
            if( i == num ) {
                return incoming_data; 
            } else { 
                i++;
            }
        }  
    }
    
    Serial.print("\n");
}

// Write array to SC16IS750 followed by a carriage return
void SPI_Uart_println(char *data) {
    SPI_Uart_WriteArray( data,strlen(data));
    SPI_Uart_WriteByte(THR, 0x0d);
}

void SPI_Uart_print(char *data)
// Routine to write array to SC16IS750 using strlen instead of hardcoded length
{
  SPI_Uart_WriteArray(data,strlen(data));
}

char spi_transfer(volatile char data)
{
  SPDR = data;                    // Start the transmission
  while (!(SPSR & (1<<SPIF)))     // Wait for the end of the transmission
  {
  };
  return SPDR;                    // return the received byte
}


