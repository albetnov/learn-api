/**
 * This is an example implementation of consuming JWT Expires API
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
          type: "expires",
        },
      });

      const response = await axios.get(`/features/JWT/expires`, {
        headers: {
          Authorization: `Bearer ${token.data.token}`,
        },
      });

      if (logging) {
        console.log(response.data);
        console.log("Waiting for 2 minutes before rehitting...");
      }

      setTimeout(() => {
        if (logging) {
          console.log("Requesting again...");
        }
        axios
          .get("/features/JWT/expires", {
            headers: {
              Authorization: `Bearer ${token.data.token}`,
            },
          })
          .catch((err) => {
            if (logging) {
              console.log(`Rejected with ${err.response.status}`);
            }
            resolve("success");
          });
      }, 120 * 1000);
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
