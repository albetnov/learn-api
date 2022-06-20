/**
 * This is an example implementation of consuming Basic Authentication API
 * with JavaScript.
 *
 * Before run this, please make sure to perform "npm install" first.
 */

const { instance: axios } = require("../config");

const basicAuth = (logging = true) =>
  new Promise(async (resolve, reject) => {
    try {
      const response = await axios.get(`/auth/basic`, {
        auth: {
          username: "root",
          password: "root123",
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

module.exports = basicAuth;

if (require.main === module) {
  basicAuth().catch((err) => {});
}
