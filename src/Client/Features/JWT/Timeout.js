/**
 * This is an example implementation of consuming JWT Timeout API
 * with JavaScript.
 *
 * Before run this, please make sure to perform "npm install" first.
 */

const { instance: axios } = require("../../config");

const timeoutFeature = (logging = true) =>
  new Promise(async (resolve, reject) => {
    try {
      if (logging) {
        console.log("Getting token...");
      }

      const token = await axios.get("/features/JWT/fetch", {
        headers: {
          Token: true,
        },
        params: {
          type: "timeout",
        },
      });

      if (logging) {
        console.log("Waiting for 1 minute...");
      }

      await new Promise((resolve, reject) => {
        setTimeout(() => {
          resolve();
        }, 60 * 1000);
      });

      const response = await axios.get(`/features/JWT/timeout`, {
        headers: {
          Authorization: `Bearer ${token.data.token}`,
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

module.exports = timeoutFeature;

if (require.main === module) {
  timeoutFeature().catch((err) => {});
}
