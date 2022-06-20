/**
 * This scripts will execute all the run task and give you the details.
 */

const basicAuth = require("./AuthBasic");
const jwtAuth = require("./AuthJwt");
const queryAuth = require("./AuthQuery");
const digestAuth = require("./AuthDigest");

(async () => {
  try {
    await basicAuth(false);
    console.log("Basic Authentication: Success");
  } catch (err) {
    console.log(`Basic Authentication: ${err.message}`);
  }

  try {
    await digestAuth(false);
    console.log("Digest Authentication: Success");
  } catch (err) {
    console.log(`Digest Authentication: ${err.message}`);
  }

  try {
    await queryAuth(false);
    console.log("Query Authentication: Success");
  } catch (err) {
    console.log(`Query Authentication: ${err.message}`);
  }

  try {
    await jwtAuth(false);
    console.log("JWT Authentication: Success");
  } catch (err) {
    console.log(`JWT Authentication: ${err.message}`);
  }
})();
