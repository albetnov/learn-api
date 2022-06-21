/**
 * This is an example implementation of consuming JWT Ratelimit API
 * with JavaScript.
 *
 * Before run this, please make sure to perform "npm install" first.
 */

const { instance: axios } = require("../config");

const timeoutFeature = (logging = true) =>
  new Promise(async (resolve, reject) => {
    try {
      axios
        .get("/features/ratelimit", {
          headers: {
            Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IkZ6dUxrc21PbWQiLCJ1c2VybmFtZSI6InJvb3QiLCJyYXRlbGltaXQiOiIzIn0.iLDG-90snWqz7NCP8CsSOkUm5UEX4y176ZeyFL5TAeA`,
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

      for (let i = 0; i < 4; i++) {
        await axios.get(`/features/ratelimit`, {
          headers: {
            Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IkZ6dUxrc21PbWQiLCJ1c2VybmFtZSI6InJvb3QiLCJyYXRlbGltaXQiOiIzIn0.iLDG-90snWqz7NCP8CsSOkUm5UEX4y176ZeyFL5TAeA`,
          },
        });
      }

      axios
        .get(`/features/ratelimit`, {
          headers: {
            Authorization: `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IkZ6dUxrc21PbWQiLCJ1c2VybmFtZSI6InJvb3QiLCJyYXRlbGltaXQiOiIzIn0.iLDG-90snWqz7NCP8CsSOkUm5UEX4y176ZeyFL5TAeA`,
          },
        })
        .catch((response) => {
          if (logging) {
            console.log(response.data);
          }
          resolve("Success");
        });
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
