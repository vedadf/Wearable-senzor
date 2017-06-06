#include "mbed.h"
#include <string>
#include <sstream>
Serial pc ( USBTX , USBRX ); 
Serial esp ( PTE0 , PTE1 );

string data = "HEHE";
string ssid ="SSID";
string password="PW";

string server = "www.cijena.ba"; 
string uri = "/us.php";

void reset() {
    esp.printf("AT+RST");
    wait(1);
    //if(esp.getc() =='O' and esp.getc() == 'K') pc.printf("Module Reset");
}

float getTemp(float voltage){
    return voltage * 100f * 3.3f;
}

string IntToString (int a)
{
    stringstream temp;
    temp<<a;
    return temp.str();
}

void connectWifi() {
    
    string cmd = "AT+CWJAP=\"" +ssid+"\",\"" + password + "\"";
    esp.printf(cmd.c_str());
    wait(4);
    
    if(esp.getc() =='O' and esp.getc() == 'K'){ 
        pc.printf("Connected!");
    } else {
        connectWifi();
        pc.printf("Cannot connect to wifi");
    }
}

void httppost () {
    string cmd =  "AT+CIPSTART=\"TCP\",\"" + server + "\",80";
    esp.printf(cmd.c_str());
    if( esp.getc() =='O' and esp.getc() == 'K' ) {
        pc.printf("TCP connection ready");
    } 
    wait(1);

    string postRequest =
    
    "POST " + uri + " HTTP/1.0\r\n" +
    "Host: " + server + "\r\n" +
    "Accept: *" + "/" + "*\r\n" +
    "Content-Length: " + IntToString(data.length()) + "\r\n" +
    "Content-Type: application/x-www-form-urlencoded\r\n" +
    "\r\n" + data;
    
    string sendCmd = "AT+CIPSEND=";
    esp.printf(sendCmd.c_str());
    esp.printf( IntToString( postRequest.length() ).c_str() );

    wait(2);
   esp.printf("AT+CIPCLOSE");
}

int main() {
 
}
