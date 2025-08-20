#include <WiFi.h>
#include <HTTPClient.h>
#include <SPI.h>
#include <TFT_eSPI.h>
#include <HardwareSerial.h>
#include <ModbusMaster.h>

const char* ssid = "COE_LAB";
const char* password = "Lablangkasimakulitka!"; 
const char* serverName = "https://npkitty.great-site.net/receive.php";

#define SENSOR_RX_PIN 16
#define SENSOR_TX_PIN 17
HardwareSerial sensorSerial(2);
ModbusMaster npkSensor;

TFT_eSPI tft = TFT_eSPI();
uint16_t calData[5] = { 342, 3492, 269, 3541, 7  };

enum ScreenState { HOME_SCREEN, NUMPAD_SCREEN, LOGIN_SCREEN };
ScreenState currentScreen = HOME_SCREEN;

// --- Global variables ---
String plotId = "None";
String numpadInput = "";
String emailInput = ""; 
String passwordInput = ""; 
bool isEditingEmail = true; 

uint16_t nitrogen = 0, phosphorus = 0, potassium = 0, moisture = 0; 
uint16_t touch_x, touch_y;

// Button ui elements
const int CHANGE_ID_BTN[] = {330, 25, 130, 45};
const int SEND_BTN[] = {330, 240, 130, 55};
const int NUM_BTN_WIDTH = 80;
const int NUM_BTN_HEIGHT = 45;
const int NUM_BTN_GAP = 10;
const char* numpad_keys[4][3] = {
  {"1", "2", "3"}, {"4", "5", "6"}, {"7", "8", "9"}, {"Del", "0", "OK"}
};
TFT_eSPI_Button idNumpadButtons[12];
TFT_eSPI_Button loginNumpadButtons[12];
const int EMAIL_FIELD[] = {20, 20, 440, 40};
const int PASS_FIELD[] = {20, 70, 440, 40};


void setupWiFi() {
  delay(10);
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  int retries = 0;
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    if(retries++ > 20) { 
        Serial.println("\nFailed to connect to WiFi!");
        return;
    }
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void sendDataToServer() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    http.begin(serverName);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    getSensorReadings();

    String httpRequestData = "userId=" + emailInput +
                             "&pin=" + passwordInput +
                             "&plotId=" + plotId +
                             "&nitrogen=" + String(nitrogen) +
                             "&phosphorus=" + String(phosphorus) +
                             "&potassium=" + String(potassium) +
                             "&moisture=" + String(moisture / 10.0);

    Serial.println("Sending data to server: ");
    Serial.println(httpRequestData);

    int httpResponseCode = http.POST(httpRequestData);
    
    tft.fillScreen(TFT_BLACK);
    tft.setTextColor(TFT_WHITE);
    tft.setTextSize(3);
    tft.setCursor(20, 100);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      Serial.print("Response from server: ");
      Serial.println(response);
      
      tft.println("Data Sent!");
      tft.setTextSize(2);
      tft.println(response);

      emailInput = "";
      passwordInput = "";
      plotId = "None";

    } else {
      Serial.print("Error on sending POST: ");
      Serial.println(httpResponseCode);
      tft.println("Send Failed!");
    }

    http.end();
    delay(3000);

  } else {
    Serial.println("WiFi Disconnected. Cannot send data.");
    tft.fillScreen(TFT_BLACK);
    tft.setTextColor(TFT_RED);
    tft.setTextSize(3);
    tft.setCursor(20, 100);
    tft.println("WiFi Error!");
    tft.println("Check connection.");
    delay(3000);
  }
}

void getSensorReadings() {
  uint8_t result;
  result = npkSensor.readHoldingRegisters(0x1E, 5);
  if (result == npkSensor.ku8MBSuccess) {
    nitrogen   = npkSensor.getResponseBuffer(0x00);
    phosphorus = npkSensor.getResponseBuffer(0x01);
    potassium  = npkSensor.getResponseBuffer(0x02);
    moisture   = npkSensor.getResponseBuffer(0x04);
  } else {
    nitrogen = 0; phosphorus = 0; potassium = 0; moisture = 0;
  }
}

