/**
 * This is an example implementation of consuming JWT Timeout API
 * with JavaScript.
 *
 * Before run this, please make sure to perform "npm install" first.
 */

const { instance: axios } = require("../config");

const timeoutFeature = (logging = true) =>
  new Promise(async (resolve, reject) => {
    try {
      axios
        .get("/features/timeout", {
          headers: {
            Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ilhva1JUTGVQSnoxeiIsInVzZXJuYW1lIjoicm9vdCJ9.drKo0_XU4Teg1bluOX56ctp_GaXL9n6lqRQrvuXU2yY`,
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

      if (logging) {
        console.log("Waiting for 2 minute...");
      }

      await new Promise((resolve, reject) => {
        setTimeout(() => {
          resolve();
        }, 120 * 1000);
      });

      const response = await axios.get(`/features/timeout`, {
        headers: {
          Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6Ilhva1JUTGVQSnoxeiIsInVzZXJuYW1lIjoicm9vdCJ9.drKo0_XU4Teg1bluOX56ctp_GaXL9n6lqRQrvuXU2yY`,
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
