#include "mbed.h"
#include <string>
#include <sstream>
Serial pc ( USBTX , USBRX ); 
Serial esp ( PTE0 , PTE1 );

string data = "29";
string ssid ="LAB-2-15";
string password="";

string server = "cijena.ba"; 
string uri = "/us.php";

void reset() {
    esp.printf("AT+RST");
    wait(2);
    printResponse();
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
    printResponse();
}

void httppost () {
    //data = IntToString(getTemp(tempSenzor)); //TODO
    string cmd =  "AT+CIPSTART=\"TCP\",\"" + server + "\",80";
    esp.printf(cmd.c_str());

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

void printResponse(){
    while(esp.readable()) {
        wifi_char=esp.getc();
        pc.putc(wifi_char);
    }
}

int main() {
    pc.baud(115200);
    wifi.baud(115200);
}