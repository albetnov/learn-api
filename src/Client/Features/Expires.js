/**
 * This is an example implementation of consuming Expires API
 * with JavaScript.
 *
 * Before run this, please make sure to perform "npm install" first.
 */

const { instance: axios } = require("../config");

const timeoutFeature = (logging = true) =>
  new Promise(async (resolve, reject) => {
    try {
      if (logging) {
        console.log("Attempting to reset expired.");
      }

      axios
        .get("/features/expires", {
          headers: {
            Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ilhva1JUTGVQSnoiLCJ1c2VybmFtZSI6InJvb3QifQ.-kcpKXGMhnXoqOcFLTu-NKuHYSrXP7kYDzuOfr3z_rg`,
            RESET_USER: "true",
          },
        })
        .then(() => {
          if (logging) {
            console.log("Resetted.");
          }
        })
        .catch((err) =>
          console.log("Failed to reset!", err.response.data.message)
        );

      const response = await axios.get(`/features/expires`, {
        headers: {
          Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ilhva1JUTGVQSnoiLCJ1c2VybmFtZSI6InJvb3QifQ.-kcpKXGMhnXoqOcFLTu-NKuHYSrXP7kYDzuOfr3z_rg`,
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
          .get("/features/expires", {
            headers: {
              Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ilhva1JUTGVQSnoiLCJ1c2VybmFtZSI6InJvb3QifQ.-kcpKXGMhnXoqOcFLTu-NKuHYSrXP7kYDzuOfr3z_rg`,
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
