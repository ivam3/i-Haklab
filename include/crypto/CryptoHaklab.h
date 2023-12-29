#pragma once

#include <string>

using std::string;

namespace crypto {
  class CryptoHaklab {
    public:
     // AES
      std::string AESEncrypt(const char *plaintext, int iv, const char * key); // Encrypt data
      std::string AESDecrypt(const char *ciphertext, int  iv, const char  *key); // Dec                                                                       
     // RC4 
      std::string Rc4Encrypt(const char *plaintext, const char *key);
      std::string Rc4Decrypt(const char *plaintext, const char *key);
    
    // Bcrypt
    string Bcrypt(const char *plaintext);
    string VerifyBcrypt(string hash, string  plaintext);

    // XOR
    string XOR();

    // Elliptic Curve 
    string EllipticCurveEncrypt(string key, string  plaintext);  // Encrypt bytes 
    string EllipticCurveDecrypt(string key, string enc);  // Decrypt ciphertext

    // ChaCha20
    string Chacha20Encrypt(string data, string psk); // Encrypt
    string Chacha20Decrypt(string ciphertext, string psk); // Decrypt       

    // Rot13
    //
    
    // Rot47
    //
    
    // Base64
    //  

    // Base32
    string B32E(string txt);
    string B32D(string txt);// 

    //  Hashing
    //

    // Triple DES 
    //
  
    // Verifying hashes
    //

    // Generate an IV 
  };
};
