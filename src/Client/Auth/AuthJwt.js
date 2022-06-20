/**
 * This is an example implementation of consuming JWT Authentication API
 * with JavaScript.
 *
 * Before run this, please make sure to perform "npm install" first.
 */

const { instance: axios } = require("../config");

const jwtAuth = (logging = true) =>
  new Promise(async (resolve, reject) => {
    try {
      const response = await axios.get(`/auth/jwt`, {
        headers: {
          Authorization:
            "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpZCI6MSwibmFtZSI6InVzZXIiLCJyb2xlIjoidXNlciJ9.J_N0u8ZlleSoG0Iy2ZKkD3qYvGdqPwpS3fBdv_NoEyWoUy8_BEPO0y9T7j0T7lT_L5qvbdEVWXNCiAjaOclRzg",
        },
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

module.exports = jwtAuth;

if (require.main === module) {
  jwtAuth().catch((err) => {});
}
