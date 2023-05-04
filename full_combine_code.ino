#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
//new for real time generating
#include <NTPClient.h>
#include <WiFiUdp.h>
//servo
#include <Servo.h>

#include <IRremoteESP8266.h>  // IRremoteESP8266 library for ESP8266
#include <IRrecv.h>           // Library to receive IR signals
#include <IRutils.h>

int min_fix1 = 10;
int min_fix2 = 12;
// Replace with your network credentials
const char* ssid = "UIU-STUDENT";
const char* password = "12345678";
//const char* ssid = "Mithu";
//const char* password = "password key";
const char* serverURL = "http://foolhardy-shelters.000webhostapp.com/Maon.php";

// Set the LCD address to 0x27 for a 16x2 display using an I2C connection
LiquidCrystal_I2C lcd(0x3F, 16, 2);

// Define the time zone and NTP server
const char* timezone = "Asia/Dhaka";
const char* ntpServer = "pool.ntp.org";
const long gmtOffset_sec = 3600*3;   // GMT offset in seconds (Bangladesh is GMT+6)
const int daylightOffset_sec = 0;      // Daylight offset in seconds (not applicable in Bangladesh)

int count=0; //to keep track of medicine box


int flag_ready = 0; //buzzer
Servo myservo1;
Servo myservo2;
Servo myservo3;

int count_ir=0;
int buzzerPin = D7;
// Initialize the IR receiver pin
#define IR_PIN D5

// Initialize the IR receiver object
IRrecv irrecv(IR_PIN);

// Initialize the variable to store the received IR code
decode_results results;

WiFiClient client;
// Initialize the WiFi and UDP client
WiFiClient wifiClient;
WiFiUDP wifiUdpClient;

// Initialize the NTP client
NTPClient ntpClient(wifiUdpClient, ntpServer, gmtOffset_sec, daylightOffset_sec);


void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);

  Serial.print("Connecting to Wi-Fi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConnected to Wi-Fi");

  // Initialize the LCD
  lcd.begin();
  lcd.backlight();

  // Initialize the NTP client
  ntpClient.begin();
  ntpClient.setTimeOffset(gmtOffset_sec);
  irrecv.enableIRIn();  // Start the IR receiver

  myservo1.attach(D0);
  myservo1.write(0);
  myservo2.attach(D3);
  myservo3.attach(D6);
  myservo3.write(90);

  pinMode(buzzerPin, OUTPUT);
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    // Update the NTP client
  ntpClient.update();

  // Get the current time in Bangladesh
  time_t currentTime = ntpClient.getEpochTime() + (gmtOffset_sec);
  struct tm* localTime = localtime(&currentTime);

    //medicine_drop();

    HTTPClient http;
    http.begin(client, serverURL);
    int httpCode = http.GET();

    if (httpCode > 0) {
      String payload = http.getString();
      Serial.println("Received JSON data:");
      Serial.println(payload);

      // Parse JSON data
      DynamicJsonDocument doc(1024);
      deserializeJson(doc, payload);

      if (doc.containsKey("message")) {
        Serial.println(doc["message"].as<String>());
        lcd.clear();
        lcd.setCursor(0, 0);
        lcd.print(doc["message"].as<String>());
      } else {
        JsonArray records = doc.as<JsonArray>();
        String allRecords = "";
        for (JsonObject record : records) {
          count++; //to fix1 the box of medicine
          String medicine = "Medicine: " + record["m_name"].as<String>();
          String quantity = "Quantity: " + record["left_medicine"].as<String>();

          String morning = record["first_time"].as<String>();
          int morning1 = morning.toInt();
          String day = record["second_time"].as<String>();
          int day1 = day.toInt();
          String night = record["third_time"].as<String>();
          int night1 = night.toInt();
          String min = record["min"].as<String>();
          int min1 = min.toInt();

          // if(record["left_medicine"]<5)
          // {
          //   buzzer2();
          // }

          // Compare the current time with the given time
          if(count==1)
          {
            if (localTime->tm_hour == morning1 && localTime->tm_min == min1) 
            {
              //Serial.println("running servo 1 morning");
              servo1();
              medicine_count1();
              flag_ready = 1;
            }
            else if(localTime->tm_hour == day1 && localTime->tm_min == min1)
            {
              servo1();
              medicine_count1();
              flag_ready = 1;
            }
            else if(localTime->tm_hour == night1 && localTime->tm_min == min1)
            {
              servo1();
              medicine_count1();
              flag_ready = 1;
            }
          }
          else if(count==2)
          {
            if (localTime->tm_hour == morning1 && localTime->tm_min == min1) 
            {
              //Serial.println("running servo 1 morning");
              servo2();
              medicine_count2();
              flag_ready = 1;
            }
            else if(localTime->tm_hour == day1 && localTime->tm_min == min1)
            {
              servo2();
              medicine_count2();
              flag_ready = 1;
            }
            else if(localTime->tm_hour == night1 && localTime->tm_min == min1)
            {
              servo2();
              medicine_count2();
              flag_ready = 1;
            }
          }
          


          allRecords += "(" + medicine + ", " + quantity + ") & ";

          if(count==2)
          {
            count = 0;
          }
        }

        // Remove the last " & " from the concatenated string
        allRecords.remove(allRecords.length() - 3);

        //Serial.println("All records:");
        //Serial.println(allRecords);

        // Start the timer for 5 minutes
        unsigned long startTime = millis();
        while (millis() - startTime < 30000) { // 300000 milliseconds = 5 minutes
          // Print and scroll the concatenated string on the LCD
          lcd.clear();
          int maxScroll = allRecords.length() - 15;
          for (int i = 0; i <= maxScroll; i++) {
            lcd.setCursor(0, 0);
            lcd.print(allRecords.substring(i, i + 16));

            // Wait for 300 milliseconds before scrolling to the next characters
            delay(400);
            if(flag_ready == 1)
            {
              buzzer();
              medicine_drop();
              //flag_ready = 0;
            }
            
            
          }
          if(flag_ready == 1)
            {
              buzzer();
              medicine_drop();
              //flag_ready = 0;
            }
        }
      }
    } else {
      Serial.print("Error on HTTP request: ");
      Serial.println(httpCode);
    }

    //medicine_drop();

    http.end();
  }
}

