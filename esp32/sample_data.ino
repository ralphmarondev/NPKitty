#include <WiFi.h>
#include <HTTPClient.h>

// WiFi credentials
const char* ssid = "YOUR_WIFI_SSID";
const char* password = "YOUR_WIFI_PASSWORD";

// Your PHP API endpoint (change to your server IP/domain + path)
const char* serverUrl = "http://192.168.0.153/npkitty/web/api/receive.php";  

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);

  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConnected to WiFi");

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Prepare data (like a POST form)
    String postData = "userId=admin@gmail.com&pin=1234";
    postData += "&plotId=PLOT001";
    postData += "&nitrogen=45";
    postData += "&phosphorus=20";
    postData += "&potassium=15";
    postData += "&moisture=30";

    http.begin(serverUrl);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Response: " + response);
    } else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }

    http.end();
  }
}

void loop() {
  // You can repeat sending every X seconds if needed
}