void drawHomeScreen() {
  tft.fillScreen(TFT_BLACK);
  tft.drawRect(5, 5, 470, 310, TFT_BLUE);
  tft.setTextColor(TFT_WHITE, TFT_BLACK);
  tft.setTextSize(3);
  tft.setCursor(20, 30);
  tft.print("Plot ID: " + plotId);
  getSensorReadings();
  tft.setTextColor(TFT_CYAN, TFT_BLACK);
  tft.setTextSize(3);
  tft.setCursor(20, 75);  tft.print("N: " + String(nitrogen)   + " mg/kg");
  tft.setCursor(20, 110); tft.print("P: " + String(phosphorus) + " mg/kg");
  tft.setCursor(20, 145); tft.print("K: " + String(potassium)  + " mg/kg");
  tft.setTextColor(TFT_GREENYELLOW, TFT_BLACK);
  tft.setTextSize(3);
  tft.setCursor(20, 190); tft.print("Moisture: " + String(moisture / 10.0) + " %");
  tft.setTextColor(TFT_WHITE, TFT_BLACK);
  tft.setTextSize(2);
  tft.setCursor(20, 235); tft.print("Touch the screen to refresh.");
  tft.setTextSize(3);
  tft.setCursor(20, 270); tft.print("Online Mode");
  tft.fillRoundRect(CHANGE_ID_BTN[0], CHANGE_ID_BTN[1], CHANGE_ID_BTN[2], CHANGE_ID_BTN[3], 8, TFT_BLUE);
  tft.setTextColor(TFT_WHITE);
  tft.setTextSize(2);
  tft.setCursor(CHANGE_ID_BTN[0] + 15, CHANGE_ID_BTN[1] + 15);
  tft.print("Change ID");
  tft.fillRoundRect(SEND_BTN[0], SEND_BTN[1], SEND_BTN[2], SEND_BTN[3], 8, TFT_BLUE);
  tft.setTextColor(TFT_WHITE);
  tft.setTextSize(3);
  tft.setCursor(SEND_BTN[0] + 30, SEND_BTN[1] + 18);
  tft.print("Send");
}

void drawNumpadScreen() {
  tft.fillScreen(TFT_BLACK);
  tft.drawRect(40, 20, 400, 60, TFT_WHITE);
  tft.setTextColor(TFT_WHITE, TFT_BLACK);
  tft.setTextSize(4);
  tft.setCursor(50, 35);
  tft.print(numpadInput);
  int start_x = (tft.width() - (3 * NUM_BTN_WIDTH + 2 * NUM_BTN_GAP)) / 2;
  int start_y = 100;
  int k = 0;
  for (int row = 0; row < 4; row++) {
    for (int col = 0; col < 3; col++) {
      int x = start_x + col * (NUM_BTN_WIDTH + NUM_BTN_GAP);
      int y = start_y + row * (NUM_BTN_HEIGHT + NUM_BTN_GAP);
      idNumpadButtons[k].initButton(&tft, x + NUM_BTN_WIDTH/2, y + NUM_BTN_HEIGHT/2, NUM_BTN_WIDTH, NUM_BTN_HEIGHT, TFT_WHITE, TFT_BLUE, TFT_WHITE, (char*)numpad_keys[row][col], 2);
      idNumpadButtons[k].drawButton();
      k++;
    }
  }
}

void updateNumpadInput() {
  tft.fillRect(45, 25, 390, 50, TFT_BLACK);
  tft.setCursor(50, 35);
  tft.print(numpadInput);
}

void updateLoginFields() {
  tft.fillRect(EMAIL_FIELD[0] + 2, EMAIL_FIELD[1] + 2, EMAIL_FIELD[2] - 4, EMAIL_FIELD[3] - 4, TFT_BLACK);
  tft.drawRect(EMAIL_FIELD[0], EMAIL_FIELD[1], EMAIL_FIELD[2], EMAIL_FIELD[3], isEditingEmail ? TFT_YELLOW : TFT_WHITE);
  tft.setTextColor(TFT_WHITE, TFT_BLACK);
  tft.setTextSize(2);
  tft.setCursor(EMAIL_FIELD[0] + 10, EMAIL_FIELD[1] - 10); tft.print("User ID:");
  tft.setTextSize(3);
  tft.setCursor(EMAIL_FIELD[0] + 10, EMAIL_FIELD[1] + 8);
  tft.print(emailInput);
  tft.fillRect(PASS_FIELD[0] + 2, PASS_FIELD[1] + 2, PASS_FIELD[2] - 4, PASS_FIELD[3] - 4, TFT_BLACK);
  tft.drawRect(PASS_FIELD[0], PASS_FIELD[1], PASS_FIELD[2], PASS_FIELD[3], !isEditingEmail ? TFT_YELLOW : TFT_WHITE);
  String passwordMask = "";
  for (unsigned int i = 0; i < passwordInput.length(); i++) {
    passwordMask += "*";
  }
  tft.setTextColor(TFT_WHITE, TFT_BLACK);
  tft.setTextSize(2);
  tft.setCursor(PASS_FIELD[0] + 10, PASS_FIELD[1] - 10); tft.print("PIN:");
  tft.setTextSize(3);
  tft.setCursor(PASS_FIELD[0] + 10, PASS_FIELD[1] + 8);
  tft.print(passwordMask);
}

void drawLoginScreen() {
  tft.fillScreen(TFT_BLACK);
  updateLoginFields();
  int start_x = (tft.width() - (3 * NUM_BTN_WIDTH + 2 * NUM_BTN_GAP)) / 2;
  int start_y = 130;
  int k = 0;
  for (int row = 0; row < 4; row++) {
    for (int col = 0; col < 3; col++) {
      int x = start_x + col * (NUM_BTN_WIDTH + NUM_BTN_GAP);
      int y = start_y + row * (NUM_BTN_HEIGHT + NUM_BTN_GAP);
      uint16_t color = TFT_BLUE;
      if (strcmp(numpad_keys[row][col], "OK") == 0) color = 0x05E0;
      if (strcmp(numpad_keys[row][col], "Del") == 0) color = TFT_ORANGE;
      loginNumpadButtons[k].initButton(&tft, x + NUM_BTN_WIDTH/2, y + NUM_BTN_HEIGHT/2, NUM_BTN_WIDTH, NUM_BTN_HEIGHT, TFT_WHITE, color, TFT_WHITE, (char*)numpad_keys[row][col], 2);
      loginNumpadButtons[k].drawButton();
      k++;
    }
  }
}

