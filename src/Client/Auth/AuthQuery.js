/**
 * This is an example implementation of consuming Query Authentication API
 * with JavaScript.
 *
 * Before run this, please make sure to perform "npm install" first.
 */

const { instance: axios } = require("./config");

const queryAuth = (logging = true) =>
  new Promise(async (resolve, reject) => {
    try {
      const response = await axios.get(`/query`, {
        params: {
          api_key: "root123",
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

module.exports = queryAuth;

if (require.main === module) {
  queryAuth().catch((err) => {});
}
