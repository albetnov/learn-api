/**
 * This is an example implementation of consuming Digest Authentication API
 * with JavaScript.
 *
 * Before run this, please make sure to perform "npm install" first.
 *
 * Since Axios does not officially support Digest Authentication. The example below use Axios-Digest to consume Digest Authentication API.
 */

const { default: AxiosDigestAuth } = require("@mhoc/axios-digest-auth/dist");
const { BASE_URL, PORT, INIT_FILE } = require("../config");

const digest = new AxiosDigestAuth({
  username: "root",
  password: "root123",
});

const digestAuth = (logging = true) =>
  new Promise(async (resolve, reject) => {
    try {
      const response = await digest.request({
        method: "GET",
        headers: { Accept: "application/json" },
        url: `${BASE_URL}:${PORT}/${INIT_FILE}/auth/digest`,
      });
      if (logging) {
        console.log(response.data);
      }
      resolve("Success");
    } catch (err) {
      reject(err);
      if (logging) {
        console.log(err.response.data);
        console.log(err.message);
      }
    }
  });

module.exports = digestAuth;

if (require.main === module) {
  digestAuth().catch((err) => {});
}