void servo1()
{

  for (int pos = 0; pos <= 90; pos += 1) {
    myservo1.write(pos);             
    delay(15);                      
  }

  for (int pos = 90; pos >= 0; pos -= 1) {
    myservo1.write(pos);              
    delay(15);                      
  }

}

void servo2()
{
  
  for (int pos = 90; pos >= 0; pos -= 1) {
    myservo2.write(pos);              
    delay(15);                      
  }

  for (int pos = 0; pos <= 90; pos += 1) {
    myservo2.write(pos);             
    delay(15);                      
  }
  
}

void servo3(){
  
  flag_ready = 0;
  medicine_done();
  for (int pos = 90; pos >= 0; pos -= 1) {
    myservo3.write(pos);              
    delay(15);                      
  }

  for (int pos = 0; pos <= 90; pos += 1) {
    myservo3.write(pos);             
    delay(15);                      
  }
}

void medicine_drop(){
  if (irrecv.decode(&results))  // If a signal is received
  {
    Serial.println(results.value, HEX);  // Print the received IR code in hexadecimal format
    irrecv.resume();  // Continue receiving IR signals
    count_ir++;
    if(count_ir==1)
    {
      servo3();
    }
    if(count_ir==2)
    {
      count_ir=0;
    }
  }
}

void buzzer(){
  tone(buzzerPin, 262, 100); //(f,d)
}

void medicine_count1(){
  HTTPClient http;
  http.begin(client, "http://foolhardy-shelters.000webhostapp.com/medicine_count1.php");
  http.GET();
}

void medicine_count2(){
  HTTPClient http;
  http.begin(client, "http://foolhardy-shelters.000webhostapp.com/medicine_count2.php");
  http.GET();
}

void medicine_done(){
  HTTPClient http;
  http.begin(client, "http://foolhardy-shelters.000webhostapp.com/medicine_done.php");
  http.GET();
}


void buzzer2(){
  tone(buzzerPin, 282, 100);
}
