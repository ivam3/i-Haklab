#include <charconv>
#include <iostream>
#include <curl/curl.h>
#include <fstream>
#include <sstream>
#include <string>
#include <typeinfo>
#include <json/json.h>

std::string getApiKey() {
    std::ifstream file("/data/data/com.termux/files/home/.local/etc/i-Haklab/variables");
    std::string apikey;

    if (file.is_open()) {
        std::string line;
        std::string variableName = "APIKEY_phonescan";

        while (std::getline(file, line)) {
            if (line.find(variableName) != std::string::npos) {
                std::istringstream iss(line);
                if (std::getline(iss, apikey, '=') && std::getline(iss, apikey, '"') && std::getline(iss, apikey, '"') && iss >> apikey) {
                    break;
                }
            }
        }
        file.close();
    }
    return apikey;
}

// structure to get the response 
struct HttpResponse {
    std::string body;
    long status_code;
};

// Getting response
size_t WriteCallback(void* contents, size_t size, size_t nmemb, std::string* response) {
    size_t total_size = size * nmemb;
    response->append((char*)contents, total_size);
    return total_size;
}

// Requests GET
HttpResponse GetRequest(const std::string& url) {
    HttpResponse response;

    CURL* curl = curl_easy_init();
    if (curl) {
        curl_easy_setopt(curl, CURLOPT_URL, url.c_str());
        curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, WriteCallback);
        curl_easy_setopt(curl, CURLOPT_WRITEDATA, &response.body);

        CURLcode res = curl_easy_perform(curl);
        if (res == CURLE_OK) {
            curl_easy_getinfo(curl, CURLINFO_RESPONSE_CODE, &response.status_code);
        }

        curl_easy_cleanup(curl);
    }

    return response;
}

void printPhoneNumberInfo(const std::string& phoneNumberInfo) {
    Json::Value jsonData;
    Json::Reader jsonReader;

    if (jsonReader.parse(phoneNumberInfo, jsonData)) {
        std::string number = jsonData["number"].asString();
        std::string localFormat = jsonData["local_format"].asString();
        std::string internationalFormat = jsonData["international_format"].asString();
        std::string countryPrefix = jsonData["country_prefix"].asString();
        std::string countryName = jsonData["country_name"].asString();
        std::string location = jsonData["location"].asString();
        std::string carrier = jsonData["carrier"].asString();
        std::string lineType = jsonData["line_type"].asString();

        std::cout << "Phone Number: " << number << std::endl;
        std::cout << "Local Format: " << localFormat << std::endl;
        std::cout << "International Format: " << internationalFormat << std::endl;
        std::cout << "Country Prefix: " << countryPrefix << std::endl;
        std::cout << "Country Name: " << countryName << std::endl;
        std::cout << "Location: " << location << std::endl;
        std::cout << "Carrier: " << carrier << std::endl;
        std::cout << "Line Type: " << lineType << std::endl;
    } else {
        std::cout << "E: Failed to parse phone number information." << std::endl;
    }
}

int main() {
  std::string apikey = getApiKey();
        if (!apikey.empty()) {
            std::string number,flink;
            std::string link = "http://apilayer.net/api/validate?access_key=";
            std::cout << "Phone Number: ";
            std::cin >> number;
            flink = link + apikey + "&number=" + number + "&country_code=&format=1";

            HttpResponse getResponse = GetRequest(flink);
            //std::cout << "GET Response: " << getResponse.body << std::endl;
            printPhoneNumberInfo(getResponse.body);

            return 0;
        } else {
            std::cout << "E: An API Key is required, set it running 'i-Haklab setapikey'" << std::endl;
        }
    return 0;
}
