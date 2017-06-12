#include "mbed.h"
#include <string>
#include <sstream>

#define maxR 100.0

Serial pc ( USBTX , USBRX ); 
Serial esp ( PTE0 , PTE1 );

AnalogIn pot (PTE20);

string IntToString (int a)
{
    stringstream temp;
    temp<<a;
    return temp.str();
}

int main() {
    
    pc.baud(115200);
    esp.baud(115200);
    
    string cipstart = "AT+CIPSTART=\"TCP\",\"cijena.ba\",80\r\n";
    string cipclose = "AT+CIPCLOSE\r\n";
    int x=0;
    
    while(1){    
        
        pc.printf("saljem\r\n");           
        
        pc.printf("konektujem se na site\r\n");
        esp.printf(cipstart.c_str());
        wait(1);
        
        float potval = pot.read() * maxR;
        int poruka = (int)potval;
        
        string cipget = "GET /us.php?data="+IntToString(poruka)+" HTTP/1.1\r\nHost: cijena.ba\r\n\r\n";
        string cipsend = "AT+CIPSEND=" + IntToString( cipget.length() ) +"\r\n";
        
        pc.printf("Cipsend\r\n");
        pc.printf(IntToString(poruka).c_str());
        esp.printf(cipsend.c_str());
        wait(1);
        pc.printf("\r\nCipget\r\n");            
        esp.printf(cipget.c_str());
        wait(1);
        
        pc.printf("poslano\r\n");       
        
    }   
    
   
}