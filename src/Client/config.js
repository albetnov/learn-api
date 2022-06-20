/**
 * This is a file to configure the entire JavaScript client.
 */

const axios = require("axios").default;

// Configure your base url here.
const BASE_URL = "http://localhost";
// Configure your port here.
const PORT = "8080";
// Configure your index.php location here.
const INIT_FILE = "src/index.php?url=";

// Editing this line below is not required.
const instance = axios.create({
  baseURL: `${BASE_URL}:${PORT}/${INIT_FILE}`,
  timeout: 2000,
});

module.exports = { instance, BASE_URL, PORT, INIT_FILE };
