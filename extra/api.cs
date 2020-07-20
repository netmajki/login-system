using System;
using System.Collections.Generic;
using System.Collections.Specialized;
using System.IO;
using System.Linq;
using System.Net;
using System.Security.Cryptography;
using System.Security.Principal;
using System.Text;
using System.Threading.Tasks;

namespace extra {
    class api {
        private static string endpoint = "http://localhost/api/index.php";

        public static bool login(string username, string password, string hwid = "default") {
            if (hwid == "default") hwid = WindowsIdentity.GetCurrent().Owner.Value;

            var ctx_iv = aes.ctx_rand;

            using (var client = new WebClient() { Proxy = null }) {
                client.Headers["User-Agent"] = "song";

                var values = new NameValueCollection {
                    ["username"] = aes.encrypt_string(username, null, ctx_iv),
                    ["password"] = aes.encrypt_string(password, null, ctx_iv),
                    ["hwid"] = aes.encrypt_string(hwid, null, ctx_iv),

                    ["ctx_iv"] = aes.encrypt_string(ctx_iv)
                };


                string[] arr = aes.decrypt_string(
                    Encoding.Default.GetString(
                        client.UploadValues(endpoint + "?type=login", values)),
                    null, ctx_iv
                    ).Split('|');

                switch (arr[0]) { 
                    case "success":
                        user_data.username = arr[1];
                        user_data.expiry = user_data.unix_to_date(Convert.ToDouble(arr[2]));
                        user_data.level = Convert.ToInt32(arr[3]);
                        return true;

                    default:
                        Console.WriteLine(arr[0]);
                        return false;
                }
            }
        }
    }
    class user_data {
        public static DateTime unix_to_date(double unixTimeStamp) =>
            new DateTime(1970, 1, 1, 0, 0, 0, 0, System.DateTimeKind.Utc).AddSeconds(unixTimeStamp).ToLocalTime();

        public static string username { get; set; }

        public static DateTime expiry { get; set; }

        public static int level { get; set; }
    }
    class aes {
        private static string default_encryption_key = "awuNVAVFGJ6NFPeE78mdegw3hkknv2kH";

        private static string default_encryption_iv = "dhwPF67YfpG5UqsV";
        public static string encrypt_string(string plain_text, string encryption_key = null, string encryption_iv = null) {
            if (encryption_key == null) encryption_key = default_encryption_key;
            if (encryption_iv == null) encryption_iv = default_encryption_iv;

            using (var instance = Aes.Create()) {
                instance.Mode = CipherMode.CBC;

                instance.Key = Encoding.Default.GetBytes(encryption_key);
                instance.IV = Encoding.Default.GetBytes(encryption_iv);

                var stream = new MemoryStream();

                using (ICryptoTransform aes_encryptor = instance.CreateEncryptor()) {
                    using (CryptoStream crypt_stream = new CryptoStream(stream, aes_encryptor, CryptoStreamMode.Write)) {
                        byte[] p_bytes = Encoding.UTF8.GetBytes(plain_text);

                        crypt_stream.Write(p_bytes, 0, p_bytes.Length);

                        crypt_stream.FlushFinalBlock();

                        return Convert.ToBase64String(stream.ToArray());
                    }
                }
            }
        }

        public static string decrypt_string(string cipher_text, string encryption_key = null, string encryption_iv = null) {
            if (encryption_key == null) encryption_key = default_encryption_key;
            if (encryption_iv == null) encryption_iv = default_encryption_iv;

            using (var instance = Aes.Create()) {
                instance.Mode = CipherMode.CBC;

                instance.Key = Encoding.Default.GetBytes(encryption_key);
                instance.IV = Encoding.Default.GetBytes(encryption_iv);

                var stream = new MemoryStream();

                using (ICryptoTransform aes_decryptor = instance.CreateDecryptor()) {
                    using (CryptoStream crypt_stream = new CryptoStream(stream, aes_decryptor, CryptoStreamMode.Write)) {
                        byte[] c_bytes = Convert.FromBase64String(cipher_text);

                        crypt_stream.Write(c_bytes, 0, c_bytes.Length);

                        crypt_stream.FlushFinalBlock();

                        return Encoding.UTF8.GetString(stream.ToArray());
                    }
                }

            }
        }
        public static string ctx_rand => Guid.NewGuid().ToString().Substring(0, 16);
    }
}