void setup() {
  Serial.begin(115200);
  
  setupWiFi();

  sensorSerial.begin(9600, SERIAL_8N1, SENSOR_RX_PIN, SENSOR_TX_PIN);
  npkSensor.begin(1, sensorSerial);
  tft.init();
  tft.setRotation(1);
  tft.setTouch(calData);
  drawHomeScreen();
  currentScreen = HOME_SCREEN;
  Serial.println("Initialization Complete. Ready.");
}

void loop() {
  if (tft.getTouch(&touch_x, &touch_y)) {
    if (currentScreen == HOME_SCREEN) {
      if ((touch_x > CHANGE_ID_BTN[0]) && (touch_x < CHANGE_ID_BTN[0] + CHANGE_ID_BTN[2]) &&
          (touch_y > CHANGE_ID_BTN[1]) && (touch_y < CHANGE_ID_BTN[1] + CHANGE_ID_BTN[3])) {
        currentScreen = NUMPAD_SCREEN;
        numpadInput = "";
        drawNumpadScreen();
      } else if ((touch_x > SEND_BTN[0]) && (touch_x < SEND_BTN[0] + SEND_BTN[2]) &&
               (touch_y > SEND_BTN[1]) && (touch_y < SEND_BTN[1] + SEND_BTN[3])) {
        currentScreen = LOGIN_SCREEN;
        drawLoginScreen();
      } else {
        drawHomeScreen();
      }
    } else if (currentScreen == NUMPAD_SCREEN) {
      for (int i = 0; i < 12; i++) {
        if (idNumpadButtons[i].contains(touch_x, touch_y)) {
          idNumpadButtons[i].press(true); idNumpadButtons[i].drawButton(); delay(150);
          if (strcmp(numpad_keys[i/3][i%3], "OK") == 0) {
            plotId = (numpadInput.length() > 0) ? numpadInput : "None";
            currentScreen = HOME_SCREEN;
            drawHomeScreen();
          } else if (strcmp(numpad_keys[i/3][i%3], "Del") == 0) {
            if (numpadInput.length() > 0) numpadInput.remove(numpadInput.length() - 1);
            updateNumpadInput();
            idNumpadButtons[i].press(false); idNumpadButtons[i].drawButton();
          } else {
             if (numpadInput.length() < 12) numpadInput += numpad_keys[i/3][i%3];
             updateNumpadInput();
             idNumpadButtons[i].press(false); idNumpadButtons[i].drawButton();
          }
          break;
        }
      }
    } else if (currentScreen == LOGIN_SCREEN) {
      bool action_taken = false;
      if ((touch_x > EMAIL_FIELD[0]) && (touch_x < EMAIL_FIELD[0] + EMAIL_FIELD[2]) &&
          (touch_y > EMAIL_FIELD[1]) && (touch_y < EMAIL_FIELD[1] + EMAIL_FIELD[3])) {
            isEditingEmail = true; updateLoginFields(); action_taken = true;
      } else if ((touch_x > PASS_FIELD[0]) && (touch_x < PASS_FIELD[0] + PASS_FIELD[2]) &&
                 (touch_y > PASS_FIELD[1]) && (touch_y < PASS_FIELD[1] + PASS_FIELD[3])) {
            isEditingEmail = false; updateLoginFields(); action_taken = true;
      }
      
      if (!action_taken) {
        for (int i = 0; i < 12; i++) {
          if (loginNumpadButtons[i].contains(touch_x, touch_y)) {
            loginNumpadButtons[i].press(true); loginNumpadButtons[i].drawButton(); delay(100);
            const char* key = numpad_keys[i/3][i%3];
            
            if (strcmp(key, "OK") == 0) {
              sendDataToServer();
            
              emailInput = "";
              passwordInput = "";
              
              currentScreen = HOME_SCREEN;
              drawHomeScreen();
            } else if (strcmp(key, "Del") == 0) {
              if (isEditingEmail && emailInput.length() > 0) emailInput.remove(emailInput.length() - 1);
              else if (!isEditingEmail && passwordInput.length() > 0) passwordInput.remove(passwordInput.length() - 1);
            } else {
              if (isEditingEmail) { if (emailInput.length() < 16) emailInput += key; } 
              else { if (passwordInput.length() < 16) passwordInput += key; }
            }
            updateLoginFields();
            loginNumpadButtons[i].press(false); loginNumpadButtons[i].drawButton();
            break;
          }
        }
      }
    }
    delay(200); 
  }
}